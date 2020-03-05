<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posyandu extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Posyandu_m','Propinsi_m','Kabupaten_m','Kecamatan_m','Puskesmas_m','Desa_m','Status_gizi_m'));
        $this->load->library('convertion');
    }

	public function index(){
        $data['judul']	= 'Data Posyandu';
        $data['menu']	= 'Data Posyandu';
        $data['sub_menu']	= 'Home';

        $this->load->view('layout/header', $data);
		$this->load->view('data_posyandu/home');
		$this->load->view('layout/footer');
    }

    public function form($id=null){
        $propinsi = $this->Propinsi_m->get_data();
        $data['data_propinsi'] = $propinsi->result();
        $data['data_kab'] = $this->Kabupaten_m->get_data($id_kabupaten = null, $propinsi->row()->id)->result();

        if($_SESSION['level'] == 3){
            $data['data_desa'] = $this->Desa_m->desaByIdpusk(substr($_SESSION['idUser'],0,7))->result();
        }

        if($id != NULL){// ID nya ada
            $data['judul']	= 'Detail Data Posyandu';
            $data['menu']	= 'Data Posyandu';
            $data['sub_menu']	= 'Detail Data Posyandu';
            $data['jenis_form'] = "detail";

            $data_user = $this->Posyandu_m->posyanduById($id);
            $data['data'] = $data_user;
            $data['data_kec'] = $this->Kecamatan_m->get_data($id_kecamatan = null, $data_user->id_kab)->result();
            $data['data_desa'] = $this->Desa_m->desaByIdpusk($data_user->id_pusk)->result();
            /* get data puskesmas
            $data['data_pusk'] = $this->Desa_m->desaByIdpusk($data_user->id_pusk)->result(); */
        }else{
            $data['judul']	= 'Tambah Data Posyandu';
            $data['menu']	= 'Data Posyandu';
            $data['sub_menu']	= 'Tambah Data Posyandu';
            $data['jenis_form'] = "tambah";
        }

        $this->load->view('layout/header', $data);
		$this->load->view('data_posyandu/form');
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

                $list = '<option value="0">Pilih</option>';
                if(!empty($data)){
                    foreach ($data as $rows) {
                        $list .= '<option value="'.$rows->id.'-'.$rows->idpusk.'">'.$rows->name.'</option>';
                    }
                }
                echo $list;
            break;
            case 'puskesmas':
                // $split_id = explode("-",$id);
                // $idpusk = end($split_id);
                // $data = $this->Puskesmas_m->puskesmasById(MD5($idpusk))->row();
                // if(!empty($data)){
                //     echo $data->namapusk;
                // }else{
                //     echo "";
                // }

                // kodingan baru
                $where = substr($id,0,7);
                // $data = $this->Puskesmas_m->puskesmasByIdKecamatan($where)->result();
                $data = $this->db->query("SELECT a.* FROM puskesmas a WHERE a.id_kecamatan='".$where."'")->result();

                $list = '<option value="">Pilih</option>';
                if(!empty($data)){
                    foreach ($data as $rows) {
                        $list .= '<option value="'.$rows->idpusk.'">'.$rows->namapusk.'</option>';
                    }
                }
                echo $list;
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
        $list = $this->Posyandu_m->get_datatables();

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();
			$row[] = '<center>'.$no.'</center>';
			$row[] = $field->namapos;
			$row[] = $field->alamatpos;
            $row[] = $field->rt;
            $row[] = $field->rw;
            $row[] = $field->desa;
            $row[] = $field->kecamatan;
            $row[] = $field->kabupaten;
            $row[] = $field->propinsi;
            $row[] = $field->puskesmas;
            $row[] = '<center>                           
                        <a href="'.site_url().'/detail-data-posyandu/'.md5($field->idpos).'">
                            <button type="button" class="btn btn-secondary">DETAIL</button>
                        </a>
                     </center>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Posyandu_m->count_all(),
			"recordsFiltered" => $this->Posyandu_m->count_filtered(),
			"data" => $data,
        );
        
		echo json_encode($output);
    }

    public function save($id = null){
        if($id != null){
            $cekIdDesa = $this->Posyandu_m->posyanduById($id)->id_desa;
        }else{
            $cekIdDesa = '';
        }

        $split_idDesa = explode("-",$this->input->post("desa"));
        $id_desa = $split_idDesa[0];

        if($cekIdDesa != $id_desa){
            $max_id = $this->Posyandu_m->max_idpos($id_desa)->max_id;
            if($max_id == 0){
                $idPosyandu = $id_desa."001";
            }else{
                $next_id = substr($max_id,-2)+1;
                $idPosyandu = $id_desa.sprintf('%02d', $next_id);
            } 
        }else{
            $idPosyandu = $this->input->post("idpos");
        }

        

        $data = array('idpos'=>$idPosyandu,
                      'idpusk'=>$this->input->post("idpusk"),
                      'namapos'=>$this->input->post("namapos"),
                      'alamatpos'=>$this->input->post("alamat"),
                      'rt'=>$this->input->post("rt"),
                      'rw'=>$this->input->post("rw"),
                      'desa_id'=>$id_desa);
        $this->Posyandu_m->save($data,$id);
    }

    public function delete($id = null){
        $this->Posyandu_m->delete($id);
    }
}
