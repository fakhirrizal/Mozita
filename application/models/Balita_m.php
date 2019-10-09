<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Balita_m extends CI_Model {

	public function getBalitaByNorm($norm = null){
        $select = " SELECT balita.*,
						   posyandu.idpos AS idpos,
						   posyandu.namapos AS namapos,
						   desa.id AS id_desa,
						   desa.name AS nama_desa,
						   kec.id AS id_kec,
						   kec.name AS nama_kec,
						   kab.id AS id_kab,
						   kab.name AS nama_kab,
						   propinsi.id AS id_prop,
						   propinsi.name AS nama_prop
					FROM balita
					JOIN posyandu ON posyandu.idpos = SUBSTRING(balita.norm,'1','12')
					JOIN desa ON desa.id = posyandu.desa_id
					JOIN kec ON kec.id = desa.district_id
					JOIN kab ON kab.id = kec.regency_id
					JOIN propinsi ON propinsi.id = kab.province_id
					WHERE propinsi.id = '".$_SESSION['kode_propinsi']."' 
					AND  MD5(balita.norm) = '$norm'";
		return $this->db->query($select)->row();
	}

	public function getBalitaByPosyandu($id_posyandu = null){
        $select = "SELECT norm
                   FROM balita
				   WHERE SUBSTRING(norm,'1','12') = '$id_posyandu'";
		// var_dump($select);
		// die();
		return $this->db->query($select)->row();
	}

	public function getBalitaByName($nama_balita = null){
		if($_SESSION['level'] == '2'){
			$and = " AND SUBSTRING(norm,'1','12') = SUBSTRING('".$_SESSION['idUser']."','1','12') ";
		}else{
			$and = " ";
		}
        $select = "SELECT norm,
						  CONCAT(norm,' - ',nama) AS nama
                   FROM balita
				   WHERE (nama LIKE '%$nama_balita%' or norm LIKE '%$nama_balita%') ".
				   $and.
				   " LIMIT 10";

		$result = $this->db->query($select)->result();
		$json = [];
		foreach ($result as $rows) {
			$json[] = ['id'=>$rows->norm, 'text'=>$rows->nama];
		}


		echo json_encode($json);
	}

	public function max_norm($id_posyandu= null){

		$select = "SELECT MAX(norm) AS max_id 
				   FROM balita 
				   WHERE SUBSTRING(norm,'1','12') = '$id_posyandu'";
		return $this->db->query($select)->row();
				   
	}

	public function getFoto($norm = null){
		if(strlen($norm) === 32){
			$norm = $norm;
		}else{
			$norm = MD5($norm);
		}
		$select = "SELECT fotobayi FROM balita WHERE MD5(norm) = '$norm'";

		return $this->db->query($select)->row();
	}
	
	private function get_datatables_query(){
		
		if($_SESSION['level'] == 2){
			$iduser = $_SESSION['idUser'];
			$this->db->where("posyandu.idpos = SUBSTRING('$iduser','1','12')");
		}

		$this->db->select("balita.*,
						   posyandu.namapos AS posyandu,
						   desa.name AS desa,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi")
				 ->join("posyandu","posyandu.idpos = SUBSTRING(balita.norm,'1','12')")
				 ->join("desa", "desa.id = posyandu.desa_id")
				 ->join("kec", "kec.id = desa.district_id")
				 ->join("kab", "kab.id = kec.regency_id")
				 ->join("propinsi", "propinsi.id = kab.province_id")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->where("balita.flag = '0'")
				 ->from("balita");

		$column_search = array('balita.nama',
							   'balita.tgllahir',
							   'balita.jenkel',
							   'balita.namaortu',
							   'balita.nikortu',
							   'balita.gakin',
							   'desa.name',
							   'kec.name',
							   'kab.name',
							   'propinsi.name',
							   'posyandu.namapos');
		$i = 0;

		foreach ($column_search as $item){  // looping awal
			if($_POST['search']['value']){ // jika datatable mengirimkan pencarian dengan metode POST
				
				if($i===0){ // looping awal
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($column_search) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}

		$this->db->order_by("balita.tglInput","DESC");

	// 	echo $this->db->last_query();
	// die();
	}

	

	function get_datatables(){
		$this->get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered(){
		$this->get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all(){
		if($_SESSION['level'] == 2){
			$iduser = $_SESSION['idUser'];
			$this->db->where("posyandu.idpos = SUBSTRING('$iduser','1','12')");
		}
		$this->db->select("balita.*,
						   posyandu.namapos AS posyandu,
						   desa.name AS desa,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi")
				 ->join("posyandu","posyandu.idpos = SUBSTRING(balita.norm,'1','12')")
				 ->join("desa", "desa.id = posyandu.desa_id")
				 ->join("kec", "kec.id = desa.district_id")
				 ->join("kab", "kab.id = kec.regency_id")
				 ->join("propinsi", "propinsi.id = kab.province_id")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->where("balita.flag = '0'")
				 ->from("balita");
		return $this->db->count_all_results();
	}

	public function save($data,$id = null){
		$cek_balita = $this->db->query("SELECT nama 
										FROM balita 
										WHERE nama = '".$data['nama']."' 
										AND nikortu = '".$data['nikortu']."' ".
										(($id != null)? " AND norm != '$id' ":" "))->num_rows();
											
		if($cek_balita > 0){
			$respons = array('status'=>'0',
							 'jenis'=>'simpan',
							 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Maaf, balita terdaftar</strong></font>');
			echo json_encode($respons);
			exit();
		}

		if($id != null){	
			$this->db->where(array("norm"=>$id));
            $update = $this->db->update("balita",$data);
            if($update){
				$respons = array('status'=>'1',
								 'jenis'=>'edit',
								 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil Mengubah Data</strong></font>');
            }else{
                $respons = array('status'=>'0',
								 'jenis'=>'edit',
								 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Gagal Mengubah Data</strong></font>');
            }
		}else{
            $insert = $this->db->insert("balita", $data);
            if($insert){
				$respons = array('status'=>'1',
								 'jenis'=>'simpan',
								 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil Menyimpan Data</strong></font>');
            }else{
				$respons = array('status'=>'0',
								 'jenis'=>'simpan',
								 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Gagal Minyimpan Data</strong></font>');
            }
		}

		echo json_encode($respons);
	}

	public function delete($id = null){
		$cekAktivitasBalita = $this->db->query("SELECT norm 
                                                FROM penimbangan 
                                                WHERE MD5(norm) = '$id'")->num_rows();

		if($cekAktivitasBalita > 0){
			$this->db->where(array("md5(norm)"=>$id));
			$update = $this->db->update("balita",array("flag"=>"1"));
			$respons = array('success'=>'1',
							 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil menghapus data</strong></font>');
		}else{
			$getFoto = $this->getFoto($id)->fotobayi;
			if($getFoto != ""){
                $dir_file = "./".str_replace(base_url(),"",$getFoto);
                
                if(file_exists($dir_file)){
                    unlink($dir_file);
                }
			}
			
			$this->db->where(array("md5(norm)"=>$id));
			$delete = $this->db->delete("balita");
			if($delete){
				$respons = array('success'=>'1',
							 	 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil menghapus data</strong></font>');
			}else{
				$respons = array('status'=>'0',
							 	 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Gagal menghapus data</strong></font>');
			}
		}

        echo json_encode($respons);
	}
}