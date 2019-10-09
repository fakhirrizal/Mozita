<div class="row">
    <div class="col-md-12">
        <a href="<?= $url_download ?>">
            <button class="btn pull-right" style="background-color:#28a745; color:#FFFFFF">
                <i class="mdi mdi-file-excel"></i> UNDUH EXCEL
            </button>
        </a>
    </div>
</div>
<div class="row m-t-20">
    <div class="col-md-12">
        <table id="table" class="table table-bordered"style="font-size:10px; color:#000000; font-weight:500; width:100%">
            <tr>
                <th class="text-left" colspan="21" style="padding-bottom: 0px; font-size:16px">HASIL PELAKSANAAN BULAN PENIMBANGAN BALITA</th>
            </tr>
            <tr>
                <th class="text-left" colspan="21" style="padding-top : 0px; font-size:16px">BERDASARKAN INDIKATOR BB/U</th>
            </tr>
            <tr>
                <th class="text-left" colspan="2" style="padding-bottom: 0px;">PROPINSI</th>
                <th class="text-left" colspan="19" style="padding-bottom: 0px;">: <?= $nama_propinsi ?></th>
            </tr>
            <tr>
                <th class="text-left" colspan="2" style="padding-bottom: 0px;">JUMLAH BALITA GAKIN</th>
                <th class="text-left" colspan="19" style="padding-bottom: 0px;">: <?= $jmlBalitaGakin ?></th>
            </tr>
            <tr>
                <th class="text-center" colspan="21"></th>
            </tr>
            <tr>
                <td class="text-center" rowspan="4">NO</td>
                <td class="text-center" rowspan="4">KABUPATEN / KOTA</td>
                <td class="text-center" rowspan="4">JML POSY</td>
                <td class="text-center" rowspan="4">BALITA YANG ADA</td>
                <td class="text-center" rowspan="4">BALITA YANG DATANG</td>
                <td class="text-center" colspan="16">JUMLAH ANAK MENURUT STATUS GIZI</td>
            </tr>
            <tr>
                <td class="text-center" colspan="8">LAKI LAKI</td>
                <td class="text-center" colspan="8">PEREMPUAN</td>
            </tr>
            <tr>
                <td class="text-center" colspan="2">SANGAT KURANG</td>
                <td class="text-center" colspan="2">KURANG</td>
                <td class="text-center" colspan="2">BAIK</td>
                <td class="text-center" colspan="2">LEBIH</td>
                <td class="text-center" colspan="2">SANGAT KURANG</td>
                <td class="text-center" colspan="2">KURANG</td>
                <td class="text-center" colspan="2">BAIK</td>
                <td class="text-center" colspan="2">LEBIH</td>
            </tr>
            <tr>
                <td class="text-center">GAKIN</td>
                <td class="text-center">&ne; GAKIN</td>
                <td class="text-center">GAKIN</td>
                <td class="text-center">&ne; GAKIN</td>
                <td class="text-center">GAKIN</td>
                <td class="text-center">&ne; GAKIN</td>
                <td class="text-center">GAKIN</td>
                <td class="text-center">&ne; GAKIN</td>
                <td class="text-center">GAKIN</td>
                <td class="text-center">&ne; GAKIN</td>
                <td class="text-center">GAKIN</td>
                <td class="text-center">&ne; GAKIN</td>
                <td class="text-center">GAKIN</td>
                <td class="text-center">&ne; GAKIN</td>
                <td class="text-center">GAKIN</td>
                <td class="text-center">&ne; GAKIN</td>
            </tr>
            <?php
                $no = 0;
                $jml_posyandu = 0;
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
                foreach ($data_kabupaten as $rows) {
                    $no++;
                    $jml_balita_aktif_laki_laki = $this->Laporan_m->getBalitaAktifLakilaki($id_posyandu = null,$rows->id);
                    $jml_balita_aktif_perempuan = $this->Laporan_m->getBalitaAktifPerempuan($id_posyandu = null,$rows->id);

                    $balita_ada = $balita_ada + $jml_balita_aktif_laki_laki + $jml_balita_aktif_perempuan;

                    $jml_balita_timbang_laki_laki = $this->Laporan_m->getBalitaTimbangLakilaki($id_posyandu = null, $blnpenimbangan, $rows->id);
                    $jml_balita_timbang_perempuan = $this->Laporan_m->getBalitaTimbangPerempuan($id_posyandu = null, $blnpenimbangan, $rows->id);

                    $balita_timbang = $balita_timbang  + $jml_balita_timbang_laki_laki + $jml_balita_timbang_perempuan;

                    $jml_posy = $this->Laporan_m->jumlahPosyandu($rows->id);
                    $jml_posyandu = $jml_posyandu + $jml_posy;
            ?>
                <tr>
                    <td class="text-center"><?= $no ?></td>
                    <td><?= $rows->name ?></td>
                    <td class="text-center"><?= (($jml_posy == 0)?"-" : $jml_posy) ?></td>
                    <td class="text-center"><?= ((($jml_balita_aktif_laki_laki + $jml_balita_aktif_perempuan) == 0)? "-": $jml_balita_aktif_laki_laki + $jml_balita_aktif_perempuan) ?> </td>
                    <td class="text-center"><?= ((($jml_balita_timbang_laki_laki + $jml_balita_timbang_perempuan) ==0)?"-": $jml_balita_timbang_laki_laki + $jml_balita_timbang_perempuan) ?></td>
                    <td class="text-center">
                        <?php
                            $a1 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Ya', $id_posyandu = null, $blnpenimbangan, 'Buruk', $rows->id);
                            if($a1== 0){
                                echo "-";
                            }else{
                                $jml_a1 = $jml_a1 + $a1;
                                echo $a1;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $a2 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Tidak', $id_posyandu = null, $blnpenimbangan, 'Buruk',$rows->id);
                            if($a2 == 0){
                                echo "-";
                            }else{
                                $jml_a2 = $jml_a2 + $a2;
                                echo $a2;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $b1 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Ya', $id_posyandu = null, $blnpenimbangan, 'Kurang', $rows->id);
                            if($b1 == 0){
                                echo "-";
                            }else{
                                $jml_b1 = $jml_b1 + $b1;
                                echo $b1;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $b2 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Tidak', $id_posyandu = null, $blnpenimbangan, 'Kurang', $rows->id);
                            if($b2 == 0){
                                echo "-";
                            }else{
                                $jml_b2 = $jml_b2 + $b2;
                                echo $b2;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $c1 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Ya', $id_posyandu = null, $blnpenimbangan, 'Baik', $rows->id);
                            if($c1 == 0){
                                echo "-";
                            }else{
                                $jml_c1 = $jml_c1 + $c1;
                                echo $c1;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $c2 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Tidak', $id_posyandu = null, $blnpenimbangan, 'Baik', $rows->id);
                            if($c2 == 0){
                                echo "-";
                            }else{
                                $jml_c2 = $jml_c2 + $c2;
                                echo $c2;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $d1 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Ya', $id_posyandu = null, $blnpenimbangan, 'Lebih', $rows->id);
                            if($d1 == 0){
                                echo "-";
                            }else{
                                $jml_d1 = $jml_d1 + $d1;
                                echo $d1;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $d2 = $this->Laporan_m->getJmlBalitaByBb_u('Laki-laki', 'Tidak', $id_posyandu = null, $blnpenimbangan, 'Lebih', $rows->id);
                            if($d2 == 0){
                                echo "-";
                            }else{
                                $jml_d2 = $jml_d2 + $d2;
                                echo $d2;
                            }
                        ?>
                    </td>
                    


                    <td class="text-center">
                        <?php
                            $e1 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Ya', $id_posyandu = null, $blnpenimbangan, 'Buruk', $rows->id);
                            if($e1== 0){
                                echo "-";
                            }else{
                                $jml_e1 = $jml_e1 + $e1;
                                echo $e1;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $e2 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Tidak', $id_posyandu = null, $blnpenimbangan, 'Buruk', $rows->id);
                            if($e2 == 0){
                                echo "-";
                            }else{
                                $jml_e2 = $jml_e2 + $e2;
                                echo $e2;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $f1 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Ya', $id_posyandu = null, $blnpenimbangan, 'Kurang', $rows->id);
                            if($f1 == 0){
                                echo "-";
                            }else{
                                $jml_f1 = $jml_f1 + $f1;
                                echo $f1;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $f2 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Tidak', $id_posyandu = null, $blnpenimbangan, 'Kurang', $rows->id);
                            if($f2 == 0){
                                echo "-";
                            }else{
                                $jml_f2 = $jml_f2 + $f2;
                                echo $f2;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $g1 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Ya', $id_posyandu = null, $blnpenimbangan, 'Baik', $rows->id);
                            if($g1 == 0){
                                echo "-";
                            }else{
                                $jml_g1 = $jml_g1 + $g1;
                                echo $g1;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $g2 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Tidak', $id_posyandu = null, $blnpenimbangan, 'Baik', $rows->id);
                            if($g2 == 0){
                                echo "-";
                            }else{
                                $jml_g2 = $jml_g2 + $g2;
                                echo $g2;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $h1 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Ya', $id_posyandu = null, $blnpenimbangan, 'Lebih', $rows->id);
                            if($h1 == 0){
                                echo "-";
                            }else{
                                $jml_h1 = $jml_h1 + $h1;
                                echo $h1;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                            $h2 = $this->Laporan_m->getJmlBalitaByBb_u('Perempuan', 'Tidak', $id_posyandu = null, $blnpenimbangan, 'Lebih', $rows->id);
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
                <td class="text-center" colspan="2">JUMLAH</td>
                <td class="text-center"><?= $jml_posyandu ?></td>
                <td class="text-center"><?= $balita_ada ?></td>
                <td class="text-center"><?= $balita_timbang ?></td>
                <td class="text-center"><?= (($jml_a1 == 0)? "-":$jml_a1) ?></td>
                <td class="text-center"><?= (($jml_a2== 0)? "-":$jml_a2) ?></td>
                <td class="text-center"><?= (($jml_b1== 0)? "-":$jml_b1) ?></td>
                <td class="text-center"><?= (($jml_b2== 0)? "-":$jml_b2) ?></td>
                <td class="text-center"><?= (($jml_c1== 0)? "-":$jml_c1) ?></td>
                <td class="text-center"><?= (($jml_c2== 0)? "-":$jml_c2) ?></td>
                <td class="text-center"><?= (($jml_d1== 0)? "-":$jml_d1) ?></td>
                <td class="text-center"><?= (($jml_d2== 0)? "-":$jml_d2) ?></td>
                <td class="text-center"><?= (($jml_e1== 0)? "-":$jml_e1) ?></td>
                <td class="text-center"><?= (($jml_e2== 0)? "-":$jml_e2) ?></td>
                <td class="text-center"><?= (($jml_f1== 0)? "-":$jml_f1) ?></td>
                <td class="text-center"><?= (($jml_f2== 0)? "-":$jml_f2) ?></td>
                <td class="text-center"><?= (($jml_g1== 0)? "-":$jml_g1) ?></td>
                <td class="text-center"><?= (($jml_g2== 0)? "-":$jml_g2) ?></td>
                <td class="text-center"><?= (($jml_h1== 0)? "-":$jml_h1) ?></td>
                <td class="text-center"><?= (($jml_h2== 0)? "-":$jml_h2) ?></td>
            </tr>
            
        </table>
    </div>
</div>
