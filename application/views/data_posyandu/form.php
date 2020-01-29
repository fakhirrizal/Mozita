
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
            $('#propinsi').select2().prop("disabled",true);
            $('#kabupaten').select2().prop("disabled",true);
            $('#kecamatan').select2().prop("disabled",true);
            $('#desa').select2().prop("disabled",true);
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

        $(document).on('change','#propinsi', function(){
            var id = $("#propinsi").val();
            $.post("<?= site_url('posyandu/combobox/kota/') ?>"+id,{id_propinsi:id}, function(result){
                $("#kabupaten").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#kabupaten', function(){
            var id = $("#kabupaten").val();
            $.post("<?= site_url('posyandu/combobox/kecamatan/') ?>"+id,{id_kab:id}, function(result){
                $("#kecamatan").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#kecamatan', function(){
            var id = $("#kecamatan").val();
            $.post("<?= site_url('posyandu/combobox/desa/') ?>"+id,{id_kecamatan:id}, function(result){
                $("#desa").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#desa', function(){
            var id = $("#desa").val();
            $.post("<?= site_url('posyandu/combobox/puskesmas/') ?>"+id,{id_desa:id}, function(result){
                $("#puskesmas").val(result);
            });
        });       
        

        $(document).on('click','#btn_new_input', function(){
            $("#form_input input[type=text]").val('');
            $("#alamat").val("");
            $('#kabupaten').select2("val","0");
            $('#kecamatan').select2("val","0");
            $('#desa').select2("val","0");
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
            $('#desa').select2().prop("disabled",false);
            $("#puskesmas").prop("disabled",true);
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
            $('#kabupaten').select2().prop("disabled",true);
            $('#kecamatan').select2().prop("disabled",true);
            $('#desa').select2().prop("disabled",true);
        });
    });
</script>



<script type="text/javascript">
	$(function(){
        $(document).on('click','.btn_save',function(){
            $('#validasi').html('');
            $('#validasi').show();
            var jenis_form = $('#jenis_form').val();
            var level = $('#level').val();

            if($('#namapos').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Posyandu Belum Diisi</font>");
                $('#namapos').focus();
                return (false);
            }else if($('#alamat').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Alamat Belum Diisi</font>");
                $('#alamat').focus();
                return (false);
            }else if($('#rt').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> RT Belum Diisi</font>");
                $('#rt').focus();
                return (false);
            }else if($('#rw').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> RW Belum Diisi</font>");
                $('#rw').focus();
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
            }else if($('#desa').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Desa Belum Diisi</font>");
                $('#desa').focus();
                return (false);
            }

            $('.btn_save').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();
            // var param = '';

            var param = 'namapos='+$('#namapos').val()+
                        '&alamat='+$('#alamat').val()+
                        '&rt='+$('#rt').val()+
                        '&rw='+$('#rw').val()+
                        '&propinsi='+$('#propinsi').val()+
                        '&kabupaten='+$('#kabupaten').val()+
                        '&kecamatan='+$('#kecamatan').val()+
                        '&desa='+$('#desa').val()+
                        '&idpos='+$('#idpos').val();
            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('posyandu/save/')?>"+$(this).attr('id'),
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
                            $('#desa').select2().prop("disabled",true);
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
                url: "<?php echo site_url('posyandu/delete/') ?>"+$(this).attr('id'),
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

                <div id="form_input" class="p-b-10 card-body">
                    <input type="hidden" id="idpos" value="<?= ((isset($data->idpos))? $data->idpos:'' ) ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Nama Posyandu *</label>
                        </div>
                        <div class="col-md-5">
                            <input id="namapos" type="text" class="form-control" value="<?php if(isset($data->namapos)) echo $data->namapos ?>">
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-2">
                            <label>Alamat</label>                            
                        </div>
                        <div class="col-md-5">
                            <textarea id="alamat" class="form-control" rows="3"><?php if(isset($data->alamatpos)) echo $data->alamatpos ?></textarea>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-2">
                            <label>RT</label>                            
                        </div>
                        <div class="col-md-2">
                            <input id="rt" type="text" class="form-control" maxlength="3" placeholder="000" value="<?php if(isset($data->rt)) echo $data->rt ?>">
                        </div>
                        <div class="col-md-1 text-right">
                            <label>RW</label>                            
                        </div>
                        <div class="col-md-2">
                            <input id="rw" type="text" class="form-control" maxlength="3" placeholder="000" value="<?php if(isset($data->rw)) echo $data->rw ?>">
                        </div>
                    </div>

                    <?php
                        if($_SESSION['level'] != 3){
                    ?>

                            <div class="row m-t-20">
                                <div class="col-md-2">
                                    <label>Propinsi *</label>
                                </div>
                                <div class="col-md-5">
                                    <select id="propinsi" class="select2 form-control" style="width:100%" disabled>
                                        <option value="0">Pilih</option>
                                        <?php
                                            foreach ($data_propinsi as $rows){
                                                echo '<option value="'.$rows->id.'" selected>'.$rows->name.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-2">
                                    <label>Kabupaten / Kota *</label>
                                </div>
                                <div class="col-md-5">
                                    <select id="kabupaten" class="select2 form-control" style="width:100%">
                                        <option value="0">Pilih</option>
                                        <?php
                                            // if(isset($data->id_kab)){
                                                foreach($data_kab as $rows_kab){
                                                    echo '<option value="'.$rows_kab->id.'" '.(($data->id_kab == $rows_kab->id)?"selected":"").'>'.$rows_kab->name.'</option>';
                                                }
                                            // }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row m-t-20">
                                <div class="col-md-2">
                                    <label>Kecamatan *</label>
                                </div>
                                <div class="col-md-5">
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
                            </div>
                    <?php   }   ?>

                    <div class="row m-t-20">
                        <div class="col-md-2">
                            <label>Desa *</label>
                        </div>
                        <div class="col-md-5">
                            <select id="desa" class="select2 form-control" style="width:100%">
                                <option value="0">Pilih</option>
                                <?php
                                    if(isset($data_desa)){
                                       
                                        foreach($data_desa as $rows_desa){
                                            if(isset($data->id_desa)){
                                                if($data->id_desa == $rows_desa->id){
                                                    $selected = "selected";
                                                }else{
                                                    $selected = "";
                                                }
                                            }else{
                                                $selected = "";
                                            }
                                            echo '<option value="'.$rows_desa->id.'-'.$rows_desa->idpusk.'" '.$selected.'>'.$rows_desa->name.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <?php
                        if($_SESSION['level'] != 3){
                    ?>
                            <div class="row m-t-20">
                                <div class="col-md-2">
                                    <label>Puskesmas *</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" id="puskesmas" class="form-control" value="<?= ((isset($data->namapusk))? $data->namapusk:"") ?>" disabled/>
                                </div>
                                <!-- kodingan baru
                                <div class="col-md-5">
                                    <select id="puskesmas" class="select2 form-control" style="width:100%">
                                        <option value="">Pilih</option>
                                        <?php
                                            if(isset($data_pusk)){
                                            
                                                foreach($data_pusk as $rows_pusk){
                                                    if(isset($data->idpusk)){
                                                        if($data->idpusk == $rows_pusk->idpusk){
                                                            $selected = "selected";
                                                        }else{
                                                            $selected = "";
                                                        }
                                                    }else{
                                                        $selected = "";
                                                    }
                                                    echo '<option value="'.$rows_pusk->idpusk.'" '.$selected.'>'.$rows_pusk->namapusk.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div> -->
                            </div>
                    <?php   } ?>
                </div><!-- ./ card-body -->
            
            <div class="card-footer">
                <div class="row">
                    <div id="col_validasi" class="col-md-4 text-left">
                        <div id="validasi"></div>
                    </div>
                    <div id="col_btn" class="col-md-3 text-right">
                        <button id="btn_cancel" class="btn btn btn-secondary" style="display:none"><i class="fa fa-chevron-left"></i> BATAL</button>
                        <button id="btn_new_input" class="btn btn btn-secondary" style="display:none"><i class="fa fa-plus-square"></i> TAMBAH BARU</button>
                        <button class="btn_hapus btn btn-danger"><i class="fa fa-trash"></i> HAPUS</button>
                        <button id="<?php if(isset($data->idpos)) echo md5($data->idpos) ?>" class="btn_save ">
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
                            <a href="<?= site_url('data-posyandu') ?>">
                                <button id="btn_ok" class="btn btn-secondary" style="display:none"style="display:none">OK</button>
                            </a>
                            <button id="btn_cancel_hapus" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                            <button id="<?php if(isset($data->idpos)) echo md5($data->idpos) ?>" class="btn_konfrim_hapus btn btn-danger">
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
