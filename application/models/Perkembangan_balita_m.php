<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perkembangan_balita_m extends CI_Model {

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

	public function getPeriodePenimbangan($norm = null){
		$select = " SELECT MIN(tglpenimbangan) AS min_tanggal,
						   MAX(tglpenimbangan) AS max_tanggal
					FROM penimbangan
					WHERE norm = '$norm'";
		return $this->db->query($select)->row();
	}

	public function getPenimbangan($norm = null, $tgl_penimbangan = null){
		$select = " SELECT DATE_FORMAT(tglpenimbangan, '%Y-%m') AS tanggal,
							bb,
							tb,
							pb,
							lila 
					FROM penimbangan 
					WHERE norm = '$norm' 
					  AND DATE_FORMAT(tglpenimbangan,'%Y-%m') = '$tgl_penimbangan' ";
		
		return $this->db->query($select)->row();

	}
}