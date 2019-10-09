<li>
    <a href="<?= site_url() ?>/laporan-penimbangan" class="waves-effect waves-dark" aria-expanded="false">
        <i class="mdi mdi-file"></i>
        <span class="hide-menu">Hasil Penimbangan</span>
    </a>
</li>
<li> 
    <a href="<?= site_url() ?>/perkembangan-balita" class="waves-effect waves-dark" aria-expanded="false">
        <i class="mdi mdi-chart-line"></i>
        <span class="hide-menu">Perkembangan Balita</span>
    </a>
</li>

<li class="nav-small-cap" style="background-color:#ef5350; color:#FFFFFF">EARLY WARNING SYSTEM</li>
<li>
    <a href="<?= site_url() ?>/balita-gizi-buruk" class="waves-effect waves-dark <?= ((isset($menu) && $menu == "Balita Gizi Buruk" )? "active":"") ?>" aria-expanded="false">
        <i class="mdi mdi-equal-box"></i>
        <span class="hide-menu">
            Balita Gizi Buruk
            <?php
                $jumlah_notif_gizi_buruk= $this->Status_gizi_m->getJumlahNotif('gizi buruk');
                if($jumlah_notif_gizi_buruk > 0){
                    $style = '';
                }else{
                    $style = 'style="display:none"';
                }
            ?>
            <span id="notif_menu" class="label label-rouded label-danger pull-right" <?= $style ?>><?= $jumlah_notif_gizi_buruk ?></span>
        </span>
    </a>
</li>
<li>
    <a href="<?= site_url() ?>/balita-stunting" class="waves-effect waves-dark <?= ((isset($menu) && $menu == "Balita Stunting" )? "active":"") ?>" aria-expanded="false">
        <i class="mdi mdi-equal-box"></i>
        <span class="hide-menu">
            Balita Stunting
            <?php
                $jumlah_notif_stunting= $this->Status_gizi_m->getJumlahNotif('stunting');
                if($jumlah_notif_stunting > 0){
                    $style = '';
                }else{
                    $style = 'style="display:none"';
                }
            ?>
            <span id="notif_stunting" class="label label-rouded label-danger pull-right" <?= $style ?>><?= $jumlah_notif_stunting ?></span>
        </span>
    </a>
</li>
<li>
    <a href="<?= site_url() ?>/balita-bb-tb-atau-bb-pb" class="waves-effect waves-dark <?= ((isset($menu) && $menu == "Balita BB / TB Atau BB / PB" )? "active":"") ?>" aria-expanded="false">
        <i class="mdi mdi-equal-box"></i>
        <span class="hide-menu">
            BB / TB Atau BB / PB
            <?php
                $jumlah_notif_bb_tb_bb_pb= $this->Status_gizi_m->getJumlahNotif('bb_tb_bb_pb');
                if($jumlah_notif_bb_tb_bb_pb > 0){
                    $style = '';
                }else{
                    $style = 'style="display:none"';
                }
            ?>
            <span id="notif_bb_tb_bb_pb" class="label label-rouded label-danger pull-right" <?= $style ?>><?= $jumlah_notif_bb_tb_bb_pb ?></span>
        </span>
    </a>
</li>
<li>
    <a href="<?= site_url() ?>/balita-imt-u" class="waves-effect waves-dark <?= ((isset($menu) && $menu == "Balita IMT / U" )? "active":"") ?>" aria-expanded="false">
        <i class="mdi mdi-equal-box"></i>
        <span class="hide-menu">
            IMT / U
            <?php
                $jumlah_notif_imt_u= $this->Status_gizi_m->getJumlahNotif('imt_u');
                if($jumlah_notif_imt_u > 0){
                    $style = '';
                }else{
                    $style = 'style="display:none"';
                }
            ?>
            <span id="notif_imt_u" class="label label-rouded label-danger pull-right" <?= $style ?>><?= $jumlah_notif_imt_u ?></span>
        </span>
    </a>
</li>
