<?php
 header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=".$title.".xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
 
 ?>
<style typew="text/css">
    table {
        border-collapse: collapse;
    }
    td{
        border:1px solid black;
        text-align: center;
    }
    .text{
        mso-number-format:"\@";/*force text*/
    }
    .text-center{
        text-align:center;
        border:0px;
    }
    .text-left{
        text-align:left;
        border:0px;
    }
    .decimal{
        mso-number-format:"0\.000";
    }
</style>

<table style="font-size:12px;">
    <tr>
        <th class="text-left" colspan="21" style="font-size:16px">HASIL PELAKSANAAN BULAN PENIMBANGAN BALITA</th>
    </tr>
    <tr>
        <th class="text-left" colspan="21" style="font-size:16px">BERDASARKAN INDIKATOR BB/U</th>
    </tr>
    <tr>
        <th class="text-center" colspan="21"></th>
    </tr>
    <tr>
        <th class="text-left" colspan="2">PROPINSI</th>
        <th class="text-left" colspan="18">: <?= $nama_propinsi ?></th>
    </tr>
    <tr>
        <th class="text-left" colspan="2">KABUPATEN</th>
        <th class="text-left" colspan="18">: <?= $kabupaten ?></th>
    </tr>
    <tr>
        <th class="text-left" colspan="2">KECAMATAN</th>
        <th class="text-left" colspan="18">: <?= $kecamatan ?></th>
    </tr>
    <tr>
        <th class="text-left" colspan="2">DESA</th>
        <th class="text-left" colspan="18">: <?= $desa ?></th>
    </tr>
    <tr>
        <th class="text-left" colspan="2">PUSKESMAS</th>
        <th class="text-left" colspan="18">: <?= $puskesmas ?></th>
    </tr>
    <tr>
        <th class="text-left" colspan="2">JUMLAH BALITA GAKIN</th>
        <th class="text-left" colspan="18">: <?= $jmlBalitaGakin ?></th>
    </tr>
    <tr>
        <th class="text-center" colspan="20"></th>
    </tr>
    <tr>
        <td rowspan="4" width="30">NO</td>
        <td rowspan="4" width="120">POSYANDU</td>
        <td rowspan="4" width="47">BALITA YANG ADA</td>
        <td rowspan="4" width="50">BALITA YANG DATANG</td>
        <td colspan="16">JUMLAH ANAK MENURUT STATUS GIZI</td>
    </tr>
    <tr>
        <td colspan="8">LAKI LAKI</td>
        <td colspan="8">PEREMPUAN</td>
    </tr>
    <tr>
        <td colspan="2">SANGAT KURANG</td>
        <td colspan="2">KURANG</td>
        <td colspan="2">BAIK</td>
        <td colspan="2">LEBIH</td>
        <td colspan="2">SANGAT KURANG</td>
        <td colspan="2">KURANG</td>
        <td colspan="2">BAIK</td>
        <td colspan="2">LEBIH</td>
    </tr>
    <tr>
        <td width="47">GAKIN</td>
        <td width="47">&ne; GAKIN</td>
        <td width="47">GAKIN</td>
        <td width="47">&ne; GAKIN</td>
        <td width="47">GAKIN</td>
        <td width="47">&ne; GAKIN</td>
        <td width="47">GAKIN</td>
        <td width="47">&ne; GAKIN</td>
        <td width="47">GAKIN</td>
        <td width="47">&ne; GAKIN</td>
        <td width="47">GAKIN</td>
        <td width="47">&ne; GAKIN</td>
        <td width="47">GAKIN</td>
        <td width="47">&ne; GAKIN</td>
        <td width="47">GAKIN</td>
        <td width="47">&ne; GAKIN</td>
    </tr>
    <?php
        $no = 0;
        $balita_ada = 0;
        $balita_timbang = 0;
        $jml_a1 = 0;
        $jml_a2 = 0;
        $jml_b1 = 0;
        $jml_b2 = 0;
        $jml_c1 = 0;
        $jml_c2 = 0;
        $jml_d1 = 0;
        $jml_d2 = 0;
        $jml_e1 = 0;
        $jml_e2 = 0;
        $jml_f1 = 0;
        $jml_f2 = 0;
        $jml_g1 = 0;
        $jml_g2 = 0;
        $jml_h1 = 0;
        $jml_h2 = 0;
        foreach ($data_posyandu as $rows) {
            $no++;
            $jml_balita_aktif_laki_laki = $this->Laporan_m->getBalitaAktifLakilaki($rows->idpos);
            $jml_balita_aktif_perempuan = $this->Laporan_m->getBalitaAktifPerempuan($rows->idpos);

            $balita_ada = $balita_ada + $jml_balita_aktif_laki_laki + $jml_balita_aktif_perempuan;

            $jml_balita_timbang_laki_laki = $this->Laporan_m->getBalitaTimbangLakilaki($rows->idpos,$blnpenimbangan);
            $jml_balita_timbang_perempuan = $this->Laporan_m->getBalitaTimbangPerempuan($rows->idpos,$blnpenimbangan);

            $balita_timbang = $balita_timbang  + $jml_balita_timbang_laki_laki + $jml_balita_timbang_perempuan;
    ?>
        <tr>
            <td><?= $no ?></td>
            <td style="text-align:left"><?= $rows->namapos ?></td>
            <td><?= $jml_balita_aktif_laki_laki + $jml_balita_aktif_perempuan ?> </td>
            <td><?= $jml_balita_timbang_laki_laki + $jml_balita_timbang_perempuan ?></td>
            <td>
                <?php
                    $a1 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Ya', $rows->idpos, $blnpenimbangan, 'Buruk');
                    if($a1== 0){
                        echo "-";
                    }else{
                        $jml_a1 = $jml_a1 + $a1;
                        echo $a1;
                    }
                ?>
            </td>
            <td>
                <?php
                    $a2 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Tidak', $rows->idpos, $blnpenimbangan, 'Buruk');
                    if($a2 == 0){
                        echo "-";
                    }else{
                        $jml_a2 = $jml_a2 + $a2;
                        echo $a2;
                    }
                ?>
            </td>
            <td>
                <?php
                    $b1 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Ya', $rows->idpos, $blnpenimbangan, 'Kurang');
                    if($b1 == 0){
                        echo "-";
                    }else{
                        $jml_b1 = $jml_b1 + $b1;
                        echo $b1;
                    }
                ?>
            </td>
            <td>
                <?php
                    $b2 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Tidak', $rows->idpos, $blnpenimbangan, 'Kurang');
                    if($b2 == 0){
                        echo "-";
                    }else{
                        $jml_b2 = $jml_b2 + $b2;
                        echo $b2;
                    }
                ?>
            </td>
            <td>
                <?php
                    $c1 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Ya', $rows->idpos, $blnpenimbangan, 'Baik');
                    if($c1 == 0){
                        echo "-";
                    }else{
                        $jml_c1 = $jml_c1 + $c1;
                        echo $c1;
                    }
                ?>
            </td>
            <td>
                <?php
                    $c2 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Tidak', $rows->idpos, $blnpenimbangan, 'Baik');
                    if($c2 == 0){
                        echo "-";
                    }else{
                        $jml_c2 = $jml_c2 + $c2;
                        echo $c2;
                    }
                ?>
            </td>
            <td>
                <?php
                    $d1 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Ya', $rows->idpos, $blnpenimbangan, 'Lebih');
                    if($d1 == 0){
                        echo "-";
                    }else{
                        $jml_d1 = $jml_d1 + $d1;
                        echo $d1;
                    }
                ?>
            </td>
            <td>
                <?php
                    $d2 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Tidak', $rows->idpos, $blnpenimbangan, 'Lebih');
                    if($d2 == 0){
                        echo "-";
                    }else{
                        $jml_d2 = $jml_d2 + $d2;
                        echo $d2;
                    }
                ?>
            </td>
            


            <td>
                <?php
                    $e1 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Ya', $rows->idpos, $blnpenimbangan, 'Buruk');
                    if($e1== 0){
                        echo "-";
                    }else{
                        $jml_e1 = $jml_e1 + $e1;
                        echo $e1;
                    }
                ?>
            </td>
            <td>
                <?php
                    $e2 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Tidak', $rows->idpos, $blnpenimbangan, 'Buruk');
                    if($e2 == 0){
                        echo "-";
                    }else{
                        $jml_e2 = $jml_e2 + $e2;
                        echo $e2;
                    }
                ?>
            </td>
            <td>
                <?php
                    $f1 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Ya', $rows->idpos, $blnpenimbangan, 'Kurang');
                    if($f1 == 0){
                        echo "-";
                    }else{
                        $jml_f1 = $jml_f1 + $f1;
                        echo $f1;
                    }
                ?>
            </td>
            <td>
                <?php
                    $f2 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Tidak', $rows->idpos, $blnpenimbangan, 'Kurang');
                    if($f2 == 0){
                        echo "-";
                    }else{
                        $jml_f2 = $jml_f2 + $f2;
                        echo $f2;
                    }
                ?>
            </td>
            <td>
                <?php
                    $g1 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Ya', $rows->idpos, $blnpenimbangan, 'Baik');
                    if($g1 == 0){
                        echo "-";
                    }else{
                        $jml_g1 = $jml_g1 + $g1;
                        echo $g1;
                    }
                ?>
            </td>
            <td>
                <?php
                    $g2 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Tidak', $rows->idpos, $blnpenimbangan, 'Baik');
                    if($g2 == 0){
                        echo "-";
                    }else{
                        $jml_g2 = $jml_g2 + $g2;
                        echo $g2;
                    }
                ?>
            </td>
            <td>
                <?php
                    $h1 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Ya', $rows->idpos, $blnpenimbangan, 'Lebih');
                    if($h1 == 0){
                        echo "-";
                    }else{
                        $jml_h1 = $jml_h1 + $h1;
                        echo $h1;
                    }
                ?>
            </td>
            <td>
                <?php
                    $h2 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Tidak', $rows->idpos, $blnpenimbangan, 'Lebih');
                    if($h2 == 0){
                        echo "-";
                    }else{
                        $jml_h2 = $jml_h2 + $h2;
                        echo $h2;
                    }
                ?>
            </td>
        </tr>
    <?php
        }
    ?>

    <tr>
        <td colspan="2">JUMLAH</td>
        <td><?= $balita_ada ?></td>
        <td><?= $balita_timbang ?></td>
        <td><?= (($jml_a1 == 0)? "-":$jml_a1) ?></td>
        <td><?= (($jml_a2== 0)? "-":$jml_a2) ?></td>
        <td><?= (($jml_b1== 0)? "-":$jml_b1) ?></td>
        <td><?= (($jml_b2== 0)? "-":$jml_b2) ?></td>
        <td><?= (($jml_c1== 0)? "-":$jml_c1) ?></td>
        <td><?= (($jml_c2== 0)? "-":$jml_c2) ?></td>
        <td><?= (($jml_d1== 0)? "-":$jml_d1) ?></td>
        <td><?= (($jml_d2== 0)? "-":$jml_d2) ?></td>
        <td><?= (($jml_e1== 0)? "-":$jml_e1) ?></td>
        <td><?= (($jml_e2== 0)? "-":$jml_e2) ?></td>
        <td><?= (($jml_f1== 0)? "-":$jml_f1) ?></td>
        <td><?= (($jml_f2== 0)? "-":$jml_f2) ?></td>
        <td><?= (($jml_g1== 0)? "-":$jml_g1) ?></td>
        <td><?= (($jml_g2== 0)? "-":$jml_g2) ?></td>
        <td><?= (($jml_h1== 0)? "-":$jml_h1) ?></td>
        <td><?= (($jml_h2== 0)? "-":$jml_h2) ?></td>
    </tr>
</table>