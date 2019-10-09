<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Profil_m','Status_gizi_m'));
        $this->load->library('convertion');
    }

	public function index(){
        $data['judul']	= 'Profil';
        $data['menu']	= 'Profil';
        $data['sub_menu']	= 'Home';
        $data['data'] = $this->Profil_m->get_data();

        $this->load->view('layout/header', $data);
		$this->load->view('profil/form_profil');
		$this->load->view('layout/footer');
    }

    public function form_ubah_pass(){
        $data['judul']	= 'Ubah Kata Sandi';
        $data['menu']	= 'Ubah Kata Sandi';
        $data['sub_menu']	= 'Home';

        $this->load->view('layout/header', $data);
		$this->load->view('profil/ganti_password');
		$this->load->view('layout/footer');
    }

    

    public function save(){   

        if(!empty($_FILES["foto_profil"]["name"])){
            $getFoto = $this->Profil_m->get_data()->foto;
            if($getFoto != ""){
                $dir_file = "./".str_replace(base_url(),"",$getFoto);
                
                if(file_exists($dir_file)){
                    unlink($dir_file);
                }
            }
			$fileTmpLoc = $_FILES["foto_profil"]["tmp_name"]; // File in the PHP image folder
			$split_filename = explode(".", $_FILES['foto_profil']['name']);
            $fileExt = end($split_filename);
            
            if(!in_array($fileExt,array('jpg','jpeg','png'))){
                $respons = array('status'=>'0',
								 'jenis'=>'simpan',
                                 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Ekstensi harus .jpg, .jpeg atau .png</strong></font>');
                echo json_encode($respons);
                exit();
            }

			$mkdir = "./uploads/pp";
			$file_name = "/".$_SESSION['idUser'].".".$fileExt;
			
			if(!is_dir($mkdir)){ 
				mkdir($mkdir,0777,TRUE); //create the folder if it's not already exists
            }

            move_uploaded_file($fileTmpLoc, $mkdir.$file_name);
			$foto_profil = ''.base_url(str_replace("./","",$mkdir).$file_name).'';
        }

        if(isset($foto_profil)){
            $data = array('nama'=>$this->input->post("nama"),
                          'phone'=>$this->input->post("phone"),
                          'email'=>$this->input->post("email"),
                          'foto'=>$foto_profil);

        }else{
            $data = array('nama'=>$this->input->post("nama"),
                          'phone'=>$this->input->post("phone"),
                          'email'=>$this->input->post("email"));
        }

        
        $this->Profil_m->save($data);
    }

    public function ubah_sandi(){
        $old_password = sha1(md5(sha1($this->input->post("old_password"))));
        
        $password = $this->Profil_m->get_data()->password;

        if($password == $old_password){
            $new_password = sha1(md5(sha1($this->input->post('new_password'))));
            $this->Profil_m->ubah_sandi($new_password);
        }else{
            $respons = array('status'=>'0',
                             'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Gagal Mengubah Password</strong></font>');
            echo json_encode($respons);
        }
        
    }
}
