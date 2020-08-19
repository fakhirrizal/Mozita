<script type="text/javascript">
    $(document).ready(function(){        
        $("#form_balita select").prop("disabled",true);
        $("#form_balita input[type=text]").prop("disabled",true);
        $("#form_balita input[type=radio]").prop("disabled",true);
        $("#form_penimbangan input[type=text]").prop("disabled",true);
        $("#form_penimbangan input[type=radio]").prop("disabled",true);

        $.post("<?= site_url('status_gizi/baca') ?>",
            {norm:"<?= $this->uri->segment(2) ?>",
             tglpenimbangan:"<?= $this->uri->segment(3) ?>"}, function(result){
                var menu = "<?= $menu ?>";
                if(menu == 'Balita Gizi Buruk'){
                    var notif = $("#notif_menu").text();
                    var jumlah_notif = parseInt(notif) - parseInt(result);
                    if(jumlah_notif > 0){
                        $("#notif_menu").text(jumlah_notif);
                    }else{
                        $("#notif_menu").hide();
                    }
                }else if(menu == 'Balita Stunting'){
                    var notif = $("#notif_stunting").text();
                    var jumlah_notif = parseInt(notif) - parseInt(result);
                    if(jumlah_notif > 0){
                        $("#notif_stunting").text(jumlah_notif);
                    }else{
                        $("#notif_stunting").hide();
                    }
                }else if(menu == 'Balita BB/ TB Atau BB/ PB'){
                    var notif = $("#notif_bb_tb_bb_pb").text();
                    var jumlah_notif = parseInt(notif) - parseInt(result);
                    if(jumlah_notif > 0){
                        $("#notif_bb_tb_bb_pb").text(jumlah_notif);
                    }else{
                        $("#notif_bb_tb_bb_pb").hide();
                    }
                }else if(menu == 'Balita IMT/ U'){
                    var notif = $("#notif_imt_u").text();
                    var jumlah_notif = parseInt(notif) - parseInt(result);
                    if(jumlah_notif > 0){
                        $("#notif_imt_u").text(jumlah_notif);
                    }else{
                        $("#notif_imt_u").hide();
                    }
                }
        });
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
                <div class="p-b-10 card-body">
                    <div class="row">
                        <!-- START INFORMASI BALITA -->
                        <div id="form_balita" class="col-md-6">
                            <!-- <div class="row p-t-20">
                                <div class=" col-md-5">
                                    <div class="row">
                                        <div id="image_preview">
                                            <?php
                                                // if (empty($data->fotobayi)){
                                                //     $src = base_url('images/default-user.png');
                                                // }else{
                                                //     $src = $data->fotobayi;
                                                // }
                                            ?>
                                            <img id="previewing" src="<?= $src ?>" style="width:150px; border:1px solid black; margin-left:10px"/>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <h3>INFORMASI BALITA</h3>
                            <hr>
                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Nama Balita</label>                            
                                </div>
                                <div class="col-md-8">
                                    <select id="nama_balita" class="form-control">
                                        <option value="0">Pilih</option>
                                        <?= ((isset($data->nama))?"<option value='".$data->norm."' selected>".$data->norm." - ".$data->nama."</option>":"") ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Tanggal Lahir</label>                            
                                </div>
                                <div class="col-md-8">
                                <input type="text" name="tgl_lahir" class="form-control" placeholder="dd-mm-yyyy" value="<?= ((isset($data->tgllahir))? $data->tgllahir:"") ?>" readonly>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Jenis Kelamin</label>                            
                                </div>
                                <div class="col-md-8">
                                    <label class="custom-control custom-radio">
                                        <input name="jenkel" type="radio" class="custom-control-input" value="Laki-laki" <?= ((isset($data->jenkel) && $data->jenkel == "Laki-laki")? "checked":"") ?> readonly>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Laki - laki</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="jenkel" type="radio" class="custom-control-input" value="Perempuan" <?= ((isset($data->jenkel) && $data->jenkel == "Perempuan")? "checked":"") ?> readonly>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Perempuan</span>
                                    </label>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Nama Orang tua</label>
                                </div>
                                <div class="col-md-8">
                                    <input name="nama_ortu" type="text" class="form-control" value="<?= ((isset($data->nmortu))? $data->nmortu:"") ?>" readonly>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>NIK Orang tua</label>
                                </div>
                                <div class="col-md-8">
                                    <input name="nik_ortu" type="text" class="form-control" value="<?= ((isset($data->nikortu))? $data->nikortu:"") ?>" readonly>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Keluarga Miskin</label>                            
                                </div>
                                <div class="col-md-8">
                                    <label class="custom-control custom-radio">
                                        <input name="gakin" type="radio" class="custom-control-input" value="Ya" <?= ((isset($data->gakin) && $data->gakin == "Ya")? "checked":"") ?> readonly>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Ya</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="gakin" type="radio" class="custom-control-input" value="Tidak" <?= ((isset($data->gakin) && $data->gakin == "Tidak")? "checked":"") ?> readonly>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Tidak</span>
                                    </label>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Propinsi</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="propinsi" class="form-control" value="<?= ((isset($data->nama_prop))? $data->nama_prop:"") ?>" readonly>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Kabupaten / Kota</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="kabupaten" class="form-control" value="<?= ((isset($data->nama_kab))? $data->nama_kab:"") ?>" readonly>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Kecamatan</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="kecamatan" class="form-control" value="<?= ((isset($data->nama_kec))? $data->nama_kec:"") ?>" readonly>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Desa</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="desa" class="form-control" value="<?= ((isset($data->nama_desa))? $data->nama_desa:"") ?>" readonly>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Posyandu</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="posyandu" class="form-control" value="<?= ((isset($data->namapos))? $data->namapos:"") ?>" readonly>
                                </div>
                            </div>
                        </div>
                         <!-- END INFORMASI BALITA -->

                         <!-- START FORM PENIMBANGAN -->
                        <div id="form_penimbangan" class="col-md-6">
                            <h3>INFORMASI PENIMBANGAN </h3>
                            <hr>
                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Tanggal Penimbangan*</label>                            
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="tgl_penimbangan" class="datepicker form-control" placeholder="dd-mm-yyyy" value="<?= ((isset($data->tglpenimbangan))? $data->tglpenimbangan:"") ?>">
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Umur Bayi *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="umur_bayi" class="form-control" value="<?= ((isset($data->umurbayi))? $data->umurbayi:"") ?>" readonly>
                                        <div class="input-group-addon">Bulan</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Berat Badan *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="bb" class="form-control" value="<?= ((isset($data->bb))? $data->bb:"") ?>">
                                        <div class="input-group-addon">KG</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Tinggi Badan *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="tb" class="form-control" value="<?= ((isset($data->tb))? $data->tb:"") ?>">
                                        <div class="input-group-addon">CM</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>Panjang Badan *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="pb" class="form-control" value="<?= ((isset($data->pb))? $data->pb:"") ?>">
                                        <div class="input-group-addon">CM</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>LILA *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" id="lila" class="form-control" value="<?= ((isset($data->lila))? $data->lila:"") ?>">
                                        <div class="input-group-addon">CM</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>BB/ U * </label>                            
                                </div>
                                <div class="col-md-8">
                                    <label class="custom-control custom-radio">
                                        <input name="bb_u" type="radio" class="custom-control-input" value="Buruk" <?= ((isset($data->bb_u) && $data->bb_u == "Buruk")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Buruk</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="bb_u" type="radio" class="custom-control-input" value="Kurang" <?= ((isset($data->bb_u) && $data->bb_u == "Kurang")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Kurang</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="bb_u" type="radio" class="custom-control-input" value="Baik" <?= ((isset($data->bb_u) && $data->bb_u == "Baik")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Baik</span>
                                    </label>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>TB/ U Atau PB/ U *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <label class="custom-control custom-radio">
                                        <input name="tb_u_pb_u" type="radio" class="custom-control-input" value="Sangat Pendek" <?= ((isset($data->tb_u_pb_u) && $data->tb_u_pb_u == "Sangat Pendek")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Sangat Pendek</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="tb_u_pb_u" type="radio" class="custom-control-input" value="Pendek" <?= ((isset($data->tb_u_pb_u) && $data->tb_u_pb_u == "Pendek")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Pendek</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="tb_u_pb_u" type="radio" class="custom-control-input" value="Normal" <?= ((isset($data->tb_u_pb_u) && $data->tb_u_pb_u == "Normal")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Normal</span>
                                    </label>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>BB/ TB Atau BB/ PB *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <label class="custom-control custom-radio">
                                        <input name="bb_tb_bb_pb" type="radio" class="custom-control-input" value="Sangat Kurus" <?= ((isset($data->bb_tb_bb_pb) && $data->bb_tb_bb_pb == "Sangat Kurus")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Sangat Kurus</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="bb_tb_bb_pb" type="radio" class="custom-control-input" value="Kurus" <?= ((isset($data->bb_tb_bb_pb) && $data->bb_tb_bb_pb == "Kurus")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Kurus</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="bb_tb_bb_pb" type="radio" class="custom-control-input" value="Normal" <?= ((isset($data->bb_tb_bb_pb) && $data->bb_tb_bb_pb == "Normal")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Normal</span>
                                    </label>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>IMT/ U *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <label class="custom-control custom-radio">
                                        <input name="imt_u" type="radio" class="custom-control-input" value="Sangat Kurus" <?= ((isset($data->imt_u) && $data->imt_u == "Sangat Kurus")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Sangat Kurus</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="imt_u" type="radio" class="custom-control-input" value="Kurus" <?= ((isset($data->imt_u) && $data->imt_u == "Kurus")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Kurus</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="imt_u" type="radio" class="custom-control-input" value="Normal" <?= ((isset($data->imt_u) && $data->imt_u == "Normal")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Normal</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="imt_u" type="radio" class="custom-control-input" value="Gemuk" <?= ((isset($data->imt_u) && $data->imt_u == "Gemuk")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Gemuk</span>
                                    </label>
                                    <label id="obesitas" class="custom-control custom-radio"  style="<?= ((isset($data->umurbayi) && $data->umurbayi > 60 )? "":"display:none") ?>">
                                        <input name="imt_u" type="radio" class="custom-control-input" value="Obesitas" <?= ((isset($data->imt_u) && $data->imt_u == "Obesitas")? "checked":"") ?>>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Obesitas</span>
                                    </label>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-4">
                                    <label>LILA/ U *</label>                            
                                </div>
                                <div class="col-md-8">
                                    <label class="custom-control custom-radio">
                                        <input name="lila_u" type="radio" class="custom-control-input" value="<23.5 cm" <?= ((isset($data->lila_u) && $data->lila_u == "<23.5 cm")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">< 23.5 CM</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="lila_u" type="radio" class="custom-control-input" value=">23.5 cm" <?= ((isset($data->lila_u) && $data->lila_u == ">23.5 cm")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">>23.5 CM</span>
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <!-- END FORM PENIMBANGAN -->
                    </div><!--./row -->                    
                </div><!-- ./ card-body -->
                
                
            
        </div><!-- ./ card -->
    </div><!-- ./ col -->
</div><!-- ./ row -->


