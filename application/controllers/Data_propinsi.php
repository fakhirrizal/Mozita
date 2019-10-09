<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_propinsi extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Propinsi_m','Status_gizi_m'));
    }

	public function index(){
        $data['judul']	= 'Pengaturan Propinsi';
        $data['menu']	= 'Pengaturan Propinsi';
        $data['sub_menu']	= 'Home';

        $data['data'] = $this->Propinsi_m->get_data()->row();

        $this->load->view('layout/header', $data);
		$this->load->view('data_propinsi/home');
		$this->load->view('layout/footer');
    }


    public function save($id = null){
        $data = array('id'=>$this->input->post("kode_propinsi"),
                      'name'=>$this->input->post("nama_propinsi"));
        $this->Propinsi_m->save($data,$id);
    }
}
