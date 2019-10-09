<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penimbangan extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Penimbangan_m','Balita_m','Posyandu_m','Propinsi_m','Kabupaten_m','Kecamatan_m','Puskesmas_m','Desa_m','Status_gizi_m'));
        $this->load->library('convertion');
    }

	public function index(){
        $data['judul']	= 'Penimbangan';
        $data['menu']	= 'Penimbangan';
        $data['sub_menu']	= 'Home';

        $this->load->view('layout/header', $data);
		$this->load->view('penimbangan/home');
		$this->load->view('layout/footer');
    }

    public function form($norm=null, $tgl_penimbangan = null){

        $data['data_propinsi'] = $this->Propinsi_m->get_data()->result();
        if($norm != NULL){// ID nya ada
            $data['judul']	= 'Detail Penimbangan';
            $data['menu']	= 'Penimbangan';
            $data['sub_menu']	= 'Detail Penimbangan';
            $data['jenis_form'] = "detail";

            $data['data'] = $this->Penimbangan_m->getDataPenimbangan($norm, $tgl_penimbangan);
        }else{
            $data['judul']	= 'Tambah Penimbangan';
            $data['menu']	= 'Penimbangan';
            $data['sub_menu']	= 'Tambah Penimbangan';
            $data['jenis_form'] = "tambah";
        }

        $this->load->view('layout/header', $data);
		$this->load->view('penimbangan/form');
		$this->load->view('layout/footer');
    }

    public function getNamaBalita(){
        $nama_balita = $this->input->get("q");
        $this->Balita_m->getBalitaByName($nama_balita);
    }

    public function getUmurBalita(){
        $tgl_lahir = strtotime(date_format(date_create($this->input->post("tglLahir")),"Y-m-d"));
        $tgl_penimbangan = strtotime(date_format(date_create($this->input->post("tglPenimbangan")),"Y-m-d"));

        // var_dump($tgl_lahir."-".$tgl_penimbangan);
        // die();

        $numBulan = 1 + (date("Y",$tgl_penimbangan)-date("Y",$tgl_lahir))*12;
        $numBulan += date("m",$tgl_penimbangan)-date("m",$tgl_lahir);

        echo $numBulan;
    }

    public function getDataBalita(){
        $norm = $this->input->post("norm");
        $getData = $this->Balita_m->getBalitaByNorm(MD5($norm));

        $result = array("tgl_lahir"=>$getData->tgllahir,
                        "jenkel"=>$getData->jenkel,
                        "nmortu"=>$getData->nmortu,
                        "nikortu"=>$getData->nikortu,
                        "gakin"=>$getData->gakin,
                        "propinsi"=>$getData->nama_prop,
                        "kabupaten"=>$getData->nama_kab,
                        "kecamatan"=>$getData->nama_kec,
                        "desa"=>$getData->nama_desa,
                        "posyandu"=>$getData->namapos
                    );

        echo json_encode($result);
    }
    
    public function list_datatables(){
        $list = $this->Penimbangan_m->get_datatables();

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
            $row[] = '<center>'.$no.'</center>';
            $row[] = $field->norm;
			$row[] = $field->nama;
            $row[] = date_format(date_create($field->tglpenimbangan),"d-m-Y");
            $row[] = $field->posyandu;
            $row[] = $field->umurbayi;
            $row[] = $field->bb;
            $row[] = $field->tb;
            $row[] = $field->pb;
            $row[] = $field->lila;
            $row[] = $field->bb_u;
            $row[] = $field->tb_u_pb_u;
            $row[] = $field->bb_tb_bb_pb;
            $row[] = $field->imt_u;
            $row[] = $field->lila_u;
            $row[] = '<center>                           
                        <a href="'.site_url().'/detail-penimbangan/'.md5($field->norm).'/'.$field->tglpenimbangan.'">
                            <button type="button" class="btn btn-secondary">DETAIL</button>
                        </a>
                     </center>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Penimbangan_m->count_all(),
			"recordsFiltered" => $this->Penimbangan_m->count_filtered(),
			"data" => $data,
        );
        
		echo json_encode($output);
    }

    public function status_gizi($jenis = null){
		switch ($jenis) {
            case 'bb_u':
                $data = array("jenkel" => $this->input->post("jenkel"),
                              "umur" => $this->input->post("umur"),
                              "bb" => $this->input->post("bb"));
                $this->Penimbangan_m->hitung_bb_u($data);
                
            break;
            case 'pb_u_tb_u':
                $data = array("jenkel" => $this->input->post("jenkel"),
                              "umur" => $this->input->post("umur"),
                              "tb" => $this->input->post("tb"),
                              "pb" => $this->input->post("pb"));
                $this->Penimbangan_m->hitung_pb_u_tb_u($data);
                
            break;

            case 'bb_pb_bb_tb':
                $data = array("jenkel" => $this->input->post("jenkel"),
                              "umur" => $this->input->post("umur"),
                              "bb" => $this->input->post("bb"),
                              "tb" => $this->input->post("tb"),
                              "pb" => $this->input->post("pb"));
                $this->Penimbangan_m->hitung_bb_pb_bb_tb($data);
                
            break;
            case 'imt_u':
                $data = array("jenkel" => $this->input->post("jenkel"),
                              "umur" => $this->input->post("umur"),
                              "bb" => $this->input->post("bb"),
                              "tb" => $this->input->post("tb"));
                $this->Penimbangan_m->hitung_imt_u($data);
                
            break;
        }
	}

    public function save($id = null, $tglPenimbangan = null){
        $data = array('norm'=>$this->input->post("norm"),
                      'umurbayi'=>$this->input->post("umur_bayi"),
                      'tglpenimbangan'=>date_format(date_create($this->input->post("tgl_penimbangan")),"Y-m-d"),
                      'bb'=>$this->input->post("bb"),
                      'tb'=>$this->input->post("tb"),
                      'pb'=>$this->input->post("pb"),
                      'lila'=>$this->input->post("lila"),
                      'bb_u'=>$this->input->post("bb_u"),
                      'tb_u_pb_u'=>$this->input->post("tb_u_pb_u"),
                      'bb_tb_bb_pb'=>$this->input->post("bb_tb_bb_pb"),
                      'imt_u'=>$this->input->post("imt_u"),
                      'lila_u'=>$this->input->post("lila_u"),
                      'iduser'=>$_SESSION['idUser']);
        
        $this->Penimbangan_m->save($data, $id, $tglPenimbangan);
    }

    public function delete($id = null,$tglpenimbangan = null){
        $this->Penimbangan_m->delete($id,$tglpenimbangan);
    }
}
