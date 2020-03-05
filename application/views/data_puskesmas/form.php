
<script type="text/javascript">
    $(document).ready(function(){
        $(".form-control").attr('autocomplete', 'off');
        var jenis_form = "<?= $jenis_form ?>";
        if(jenis_form == 'tambah'){
            $(".btn_hapus").hide();
            $(".btn_save").addClass("btn btn-info");
            $("#text_btn").append('<i class="fa fa-save"></i> ');
            $("#text_btn").append('SIMPAN');
        }else{
            $(".btn_hapus").show();
            $(".btn_save").removeClass("btn_save").addClass("btn_edit btn btn-warning");
            $("#text_btn").append('<i class="fa fa-edit"></i> ');
            $("#text_btn").append('UBAH');

            $("#form_input input[type=text]").prop("disabled",true);
            $("#alamat").prop("disabled",true);
            $('#kabupaten').select2().prop("disabled",true);
            $('#kecamatan').select2().prop("disabled",true);
        }
    });
</script>

<script type="text/javascript">
    $(function(){     
        // START FORM MODAL DELETE
        $(document).on('click','.btn_hapus',function(){
            $('#validasi_hapus').html('Apakah Anda ingin menghapus data ini?');
            $('#modal_hapus').modal('show');
        }); 

        $(document).on('click','#btn_new_input', function(){
            $("#form_input input[type=text]").val('');
            $("#alamat").val("");
            $('#kabupaten').select2("val","0");
            $('#kecamatan').select2("val","0");
            $('.btn_save').show();
            $('#btn_new_input').hide();
            $('#validasi').hide();
        });

        $(document).on('click','.btn_edit', function(){
            $("#btn_cancel").show();
            $(".btn_hapus").hide();
            $(".btn_edit").removeClass("btn_edit btn btn-warning").addClass("btn_save btn btn-info");
            $("#text_btn").text("");
            $("#text_btn").append('<i class="fa fa-save"></i> ');
            $("#text_btn").append('SIMPAN');

            $("#form_input input[type=text]").prop("disabled",false);
            $("#alamat").prop("disabled",false);
            $('#kabupaten').select2().prop("disabled",false);
            $('#kecamatan').select2().prop("disabled",false);
        });

        $(document).on('click','#btn_cancel', function(){
            $("#btn_cancel").hide();
            $(".btn_save").removeClass("btn_save btn btn-info").addClass("btn_edit btn btn-warning");
            $("#text_btn").text("");
            $("#text_btn").append('<i class="fa fa-save"></i> ');
            $("#text_btn").append('UBAH');

            $(".btn_hapus").show();
            

            $("#form_input input[type=text]").prop("disabled",true);
            $("#alamat").prop("disabled",true);
            $('#propinsi').select2().prop("disabled",true);
            $('#kabupaten').select2().prop("disabled",true);
            $('#kecamatan').select2().prop("disabled",true);
            $('#desa').select2().prop("disabled",true);
        });

        $(document).on('change','#kabupaten', function(){
            var id = $("#kabupaten").val();
            $.post("<?= site_url('posyandu/combobox/kecamatan/') ?>"+id,{id_kab:id}, function(result){
                $("#kecamatan").html(result);
                $('.select2').select2();
            });
        });
    });
</script>



<script type="text/javascript">
	$(function(){
        $(document).on('click','.btn_save',function(){
            $('#validasi').html('');
            $('#validasi').show();

            if($('#namapusk').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nama Puskesmas Belum Diisi</font>");
                $('#namapusk').focus();
                return (false);
            }else if($('#jenis').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Jenis Puskesmas Belum Diisi</font>");
                $('#jenis').focus();
                return (false);
            }else if($('#keppusk').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kepala Puskesmas Belum Diisi</font>");
                $('#keppusk').focus();
                return (false);
            }else if($('#nipkep').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> NIP Kepala Puskesmas Belum Diisi</font>");
                $('#nipkep').focus();
                return (false);
            }else if($('#nutripusk').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nutrisionis Puskesmas Belum Diisi</font>");
                $('#nutripusk').focus();
                return (false);
            }else if($('#nipnutri').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> NIP Nutrisionis Belum Diisi</font>");
                $('#nipnutri').focus();
                return (false);
            }else if($('#alamat').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Alamat Puskesmas Belum Diisi</font>");
                $('#alamat').focus();
                return (false);
            }else if($('#propinsi').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Propinsi Belum Diisi</font>");
                $('#propinsi').focus();
                return (false);
            }else if($('#kabupaten').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kabupaten Belum Diisi</font>");
                $('#kabupaten').focus();
                return (false);
            }else if($('#kecamatan').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kecamatan Belum Diisi</font>");
                $('#kecamatan').focus();
                return (false);
            }

            $('.btn_save').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();
            // var param = '';

            var param = 'namapusk='+$('#namapusk').val()+
                        '&jenis='+$('#jenis').val()+
                        '&keppusk='+$('#keppusk').val()+
                        '&nipkep='+$('#nipkep').val()+
                        '&nutripusk='+$('#nutripusk').val()+
                        '&nipnutri='+$('#nipnutri').val()+
                        '&alamat='+$('#alamat').val()+
                        '&propinsi='+$('#propinsi').val()+
                        '&kabupaten='+$('#kabupaten').val()+
                        '&kecamatan='+$('#kecamatan').val()+
                        '&idpusk='+$('#idpusk').val();
            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('puskesmas/save/')?>"+$(this).attr('id'),
                data: param,
                dataType : "json",
                success: function(result) {
                    $('#loading').hide();
                    $('.btn_save').prop('disabled',false);

                    if(result['status'] == "1"){
                        if(result['jenis'] == "simpan"){
                            $('.btn_save').hide();
                            $('#btn_new_input').show();
                        }else if(result['jenis'] == "edit"){
                            $("#btn_cancel").hide();
                            $(".btn_hapus").show();
                            //BUTTON SIMPAN
                            $(".btn_save").removeClass("btn_save btn btn-info").addClass("btn_edit btn btn-warning");
                            $("#text_btn").text("");
                            $("#text_btn").append('<i class="fa fa-save"></i> ');
                            $("#text_btn").append('UBAH');

                            $("#form_input input[type=text]").prop("disabled",true);
                            $("#alamat").prop("disabled",true);
                            $('#kabupaten').select2().prop("disabled",true);
                            $('#kecamatan').select2().prop("disabled",true);
                        }                         
                    }
                    $('#validasi').html(result['message']);
                    $('#text_btn').show();
                    
                },
                error: function(result) {
                    $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Terjadi Kesalahan Sistem</font>");
                    $('.btn_save').prop('disabled',false);
                    $('#loading').hide();
                    $('#text_btn').show();
                }
            });
        });

        // PROSES DELETE
        $(document).on('click','.btn_konfrim_hapus',function(){
            $('.btn_konfrim_hapus').prop('disabled',true);
            $('#text_btn_hapus').hide();
            $('#loading_hapus').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('puskesmas/delete/') ?>"+$(this).attr('id'),
                dataType:"json",
                success: function(result) {
                    $('.btn_konfrim_hapus').prop('disabled',false);
                    $('#text_btn_hapus').show();
                    $('#loading_hapus').hide();
                    if(result['success'] == '1'){
                        $('.btn_konfrim_hapus').hide();
                        $('#btn_cancel_hapus').hide();
                        $('#btn_ok').show();
                    }
                    $('#validasi_hapus').html(result['message']);
                },
                error: function(result) {
                    $('#validasi_hapus').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Terjadi Kesalahan Sistem</font>");
                    $('.btn_save').prop('disabled',false);
                    $('#loading').hide();
                    $('#text_btn').show();
                }
            });
        });
	 });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card">

                <div class="p-b-10 card-body">
                    <input id="idpusk" type="hidden" value="<?php if(isset($data->idpusk)) echo $data->idpusk ?>">
                    <div id="form_input">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nama Puskesmas *</label>
                            </div>
                            <div class="col-md-5">
                                <input id="namapusk" type="text" class="form-control" value="<?php if(isset($data->namapusk)) echo $data->namapusk ?>">
                            </div>
                        </div>

                        <div class="row m-t-20">
                            <div class="col-md-3">
                                <label>Jenis Puskesmas *</label>
                            </div>
                            <div class="col-md-5">
                                <input id="jenis" type="text" class="form-control" value="<?php if(isset($data->jenis)) echo $data->jenis ?>">
                            </div>
                        </div>

                        <div class="row m-t-20">
                            <div class="col-md-3">
                                <label>Kepala Puskesmas / NIP *</label>                            
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input id="keppusk" type="text" class="form-control" value="<?php if(isset($data->keppusk)) echo $data->keppusk ?>">
                                    <div class="input-group-addon">/</div>
                                    <input id="nipkep" type="text" class="form-control" value="<?php if(isset($data->nipkep)) echo $data->nipkep ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row m-t-20">
                            <div class="col-md-3">
                                <label>Nutrisionis Puskesmas / NIP *</label>                            
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input id="nutripusk" type="text" class="form-control" value="<?php if(isset($data->nutripusk)) echo $data->nutripusk ?>">
                                    <div class="input-group-addon">/</div>
                                    <input id="nipnutri" type="text" class="form-control" value="<?php if(isset($data->nipnutri)) echo $data->nipnutri ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row m-t-20">
                            <div class="col-md-3">
                                <label>Alamat Puskesmas</label>                            
                            </div>
                            <div class="col-md-5">
                                <textarea id="alamat" class="form-control" rows="3"><?php if(isset($data->almtpusk)) echo $data->almtpusk ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-3">
                            <label>Propinsi *</label>
                        </div>
                        <div class="col-md-5">
                            <input id="propinsi" type="text" class="form-control" value="<?php if(isset($propinsi)) echo $propinsi ?>" readonly>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-3">
                            <label>Kabupaten / Kota *</label>
                        </div>
                        <div class="col-md-5">
                            <select id="kabupaten" class="select2 form-control" style="width:100%">
                                <option value="0">Pilih</option>
                                <?php
                                    if(isset($data->id_kab)){
                                        $id_kab = $data->id_kab;
                                    }else{
                                        $id_kab = "";
                                    }
                                    foreach($data_kab as $rows_kab){
                                        echo '<option value="'.$rows_kab->id.'" '.(($id_kab == $rows_kab->id)?"selected":"").'>'.$rows_kab->name.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-3">
                            <label>Kecamatan *<?= substr($data->idpusk,0,4); ?></label>
                        </div>
                        <div class="col-md-5">
                            <select id="kecamatan" class="select2 form-control" style="width:100%" required>
                                <option value="0">Pilih</option>
                                <?php
                                    if(isset($data->id_kecamatan)){
                                        foreach($data_kec as $rows_kec){
                                            echo '<option value="'.$rows_kec->id.'" '.(($data->id_kecamatan == $rows_kec->id)?"selected":"").'>'.$rows_kec->name.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div><!-- ./ card-body -->
            
            <div class="card-footer">
                <div class="row">
                    <div id="col_validasi" class="col-md-4 text-left">
                        <div id="validasi"></div>
                    </div>
                    <div id="col_btn" class="col-md-4 text-right">
                        <button id="btn_cancel" class="btn btn btn-secondary" style="display:none"><i class="fa fa-chevron-left"></i> BATAL</button>
                        <button id="btn_new_input" class="btn btn btn-secondary" style="display:none"><i class="fa fa-plus-square"></i> TAMBAH BARU</button>
                        <button class="btn_hapus btn btn-danger"><i class="fa fa-trash"></i> HAPUS</button>
                        <button id="<?php if(isset($data->idpusk)) echo md5($data->idpusk) ?>" class="btn_save ">
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
            </div><!-- ./ card-footer -->

        </div><!-- ./ card -->
    </div><!-- ./ col -->
</div><!-- ./ row -->

<!-- START TAMPIL MODAL -->
<div id="modal_hapus" class="modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-danger">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
               
                <div class="card-body">
                    <div class="row">
                        <div id="validasi_hapus" class="col-md-12">
                            
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <a href="<?= site_url('data-puskesmas') ?>">
                                <button id="btn_ok" class="btn btn-secondary" style="display:none"style="display:none">OK</button>
                            </a>
                            <button id="btn_cancel_hapus" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                            <button id="<?php if(isset($data->idpusk)) echo md5($data->idpusk) ?>" class="btn_konfrim_hapus btn btn-danger">
                                <div id="loading_hapus" class="spinner" style="display:none">
                                    <div class="rect1"></div>
                                    <div class="rect2"></div>
                                    <div class="rect3"></div>
                                    <div class="rect4"></div>
                                    <div class="rect5"></div>
                                </div>
                                <a id="text_btn_hapus">HAPUS</a>
                            </button>
                        </div>
                    </div><!-- ./row -->
                </div>

            </div><!-- ./Modal content-->
        </div>
    </div>
</div>
<!-- END TAMPIL MODAL -->



<script>
    $(document).ready(function(){
        $('.select2').select2();
    })
</script>
