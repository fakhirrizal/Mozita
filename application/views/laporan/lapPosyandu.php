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
        <table id="table" class="table table-bordered" style="font-size:10px; color:#000000; font-weight:500; width:100%">
            <thead>
                <tr>
                    <th colspan="3">1. PROPINSI</th>
                    <th colspan="8">: <?= $nama_propinsi ?></th>
                    <th colspan="4">5. NAMA POSYANDU</th>
                    <th colspan="7">: <?= $posyandu ?></th>
                </tr>
                <tr>
                    <th colspan="3">2. KABUPATEN / KOTA</th>
                    <th colspan="8">: <?= $kabupaten ?></th>
                    <th colspan="4">6. JUMLAH BALITA YANG ADA (L/P)</th>
                    <th colspan="7">: <?= $jml_balita_aktif_laki_laki." / ".$jml_balita_aktif_perempuan ?></th>
                </tr>
                <tr>
                    <th colspan="3">3. KECAMATAN</th>
                    <th colspan="8">: <?= $kecamatan ?></th>
                    <th colspan="4">7. JUMLAH BALITA DITIMBANG (L/P)</th>
                    <th colspan="7">: <?= $jml_balita_timbang_laki_laki." / ".$jml_balita_timbang_perempuan ?></th>
                </tr>
                <tr>
                    <th colspan="3">4. KELURAHAN</th>
                    <th colspan="8">: <?= $desa ?></th>
                    <th colspan="4">8. TANGGAL PENIMBANGAN</th>
                    <th colspan="7">: <?= (($tgl_penimbangan == "")?" ":date_format(date_create($tgl_penimbangan),"d-m-Y")) ?></th>
                </tr>
                <tr>
                    <td class="text-center" colspan="22"></td>
                </tr>

                <tr>
                    <td class="text-center align-middle" rowspan="3">NO</td>
                    <td class="text-center align-middle" rowspan="3" style="width:30%;">NAMA BALITA</td>
                    <th class="text-center align-middle" rowspan="3">L/P</td>
                    <td class="text-center align-middle" rowspan="3" style="width:30%">NAMA ORANG TUA</td>
                    <td class="text-center align-middle" rowspan="3" style="width:30%">TGL LAHIR</td>
                    <td class="text-center align-middle" rowspan="3">UMUR<br>(BL)</td>
                    <td class="text-center align-middle" rowspan="3">BB<br>(KG)</td>
                    <td class="text-center align-middle" rowspan="3">PB<br>(CM)</td>
                    <td class="text-center align-middle" rowspan="3">TB<br>(CM)</td>
                    <td class="text-center align-middle" rowspan="3">LILA<br>(CM</td>
                    <td class="text-center" colspan="12">STATUS GIZI</td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3">BB/U</td>
                    <td class="text-center" colspan="3">TB/U ATAU PB/U</td>
                    <td class="text-center" colspan="3">BB/ TB Atau BB/ PB</td>
                    <td class="text-center" rowspan="2">IMT/U</td>
                    <td class="text-center" colspan="2">LILA/U</td>
                </tr>
                <tr>
                    <td class="text-center">KURANG</td>
                    <td class="text-center">BAIK</td>
                    <td class="text-center">BURUK</td>
                    <td class="text-center">PENDEK</td>
                    <td class="text-center">NORMAL</td>
                    <td class="text-center">SANGAT PENDEK</td>
                    <td class="text-center">KURUS</td>
                    <td class="text-center">NORMAL</td>
                    <td class="text-center">SANGAT KURUS</td>
                    <td class="text-center">&lt;23.5 CM</td>
                    <td class="text-center">&gt;23.5 CM</td>
                </tr>
                <tr>
                    <td class="text-center">(1)</td>
                    <td class="text-center">(2)</td>
                    <td class="text-center">(3)</td>
                    <td class="text-center">(4)</td>
                    <td class="text-center">(5)</td>
                    <td class="text-center">(6)</td>
                    <td class="text-center">(7)</td>
                    <td class="text-center">(8)</td>
                    <td class="text-center">(9)</td>
                    <td class="text-center">(10)</td>
                    <td class="text-center">(11)</td>
                    <td class="text-center">(12)</td>
                    <td class="text-center">(13)</td>
                    <td class="text-center">(14)</td>
                    <td class="text-center">(15)</td>
                    <td class="text-center">(16)</td>
                    <td class="text-center">(17)</td>
                    <td class="text-center">(18)</td>
                    <td class="text-center">(19)</td>
                    <td class="text-center">(20)</td>
                    <td class="text-center">(21)</td>
                    <td class="text-center">(22)</td>
                </tr>
            </head>
            <tbody>
                <?php
                    $no = 0;
                    $jml_kurang = 0;
                    $jml_baik = 0;
                    $jml_buruk = 0;
                    $jml_pendek = 0;
                    $jml_normal = 0;
                    $jml_sgt_pendek = 0;
                    $jml_kurus = 0;
                    $jml_bb_normal = 0;
                    $jml_sgt_kurus = 0;
                    $jml_lila_1 = 0;
                    $jml_lila_2 = 0;
                    foreach ($data_balita as $rows) {
                        $no++;

                        (($rows->bb_u == "Kurang")? $jml_kurang++ : "");
                        (($rows->bb_u == "Baik")? $jml_baik++ : "");
                        (($rows->bb_u == "Buruk")? $jml_buruk++ : "");

                        (($rows->tb_u_pb_u == "Pendek")? $jml_pendek++ : "");
                        (($rows->tb_u_pb_u == "Normal")? $jml_normal++ : "");
                        (($rows->tb_u_pb_u == "Sangat Pendek")? $jml_sgt_pendek++ : "");

                        (($rows->bb_tb_bb_pb == "Kurus")? $jml_kurus++ : "");
                        (($rows->bb_tb_bb_pb == "Normal")? $jml_bb_normal++ : "");
                        (($rows->bb_tb_bb_pb == "Sangat Kurus")? $jml_sgt_kurus++ : "");

                        (($rows->lila_u == "<23.5 cm")? $jml_lila_1++ :"");
                        (($rows->lila_u == ">23.5 cm")? $jml_lila_2++ :"");
                ?>
                        <tr>
                            <td class="text-center"><?= $no ?></td>
                            <td style="width:500px;"><?= $rows->nama ?></td>
                            <td class="text-center"><?= (($rows->jenkel == "Laki-laki")?"L":"P") ?></td>
                            <td style="width:500px;"><?= $rows->nmortu ?></td>
                            <td class="text-center"><?= $rows->tgllahir ?></td>
                            <td class="text-center"><?= $rows->umurbayi ?></td>
                            <td class="text-center"><?= $rows->bb ?></td>
                            <td class="text-center"><?= $rows->pb ?></td>
                            <td class="text-center"><?= $rows->tb ?></td>
                            <td class="text-center"><?= $rows->lila ?></td>
                            <td class="text-center"><?= (($rows->bb_u == "Kurang")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->bb_u == "Baik")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->bb_u == "Buruk")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->tb_u_pb_u == "Pendek")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->tb_u_pb_u == "Normal")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->tb_u_pb_u == "Sangat Pendek")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->bb_tb_bb_pb == "Kurus")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->bb_tb_bb_pb == "Normal")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->bb_tb_bb_pb == "Sangat Kurus")?"V":"") ?></td>
                            <td class="text-center"><?= $rows->imt_u ?></td>
                            <td class="text-center"><?= (($rows->lila_u == "<23.5 cm")?"V":"") ?></td>
                            <td class="text-center"><?= (($rows->lila_u == ">23.5 cm")?"V":"") ?></td>
                        </tr>
                <?php   }   ?>
                <tr>
                    <td class="text-center" colspan="10">JUMLAH ANAK MENURUT STATUS GIZI</td>
                    <td class="text-center"><?= $jml_kurang ?></td>
                    <td class="text-center"><?= $jml_baik ?></td>
                    <td class="text-center"><?= $jml_buruk ?></td>
                    <td class="text-center"><?= $jml_pendek ?></td>
                    <td class="text-center"><?= $jml_normal ?></td>
                    <td class="text-center"><?= $jml_sgt_pendek ?></td>
                    <td class="text-center"><?= $jml_kurus ?></td>
                    <td class="text-center"><?= $jml_bb_normal ?></td>
                    <td class="text-center"><?= $jml_sgt_kurus ?></td>
                    <td class="text-center"><?= $no ?></td>
                    <td class="text-center"><?= $jml_lila_1 ?></td>
                    <td class="text-center"><?= $jml_lila_2 ?></td>
                </tr>

                <tr>
                    <td class="text-center" colspan="22"></td>
                </tr>
                <tr>
                    <th colspan="2">JUMLAH BALITA PUNYA KMS (K)</th>
                    <th colspan="4">: <?= $jml_balita_punya_kms ?></th>
                    <th class="text-right" colspan="2">K / S</th>
                    <th colspan="7">: <?= $k_s." %" ?></th>
                    <th class="text-right" colspan="2">POSYANDU</th>
                    <th colspan="5">: <?= $posyandu ?></th>
                </tr>
                <tr>
                    <th colspan="2">JUMLAH BALITA NAIK BB (N)</th>
                    <th colspan="4">: <?= $jml_balita_naik_bb ?></th>
                    <th class="text-right" colspan="2">D / S</th>
                    <th colspan="14">: <?= $d_s." %" ?></th>
                </tr>
                <tr>
                    <th colspan="6"></th>
                    <th class="text-right" colspan="2">N / D</th>
                    <th colspan="14">: <?= $n_d." %" ?></th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
