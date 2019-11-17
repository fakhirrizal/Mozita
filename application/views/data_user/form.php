
<script type="text/javascript">
    $(document).ready(function(){
        $(".form-control").attr('autocomplete', 'off');
    });
</script>
<div class="card-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="title modal-title"></h4>
</div>
<div id="form_input" class="card-body" disabled>
    <input type="hidden" id="jenis_form" value="<?= ((isset($jenis_form))? $jenis_form:'' ) ?>">
    <input type="hidden" id="aktif" value="<?= ((isset($data->aktif))? $data->aktif:'' ) ?>">
    <div class="row">
        <div class="col-md-6">
            <label>Nama Lengkap *</label>
            <input id="name" type="text" class="form-control" value="<?php if(isset($data->nama)) echo $data->nama ?>">
        </div>
        <div class="col-md-6">
            <label>NIP</label>
            <input id="nip" type="text" class="form-control" value="<?php if(isset($data->nip)) echo $data->nip ?>">
        </div>
    </div>
    <div class="row m-t-10">
        <div class="col-md-6">
            <label>Nomor Seluler *</label>
            <input id="phone" type="text" class="form-control" value="<?php if(isset($data->phone)) echo $data->phone ?>">
        </div>
        <div class="col-md-6">
            <label>Email *</label>
            <input id="email" type="text" class="form-control" value="<?php if(isset($data->email)) echo $data->email ?>">
        </div>
    </div>
    <?php
        if($jenis_form == "tambah"){
    ?>
            <div class="row m-t-10">
                <div class="col-md-6">
                    <label>Kata Sandi *</label>
                    <input id="password" type="password" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Ulangi Kata Sandi *</label>
                    <input id="confrim_password" type="password" class="form-control">
                </div>
            </div>
    <?php
        }else if($jenis_form == "edit"){
    ?>
            <div class="row m-t-10">
                <div class="col-md-6">
                    <label>Kata Sandi Baru</label>
                    <input id="new_password" type="password" class="form-control" placeholder="Isi jika ingin merubah password">
                </div>
                <div class="col-md-6">
                    <label>Ulangi Kata Sandi Baru</label>
                    <input id="confrim_new_password" type="password" class="form-control">
                </div>
            </div>
    <?php
        }
    ?>
    <div class="form-item m-t-10">
        <label>Level Pengguna</label>
        <select id="level" class="form-control" <?= (($_SESSION['level'] == 3)? "disabled":"")?>>
            <option value="0">Pilih</option>
            <!-- <option value="1">Admin</option> -->
            <option value="2" <?= (((isset($data->level) && $data->level == '2') or $_SESSION['level'] == 3)? "selected":"") ?>>Bidan / Kader</option>
            <option value="3" <?= ((isset($data->level) && $data->level == '3')? "selected":"") ?>>Puskesmas</option>
            <option value="7" <?= ((isset($data->level) && $data->level == '7')? "selected":"") ?>>Lurah</option>
            <option value="6" <?= ((isset($data->level) && $data->level == '6')? "selected":"") ?>>Camat</option>
            <option value="4" <?= ((isset($data->level) && $data->level == '4')? "selected":"") ?>>Dinas Kesehatan Kabupaten / Kota</option>
            <option value="5" <?= ((isset($data->level) && $data->level == '5')? "selected":"") ?>>Dinas Kesahatan Propinsi</option>
        </select>
    </div>
    <div class="row m-t-10">
        <div id="form_propinsi" class="col-md-6" style="<?= ((isset($data->id_prop) && $_SESSION['level'] != 3)?'':'display:none') ?>">
            <label>Propinsi *</label>
            <select id="propinsi" class="select2 form-control" style="width:100%" disabled>
                
                <?php
                    foreach ($data_propinsi as $rows){
                        echo '<option value="'.$rows->id.'">'.$rows->name.'</option>';
                    }
                ?>
            </select>
        </div>
        <div id="form_kab" class="col-md-6" style="<?= ((isset($data->id_kab) && $_SESSION['level'] != 3)?'':'display:none') ?>">
            <label>Kabupaten / Kota *</label>
            <select id="kabupaten" class="select2 form-control" style="width:100%">
                <option value="0">Pilih</option>
                <?php
                    // if(isset($data->id_kab)){
                        foreach($data_kab as $rows_kab){
                            echo '<option value="'.$rows_kab->id.'" '.(($data->id_kab == $rows_kab->id)?"selected":"").'>'.$rows_kab->name.'</option>';
                        // }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row m-t-10">
        <div id="form_kec" class="col-md-6" style="<?= ((isset($data->id_kec) && $_SESSION['level'] != 3)?'':'display:none') ?>">
            <label>Kecamatan *</label>
            <select id="kecamatan" class="select2 form-control" style="width:100%">
                <option value="0">Pilih</option>
                <?php
                    if(isset($data->id_kec)){
                        foreach($data_kec as $rows_kec){
                            echo '<option value="'.$rows_kec->id.'" '.(($data->id_kec == $rows_kec->id)?"selected":"").'>'.$rows_kec->name.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <div id="form_puskesmas" class="col-md-6" style="<?= ((isset($data->id_pusk) && $_SESSION['level'] != 3)?'':'display:none') ?>">
            <label>Puskesmas *</label>
            <select id="puskesmas" class="select2 form-control" style="width:100%">
                <option value="0">Pilih</option>
                <?php
                    if(isset($data->id_pusk)){
                        foreach($data_pusk as $rows_pusk){
                            echo '<option value="'.$rows_pusk->idpusk.'" '.(($data->id_pusk == $rows_pusk->idpusk)?"selected":"").'>'.$rows_pusk->namapusk.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row m-t-10">
        <div id="form_desa" class="col-md-6" style="<?= ((isset($data->id_desa) or $_SESSION['level'] == 3)?'':'display:none') ?>">
            <label>Desa *</label>
            <select id="desa" class="select2 form-control" style="width:100%">
                <option value="0">Pilih</option>
                <?php
                    if(isset($data_desa)){
                        foreach($data_desa as $rows_desa){
                            echo '<option value="'.$rows_desa->id.'" '.(($data->id_desa == $rows_desa->id)?"selected":"").'>'.$rows_desa->name.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        
        <div id="form_posyandu" class="col-md-6" style="<?= ((isset($data->id_posyandu) or $_SESSION['level'] == 3)?'':'display:none') ?>">
            <label>Posyandu *</label>
            <select id="posyandu" class="select2 form-control" style="width:100%">
                <option value="0">Pilih</option>
                <?php
                    if(isset($data->id_posyandu)){
                        foreach($data_pos as $rows_pos){
                            echo '<option value="'.$rows_pos->idpos.'" '.(($data->id_posyandu == $rows_pos->idpos)?"selected":"").'>'.$rows_pos->namapos.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>            
</div>
<div class="card-footer">
    <div class="row">
        <div class="col-md-7 text-left">
            <div id="validasi"></div>
        </div>
        <div class="col-md-5 text-right">
            <button id="btn_new_input" class="btn" style="display:none">TAMBAH BARU</button>
            <button id="<?php if(isset($data->idUser)) echo md5($data->idUser) ?>" class="btn_save">
                <div id="loading" class="spinner" style="display:none">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
                <a id="text_btn"></a>
            </button>
        </div>
    </div><!-- ./row -->
</div>

<script>
    $(document).ready(function(){
        $('.select2').select2();
    })
</script>
