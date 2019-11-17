<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Data_user_m extends CI_Model{

	public function getUserById($id_user = null){
		$select = "SELECT userapp.*,
						  posyandu.idpos AS id_posyandu,
						  desa.id AS id_desa,
						  puskesmas.idpusk AS id_pusk,
						  kec.id AS id_kec,
						  kab.id AS id_kab,
						  propinsi.id AS id_prop
					FROM userapp
					LEFT JOIN propinsi ON propinsi.id = SUBSTR(userapp.idUser,'1','2')
					LEFT JOIN kab ON kab.id =  SUBSTR(userapp.idUser,'1','4')
					LEFT JOIN kec ON kec.id = SUBSTR(userapp.idUser,'1','7')
					LEFT JOIN desa ON desa.id = SUBSTR(userapp.idUser,'1','10')
					LEFT JOIN posyandu ON posyandu.idpos = SUBSTR(userapp.idUser,'1','12')
					LEFT JOIN puskesmas ON puskesmas.idpusk = desa.idpusk
					WHERE MD5(userapp.idUser) = '$id_user' ";
		return $this->db->query($select)->row();
	}

	private function get_datatables_query(){		
		if($_SESSION['level'] == 3){
			$this->db->where("userapp.level = 2");
			$this->db->where("desa.idpusk = SUBSTRING('".$_SESSION['idUser']."','1','7')");
		}
		$this->db->select("userapp.*,
						   posyandu.namapos,
						   posyandu.alamatpos,
						   posyandu.rt,
						   posyandu.rw,
						   desa.name AS desa,
						   puskesmas.namapusk AS puskesmas,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi")
				 ->join("posyandu", "posyandu.idpos = SUBSTR(userapp.idUser,'1','12')", "LEFT")
				 ->join("desa", "desa.id = posyandu.desa_id", "LEFT")
				 ->join("kec", "kec.id = desa.district_id", "LEFT")
				 ->join("puskesmas", "puskesmas.idpusk = desa.idpusk", "LEFT")
				 ->join("kab", "kab.id = kec.regency_id", "LEFT")
				 ->join("propinsi", "propinsi.id = kab.province_id", "LEFT")
				 ->where("userapp.level != 1")
				 ->where("userapp.flag = '0'")
				 ->from("userapp");

		$column_search = array('userapp.idUser','userapp.foto','userapp.nip', 'userapp.nama','userapp.phone','userapp.email','userapp.aktif');
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

		$this->db->order_by("userapp.tglInput","DESC");

		// if(isset($_POST['order'])){
		// 	$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		// } 
		// else if(isset($order)){
		// 	$order_by = $order;
		// 	$this->db->order_by(key($order_by), $order_by[key($order_by)]);
		// }
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
		if($_SESSION['level'] == 3){
			$this->db->where("userapp.level = 2");
			$this->db->where("desa.idpusk = SUBSTRING('".$_SESSION['idUser']."','1','7')");
		}
		$this->db->select("userapp.*,
						   posyandu.namapos,
						   posyandu.alamatpos,
						   posyandu.rt,
						   posyandu.rw,
						   desa.name AS desa,
						   puskesmas.namapusk AS puskesmas,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi")
				 ->join("posyandu", "posyandu.idpos = SUBSTR(userapp.idUser,'1','12')", "LEFT")
				 ->join("desa", "desa.id = posyandu.desa_id", "LEFT")
				 ->join("kec", "kec.id = desa.district_id", "LEFT")
				 ->join("puskesmas", "puskesmas.idpusk = desa.idpusk", "LEFT")
				 ->join("kab", "kab.id = kec.regency_id", "LEFT")
				 ->join("propinsi", "propinsi.id = kab.province_id", "LEFT")
				 ->where("userapp.level != 1")
				 ->where("userapp.flag = '0'")
				 ->from("userapp");
		return $this->db->count_all_results();
	}

	public function max_idUser($level = null,$id = null){
		if($level == "2"){
			$where = " WHERE LEVEL = '2' AND SUBSTRING(idUser,'1','14') = '".$id."99'";
		}else if($level == "3"){
			$where = " WHERE LEVEL = '3' AND SUBSTRING(idUser,'1','12') = '".$id."99'";
		}else if($level == "4"){
			$where = " WHERE LEVEL = '4' AND SUBSTRING(idUser,'1','12') = '".$id."00000000'";
		}else if($level == "5"){
			$where = " WHERE LEVEL = '5' AND SUBSTRING(idUser,'1','12') = '".$id."0000000000'";
		}else if($level == "6"){
			$where = " WHERE LEVEL = '6' AND SUBSTRING(idUser,'1','12') = '".$id."0000000000'";
		}else if($level == "7"){
			$where = " WHERE LEVEL = '7' AND SUBSTRING(idUser,'1','12') = '".$id."0000000000'";
		}

		$select = "SELECT MAX(idUser) AS max_id 
				   FROM userapp ".
				   $where;
		return $this->db->query($select)->row();
				   
	}

	public function cek_user_terdaftar($id = null, $phone = null, $email = null){
		$select = "SELECT idUser
				   FROM userapp
				   WHERE (phone = '$phone' OR email = '$email') ".
				   (($id == null)? " ":" AND MD5(idUser) != '$id'");
		return $this->db->query($select)->num_rows();
	}
	public function save($data,$id = null){
		$cek_user = $this->cek_user_terdaftar($id,$data['phone'],$data['email']);
		if($cek_user > 0){
			$respons = array('status'=>'0',
							 'jenis'=>'simpan',
							 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Maaf, nomor seluler atau email sudah terdaftar</strong></font>');
			echo json_encode($respons);
			exit();
		}
		if($id != null){	
			$this->db->where(array("md5(idUser)"=>$id));
            $update = $this->db->update("userapp",$data);
            if($update){
				$respons = array('status'=>'1',
								 'jenis'=>'simpan',
								 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil Mengubah Data</strong></font>');
            }else{
                $respons = array('status'=>'0',
								 'jenis'=>'simpan',
								 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Gagal Mengubah Data</strong></font>');
            }
		}else{
            $insert = $this->db->insert("userapp", $data);
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
		$cekAktivitasUser = $this->db->query("SELECT iduser FROM penimbangan WHERE MD5(iduser) = '$id'")->num_rows();

		if($cekAktivitasUser > 0){
			$this->db->where(array("md5(idUser)"=>$id));
			$update = $this->db->update("userapp",array("flag"=>"1"));
			$message = '<font color="#009900"><i class="fa fa-check-square">&nbsp;</i> Data Berhasil Dihapus </font>';
		}else{
			$this->db->where(array("md5(idUser)"=>$id));
			$delete = $this->db->delete("userapp");
			if($delete){
				$message = '<font color="#009900"><i class="fa fa-check-square">&nbsp;</i> Data Berhasil Dihapus </font>';
			}else{
				$message = "<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Gagal Menghapus Data</font>";
			}
		}

        $validasi ="";
        $validasi .='<div class="card-header" style="background-color: white">';
        $validasi .='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        $validasi .='<h4 class="title">'.$message.'</h4></div>';
		echo $validasi;
	}	

	public function aktif_nonaktif_user($aktif = null,$id = null){
		// echo $aktif;
		// die();
		if($aktif == 'Ya'){
			$update = 'tidak';
			$button = 'ya';
			$message = 'Pengguna berhasil dinonaktifkan';
		}else{
			$update = 'ya';
			$button = 'tidak';
			$message = 'Pengguna berhasil diaktifkan';
		}
		$this->db->where(array("md5(idUser)"=>$id));
		$update = $this->db->update("userapp",array("aktif"=>"$update"));

		// echo $this->db->last_query();
		// die();

		if($update){
			$respons = array('success'=>'1',
							 'button'=>$button,
							 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong>'.$message.'</strong></font>');
		}else{
			$respons = array('success'=>'0',
							 'button'=>'',
							 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Gagal Minyimpan Data</strong></font>');
		}

		echo json_encode($respons);
	}

}
