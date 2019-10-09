<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct(){
        parent::__construct();
        if(empty($_SESSION['idUser'])){
            redirect(base_url());
        }
        $this->load->model(array('Laporan_m','Posyandu_m','Propinsi_m','Kabupaten_m','Kecamatan_m','Puskesmas_m','Desa_m','Status_gizi_m'));
        $this->load->library('convertion');
    }

	public function index(){
        $data['judul']	= 'Laporan Penimbangan';
        $data['menu']	= 'Laporan Penimbangan';
        $data['sub_menu']	= 'Home';

        $getPropinsi = $this->Propinsi_m->get_data()->row();
        $data['propinsi'] = $getPropinsi->name;
        if($_SESSION['level'] == '1' or $_SESSION['level'] == '5'){
            $data['data_kab'] = $this->Kabupaten_m->get_data($id_kabupaten = null, $getPropinsi->id)->result();
        }else if($_SESSION['level'] == '2'){
            $data['data_kab'] = $this->Laporan_m->getKab();
            $data['data_kec'] = $this->Laporan_m->getKec()->row();
            $data['data_desa'] = $this->Laporan_m->getDesa();
            $data['data_pusk'] = $this->Laporan_m->getPusk();
            $data['data_posy'] = $this->Laporan_m->getPosy();
        }else if($_SESSION['level'] == '3'){
            $data['data_desa'] = $this->Desa_m->desaByIdpusk(substr($_SESSION['idUser'],'0','7'))->result();
        }else if($_SESSION['level'] == '4'){
            $data['data_kab'] = $this->Laporan_m->getKab();
            $data['data_kec'] = $this->Laporan_m->getKec()->result();
            // $data['data_desa'] = $this->Laporan_m->getDesa();
            // $data['data_pusk'] = $this->Laporan_m->getPusk();
            // $data['data_posy'] = $this->Laporan_m->getPosy();
        }

        $this->load->view('layout/header', $data);
		$this->load->view('laporan/home');
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
        $list = '<option value="semua">Pilih Semua</option>';
        if(!empty($list_data)){
            foreach ($list_data as $rows) {
                $list .= '<option value="'.$rows["id"].'">'.$rows["ket"].'</option>';
            }
        }
        echo $list;
    }

    public function view(){
        $nama_propinsi = $this->input->post('propinsi');
        $id_propinsi = $this->Propinsi_m->getPropinsiByName($nama_propinsi)->row()->id;
        $id_kabupaten = $this->input->post('kabupaten');
        $id_kecamatan = $this->input->post('kecamatan');
        $id_puskesmas = $this->input->post('puskesmas');
        $id_desa = $this->input->post('desa');
        $id_posyandu = $this->input->post('posyandu');
        $blnpenimbangan = $this->input->post('blnpenimbangan');

        $data['blnpenimbangan'] = $blnpenimbangan;
        $data['nama_propinsi'] = $nama_propinsi;

        if($id_kabupaten != 'semua' && $_SESSION['level'] != '3'){
            $data['kabupaten'] = $this->Kabupaten_m->get_data(MD5($id_kabupaten))->row()->name;
        }
        
        if($id_kecamatan != 'semua' && $_SESSION['level'] != '3'){
            $data['kecamatan'] = $this->Kecamatan_m->get_data(MD5($id_kecamatan))->row()->name;
        }
        
        if($id_desa != 'semua'){
            $data['desa'] = $this->Desa_m->get_data(MD5($id_desa))->row()->name;
        }

        if($id_puskesmas != 'semua' && $_SESSION['level'] != '3'){
            $data['puskesmas'] = $this->Puskesmas_m->puskesmasById(MD5($id_puskesmas))->row()->namapusk;
        }
        
        if($_SESSION['level'] == '3'){
            $data_puskesmas = $this->Laporan_m->getDataByPuskesmas($_SESSION['idUser']);
            $id_puskesmas = $data_puskesmas->idpusk;
            $data['kabupaten'] = $data_puskesmas->kab;
            $data['kecamatan'] = $data_puskesmas->kec;
            $data['puskesmas'] = $data_puskesmas->namapusk;
        }

        if($id_kabupaten == 'semua' && $_SESSION['level'] != '3'){
            $data['data_kabupaten'] = $this->Kabupaten_m->get_data(null, $id_propinsi)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin(null, $id_propinsi);
            $data['url_download'] = site_url('laporan/unduh_excel/'.str_replace(" ","_",$nama_propinsi).'/'.$id_kabupaten.'/'.$id_kecamatan.'/'.$id_puskesmas.'/'.$id_desa.'/'.$id_posyandu.'/'.$blnpenimbangan);
            $this->load->view('laporan/lapPropinsi',$data);
        }else if($id_kecamatan == 'semua' && $_SESSION['level'] != '3'){
            $data['data_kecamatan'] = $this->Kecamatan_m->get_data(null, $id_kabupaten)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin(null, null, $id_kabupaten);
            $data['url_download'] = site_url('laporan/unduh_excel/'.str_replace(" ","_",$nama_propinsi).'/'.$id_kabupaten.'/'.$id_kecamatan.'/'.$id_puskesmas.'/'.$id_desa.'/'.$id_posyandu.'/'.$blnpenimbangan);
            $this->load->view('laporan/lapKabupaten',$data);
        }else if($id_puskesmas == 'semua' && $_SESSION['level'] != '3'){
            $data['data_desa'] = $this->Desa_m->desaByIdKec($id_kecamatan)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin(null, null, null, $id_kecamatan);
            $data['url_download'] = site_url('laporan/unduh_excel/'.str_replace(" ","_",$nama_propinsi).'/'.$id_kabupaten.'/'.$id_kecamatan.'/'.$id_puskesmas.'/'.$id_desa.'/'.$id_posyandu.'/'.$blnpenimbangan);
            $this->load->view('laporan/lapKecamatan',$data);
        }else if($id_desa == 'semua'){
            $data['data_desa'] = $this->Desa_m->desaByIdpusk($id_puskesmas)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin(null, null, null, null, $id_puskesmas);
            $data['data_puskesmas'] = $this->Puskesmas_m->puskesmasById(MD5($id_puskesmas))->row();
            $data['url_download'] = site_url('laporan/unduh_excel/'.str_replace(" ","_",$nama_propinsi).'/'.$id_kabupaten.'/'.$id_kecamatan.'/'.$id_puskesmas.'/'.$id_desa.'/'.$id_posyandu.'/'.$blnpenimbangan);
            $this->load->view('laporan/lapPuskesmas',$data);
        }else if($id_posyandu == 'semua'){
            $data['data_posyandu'] = $this->Posyandu_m->posyanduByIdDesa($id_desa)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin($id_desa);
            $data['url_download'] = site_url('laporan/unduh_excel/'.str_replace(" ","_",$nama_propinsi).'/'.$id_kabupaten.'/'.$id_kecamatan.'/'.$id_puskesmas.'/'.$id_desa.'/'.$id_posyandu.'/'.$blnpenimbangan);
            $this->load->view('laporan/lapDesa',$data);

        }else{
            $data['posyandu'] = $this->Posyandu_m->posyanduById(MD5($id_posyandu))->namapos;
            $jml_balita_aktif_laki_laki = $this->Laporan_m->getBalitaAktifLakilaki($id_posyandu);
            $jml_balita_aktif_perempuan = $this->Laporan_m->getBalitaAktifPerempuan($id_posyandu);
            $data['jml_balita_aktif_laki_laki'] = $jml_balita_aktif_laki_laki;
            $data['jml_balita_aktif_perempuan'] = $jml_balita_aktif_perempuan;

            $jml_balita_timbang_laki_laki = $this->Laporan_m->getBalitaTimbangLakilaki($id_posyandu,$blnpenimbangan);
            $jml_balita_timbang_perempuan = $this->Laporan_m->getBalitaTimbangPerempuan($id_posyandu,$blnpenimbangan);
            $data['jml_balita_timbang_laki_laki'] = $jml_balita_timbang_laki_laki;
            $data['jml_balita_timbang_perempuan'] = $jml_balita_timbang_perempuan;

            
            

            $S = $jml_balita_aktif_laki_laki + $jml_balita_aktif_perempuan; // JUMLAH BALITA YANG ADA
            $K = $this->Laporan_m->getBalitaPunyaKms($id_posyandu); // JUMLAH BALITA YANG PUNYA KMS
            $D = $jml_balita_timbang_laki_laki + $jml_balita_timbang_perempuan; // JUMLAH BALITA DITIMBANG
            $N = $this->Laporan_m->getBalitaNaikBB($id_posyandu,$blnpenimbangan); // JUMLAH BALITA NAIK BB


            $data['jml_balita_punya_kms'] = $K;
            $data['jml_balita_naik_bb'] = $N;
            if($K == ''){
                $data['k_s'] = 0;
            }else{
                $data['k_s'] = round(($K / $S) * 100);
            }
            
            if($D  == ''){
                $data['d_s'] = 0;
            }else{
                $data['d_s'] = round(($D / $S) * 100);
            }
            
            if($N == ''){
                $data['n_d'] = 0;
            }else{
                $data['n_d'] = round((($N) / $D) * 100);
            }
            
            $data['data_balita'] = $this->Laporan_m->getBalita($id_posyandu,$blnpenimbangan)->result();

            $tgl_penimbangan = $this->Laporan_m->getBalita($id_posyandu,$blnpenimbangan)->first_row();
            if(isset($tgl_penimbangan)){
                $data['tgl_penimbangan'] = $tgl_penimbangan->tglpenimbangan;
            }else{
                $data['tgl_penimbangan'] = '';
            }
             

            $data['url_download'] = site_url('laporan/unduh_excel/'.str_replace(" ","_",$nama_propinsi).'/'.$id_kabupaten.'/'.$id_kecamatan.'/'.$id_puskesmas.'/'.$id_desa.'/'.$id_posyandu.'/'.$blnpenimbangan);
            

            $this->load->view('laporan/lapPosyandu',$data);
        }
    }


    public function unduh_excel($nama_propinsi = null, $id_kabupaten = null, $id_kecamatan = null, $id_puskesmas = null, $id_desa = null, $id_posyandu = null, $blnpenimbangan = null){
        $nama_propinsi = str_replace("_"," ",$nama_propinsi);
        $id_propinsi = $this->Propinsi_m->getPropinsiByName($nama_propinsi)->row()->id;
        $data['nama_propinsi'] = $nama_propinsi;
        $data['blnpenimbangan'] = $blnpenimbangan;
        
        if($id_kabupaten != 'semua' && $_SESSION['level'] != '3'){
            $nama_kab = $this->Kabupaten_m->get_data(MD5($id_kabupaten))->row()->name;
            $data['kabupaten'] = $nama_kab;
        }
        
        if($id_kecamatan != 'semua' && $_SESSION['level'] != '3'){
            $nama_kec = $this->Kecamatan_m->get_data(MD5($id_kecamatan))->row()->name;
            $data['kecamatan'] = $nama_kec;
        }
        
        if($id_desa != 'semua'){
            $nama_desa = $this->Desa_m->get_data(MD5($id_desa))->row()->name;
            $data['desa'] = $nama_desa;
        }

        if($id_puskesmas != 'semua' && $_SESSION['level'] != '3'){
            $nama_puskesmas = $this->Puskesmas_m->puskesmasById(MD5($id_puskesmas))->row()->namapusk;
            $data['puskesmas'] = $nama_puskesmas;
        }
        
        if($_SESSION['level'] == '3'){
            $data_puskesmas = $this->Laporan_m->getDataByPuskesmas($_SESSION['idUser']);
            $id_puskesmas = $data_puskesmas->idpusk;
            $nama_desa = $data_puskesmas->desa;
            $nama_puskesmas = $data_puskesmas->namapusk;
            $data['kabupaten'] = $data_puskesmas->kab;
            $data['kecamatan'] = $data_puskesmas->kec;
            $data['puskesmas'] = $nama_puskesmas;
        }


        if($id_kabupaten == 'semua' && $_SESSION['level'] != '3'){
            $data['data_kabupaten'] = $this->Kabupaten_m->get_data($id_kabupaten = null, $id_propinsi)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin($id_desa = null, $id_propinsi);
            $data['title'] = str_replace(" ","_",$nama_propinsi)."_".$blnpenimbangan;
            $this->load->view('laporan/cetakLapPropinsi',$data);
        }else if($id_kecamatan == 'semua' && $_SESSION['level'] != '3'){
            $data['data_kecamatan'] = $this->Kecamatan_m->get_data(null, $id_kabupaten)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin(null, null, $id_kabupaten);
            $data['title'] = str_replace(" ","_",$nama_kab)."_".$blnpenimbangan;
            $this->load->view('laporan/cetakLapKabupaten',$data);

        }else if($id_puskesmas == 'semua' && $_SESSION['level'] != '3'){
            $data['data_desa'] = $this->Desa_m->desaByIdKec($id_kecamatan)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin(null, null, null, $id_kecamatan);
            $data['title'] = str_replace(" ","_",$nama_kec)."_".$blnpenimbangan;
            $this->load->view('laporan/cetakLapKecamatan',$data);

        }else if($id_desa == 'semua'){
            $data['data_desa'] = $this->Desa_m->desaByIdpusk($id_puskesmas)->result();
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin(null, null, null, null, $id_puskesmas);
            $data['data_puskesmas'] = $this->Puskesmas_m->puskesmasById(MD5($id_puskesmas))->row();
            $data['title'] = str_replace(" ","_",$nama_puskesmas)."_".$blnpenimbangan;
            $this->load->view('laporan/cetakLapPuskesmas',$data);
        }else if($id_posyandu == 'semua'){
            $data['data_posyandu'] = $this->Posyandu_m->posyanduByIdDesa($id_desa)->result();
            $data['blnpenimbangan'] = $blnpenimbangan;
            $data['jmlBalitaGakin'] = $this->Laporan_m->getBalitaGakin($id_desa);
            $data['title'] = $nama_desa."_".$blnpenimbangan;
            $this->load->view('laporan/cetakLapDesa',$data);

        }else{
            $nama_posyandu = $this->Posyandu_m->posyanduById(MD5($id_posyandu))->namapos;
            $data['posyandu'] = $nama_posyandu;
            $jml_balita_aktif_laki_laki = $this->Laporan_m->getBalitaAktifLakilaki($id_posyandu);
            $jml_balita_aktif_perempuan = $this->Laporan_m->getBalitaAktifPerempuan($id_posyandu);
            $data['jml_balita_aktif_laki_laki'] = $jml_balita_aktif_laki_laki;
            $data['jml_balita_aktif_perempuan'] = $jml_balita_aktif_perempuan;

            $jml_balita_timbang_laki_laki = $this->Laporan_m->getBalitaTimbangLakilaki($id_posyandu,$blnpenimbangan);
            $jml_balita_timbang_perempuan = $this->Laporan_m->getBalitaTimbangPerempuan($id_posyandu,$blnpenimbangan);
            $data['jml_balita_timbang_laki_laki'] = $jml_balita_timbang_laki_laki;
            $data['jml_balita_timbang_perempuan'] = $jml_balita_timbang_perempuan;

            
            

            $S = $jml_balita_aktif_laki_laki + $jml_balita_aktif_perempuan; // JUMLAH BALITA YANG ADA
            $K = $this->Laporan_m->getBalitaPunyaKms($id_posyandu); // JUMLAH BALITA YANG PUNYA KMS
            $D = $jml_balita_timbang_laki_laki + $jml_balita_timbang_perempuan; // JUMLAH BALITA DITIMBANG
            $N = $this->Laporan_m->getBalitaNaikBB($id_posyandu,$blnpenimbangan); // JUMLAH BALITA NAIK BB


            $data['jml_balita_punya_kms'] = $K;
            $data['jml_balita_naik_bb'] = $N;
            if($K == ''){
                $data['k_s'] = 0;
            }else{
                $data['k_s'] = round(($K / $S) * 100);
            }
            
            if($D  == ''){
                $data['d_s'] = 0;
            }else{
                $data['d_s'] = round(($D / $S) * 100);
            }
            
            if($N == ''){
                $data['n_d'] = 0;
            }else{
                $data['n_d'] = round((($N) / $D) * 100);
            }
            // $data['k_s'] = round(($K / $S) * 100);
            // $data['d_s'] = round(($D / $S) * 100);
            // $data['n_d'] = round(($N / $D) * 100);
            $data['data_balita'] = $this->Laporan_m->getBalita($id_posyandu,$blnpenimbangan)->result();
            $tgl_penimbangan = $this->Laporan_m->getBalita($id_posyandu,$blnpenimbangan)->first_row();
            if(isset($tgl_penimbangan)){
                $data['tgl_penimbangan'] = $tgl_penimbangan->tglpenimbangan;
            }else{
                $data['tgl_penimbangan'] = '';
            }
            // $data['tgl_penimbangan'] = $this->Laporan_m->getBalita($id_posyandu,$blnpenimbangan)->first_row()->tglpenimbangan;
            $data['title'] = $nama_posyandu."_".$blnpenimbangan;
            
            $this->load->view('laporan/cetakLapPosyandu',$data);
        }
    }
}
