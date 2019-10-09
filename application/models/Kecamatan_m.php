<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan_m extends CI_Model {

	public function get_data($id_kecamatan = null, $id_kabupaten = null){
        $select = " SELECT *
                    FROM kec ".
                    (($id_kecamatan == null)?" " : " WHERE MD5(id) = '$id_kecamatan' ").
                    (($id_kabupaten == null)?" " : " WHERE regency_id = '$id_kabupaten' ");
		return $this->db->query($select);
    }
}