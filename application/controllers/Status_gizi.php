<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_gizi extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Status_gizi_m','Penimbangan_m'));
        $this->load->library('convertion');
    }

	public function index(){
    }

    public function home($jenis = null){
        switch ($jenis) {
            case 'balita-gizi-buruk':
                $data['judul']	= 'Balita Gizi Buruk';
                $data['menu']	= 'Balita Gizi Buruk';
                $data['sub_menu']	= 'Home';
            break;
            case 'balita-stunting':
                $data['judul']	= 'Balita Stunting';
                $data['menu']	= 'Balita Stunting';
                $data['sub_menu']	= 'Home';
            break;
            case 'bb-tb-bb-pb':
                $data['judul']	= 'Balita BB/ TB Atau BB/ PB';
                $data['menu']	= 'Balita BB/ TB Atau BB/ PB';
                $data['sub_menu']	= 'Home';
            break;
            case 'imt_u':
                $data['judul']	= 'Balita IMT/ U';
                $data['menu']	= 'Balita IMT/ U';
                $data['sub_menu']	= 'Home';
            break;
        }

        $this->load->view('layout/header', $data);
		$this->load->view('status_gizi/home');
		$this->load->view('layout/footer');
    }

    public function form($jenis = null, $norm=null, $tgl_penimbangan = null){

        switch ($jenis) {
            case 'gizi_buruk':
                $data['judul']	= 'Detail Balita Gizi Buruk';
                $data['menu']	= 'Balita Gizi Buruk';
                $data['sub_menu']	= 'Detail Balita Gizi Buruk';
            break;
            case 'stunting':
                $data['judul']	= 'Detail Balita Stunting';
                $data['menu']	= 'Balita Stunting';
                $data['sub_menu']	= 'Detail Balita Stunting';
            break;
            case 'bb_tb_bb_pb':
                $data['judul']	= 'Detail Balita BB/ TB Atau BB/ PB';
                $data['menu']	= 'Balita BB/ TB Atau BB/ PB';
                $data['sub_menu']	= 'Detail Balita BB/ TB Atau BB/ PB';
            break;
            case 'imt_u':
                $data['judul']	= 'Detail Balita IMT/ U';
                $data['menu']	= 'Balita IMT/ U';
                $data['sub_menu']	= 'Detail Balita IMT/ U';
            break;
        }

        $data['data'] = $this->Penimbangan_m->getDataPenimbangan($norm, $tgl_penimbangan);
        

        $this->load->view('layout/header', $data);
		$this->load->view('status_gizi/form');
		$this->load->view('layout/footer');
    }
    
    public function list_datatables($jenis = null){
        $list = $this->Status_gizi_m->get_datatables($jenis);

        $level = $_SESSION['level'];

        if($jenis == 'balita-gizi-buruk'){
            $column = 'bb_u';
            $url_detail = 'detail-balita-gizi-buruk';
        }else if($jenis == 'balita-stunting'){
            $column = 'tb_u_pb_u';
            $url_detail = 'detail-balita-stunting';
        }else if($jenis == 'balita-bb-tb-atau-bb-pb'){
            $column = 'bb_tb_bb_pb';
            $url_detail = 'detail-balita-bb-tb-atau-bb-pb';
        }else if($jenis == 'balita-imt-u'){
            $column = 'imt_u';
            $url_detail = 'detail-balita-imt-u';
        }



		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
            $no++;
            
            $cek_baca = $field->baca;
            if($level == '1'){
                $find = strpos($cek_baca,'1');
                if($find !== false){
                    $baca = '1'	;
                }else{
                    $baca = '0';
                }
            }else if($level == '2'){
                $find = strpos($cek_baca,'2');
                if($find !== false){
                    $baca = '1';
                }else{
                    $baca = '0';
                }
            }else if($level == '3'){
                $find = strpos($cek_baca,'3');
                if($find !== false){
                    $baca = '1';
                }else{
                    $baca = '0';
                }
            }else if($level == '4'){
                $find = strpos($cek_baca,'4');
                if($find !== false){
                    $baca = '1';
                }else{
                    $baca = '0';
                }
            }else if($level == '5'){
                $find = strpos($cek_baca,'5');
                if($find !== false){
                    $baca = '1';
                }else{
                    $baca = '0';
                }
            }

            $row = array();
            
            $row[] = '<center>'.$no.'</center>';
            $row[] = $field->norm;
			$row[] = $field->nama;
            $row[] = date_format(date_create($field->tglpenimbangan),"d-m-Y");
            $row[] = $field->posyandu;
            $row[] = $field->umurbayi;
            $row[] = $field->$column;
            $row[] = '<center>                           
                        <a href="'.site_url().'/'.$url_detail.'/'.md5($field->norm).'/'.$field->tglpenimbangan.'">
                            <button type="button" class="btn btn-secondary">DETAIL</button>
                        </a>
					 </center>';
			$row[] = '<center>                           
						<a href="'.site_url('/lokasi_balita/'.md5($field->norm)).'">
							<button type="button" class="btn btn-secondary">Lihat Lokasi</button>
						</a>
                    </center>';
            $get_no_wa = $this->db->query("SELECT a.* FROM balita a WHERE a.norm='".$field->norm."'")->row();
            $row[] = '<center>                           
                        <a href="https://api.whatsapp.com/send?phone='.$get_no_wa->wa_ortu.'">
                            <button type="button" class="btn btn-secondary">Kirim Pemberitahuan</button>
                        </a>
                    </center>';
            $row[] = $baca;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Status_gizi_m->count_all($jenis),
			"recordsFiltered" => $this->Status_gizi_m->count_filtered($jenis),
			"data" => $data,
        );
        
		echo json_encode($output);
    }

    public function baca(){
        $norm = $this->input->post('norm');
        $tglpenimbangan = date_format(date_create($this->input->post('tglpenimbangan')),"Y-m-d");

        $this->Status_gizi_m->baca($norm,$tglpenimbangan);
    }

}
