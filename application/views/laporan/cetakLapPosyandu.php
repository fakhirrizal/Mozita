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
    <thead>
        <tr>
            <th class="text-center" colspan="22">HASIL PENIMBANGAN PADA "BULAN OPERASI TIMBANG"</th>
        </tr>
        <tr>
            <th class="text-center" colspan="22">DI TINGKAT DESA / POSYANDU</th>
        </tr>
        <tr>
            <th class="text-center" colspan="22">TAHUN <?= date_format(date_create($tgl_penimbangan),"Y") ?></th>
        </tr>
        <tr>
            <th class="text-center" colspan="22"></th>
        </tr>
        <tr>
            <th class="text-left" colspan="3">1. PROPINSI</th>
            <th class="text-left" colspan="12">: <?= $nama_propinsi ?></th>
            <th class="text-left" colspan="5">5. NAMA POSYANDU</th>
            <th class="text-left" colspan="2">: <?= $posyandu ?></th>
        </tr>
        <tr>
            <th class="text-left" colspan="3">2. KABUPATEN / KOTA</th>
            <th class="text-left" colspan="12">: <?= $kabupaten ?></th>
            <th class="text-left" colspan="5">6. JUMLAH BALITA YANG ADA (L/P)</th>
            <th class="text-left" colspan="2">: <?= $jml_balita_aktif_laki_laki." / ".$jml_balita_aktif_perempuan ?></th>
        </tr>
        <tr>
            <th class="text-left" colspan="3">3. KECAMATAN</th>
            <th class="text-left" colspan="12">: <?= $kecamatan ?></th>
            <th class="text-left" colspan="5">7. JUMLAH BALITA DITIMBANG (L/P)</th>
            <th class="text-left" colspan="2">: <?= $jml_balita_timbang_laki_laki." / ".$jml_balita_timbang_perempuan ?></th>
        </tr>
        <tr>
            <th class="text-left" colspan="3">4. KELURAHAN</th>
            <th class="text-left" colspan="12">: <?= $desa ?></th>
            <th class="text-left" colspan="5">8. TANGGAL PENIMBANGAN</th>
            <th class="text-left" colspan="2">: <?= (($tgl_penimbangan == "")?" ":date_format(date_create($tgl_penimbangan),"d-m-Y")) ?></th>
        </tr>
        <tr>
            <td class="text-left" colspan="22"></td>
        </tr>

        <tr>
            <td rowspan="3" width="30">NO</td>
            <td rowspan="3" width="80">NAMA BALITA</td>
            <th rowspan="3" width="30">L/P</td>
            <td rowspan="3" width="80">NAMA ORANG TUA</td>
            <td rowspan="3" width="80">TGL LAHIR</td>
            <td rowspan="3" width="40">UMUR<br>(BL)</td>
            <td rowspan="3" width="40">BB<br>(KG)</td>
            <td rowspan="3" width="40">PB<br>(CM)</td>
            <td rowspan="3" width="40">TB<br>(CM)</td>
            <td rowspan="3" width="40">LILA<br>(CM</td>
            <td colspan="12">STATUS GIZI</td>
        </tr>
        <tr>
            <td colspan="3">BB/U</td>
            <td colspan="3">TB/U ATAU PB/U</td>
            <td colspan="3">BB/ TB Atau BB/ PB</td>
            <td rowspan="2" width="47">IMT/U</td>
            <td colspan="2">LILA/U</td>
        </tr>
        <tr>
            <td width="50">KURANG</td>
            <td width="47">BAIK</td>
            <td width="47">BURUK</td>
            <td width="47">PENDEK</td>
            <td width="47">NORMAL</td>
            <td width="47">SANGAT PENDEK</td>
            <td width="47">KURUS</td>
            <td width="47">NORMAL</td>
            <td width="47">SANGAT KURUS</td>
            <td width="55">&lt;23.5 CM</td>
            <td width="55">&gt;23.5 CM</td>
        </tr>
        <tr>
            <td class="text">(1)</td>
            <td class="text">(2)</td>
            <td class="text">(3)</td>
            <td class="text">(4)</td>
            <td class="text">(5)</td>
            <td class="text">(6)</td>
            <td class="text">(7)</td>
            <td class="text">(8)</td>
            <td class="text">(9)</td>
            <td class="text">(10)</td>
            <td class="text">(11)</td>
            <td class="text">(12)</td>
            <td class="text">(13)</td>
            <td class="text">(14)</td>
            <td class="text">(15)</td>
            <td class="text">(16)</td>
            <td class="text">(17)</td>
            <td class="text">(18)</td>
            <td class="text">(19)</td>
            <td class="text">(20)</td>
            <td class="text">(21)</td>
            <td class="text">(22)</td>
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
                    <td><?= $no ?></td>
                    <td style="text-align:left"><?= $rows->nama ?></td>
                    <td><?= (($rows->jenkel == "Laki-laki")?"L":"P") ?></td>
                    <td style="text-align:left"><?= $rows->nmortu ?></td>
                    <td><?= $rows->tgllahir ?></td>
                    <td><?= $rows->umurbayi ?></td>
                    <td><?= $rows->bb ?></td>
                    <td><?= $rows->pb ?></td>
                    <td><?= $rows->tb ?></td>
                    <td><?= $rows->lila ?></td>
                    <td><?= (($rows->bb_u == "Kurang")?"V":"") ?></td>
                    <td><?= (($rows->bb_u == "Baik")?"V":"") ?></td>
                    <td><?= (($rows->bb_u == "Buruk")?"V":"") ?></td>
                    <td><?= (($rows->tb_u_pb_u == "Pendek")?"V":"") ?></td>
                    <td><?= (($rows->tb_u_pb_u == "Normal")?"V":"") ?></td>
                    <td><?= (($rows->tb_u_pb_u == "Sangat Pendek")?"V":"") ?></td>
                    <td><?= (($rows->bb_tb_bb_pb == "Kurus")?"V":"") ?></td>
                    <td><?= (($rows->bb_tb_bb_pb == "Normal")?"V":"") ?></td>
                    <td><?= (($rows->bb_tb_bb_pb == "Sangat Kurus")?"V":"") ?></td>
                    <td><?= $rows->imt_u ?></td>
                    <td><?= (($rows->lila_u == "<23.5 cm")?"V":"") ?></td>
                    <td><?= (($rows->lila_u == ">23.5 cm")?"V":"") ?></td>
                </tr>
        <?php   }   ?>
        <tr>
            <td colspan="10">JUMLAH ANAK MENURUT STATUS GIZI</td>
            <td><?= $jml_kurang ?></td>
            <td><?= $jml_baik ?></td>
            <td><?= $jml_buruk ?></td>
            <td><?= $jml_pendek ?></td>
            <td><?= $jml_normal ?></td>
            <td><?= $jml_sgt_pendek ?></td>
            <td><?= $jml_kurus ?></td>
            <td><?= $jml_bb_normal ?></td>
            <td><?= $jml_sgt_kurus ?></td>
            <td><?= $no ?></td>
            <td><?= $jml_lila_1 ?></td>
            <td><?= $jml_lila_2 ?></td>
        </tr>

        <tr>
            <td class="text-left" colspan="22"></td>
        </tr>
        <tr>
            <th class="text-left" colspan="4">JUMLAH BALITA PUNYA KMS (K)</th>
            <th class="text-left" colspan="2">: <?= $jml_balita_punya_kms ?></th>
            <th class="text-left" colspan="2">K / S</th>
            <th class="text-left" colspan="7">: <?= $k_s." %" ?></th>
            <th class="text-left" colspan="2">POSYANDU</th>
            <th class="text-left" colspan="5">: <?= $posyandu ?></th>
        </tr>
        <tr>
            <th class="text-left" colspan="4">JUMLAH BALITA NAIK BB (N)</th>
            <th class="text-left" colspan="2">: <?= $jml_balita_naik_bb ?></th>
            <th class="text-left" colspan="2">D / S</th>
            <th class="text-left" colspan="14">: <?= $d_s." %" ?></th>
        </tr>
        <tr>
            <th class="text-left" colspan="6"></th>
            <th class="text-left" colspan="2">N / D</th>
            <th class="text-left" colspan="14">: <?= $n_d." %" ?></th>
        </tr>
    </tbody>
</table>
