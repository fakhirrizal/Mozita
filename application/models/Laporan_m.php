<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_m extends CI_Model {

	public function getKab(){
		if($_SESSION['level'] == 2 or $_SESSION['level'] == 4){
			$where = " WHERE id = SUBSTRING('".$_SESSION['idUser']."','1','4')";
		}else{
			$where = " ";
		}
		$select = " SELECT * FROM kab ".
				  $where;
		return $this->db->query($select)->row();
	}

	public function getKec(){
		if($_SESSION['level'] == 2){
			$where = " WHERE id = SUBSTRING('".$_SESSION['idUser']."','1','7')";
		}else if($_SESSION['level'] == 4){
			$idkab = $this->getKab()->id;
			$where = " WHERE regency_id = '$idkab'";
		}else{
			$where = " ";
		}

		$select = " SELECT * FROM kec ".
				  $where;
		return $this->db->query($select);
	}

	public function getDesa(){
		if($_SESSION['level'] == 2){
			$where = " WHERE id = SUBSTRING('".$_SESSION['idUser']."','1','10')";
		}else{
			$where = " ";
		}
		$select = " SELECT * FROM desa ".
				  $where;
		return $this->db->query($select)->row();
	}

	public function getPusk(){
		$idpusk = $this->getDesa()->idpusk;
		$select = " SELECT * FROM puskesmas WHERE idpusk = '$idpusk' ";
		return $this->db->query($select)->row();
	}

	public function getPosy(){
		if($_SESSION['level'] == 2){
			$where = " WHERE idpos = SUBSTRING('".$_SESSION['idUser']."','1','12')";
		}else{
			$where = " ";
		}
		$select = " SELECT * FROM posyandu ".
				  $where;
		return $this->db->query($select)->row();
	}

	public function getBalita($posyandu = null, $blnpenimbangan = null){
        $select = " SELECT balita.nama,
						   balita.jenkel,
						   balita.nmortu,
						   balita.tgllahir,
						   penimbangan.* 
					FROM penimbangan,balita
					WHERE penimbangan.norm = balita.norm
					AND SUBSTRING(penimbangan.norm,'1','12') = '$posyandu'
					AND DATE_FORMAT(penimbangan.tglpenimbangan,'%m-%Y') = '$blnpenimbangan'";
		// var_dump($select);
		return $this->db->query($select);
	}

	public function jumlahPosyandu($id_kab = null, $id_kec = null, $id_desa = null){
		$select = "SELECT namapos
				   FROM posyandu ".
				   (($id_kab == null)? "":" WHERE SUBSTRING(idpos,'1','4') = '$id_kab'").
				   (($id_kec == null)? "":" WHERE SUBSTRING(idpos,'1','7') = '$id_kec'").
				   (($id_desa == null)? "":" WHERE SUBSTRING(idpos,'1','10') = '$id_desa'");
		return $this->db->query($select)->num_rows();

	}

	public function getBalitaAktifLakilaki($id_posyandu = null,$id_kab = null, $id_kec = null, $id_desa = null){
		$select = "SELECT nama
				   FROM balita ".
				   (($id_posyandu == null)? " ":" WHERE SUBSTRING(norm,'1','12') = '$id_posyandu' ").
				   (($id_kab == null)? " ":" WHERE SUBSTRING(norm,'1','4') = '$id_kab' ").
				   (($id_kec == null)?"":" WHERE SUBSTRING(norm,'1','7') = '$id_kec'").
				   (($id_desa == null)?"":" WHERE SUBSTRING(norm,'1','10') = '$id_desa'").
				   " AND aktif = 'Ya'
				   AND jenkel = 'Laki-laki'";
		return $this->db->query($select)->num_rows();
	}

	public function getBalitaAktifPerempuan($id_posyandu = null,$id_kab = null, $id_kec = null, $id_desa = null){
		$select = "SELECT nama
				   FROM balita ".
				   (($id_posyandu == null)? " ":" WHERE SUBSTRING(norm,'1','12') = '$id_posyandu' ").
				   (($id_kab == null)? " ":" WHERE SUBSTRING(norm,'1','4') = '$id_kab' ").
				   (($id_kec == null)?"":" WHERE SUBSTRING(norm,'1','7') = '$id_kec'").
				   (($id_desa == null)?"":" WHERE SUBSTRING(norm,'1','10') = '$id_desa'").
				   " AND aktif = 'Ya'
				   AND jenkel = 'Perempuan'";
		return $this->db->query($select)->num_rows();
	}

	public function getBalitaTimbangLakilaki($posyandu = null, $blnpenimbangan = null, $id_kab = null, $id_kec = null, $id_desa = null){
		
		$select = " SELECT balita.jenkel
					FROM penimbangan,balita
					WHERE penimbangan.norm = balita.norm ".
					(($posyandu == null)?"":" AND SUBSTRING(penimbangan.norm,'1','12') = '$posyandu' ").
					(($id_kab == null)?"":" AND SUBSTRING(penimbangan.norm,'1','4') = '$id_kab' ").
					(($id_kec == null)?"":" AND SUBSTRING(penimbangan.norm,'1','7') = '$id_kec' ").
					(($id_desa == null)?"":" AND SUBSTRING(penimbangan.norm,'1','10') = '$id_desa' ").
					" AND DATE_FORMAT(penimbangan.tglpenimbangan,'%m-%Y') = '$blnpenimbangan'
					AND balita.jenkel = 'Laki-laki'";

		return $this->db->query($select)->num_rows();
	}

	public function getBalitaTimbangPerempuan($posyandu = null, $blnpenimbangan = null, $id_kab = null, $id_kec = null, $id_desa = null){
		$select = " SELECT balita.jenkel
					FROM penimbangan,balita
					WHERE penimbangan.norm = balita.norm ".
					(($posyandu == null)?"":" AND SUBSTRING(penimbangan.norm,'1','12') = '$posyandu' ").
					(($id_kab == null)?"":" AND SUBSTRING(penimbangan.norm,'1','4') = '$id_kab'").
					(($id_kec == null)?"":" AND SUBSTRING(penimbangan.norm,'1','7') = '$id_kec'").
					(($id_desa == null)?"":" AND SUBSTRING(penimbangan.norm,'1','10') = '$id_desa'").
					" AND DATE_FORMAT(penimbangan.tglpenimbangan,'%m-%Y') = '$blnpenimbangan'
					AND balita.jenkel = 'Perempuan'";
		return $this->db->query($select)->num_rows();
	}

	public function getBalitaPunyaKms($id_posyandu = null){
		$select = " SELECT norm 
					FROM balita
					WHERE kms = 'Ya'
					AND SUBSTRING(norm,'1','12') = '$id_posyandu'";
		return $this->db->query($select)->num_rows();			
	}

	public function getBalitaNaikBB($posyandu = null, $blnpenimbangan = null){
		$penimbanganSekarang = date_format(date_create("01-".$blnpenimbangan),"Y-m");
		$penimbanganBulanLalu = date('Y-m', strtotime('-1 month', strtotime($penimbanganSekarang)));

		$balita_ditimbang = $this->getBalita($posyandu,$blnpenimbangan)->result();

		$jumlah = 0;
		foreach($balita_ditimbang as $rows) {
			$cek_penimbangan_bulan_lalu = $this->getPenimbanganBulanlalu($posyandu, $penimbanganBulanLalu, $rows->norm);
			if($cek_penimbangan_bulan_lalu->num_rows() > 0){
				if($rows->bb > $cek_penimbangan_bulan_lalu->row()->bb){
					$jumlah++;
				}
			}
		}

		return $jumlah;

	}


	public function getPenimbanganBulanlalu($posyandu = null, $blnpenimbangan = null, $norm = null){
        $select = " SELECT bb
					FROM penimbangan
					WHERE norm = '$norm'
					AND SUBSTRING(norm,'1','12') = '$posyandu'
					AND DATE_FORMAT(tglpenimbangan,'%m-%Y') = '$blnpenimbangan'";
		// var_dump($select);
		return $this->db->query($select);
	}

	public function getJmlBalitaByBb_u($jenkel = null, $gakin = null, $id_posyandu = null, $blnpenimbangan = null, $bb_u = null, $id_kab = null, $id_kec = null, $id_desa = null){
		$select = " SELECT balita.nama 
					FROM penimbangan, balita
					WHERE penimbangan.norm = balita.norm
					AND balita.jenkel = '$jenkel'
					AND balita.gakin = '$gakin' ".
					(($id_posyandu == null)?" ":" AND SUBSTRING(penimbangan.norm,'1','12') = '$id_posyandu'").
					(($id_kab == null)?" ":" AND SUBSTRING(penimbangan.norm,'1','4') = '$id_kab'").
					(($id_kec == null)?" ":" AND SUBSTRING(penimbangan.norm,'1','7') = '$id_kec'").
					(($id_desa == null)?" ":" AND SUBSTRING(penimbangan.norm,'1','10') = '$id_desa'").
					" AND DATE_FORMAT(penimbangan.tglpenimbangan,'%m-%Y') = '$blnpenimbangan'
					AND penimbangan.bb_u = '$bb_u'";
		return $this->db->query($select)->num_rows();
	}

	public function getBalitaGakin($id_desa = null, $id_propinsi = null, $id_kab = null, $id_kec = null, $id_pusk = null){

		if($id_pusk != null){
			$select = " SELECT id
						FROM desa
						WHERE idpusk = '$id_pusk'";
			$data_desa =  $this->db->query($select)->result();
			foreach ($data_desa as $rows) {
				$idDesa[] = $rows->id;
			}

			if($idDesa != ""){
				$idDesa = implode("','",$idDesa);
			}else{
				$idDesa = "";
			}
		}

		$select = " SELECT nama 
					FROM balita
					WHERE gakin = 'Ya' ".
					(($id_desa == null)?" ": " AND SUBSTRING(norm,'1','10') = '$id_desa'").
					(($id_propinsi == null)?" ": " AND SUBSTRING(norm,'1','2') = '$id_propinsi'").
					(($id_kab == null)?" ": " AND SUBSTRING(norm,'1','4') = '$id_kab'").
					(($id_kec == null)?" ": " AND SUBSTRING(norm,'1','7') = '$id_kec'");
					(($id_pusk == null)?" ": " AND SUBSTRING(norm,'1','10') IN ('$idDesa') ");
		return $this->db->query($select)->num_rows();
	}

	public function getDataByPuskesmas($id_puskesmas){
		$select = " SELECT propinsi.name AS prop,
							kab.name AS kab,
							kec.name AS kec,
							puskesmas.namapusk,
							puskesmas.idpusk,
							desa.name AS desa
					FROM puskesmas
					JOIN desa ON desa.idpusk = puskesmas.idpusk
					JOIN kec ON kec.id= desa.district_id
					JOIN kab ON kab.id = kec.regency_id
					JOIN propinsi ON propinsi.id = kab.province_id
					WHERE puskesmas.idpusk = SUBSTRING('$id_puskesmas','1','7')
					GROUP BY puskesmas.idpusk";
		return $this->db->query($select)->row();			
	}
}