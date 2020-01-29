<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Convertion {
    public function get_level($level = null){
        switch($level){
            case '1' : return 'Admin'; break;
            case '2' : return 'Bidan / Kader'; break;
            case '3' : return 'Puskesmas'; break;
            case '4' : return 'Dinkes Kabupaten / Kota'; break;
            case '5' : return 'Dinkes Propinsi'; break;
            case '6' : return 'Camat'; break;
            case '7' : return 'Lurah'; break;
            default	: return '-'; break;
        }
    }

	public function latin_to_romawi($nil) {
		switch($nil){
            case '1' : return 'I'; break;
            case '2' : return 'II'; break;
            case '3' : return 'III'; break;
            case '4' : return 'IV'; break;
            case '5' : return 'V'; break;
            case '6' : return 'VI'; break;
            case '7' : return 'VII'; break;
            case '8' : return 'VIII'; break;
            case '9' : return 'IX'; break;
            case '10' : return 'X'; break;
            case '11' : return 'XI'; break;
            case '12' : return 'XII'; break;
            case '13' : return 'XIII'; break;
            case '14' : return 'XIV'; break;
            default	: return '-'; break;
        }
    }

	public function bulan($month) {
		switch($month){
                case '1' : return 'Januari'; break;
                case '2' : return 'Februari'; break;
                case '3' : return 'Maret'; break;
                case '4' : return 'April'; break;
                case '5' : return 'Mei'; break;
                case '6' : return 'Juni'; break;
                case '7' : return 'Juli'; break;
                case '8' : return 'Agustus'; break;
                case '9' : return 'September'; break;
                case '10' : return 'Oktober'; break;
                case '11' : return 'November'; break;
                case '12' : return 'Desember'; break;
                default	: return '-'; break;
        }
    }

	public function hari($hari) {
		switch($hari){
            case '1' : return 'Senin'; break;
            case '2' : return 'Selasa'; break;
            case '3' : return 'Rabu'; break;
            case '4' : return 'Kamis'; break;
            case '5' : return 'Jumat'; break;
            case '6' : return 'Sabtu'; break;
            case '7' : return 'Minggu'; break;
            default	: return '-'; break;
        }
    }

	function get_day($nil = ''){
            switch($nil){
                case 'Sun' : return 'Minggu'; break;
                case 'Mon' : return 'Senin'; break;
                case 'Tue' : return 'Selasa'; break;
                case 'Wed' : return 'Rabu'; break;
                case 'Thu' : return 'Kamis'; break;
                case 'Fri' : return 'Jumat'; break;
                case 'Sat' : return 'Sabtu'; break;
                default	: return '-'; break;
            }
    }

}
?>
