<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
public function __construct() {
	  parent::__construct();
	  $this->load->model(array('Login_m'));
  }

	public function index() {
		if(empty($_SESSION['idUser'])){
			$this->load->view('login');
		}else{
			if($_SESSION['level'] == 1){
				redirect(site_url("data-user"));
			}else if($_SESSION['level'] == 2){
				redirect(site_url("data-penimbangan"));
			}else if(in_array($_SESSION['level'],array('3','4','5','6','7'))){
				redirect(site_url("laporan-penimbangan"));
			}
		}
	}

	public function cek_login() {
		$username =  $this->input->post('username');
		$password = sha1(md5(sha1($this->input->post('password'))));

		$data_user = $this->Login_m->cek_user($username, $password);
		if ($data_user->num_rows() == 1) {
			
			$data_user = $data_user->row();

			$level_user = $data_user->level;

			if($level_user == "1"){
				$pengguna = "Admin Propinsi ".ucwords(strtolower($this->Login_m->get_kode_propinsi()->name));
			}else if($level_user == "2"){
				$pengguna = "Bidan / Kader ".ucwords(strtolower($data_user->namapos)).", Desa".ucwords(strtolower($data_user->desa));
			}else if($level_user == "3"){
				$pengguna = "Puskesmas ".ucwords(strtolower($data_user->puskesmas));
			}else if($level_user == "4"){
				$pengguna = "Dinas Kesahatan Kabupaten/Kota ".ucwords(strtolower($data_user->kabupaten));
			}else if($level_user == "5"){
				$pengguna = "Dinas Kesahatan Propinsi ".ucwords(strtolower($data_user->propinsi));
			}else if($level_user == "6"){
				$pengguna = "Camat ".ucwords(strtolower($data_user->kecamatan));
			}else if($level_user == "7"){
				$pengguna = "Lurah Desa ".ucwords(strtolower($data_user->desa));
			}

			if(filter_var($data_user->foto, FILTER_VALIDATE_URL) === FALSE){
				$foto = base_url('images/default-user.png');
			}else{
				$foto = $data_user->foto;
			}

			$sess_data = array('idUser' => $data_user->idUser,
							   'nip' => $data_user->nip,
							   'nama' => $data_user->nama,
							   'phone' => $data_user->phone,
							   'email' => $data_user->email,
							   'foto' => $foto,
							   'level' => $data_user->level,
							   'aktif'=>$data_user->aktif,
							   'kode_propinsi'=>$this->Login_m->get_kode_propinsi()->id,
							   'lokasi' => $this->input->post('location'),
							   'pengguna'=>$pengguna);

			$this->session->set_userdata($sess_data);
			
			if($_SESSION['aktif'] == 'Ya'){
				if($_SESSION['level'] == 1){
					redirect(site_url("data-user"));
				}else if($_SESSION['level'] == 2){
					redirect(site_url("penimbangan"));
				}else if(in_array($_SESSION['level'],array('3','4','5','6','7'))){
					redirect(site_url("laporan-penimbangan"));
				}
			}else{
				$data['judul']	= 'Login - Mozita';
				$data['validasi'] = '<font color="#ef5350"><i class="fa fa-exclamation-triangle">&nbsp;</i><b>Maaf, akun Anda sudah tidak aktif</b></font>';
				$this->load->view('login', $data);
			}

		}
		else{
			$data['judul']	= 'Login - Mozita';
			$data['validasi'] = '<font color="#ef5350"><i class="fa fa-exclamation-triangle">&nbsp;</i><b>Email atau kata sandi yang Anda masukkan salah </b></font>';
			$this->load->view('login', $data);
		}
	}
		

	public function logout() {
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('id_level');
		session_destroy();
		redirect('Login');
	}

}

?>
