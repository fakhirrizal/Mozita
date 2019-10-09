<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perkembangan_balita extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Balita_m','Status_gizi_m','Perkembangan_balita_m'));
        $this->load->library('convertion');
    }

	public function index(){
        $data['judul']	= 'Perkembangan Balita';
        $data['menu']	= 'Perkembangan Balita';
        $data['sub_menu']	= 'Home';

        $this->load->view('layout/header', $data);
		$this->load->view('perkembangan_balita/home');
		$this->load->view('layout/footer');
    }

    public function getNamaBalita(){
        $nama_balita = $this->input->get("q");
        $this->Balita_m->getBalitaByName($nama_balita);
    }

    public function getData($norm = null){
        $bulan = array("01"=>"Januari",
                       "02"=>"Februari",
                       "03"=>"Maret",
                       "04"=>"April",
                       "05"=>"Mei",
                       "06"=>"Juni",
                       "07"=>"Juli",
                       "08"=>"Agustus",
                       "09"=>"September",
                       "10"=>"Oktober",
                       "11"=>"November",
                       "12"=>"Desember");

        $get_periode = $this->Perkembangan_balita_m->getPeriodePenimbangan($norm);

        $tgl_awal = date_format(date_create($get_periode->min_tanggal),"Y-m");
        $tgl_akhir = date_format(date_create($get_periode->max_tanggal),"Y-m");

        for($i = $tgl_awal; strtotime($i) <= strtotime($tgl_akhir); $i = date('Y-m', strtotime('+1 month', strtotime($i)))){
            $tgl_penimbangan = date_format(date_create($i),"Y-m");

            $get_data = $this->Perkembangan_balita_m->getPenimbangan($norm,$tgl_penimbangan);
            $data_grafik[] = array('period'=>date_format(date_create($i),"m-Y"),
                                   'BB'    =>((isset($get_data))? $get_data->bb:"0"),
                                   'TB'    =>((isset($get_data))? $get_data->tb:"0"),
                                   'PB'    =>((isset($get_data))? $get_data->pb:"0"),
                                   'LILA'  =>((isset($get_data))? $get_data->lila:"0"));
            
        }

        $data['data_grafik'] = json_encode($data_grafik);

        $data['balita'] = $this->Balita_m->getBalitaByNorm(MD5($norm));
        $this->load->view('perkembangan_balita/line_cart',$data);
    }

    
}
