<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puskesmas_m extends CI_Model {

    // public function puskesmasById($id_pusk = null){
    //     $select = " SELECT namapusk
    //                 FROM puskesmas
    //                 WHERE idpusk = '$id_pusk'";
	// 	return $this->db->query($select);
	// }
	
	public function puskesmasById($id_pusk = null){
        $select = " SELECT puskesmas.*,
						   propinsi.name AS prop,
						   kab.name AS kab,
						   kab.id AS id_kab
					FROM puskesmas,propinsi,kab
					WHERE SUBSTRING(puskesmas.idpusk,'1','2') = propinsi.id
					AND SUBSTRING(puskesmas.idpusk,'1','4') = kab.id
					AND MD5(puskesmas.idpusk) = '$id_pusk'";

		return $this->db->query($select);
    }

	public function puskesmasByIdKecamatan($id_kecamatan = null){
        $select = " SELECT puskesmas.*
                    FROM kec,desa,puskesmas
                    WHERE kec.id = desa.district_id
                      AND desa.idpusk = puskesmas.idpusk 
                      AND kec.id = '$id_kecamatan'
                    GROUP BY puskesmas.idpusk
                    ORDER BY puskesmas.namapusk ASC";
		return $this->db->query($select);
	}

	// kodingan baru
	// public function puskesmasByIdKecamatan($id_kecamatan = null){
    //     $select = " SELECT puskesmas.*
    //                 FROM puskesmas
    //                 WHERE id_kecamatan = '$id_kecamatan'";
	// 	return $this->db->query($select);
	// }

	public function max_idpusk($idkab= null){

		$select = "SELECT MAX(idpusk) AS max_id 
				   FROM puskesmas 
				   WHERE SUBSTRING(idpusk,'1','4') = '".$idkab."'";
		return $this->db->query($select)->row();
				   
	}
	
	private function get_datatables_query(){

		$this->db->select("puskesmas.*,
						   propinsi.name AS prop,
						   kab.name AS kab")
				 ->join("propinsi", "propinsi.id = SUBSTRING(puskesmas.idpusk,'1','2')")
				 ->join("kab", "kab.id = SUBSTRING(puskesmas.idpusk,'1','4')")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->where("puskesmas.flag = '0'")
				 ->from("puskesmas");

		$column_search = array('puskesmas.namapusk',
							   'puskesmas.almtpusk',
							   'puskesmas.jenis',
							   'puskesmas.keppusk',
							   'puskesmas.nipkep',
							   'puskesmas.nutripusk',
							   'puskesmas.nipnutri',
							   'kab.name',
							   'propinsi.name');
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

		$this->db->order_by("puskesmas.tglInput","DESC");

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
		$this->db->select("puskesmas.*,
						   propinsi.name AS prop,
						   kab.name AS kab")
				 ->join("propinsi", "propinsi.id = SUBSTRING(puskesmas.idpusk,'1','2')")
				 ->join("kab", "kab.id = SUBSTRING(puskesmas.idpusk,'1','4')")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->where("puskesmas.flag = '0'")
				 ->from("puskesmas");
		return $this->db->count_all_results();
	}

	public function max_idpos($id_desa= null){

		$select = "SELECT MAX(idpos) AS max_id 
				   FROM posyandu 
				   WHERE desa_id = '".$id_desa."'";
		return $this->db->query($select)->row();
				   
	}

	public function save($data,$id = null){
		$cek_puskesmas = $this->db->query("SELECT namapusk 
										   FROM puskesmas 
										   WHERE namapusk = '".$data['namapusk']."' 
											AND keppusk = '".$data['keppusk']."' ".
										  (($id != null)? " AND MD5(idpusk) != '$id' ":" "))->num_rows();
											
		if($cek_puskesmas > 0){
			$respons = array('status'=>'0',
							 'jenis'=>'simpan',
							 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Maaf, nama puskesmas sudah terdaftar</strong></font>');
			echo json_encode($respons);
			exit();
		}

		if($id != null){	
			$this->db->where(array("md5(idpusk)"=>$id));
            $update = $this->db->update("puskesmas",$data);
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
            $insert = $this->db->insert("puskesmas", $data);
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
		$cekAktivitasPuskesmas = $this->db->query("SELECT idpusk 
                                                  FROM desa 
                                                  WHERE MD5(idpusk) = '$id'")->num_rows();

		if($cekAktivitasPuskesmas > 0){
			$this->db->where(array("md5(idpusk)"=>$id));
			$update = $this->db->update("puskesmas",array("flag"=>"1"));
			$respons = array('success'=>'1',
							 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil menghapus data</strong></font>');
		}else{
			$this->db->where(array("md5(idpusk)"=>$id));
			$delete = $this->db->delete("puskesmas");
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