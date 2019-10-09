<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Balita extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(empty($_SESSION['idUser'])){
			redirect(base_url());
		}
		$this->load->model(array('Balita_m','Posyandu_m','Propinsi_m','Kabupaten_m','Kecamatan_m','Puskesmas_m','Desa_m','Status_gizi_m'));
		$this->load->library('convertion');
	}

	public function index(){
		$data['judul']	= 'Data Balita';
		$data['menu']	= 'Data Balita';
		$data['sub_menu']	= 'Home';

		$this->load->view('layout/header', $data);
		$this->load->view('data_balita/home');
		$this->load->view('layout/footer');
	}

	public function form($norm=null){

		$data_propinsi = $this->Propinsi_m->get_data()->row();
		$data['propinsi'] = $data_propinsi->name;
		$data['data_kab'] = $this->Kabupaten_m->get_data($id_kabupaten = null, $data_propinsi->id)->result();
		if($norm != NULL){// ID nya ada
			$data['judul']	= 'Detail Data Balita';
			$data['menu']	= 'Data Balita';
			$data['sub_menu']	= 'Detail Data Balita';
			$data['jenis_form'] = "detail";

			$data_balita = $this->Balita_m->getBalitaByNorm($norm);
			$data['data'] = $data_balita;
			$data['data_kec'] = $this->Kecamatan_m->get_data($id_kecamatan = null, $data_balita->id_kab)->result();
			$data['data_desa'] = $this->Desa_m->desaByIdKec($data_balita->id_kec)->result();
			$data['data_posyandu'] = $this->Posyandu_m->posyanduByIdDesa($data_balita->id_desa)->result();
		}else{
			$data['judul']	= 'Tambah Data Balita';
			$data['menu']	= 'Data Balita';
			$data['sub_menu']	= 'Tambah Data Balita';
			$data['jenis_form'] = "tambah";
		}

		$this->load->view('layout/header', $data);
		$this->load->view('data_balita/form');
		$this->load->view('layout/footer');
	}

	public function lokasi_balita($norm=NULL){
		$data['judul']	= 'Detail Data Balita';
		$data['menu']	= 'Data Balita';
		$data['sub_menu']	= 'Detail Data Balita';
		$data['lokasi'] = $this->db->query("SELECT a.* FROM balita a WHERE md5(a.norm) = '".$norm."'")->row();

		$this->load->view('layout/header', $data);
		$this->load->view('data_balita/lokasi_balita',$data);
		$this->load->view('layout/footer');
	}

	public function combobox($type = null, $id = null){

		switch ($type) {
			case 'kota':
				$data = $this->Kabupaten_m->get_data($id_kabupaten = null, $id)->result();
				foreach ($data as $rows) {
					$list_data[] = array('id'=>$rows->id,
										'ket'=>$rows->name);
				}
				$this->list_combobox($list_data);
			break;
			case 'kecamatan':
				$data = $this->Kecamatan_m->get_data($id_kecamatan = null, $id)->result();
				foreach ($data as $rows) {
					$list_data[] = array('id'=>$rows->id,
										'ket'=>$rows->name);
				}
				$this->list_combobox($list_data);
			break;
			case 'desa':
				$data = $this->Desa_m->desaByIdKec($id)->result();
				foreach ($data as $rows) {
					$list_data[] = array('id'=>$rows->id,
										'ket'=>$rows->name);
				}
				$this->list_combobox($list_data);
			break;

			case 'posyandu':
				$data = $this->Posyandu_m->posyanduByIdDesa($id)->result();
				foreach ($data as $rows) {
					$list_data[] = array('id'=>$rows->idpos,
										'ket'=>$rows->namapos);
				}
				$this->list_combobox($list_data);
			break;
		}
	}

	public function list_combobox($list_data){
		$list = '<option value="0">Pilih</option>';
		if(!empty($list_data)){
			foreach ($list_data as $rows) {
				$list .= '<option value="'.$rows["id"].'">'.$rows["ket"].'</option>';
			}
		}
		echo $list;
	}

	public function list_datatables(){
		$list = $this->Balita_m->get_datatables();

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<center>'.$no.'</center>';
			$row[] = '<center><img src="'.((empty($field->fotobayi))? base_url('images/default-user.png'):$field->fotobayi).'" width="50" height=""></center>';
			$row[] = $field->nama;
			$row[] = $field->tgllahir;
			$row[] = $field->jenkel;
			$row[] = $field->nmortu;
			$row[] = $field->nikortu;
			$row[] = $field->gakin;
			$row[] = $field->posyandu;
			$row[] = $field->desa;
			$row[] = $field->kecamatan;
			$row[] = $field->kabupaten;
			$row[] = $field->propinsi;
			$row[] = '<center>
						<a href="'.site_url().'/detail-data-balita/'.md5($field->norm).'">
							<button type="button" class="btn btn-secondary">DETAIL</button>
						</a>
					</center>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Balita_m->count_all(),
			"recordsFiltered" => $this->Balita_m->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function save(){
		$id = $this->input->post("norm");
		if($_SESSION['level'] == 2){
			$posyandu = $this->Posyandu_m->posyanduById(MD5(substr($_SESSION['idUser'],'0','12')));
			$id_posyandu = $posyandu->idpos;
		}else{
			$id_posyandu = $this->input->post("posyandu");
		}

		if($id != null){
			$getFoto = $this->Balita_m->getFoto($id)->fotobayi;
			$getNorm = $this->Balita_m->getBalitaByPosyandu($id_posyandu);
			if(!empty($getNorm)){
				$cekNorm = $getNorm->norm;
			}else{
				$cekNorm = '';
			}

			if(substr($id,'0','12') != substr($cekNorm,'0','12')){
				$max_id = $this->Balita_m->max_norm($id_posyandu)->max_id;
				if($max_id == 0){
					$norm = $id_posyandu.date("y")."001";
				}else{
					if(date("y") == substr($max_id,-5,2)){
						$next_id = substr($max_id,-3)+1;
						$norm = $id_posyandu.sprintf('%03d', $next_id);
					}else{
						$norm = $id_posyandu.date("y")."001";
					}
				}
			}else{
				$norm = $this->input->post("norm");
			}
		}else{
			$getFoto = '';
			$max_id = $this->Balita_m->max_norm($id_posyandu)->max_id;
			if($max_id == 0){
				$norm = $id_posyandu.date("y")."001";
			}else{
				if(date("y") == substr($max_id,-5,2)){
					$next_id = substr($max_id,-3)+1;
					$norm = $id_posyandu.date("y").sprintf('%03d', $next_id);
				}else{
					$norm = $id_posyandu.date("y")."001";
				}
			}
		}
		if(!empty($_FILES["foto_balita"]["name"])){
			if($getFoto != ""){
				$dir_file = "./".str_replace(base_url(),"",$getFoto);
				if(file_exists($dir_file)){
					unlink($dir_file);
				}
			}
			$fileTmpLoc = $_FILES["foto_balita"]["tmp_name"]; // File in the PHP image folder
			$split_filename = explode(".", $_FILES['foto_balita']['name']);
			$fileExt = end($split_filename);
			if(!in_array($fileExt,array('jpg','jpeg','png'))){
				$respons = array('status'=>'0',
								'jenis'=>'simpan',
								'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Ekstensi harus .jpg, .jpeg atau .png</strong></font>');
				echo json_encode($respons);
				exit();
			}

			$mkdir = "./uploads/balita/".$id_posyandu."/".date("Ym");
			$file_name = "/".$_SESSION['idUser'].date("YmdHis").".".$fileExt;
			if(!is_dir($mkdir)){
				mkdir($mkdir,0777,TRUE); //create the folder if it's not already exists
			}

			move_uploaded_file($fileTmpLoc, $mkdir.$file_name);
			$foto_balita = ''.base_url(str_replace("./","",$mkdir).$file_name).'';
		}

		if(isset($foto_balita)){
			$data = array('norm'=>$norm,
						'nama'=>$this->input->post("nama_balita"),
						'tgllahir'=>$this->input->post("tgl_lahir"),
						'jenkel'=>$this->input->post("jenkel"),
						'nmortu'=>$this->input->post("nama_ortu"),
						'nikortu'=>$this->input->post("nik_ortu"),
						'gakin'=>$this->input->post("gakin"),
						'kms'=>$this->input->post("kms"),
						'fotobayi'=>$foto_balita,
						'lat'=>$this->input->post("lat"),
						'lng'=>$this->input->post("lng"),
						'aktif'=>$this->input->post("aktif"),
						'userInput'=>$_SESSION['idUser']);

		}else{
			$data = array('norm'=>$norm,
						'nama'=>$this->input->post("nama_balita"),
						'tgllahir'=>$this->input->post("tgl_lahir"),
						'jenkel'=>$this->input->post("jenkel"),
						'nmortu'=>$this->input->post("nama_ortu"),
						'nikortu'=>$this->input->post("nik_ortu"),
						'gakin'=>$this->input->post("gakin"),
						'kms'=>$this->input->post("kms"),
						'lat'=>$this->input->post("lat"),
						'lng'=>$this->input->post("lng"),
						'aktif'=>$this->input->post("aktif"),
						'userInput'=>$_SESSION['idUser']);
		}

		$this->Balita_m->save($data,$id);
	}

	public function delete($id = null){
		$this->Balita_m->delete($id);
	}
}