<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kabupaten_m extends CI_Model {

	public function get_data($id_kabupaten = null, $id_propinsi = null){
        $select = " SELECT *
                    FROM kab ".
                    (($id_kabupaten == null)?" " : " WHERE MD5(id) = '$id_kabupaten' ").
                    (($id_propinsi == null)?" " : " WHERE province_id = '$id_propinsi' ");
		return $this->db->query($select);
    }
}