<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puskesmas extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Propinsi_m','Kabupaten_m','Puskesmas_m','Status_gizi_m'));
        $this->load->library('convertion');
    }

	public function index(){
        $data['judul']	= 'Data Puskesmas';
        $data['menu']	= 'Data Puskesmas';
        $data['sub_menu']	= 'Home';

        $this->load->view('layout/header', $data);
		$this->load->view('data_puskesmas/home');
		$this->load->view('layout/footer');
    }

    public function form($id=null){
        $data_propinsi = $this->Propinsi_m->get_data()->row();
        $data['propinsi'] = $data_propinsi->name;
        $data['data_kab'] = $this->Kabupaten_m->get_data($id_kabupaten = null, $data_propinsi->id)->result();
        if($id != NULL){// ID nya ada
            $data['judul']	= 'Detail Data Puskesmas';
            $data['menu']	= 'Data Puskesmas';
            $data['sub_menu']	= 'Detail Data Puskesmas';
            $data['jenis_form'] = "detail";

            $data['data'] = $this->Puskesmas_m->puskesmasById($id)->row();;
        }else{
            $data['judul']	= 'Tambah Data Puskesmas';
            $data['menu']	= 'Data Puskesmas';
            $data['sub_menu']	= 'Tambah Data Puskesmas';
            $data['jenis_form'] = "tambah";
        }

        $this->load->view('layout/header', $data);
		$this->load->view('data_puskesmas/form');
		$this->load->view('layout/footer');
    }
    
    public function list_datatables(){
        $list = $this->Puskesmas_m->get_datatables();

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<center>'.$no.'</center>';
			$row[] = $field->namapusk;
			$row[] = $field->jenis;
            $row[] = $field->nipkep.' - '.$field->keppusk;
            $row[] = $field->nipnutri.' - '.$field->nutripusk;
            $row[] = $field->almtpusk;
            $row[] = $field->prop;
            $row[] = $field->kab;
            $row[] = '<center>                           
                        <a href="'.site_url().'/detail-puskesmas/'.md5($field->idpusk).'">
                            <button type="button" class="btn btn-secondary">DETAIL</button>
                        </a>
                     </center>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Puskesmas_m->count_all(),
			"recordsFiltered" => $this->Puskesmas_m->count_filtered(),
			"data" => $data,
        );
        
		echo json_encode($output);
    }

    public function save($id = null){
        if($id != null){
            $cekIdKab = $this->Puskesmas_m->puskesmasById($id)->row()->idpusk;
        }else{
            $cekIdKab = '';
        }

        $idkab = $this->input->post("kabupaten");

        if(SUBSTR($cekIdKab,'0','4') != $idkab){
            $max_id = $this->Puskesmas_m->max_idpusk($idkab)->max_id;
            if($max_id == 0){
                $idpusk = $idkab."001";
            }else{
                $next_id = substr($max_id,-3)+1;
                $idpusk = $idkab.sprintf('%03d', $next_id);
            } 
        }else{
            $idpusk = $this->input->post("idpusk");
        }

        

        $data = array('idpusk'=>$idpusk,
                      'namapusk'=>$this->input->post("namapusk"),
                      'almtpusk'=>$this->input->post("alamat"),
                      'jenis'=>$this->input->post("jenis"),
                      'keppusk'=>$this->input->post("keppusk"),
                      'nipkep'=>$this->input->post("nipkep"),
                      'nutripusk'=>$this->input->post("nutripusk"),
                      'nipnutri'=>$this->input->post("nipnutri"));
        $this->Puskesmas_m->save($data,$id);
    }

    public function delete($id = null){
        $this->Puskesmas_m->delete($id);
    }
}
