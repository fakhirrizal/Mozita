<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Login_m extends CI_Model{

    public function cek_user($username = null, $password = null) {
        $select = " SELECT userapp.*,
                            posyandu.namapos,
                            posyandu.alamatpos,
                            posyandu.rt,
                            posyandu.rw,
                            desa.name AS desa,
                            puskesmas.namapusk AS puskesmas,
                            kec.name AS kecamatan,
                            kab.name AS kabupaten,
                            propinsi.name AS propinsi
                    FROM userapp
                    LEFT JOIN posyandu ON posyandu.idpos = SUBSTR(userapp.idUser,'1','12')
                    LEFT JOIN desa ON desa.id = posyandu.desa_id
                    LEFT JOIN kec ON kec.id = desa.district_id
                    LEFT JOIN puskesmas ON puskesmas.idpusk = desa.idpusk
                    LEFT JOIN kab ON kab.id = kec.regency_id
                    LEFT JOIN propinsi ON propinsi.id = kab.province_id
                    WHERE IF(userapp.email = '$username', 1, IF(userapp.phone = '$username', 1, 0))
                      AND userapp.password = '$password'";
        // var_dump($select);
        // die();
        return $this->db->query($select);
    }

    public function get_kode_propinsi(){
        $select = "SELECT * FROM propinsi";
        return $this->db->query($select)->row();
    }
}
