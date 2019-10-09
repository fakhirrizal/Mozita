<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penimbangan_m extends CI_Model {

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

	public function getBalitaByPosyandu($id_posyandu = null){
        $select = "SELECT norm
                   FROM balita
				   WHERE SUBSTRING(norm,'1','12') = '$id_posyandu'";
		// var_dump($select);
		// die();
		return $this->db->query($select)->row();
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
			$this->db->where("posyandu.idpos = SUBSTRING('".$_SESSION['idUser']."','1','12')");
		}

		$this->db->select("balita.*,
						   penimbangan.*,
						   posyandu.namapos AS posyandu,
						   desa.name AS desa,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi")
				 ->join("penimbangan","penimbangan.norm = balita.norm")	  
				 ->join("posyandu","posyandu.idpos = SUBSTRING(balita.norm,'1','12')")
				 ->join("desa", "desa.id = posyandu.desa_id")
				 ->join("kec", "kec.id = desa.district_id")
				 ->join("kab", "kab.id = kec.regency_id")
				 ->join("propinsi", "propinsi.id = kab.province_id")
				 ->where("propinsi.id = '".$_SESSION['kode_propinsi']."'")
				 ->from("balita");

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
			$this->db->where("posyandu.idpos = SUBSTRING('".$_SESSION['idUser']."','1','12')");
		}
		$this->db->select("balita.*,
						   penimbangan.*,
						   posyandu.namapos AS posyandu,
						   desa.name AS desa,
						   kec.name AS kecamatan,
						   kab.name AS kabupaten,
						   propinsi.name AS propinsi")
				 ->join("penimbangan","penimbangan.norm = balita.norm")	   
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

	public function hitung_bb_u($data = null){
		$get_simpang_baku = $this->db->query("SELECT * FROM bb_u WHERE jenkel = '".$data['jenkel']."' AND umur = '".$data['umur']."'");
		if($get_simpang_baku->num_rows() > 0){
			$simpang_baku = $get_simpang_baku->row();

			$nilai_median = $simpang_baku->median;

			if($data['umur'] < $nilai_median){
				$nilai_simpang_baku_rujukan = $nilai_median - $simpang_baku->_SD1;
			}else{
				$nilai_simpang_baku_rujukan = $simpang_baku->SD1 - $nilai_median;
			}

			$z_score = ($data['bb'] - $nilai_median) / $nilai_simpang_baku_rujukan;

			if($z_score < -3){
				$status_gizi = "Buruk";
			}else if($z_score == -3 or $z_score < -2){
				$status_gizi = "Kurang";
			}else if($z_score == -2 or $z_score <= 2){
				$status_gizi = "Baik";
			}else if($z_score > 2){
				$status_gizi = "Lebih";
			}

			$respons = array('status'=>'1',
							 'status_gizi'=>$status_gizi);

		}else{
			$respons = array('status'=>'0',
							 'status_gizi'=>'');
		}

		echo json_encode($respons);
	}


	public function hitung_pb_u_tb_u($data = null){
		$get_simpang_baku = $this->db->query("SELECT * FROM pb_u_tb_u WHERE jenkel = '".$data['jenkel']."' AND umur = '".$data['umur']."'");
		if($get_simpang_baku->num_rows() > 0){
			$simpang_baku = $get_simpang_baku->row();

			$nilai_median = $simpang_baku->median;

			if($data['umur'] == 0 or $data['umur'] <= 24){
				$nilai_individu_subyek = $data['pb'];
				$nilai_simpang_baku_rujukan = $nilai_median - $simpang_baku->_SD1;
			}else{
				$nilai_individu_subyek = $data['tb'];
				$nilai_simpang_baku_rujukan = $simpang_baku->SD1 - $nilai_median;
			}

			$z_score = ($nilai_individu_subyek - $nilai_median) / $nilai_simpang_baku_rujukan;

			if($z_score < -3){
				$status_gizi = "Sangat Pendek";
			}else if($z_score == -3 or $z_score < -2){
				$status_gizi = "Pendek";
			}else if($z_score == -2 or $z_score <= 2){
				$status_gizi = "Normal";
			}else if($z_score > 2){
				$status_gizi = "Tinggi";
			}

			$respons = array('status'=>'1',
							 'status_gizi'=>$status_gizi);

		}else{
			$respons = array('status'=>'0',
							 'status_gizi'=>'');
		}

		echo json_encode($respons);
	}

	public function hitung_bb_pb_bb_tb($data = null){
		$get_simpang_baku = $this->db->query("SELECT * FROM bb_pb_bb_tb WHERE jenkel = '".$data['jenkel']."' AND umur = '".$data['umur']."'");
		if($get_simpang_baku->num_rows() > 0){
			$simpang_baku = $get_simpang_baku->row();

			$nilai_median = $simpang_baku->median;

			if($data['umur'] == 0 or $data['umur'] <= 24){
				$nilai_individu_subyek = $data['bb'];
				$nilai_simpang_baku_rujukan = $nilai_median - $simpang_baku->_SD1;
			}else{
				$nilai_individu_subyek = $data['bb'];
				$nilai_simpang_baku_rujukan = $simpang_baku->SD1 - $nilai_median;
				
			}

			$z_score = ($nilai_individu_subyek - $nilai_median) / $nilai_simpang_baku_rujukan;

			if($z_score < -3){
				$status_gizi = "Sangat Kurus";
			}else if($z_score == -3 or $z_score < -2){
				$status_gizi = "Kurus";
			}else if($z_score == -2 or $z_score <= 2){
				$status_gizi = "Normal";
			}else if($z_score > 2){
				$status_gizi = "Gemuk";
			}

			$respons = array('status'=>'1',
							 'status_gizi'=>$status_gizi);

		}else{
			$respons = array('status'=>'0',
							 'status_gizi'=>'');
		}

		echo json_encode($respons);
	}

	public function hitung_imt_u($data = null){
		$get_simpang_baku = $this->db->query("SELECT * FROM imt_u WHERE jenkel = '".$data['jenkel']."' AND umur = '".$data['umur']."'");
		if($get_simpang_baku->num_rows() > 0){
			$simpang_baku = $get_simpang_baku->row();
			$nilai_median = $simpang_baku->median;

			$tb = $data['tb'] / 100;
			$imt = $data['bb'] / ($tb * $tb);

			if($imt  > $nilai_median){
				$z_score = ($imt - $nilai_median) / ($simpang_baku->SD1 - $nilai_median);
			}else{
				$z_score = ($imt - $nilai_median) / ($nilai_median - $simpang_baku->_SD1);
			}

			if($data['umur'] == 0 or $data['umur'] <= 60){
				if($z_score < -3){
					$status_gizi = "Sangat Kurus";
				}else if($z_score == -3 or $z_score < -2){
					$status_gizi = "Kurus";
				}else if($z_score == -2 or $z_score <= 2){
					$status_gizi = "Normal";
				}else if($z_score > 2){
					$status_gizi = "Gemuk";
				}
			}else if($data['umur'] > 60 or $data['umur'] <= 216){
				if($z_score < -3){
					$status_gizi = "Sangat Kurus";
				}else if($z_score == -3 or $z_score < -2){
					$status_gizi = "Kurus";
				}else if($z_score == -2 or $z_score <= 1){
					$status_gizi = "Normal";
				}else if($z_score > 1 or $z_score <= 2){
						$status_gizi = "Gemuk";
				}else if($z_score > 2){
					$status_gizi = "Obesitas";
				}
			}

			$respons = array('status'=>'1',
							 'status_gizi'=>$status_gizi);

		}else{
			$respons = array('status'=>'0',
							 'status_gizi'=>'');
		}

		echo json_encode($respons);
	}

	public function save($data,$id = null, $tglPenimbangan = null){

		$cek_penimbangan = $this->db->query("SELECT norm
										FROM penimbangan 
										WHERE norm = '".$data['norm']."' 
										AND tglpenimbangan = '".$data['tglpenimbangan']."' ".
										(($id != null && $tglPenimbangan != null)? " AND MD5(norm) != '$id' AND tglpenimbangan = '$tglPenimbangan'":" "))->num_rows();

		if($cek_penimbangan > 0){
			$respons = array('status'=>'0',
							 'jenis'=>'simpan',
							 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Maaf, balita sudah ditimbang</strong></font>');
			echo json_encode($respons);
			exit();
		}

		if($id != null){
			
			$this->db->where(array("MD5(norm)"=>$id,"tglpenimbangan"=>$tglPenimbangan));
            $update = $this->db->update("penimbangan",$data);
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
            $insert = $this->db->insert("penimbangan", $data);
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

	public function delete($id = null,$tglpenimbangan = null){
		$this->db->where(array("md5(norm)"=>$id,"tglpenimbangan"=>$tglpenimbangan));
		$delete = $this->db->delete("penimbangan");
		if($delete){
			$respons = array('success'=>'1',
								'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil menghapus data</strong></font>');
		}else{
			$respons = array('status'=>'0',
								'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Gagal menghapus data</strong></font>');
		}

        echo json_encode($respons);
	}
}