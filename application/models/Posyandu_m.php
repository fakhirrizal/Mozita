<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posyandu_m extends CI_Model {
	// kodingan lama
	// public function posyanduById($idpos = null){
    //     $select = " SELECT posyandu.*,
	// 					   desa.id AS id_desa,
	// 					   kec.id AS id_kec,
	// 					   kab.id AS id_kab,
	// 					   propinsi.id AS id_prop,
	// 					   puskesmas.idpusk AS id_pusk,
	// 					   puskesmas.namapusk
	// 				FROM posyandu
	// 				JOIN desa ON desa.id = posyandu.desa_id
	// 				JOIN kec ON kec.id = desa.district_id
	// 				JOIN kab ON kab.id = kec.regency_id
	// 				JOIN propinsi ON propinsi.id = kab.province_id
	// 				JOIN puskesmas ON puskesmas.idpusk = desa.idpusk
	// 				WHERE propinsi.id = '".$_SESSION['kode_propinsi']."'
	// 				  AND posyandu.flag = '0'
	// 				  AND MD5(posyandu.idpos) = '$idpos'";
	// 	return $this->db->query($select)->row();
	// }
	// kodingan baru
	public function posyanduById($idpos = null){
        $select = " SELECT posyandu.*,
						   desa.id AS id_desa,
						   kec.id AS id_kec,
						   kab.id AS id_kab,
						   propinsi.id AS id_prop,
						   puskesmas.idpusk AS id_pusk,
						   puskesmas.namapusk
					FROM posyandu
					JOIN desa ON desa.id = posyandu.desa_id
					JOIN kec ON kec.id = desa.district_id
					JOIN kab ON kab.id = kec.regency_id
					JOIN propinsi ON propinsi.id = kab.province_id
					LEFT JOIN puskesmas ON puskesmas.idpusk = posyandu.idpusk
					WHERE propinsi.id = '".$_SESSION['kode_propinsi']."'
					  AND posyandu.flag = '0'
					  AND MD5(posyandu.idpos) = '$idpos'";
		return $this->db->query($select)->row();
	}

	public function posyanduByIdDesa($desa_id = null){
        $select = "SELECT *
                   FROM posyandu
				   WHERE desa_id = '$desa_id'";
		return $this->db->query($select);
	}
	
	private function get_datatables_query(){
		
				
		if($_SESSION["level"] == 3){
			$id_puskesmas = substr($_SESSION['idUser'],0,7);
			$this->db->where("desa.idpusk = '$id_puskesmas'");
		}
		// kodingan lama
		// $this->db->select("posyandu.*,
		// 				   desa.name AS desa,
		// 				   kec.name AS kecamatan,
		// 				   kab.name AS kabupaten,
		// 				   propinsi.name AS propinsi,
		// 				   puskesmas.namapusk AS puskesmas")
		// 		 ->join("desa", "desa.id = posyandu.desa_id")
		// 		 ->join("kec", "kec.id = desa.district_id")
		// 		 ->join("kab", "kab.id = kec.regency_id")
		// 		 ->join("propinsi", "propinsi.id = kab.province_id")
		// 		 ->join("puskesmas", "puskesmas.idpusk = desa.idpusk")
		// 		 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
		// 		 ->where("posyandu.flag = '0'")
		// 		 ->from("posyandu");
		// kodingan baru
		$this->db->select("posyandu.*,
						   desa.name AS desa,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi,
						   puskesmas.namapusk AS puskesmas")
				 ->join("desa", "desa.id = posyandu.desa_id")
				 ->join("kec", "kec.id = desa.district_id")
				 ->join("kab", "kab.id = kec.regency_id")
				 ->join("propinsi", "propinsi.id = kab.province_id")
				 ->join("puskesmas", "puskesmas.idpusk = posyandu.idpusk", "LEFT")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->where("posyandu.flag = '0'")
				 ->from("posyandu");

		$column_search = array('posyandu.namapos',
							   'posyandu.alamatpos',
							   'posyandu.rt',
							   'posyandu.rw',
							   'desa.name',
							   'kec.name',
							   'kab.name',
							   'propinsi.name',
							   'puskesmas.namapusk');
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

		$this->db->order_by("posyandu.tglInput","DESC");

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
		if($_SESSION["level"] == 3){
			$id_puskesmas = substr($_SESSION['idUser'],0,7);
			$this->db->where("desa.idpusk = '$id_puskesmas'");
		}
		$this->db->select("posyandu.*,
						   desa.name AS desa,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi,
						   puskesmas.namapusk AS puskesmas")
				 ->join("desa", "desa.id = posyandu.desa_id")
				 ->join("kec", "kec.id = desa.district_id")
				 ->join("kab", "kab.id = kec.regency_id")
				 ->join("propinsi", "propinsi.id = kab.province_id")
				 ->join("puskesmas", "puskesmas.idpusk = desa.idpusk")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->where("posyandu.flag = '0'")
				 ->from("posyandu");
		return $this->db->count_all_results();
	}

	public function max_idpos($id_desa= null){

		$select = "SELECT MAX(idpos) AS max_id 
				   FROM posyandu 
				   WHERE desa_id = '".$id_desa."'";
		return $this->db->query($select)->row();
				   
	}

	public function save($data,$id = null){
		$cek_posyandu = $this->db->query("SELECT namapos 
										  FROM posyandu 
										  WHERE namapos = '".$data['namapos']."' 
											AND desa_id = '".$data['desa_id']."' ".
										  (($id != null)? " AND MD5(idpos) != '$id' ":" "))->num_rows();
											
		if($cek_posyandu > 0){
			$respons = array('status'=>'0',
							 'jenis'=>'simpan',
							 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Maaf, nama posyandu sudah terdaftar</strong></font>');
			echo json_encode($respons);
			exit();
		}

		if($id != null){	
			$this->db->where(array("md5(idpos)"=>$id));
            $update = $this->db->update("posyandu",$data);
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
            $insert = $this->db->insert("posyandu", $data);
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
		$cekAktivitasPosyandu = $this->db->query("SELECT idUser 
                                                  FROM userapp 
                                                  WHERE LEVEL = '2' 
                                                    AND MD5(SUBSTRING(idUser,'1','12')) = '$id'")->num_rows();

		if($cekAktivitasPosyandu > 0){
			$this->db->where(array("md5(idpos)"=>$id));
			$update = $this->db->update("posyandu",array("flag"=>"1"));
			$respons = array('success'=>'1',
							 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil menghapus data</strong></font>');
		}else{
			$this->db->where(array("md5(idpos)"=>$id));
			$delete = $this->db->delete("posyandu");
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