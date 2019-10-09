<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Propinsi_m extends CI_Model {

	public function get_data($id_propinsi = null){
        $select = " SELECT *
                    FROM propinsi ".
                    (($id_propinsi == null)?" " : " WHERE id = '$id_propinsi' ");
		return $this->db->query($select);
    }

    public function getPropinsiByName($nama_propinsi = null){
        $select = " SELECT *
                    FROM propinsi 
                    WHERE name = '$nama_propinsi' ";
		return $this->db->query($select);
    }

    public function save($data,$id = null){
        $this->db->where(array("id"=>$id));
        $update = $this->db->update("propinsi",$data);
        if($update){
            $respons = array('success'=>'1',
                             'id'=>$data['id'],
                             'message'=>'<font color="#009900"><i class="fa fa-check-square">&nbsp;</i><strong> Berhasil Mengubah Data</strong></font>');
        }else{
            $respons = array('success'=>'0',
                             'id'=>'',
                             'message'=>'<font color="#eb3a28"><i class="fa fa-exclamation-triangle">&nbsp;</i><strong> Gagal Mengubah Data</strong></font>');
        }

        echo json_encode($respons);
		
	}
}