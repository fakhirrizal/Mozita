<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desa_m extends CI_Model {

    public function get_data($id_desa = null){
        $select = "SELECT *
                   FROM desa ".
                   (($id_desa != null)? "WHERE MD5(id) = '$id_desa'":"");
		return $this->db->query($select);
    }
    
    public function desaByIdpusk($id_puskesmas = null){
        $select = "SELECT desa.*
                   FROM desa,puskesmas
                   WHERE desa.idpusk = puskesmas.idpusk
                   AND puskesmas.idpusk = '$id_puskesmas'";
        // var_dump($select);
		return $this->db->query($select);
    }

    public function desaByIdKec($id_kec = null){
        $select = "SELECT *
                   FROM desa
                   WHERE district_id = '$id_kec'";
		return $this->db->query($select);
    }
}