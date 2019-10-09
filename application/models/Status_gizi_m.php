<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status_gizi_m extends CI_Model {

	public function getDataPenimbangan($norm = null, $tgl_penimbangan = null){
        $select = " SELECT balita.*,
						   penimbangan.*,
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
					JOIN penimbangan ON penimbangan.norm = balita.norm
					JOIN posyandu ON posyandu.idpos = SUBSTRING(balita.norm,'1','12')
					JOIN desa ON desa.id = posyandu.desa_id
					JOIN kec ON kec.id = desa.district_id
					JOIN kab ON kab.id = kec.regency_id
					JOIN propinsi ON propinsi.id = kab.province_id
					WHERE propinsi.id = '".$_SESSION['kode_propinsi']."' 
					AND  MD5(balita.norm) = '$norm'
					AND penimbangan.tglpenimbangan = '$tgl_penimbangan'";
		return $this->db->query($select)->row();
	}

	public function getJumlahNotif($jenis = null){
		$level = $_SESSION['level'];
		if($level == '1'){
			$where = " WHERE !FIND_IN_SET('1',baca)";
		}else if($level == '2'){
			$where = " WHERE !FIND_IN_SET('2',baca)";
		}else if($level == '3'){
			$where = " WHERE !FIND_IN_SET('3',baca)";
		}else if($level == '4'){
			$where = " WHERE !FIND_IN_SET('4',baca)";
		}else if($level == '5'){
			$where = " WHERE !FIND_IN_SET('5',baca)";
		}else{
			$where = "";
		}

		if($jenis == 'gizi buruk'){
			$and = " AND bb_u = 'Buruk'";
		}else if($jenis == 'stunting'){
			$and = " AND tb_u_pb_u = 'Sangat Pendek'";
		}else if($jenis == 'bb_tb_bb_pb'){
			$and = " AND bb_tb_bb_pb = 'Sangat Kurus'";
		}else if($jenis == 'imt_u'){
			$and = " AND imt_u IN ('Sangat Kurus','Obesitas')";
		}
		$select = "SELECT norm 
				   FROM penimbangan ".
				   $where.
				   $and;
		return $this->db->query($select)->num_rows();
	}
	
	private function get_datatables_query($jenis = null){
		if($_SESSION['level'] == 2){
			$this->db->where("posyandu.idpos = SUBSTRING('".$_SESSION['idUser']."','1','12')");
		}else if($_SESSION['level'] == 3){
			$this->db->where("desa.idpusk = SUBSTRING('".$_SESSION['idUser']."','1','7')");
		}else if($_SESSION['level'] == 4){
			$this->db->where("kab.id = SUBSTRING('".$_SESSION['idUser']."','1','4')");
		}else if($_SESSION['level'] == 5){
			$this->db->where("propinsi.id = SUBSTRING('".$_SESSION['idUser']."','1','2')");
		}
		
		if($jenis == "balita-gizi-buruk"){
			$where = " penimbangan.bb_u = 'Buruk'";
		}else if($jenis == "balita-stunting"){
			$where = " penimbangan.tb_u_pb_u = 'Sangat Pendek'";
		}else if($jenis == "balita-bb-tb-atau-bb-pb"){
			$where = " penimbangan.bb_tb_bb_pb = 'Sangat Kurus'";
		}else if($jenis == "balita-imt-u"){
			$where = " penimbangan.imt_u IN ('Sangat Kurus','Obesitas')";
		}

		$this->db->select("balita.*,
						   penimbangan.*,
						   posyandu.namapos AS posyandu,
						   desa.name AS desa,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi")
				 ->join("balita","balita.norm = penimbangan.norm") 
				 ->join("posyandu","posyandu.idpos = SUBSTRING(balita.norm,'1','12')")
				 ->join("desa", "desa.id = posyandu.desa_id")
				 ->join("kec", "kec.id = desa.district_id")
				 ->join("kab", "kab.id = kec.regency_id")
				 ->join("propinsi", "propinsi.id = kab.province_id")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->where($where)
				 ->from("penimbangan");

		$column_search = array('balita.nama',
							   'penimbangan.norm',
							   'penimbangan.umurbayi',
							   'penimbangan.tglpenimbangan',
							   'penimbangan.bb',
							   'penimbangan.tb',
							   'penimbangan.pb',
							   'penimbangan.lila',
							   'penimbangan.bb_u',
							   'penimbangan.tb_u_pb_u',
							   'penimbangan.bb_tb_bb_pb',
							   'penimbangan.imt_u',
							   'penimbangan.lila_u',
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

		$this->db->order_by("penimbangan.tglpenimbangan","DESC");
		$this->db->order_by("penimbangan.tgljamentry","DESC");

	// 	echo $this->db->last_query();
	// die();
	}

	

	function get_datatables($jenis = null){
		$this->get_datatables_query($jenis);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($jenis = null){
		$this->get_datatables_query($jenis);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($jenis = null){
		if($_SESSION['level'] == 2){
			$this->db->where("posyandu.idpos = SUBSTRING('".$_SESSION['idUser']."','1','12')");
		}else if($_SESSION['level'] == 3){
			$this->db->where("desa.idpusk = SUBSTRING('".$_SESSION['idUser']."','1','7')");
		}else if($_SESSION['level'] == 4){
			$this->db->where("kab.id = SUBSTRING('".$_SESSION['idUser']."','1','4')");
		}else if($_SESSION['level'] == 5){
			$this->db->where("propinsi.id = SUBSTRING('".$_SESSION['idUser']."','1','2')");
		}

		if($jenis == "balita-gizi-buruk"){
			$where = " penimbangan.bb_u = 'Buruk'";
		}else if($jenis == "balita-stunting"){
			$where = " penimbangan.tb_u_pb_u = 'Sangat Pendek'";
		}else if($jenis == "balita-bb-tb-atau-bb-pb"){
			$where = " penimbangan.bb_tb_bb_pb = 'Sangat Kurus'";
		}else if($jenis == "balita-imt-u"){
			$where = " penimbangan.imt_u IN ('Sangat Kurus','Obesitas')";
		}
		
		$this->db->select("balita.*,
						   penimbangan.*,
						   posyandu.namapos AS posyandu,
						   desa.name AS desa,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi")
				 ->join("balita","balita.norm = penimbangan.norm")	   
				 ->join("posyandu","posyandu.idpos = SUBSTRING(balita.norm,'1','12')")
				 ->join("desa", "desa.id = posyandu.desa_id")
				 ->join("kec", "kec.id = desa.district_id")
				 ->join("kab", "kab.id = kec.regency_id")
				 ->join("propinsi", "propinsi.id = kab.province_id")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->where($where)
				 ->from("penimbangan");
		return $this->db->count_all_results();
	}

	public function baca($norm = null,$tglpenimbangan = null){
		$level = $_SESSION['level'];
		if($level == '1'){
			$baca = '1';
		}else if($level == '2'){
			$baca = '2';
		}else if($level == '3'){
			$baca = '3';
		}else if($level == '4'){
			$baca = '4';
		}

		$cek_baca = $this->db->query("SELECT norm
									  FROM penimbangan
									  WHERE FIND_IN_SET('$baca',baca)
									  AND MD5(norm) = '$norm'
									  AND tglpenimbangan = '$tglpenimbangan'");
		if($cek_baca->num_rows() == 0 ){
			$cek_baca2 = $this->db->query("SELECT baca
										   FROM penimbangan
										   WHERE MD5(norm) = '$norm'
										     AND tglpenimbangan = '$tglpenimbangan'")->row();
			if(empty($cek_baca2->baca)){
				$set_update = "$baca";
			}else{
				$set_update = "CONCAT(baca,',','$baca')";
			}

			$update = "UPDATE penimbangan
					   SET baca = $set_update
					   WHERE MD5(norm) = '$norm'
					     AND tglpenimbangan = '$tglpenimbangan'";
			$query = $this->db->query($update);
			if($query){
				echo "1";
			}else{
				echo "0";
			}
		}
	}
}