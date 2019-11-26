<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_user extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Data_user_m','Propinsi_m','Kabupaten_m','Kecamatan_m','Puskesmas_m','Desa_m','Posyandu_m','Status_gizi_m'));
        $this->load->library('convertion');
    }

	public function index(){
        $data['judul']	= 'Data Pengguna';
        $data['menu']	= 'Data Pengguna';
        $data['sub_menu']	= 'Home';

        $this->load->view('layout/header', $data);
		$this->load->view('data_user/home');
		$this->load->view('layout/footer');
    }

    public function form($id=null){
        $data_prop = $this->Propinsi_m->get_data();
        $data['data_propinsi'] = $data_prop->result();
        $data['data_kab'] = $this->Kabupaten_m->get_data($id_kabupaten = null, $data_prop->row()->id)->result();
        if($_SESSION['level'] == '3'){
            $data['data_desa'] = $this->Desa_m->desaByIdpusk(substr($_SESSION['idUser'],'0','7'))->result();
        }
        if($id != NULL){// ID nya ada
            $data['jenis_form'] = "edit";
            $data_user = $this->Data_user_m->getUserById($id);
            $data['data'] = $data_user;
            // $data['data_kab'] = $this->Kabupaten_m->get_data($id_kabupaten = null, $data_user->id_prop)->result();
            $data['data_kec'] = $this->Kecamatan_m->get_data($id_kecamatan = null, $data_user->id_kab)->result();
            $data['data_pusk'] = $this->Puskesmas_m->puskesmasByIdKecamatan($data_user->id_kec)->result();
            $data['data_desa'] = $this->Desa_m->desaByIdpusk($data_user->id_pusk)->result();
            $data['data_pos'] = $this->Posyandu_m->posyanduByIdDesa($data_user->id_desa)->result();
        }else{
            $data['jenis_form'] = "tambah";
        }

        $this->load->view('data_user/form',$data);
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
            case 'puskesmas':
                $data = $this->Puskesmas_m->puskesmasByIdKecamatan($id)->result();
                foreach ($data as $rows) {
                    $list_data[] = array('id'=>$rows->idpusk,
                                         'ket'=>$rows->namapusk);
                }
                $this->list_combobox($list_data);
            break;
            case 'desa':
                $data = $this->Desa_m->desaByIdpusk($id)->result();
                foreach ($data as $rows) {
                    $list_data[] = array('id'=>$rows->id,
                                         'ket'=>$rows->name);
                }
                $this->list_combobox($list_data);
            break;
            case 'posyandu':
                $data = $this->Posyandu_m->posyanduByIdDesa($id);
                if($data->num_rows() > 0 ){
                    foreach ($data->result() as $rows) {
                        $list_data[] = array('id'=>$rows->idpos,
                                             'ket'=>$rows->namapos);
                    }
                }else{
                    $list_data = "";
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
    
    public function list_data(){
        $this->load->view('data_user/list_data');
    }

    public function list_datatables(){
        $list = $this->Data_user_m->get_datatables();

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<center>'.$no.'</center>';
			$row[] = '<center><img src="'.((empty($field->foto))? base_url('images/default-user.png'):$field->foto).'" width="50" height=""></center>';
			$row[] = $field->nama;
            $row[] = $field->nip;
            $row[] = $field->phone;
            $row[] = $field->email;
            $row[] = $this->convertion->get_level($field->level);
            $row[] = '<center>'.$field->aktif.'</center>';
            $row[] = '<center>
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Aksi
                            </button>
                            <div class="dropdown-menu">
                                <a href="javascript:;" id="ya-'.md5($field->idUser).'"  class="btn_aktif dropdown-item">'.(($field->aktif == "Ya")? "Non Aktifkan":"Aktifkan").'</a>
                                <a href="javascript:;" id="'.md5($field->idUser).'" class="btn_edit dropdown-item">Ubah</a>
                                <a href="javascript:;" id="'.md5($field->idUser).'" class="btn_delete dropdown-item">Hapus</a>
                        </div>
                     </center>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Data_user_m->count_all(),
			"recordsFiltered" => $this->Data_user_m->count_filtered(),
			"data" => $data,
        );
        
		echo json_encode($output);
    }

    public function save($id = null){
        $level = $this->input->post("level");

        if($level == "2"){
            $id_posyandu = $this->input->post("posyandu");
            $max_id = $this->Data_user_m->max_idUser($level, $id_posyandu)->max_id;
            if($max_id == 0){
                $idUser = $id_posyandu."991";
            }else{
                $next_id = substr($max_id,-1)+1;
                $idUser = $id_posyandu."99".$next_id;
            }  
        }else if($level == "3"){
            $kecamatan = $this->input->post("kecamatan");
            $id_puskesmas = substr($this->input->post("puskesmas"),'0','4');
            $nomor = $id_puskesmas;
            $max_id = $this->Data_user_m->max_idUser($level, $nomor)->max_id;
            if($max_id == 0){
                $idUser = $nomor."00000001";
            }else{
                $next_id = substr($max_id,-8) + 1;
                $idUser = $nomor."99".sprintf('%08d', $next_id);
            }  
        }else if($level == "4"){
            $id_kabupaten = $this->input->post("kabupaten");
            $max_id = $this->Data_user_m->max_idUser($level, $id_kabupaten)->max_id;
            if($max_id == 0){
                $idUser = $id_kabupaten."00000000001";
            }else{
                $next_id = substr($max_id,-3) + 1;
                $idUser = $id_kabupaten."00000000".sprintf('%03d', $next_id);
            }  
        }else if($level == "5"){
            $id_propinsi = $this->input->post("propinsi");
            $max_id = $this->Data_user_m->max_idUser($level, $id_propinsi)->max_id;
            if($max_id == 0){
                $idUser = $id_propinsi."0000000000001";
            }else{
                $next_id = substr($max_id,-3) + 1;
                $idUser = $id_propinsi."0000000000".sprintf('%03d', $next_id);
            }  
        }else if($level == "6"){
            $id_kecamatan = $this->input->post("kecamatan");
            $max_id = $this->Data_user_m->max_idUser($level, $id_kecamatan)->max_id;
            if($max_id == 0){
                $idUser = $id_kecamatan."00000001";
            }else{
                $next_id = substr($max_id,-3) + 1;
                $idUser = $id_kecamatan."00000".sprintf('%03d', $next_id);
            }  
        }else if($level == "7"){
            $id_desa = $this->input->post("desa");
            $max_id = $this->Data_user_m->max_idUser($level, $id_desa)->max_id;
            if($max_id == 0){
                $idUser = $id_desa."00001";
            }else{
                $next_id = substr($max_id,-3) + 1;
                $idUser = $id_desa."00".sprintf('%03d', $next_id);
            }  
        }

        if($id != null){
            if($this->input->post("new_password") != null){
                $data = array('idUser'=>$idUser,
                              'nip'=>$this->input->post("nip"),
                              'nama'=>$this->input->post("nama"),
                              'phone'=>$this->input->post("phone"),
                              'email'=>$this->input->post("email"),
                              'level'=>$this->input->post("level"),
                              'password'=>sha1(md5(sha1($this->input->post("new_password")))));
            }else{
                $data = array('idUser'=>$idUser,
                            'nip'=>$this->input->post("nip"),
                            'nama'=>$this->input->post("nama"),
                            'phone'=>$this->input->post("phone"),
                            'email'=>$this->input->post("email"),
                            'level'=>$this->input->post("level"));
            }
        }else{
            $data = array('idUser'=>$idUser,
                          'nip'=>$this->input->post("nip"),
                          'nama'=>$this->input->post("nama"),
                          'phone'=>$this->input->post("phone"),
                          'email'=>$this->input->post("email"),
                          'level'=>$this->input->post("level"),
                          'password'=>sha1(md5(sha1($this->input->post("password")))));
        }
        
        
        $this->Data_user_m->save($data,$id);
    }

    public function delete($id = null){
        $this->Data_user_m->delete($id);
    }

    public function aktif_nonaktif_user($id = null){
        $aktif = $this->input->post("aktif");
        $this->Data_user_m->aktif_nonaktif_user($aktif,$id);
    }
}
