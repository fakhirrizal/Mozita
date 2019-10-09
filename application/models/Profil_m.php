<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_m extends CI_Model {

	public function get_data(){
        $select = " SELECT *
					FROM userapp
					WHERE idUser = '".$_SESSION['idUser']."'";
		return $this->db->query($select)->row();
	}

	public function save($data){			
		$this->db->where(array("idUser"=>$_SESSION['idUser']));
		$update = $this->db->update("userapp",$data);
		if($update){
			if(isset($data['foto'])){
				$this->session->set_userdata(array('foto' => $data['foto']));
				$url_foto = $data['foto'];
			}else{
				$url_foto = '';
			}
			
			$respons = array('status'=>'1',
							 'url_foto'=>$url_foto,
							 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil Mengubah Data</strong></font>');
		}else{
			$respons = array('status'=>'0',
							 'url_foto'=>'',
							 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Gagal Mengubah Data</strong></font>');
		}

		echo json_encode($respons);
	}


	public function ubah_sandi($new_password){			
		$this->db->where(array("idUser"=>$_SESSION['idUser']));
		$update = $this->db->update("userapp",array("password"=>"$new_password"));
		if($update){			
			$respons = array('status'=>'1',
							 'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil Mengubah Password</strong></font>');
		}else{
			$respons = array('status'=>'0',
							 'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Gagal Mengubah Password</strong></font>');
		}

		echo json_encode($respons);
	}
}