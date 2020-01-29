
<script type="text/javascript">
    $(document).ready(function(){
        $(".form-control").attr('autocomplete', 'off');

        $("input[name='bb_u']").prop("disabled",true);
        $("input[name='tb_u_pb_u']").prop("disabled",true);
        $("input[name='bb_tb_bb_pb']").prop("disabled",true);
        $("input[name='imt_u']").prop("disabled",true);
        $("input[name='lila_u']").prop("disabled",true);
        $("#form_balita input[type=radio]").prop("disabled",true);

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
            $("#form_balita select").prop("disabled",true);
            $("#form_balita input[type=text]").prop("disabled",true);
            $("#form_penimbangan input[type=radio]").prop("disabled",true);
            $("#form_penimbangan input[type=text]").prop("disabled",true);
           
        }
    });
</script>

<script type="text/javascript">
    $(function(){     
        // START FORM MODAL DELETE
        $(document).on('click','.btn_hapus',function(e){
            e.preventDefault();
            $('#validasi_hapus').html('Apakah Anda ingin menghapus data ini?');
            $('#modal_hapus').modal('show');
        });  
        
        $(document).on('click','#btn_new_input', function(){
            $('#nama_balita').select2("val","0");
            $("#form_balita input[type=text]").val('');
            $("#form_balita input[type=radio]").prop("checked",false);
            $("#form_penimbangan input[type=text]").val('');
            $("#form_penimbangan input[type=radio]").prop("checked",false);
            $('.btn_save').show();
            $('#btn_new_input').hide();
            $('#validasi').hide();
        });

        $(document).on('click','.btn_edit', function(e){
            e.preventDefault();
            $("#btn_cancel").show();
            $(".btn_hapus").hide();
            
            $(".btn_edit").removeClass("btn_edit btn btn-warning").addClass("btn_save btn btn-info");
            $("#text_btn").text("");
            $("#text_btn").append('<i class="fa fa-save"></i> ');
            $("#text_btn").append('SIMPAN');

            $("#form_balita select").prop("disabled",false);
            $("#form_penimbangan input[type=text]").prop("disabled",false);
            $("#form_penimbangan input[type=radio]").prop("disabled",false);

            $("input[name='bb_u']").prop("disabled",true);
            $("input[name='tb_u_pb_u']").prop("disabled",true);
            $("input[name='bb_tb_bb_pb']").prop("disabled",true);
            $("input[name='imt_u']").prop("disabled",true);
            $("input[name='lila_u']").prop("disabled",true);
            $("#form_balita input[type=radio]").prop("disabled",true);

        });

        $(document).on('click','#btn_cancel', function(){
            $("#btn_cancel").hide();
            $(".btn_save").removeClass("btn_save btn btn-info").addClass("btn_edit btn btn-warning");
            $("#text_btn").text("");
            $("#text_btn").append('<i class="fa fa-save"></i> ');
            $("#text_btn").append('UBAH');

            $(".btn_hapus").show();

            $("#form_balita select").prop("disabled",true);
            $("#form_penimbangan input[type=text]").prop("disabled",true);
            $("#form_penimbangan input[type=radio]").prop("disabled",true);
        });
        
        $(document).on('change','#nama_balita', function(){
            $("#tgl_penimbangan").val('');
            $("#umur_bayi").val('');
            $("#form_penimbangan input[type=text]").val('');
            $("#form_penimbangan input[type=radio]").prop("checked",false);

            $.post("penimbangan/getDataBalita",{norm:$("#nama_balita").val()}, function(result){

                $("input[name='tgl_lahir']").val(result['tgl_lahir']);
                $("input[name=jenkel][value='"+result['jenkel']+"']").prop("checked",true);
                $("input[name='nama_ortu']").val(result['nmortu']);
                $("input[name='nik_ortu']").val(result['nikortu']);
                $("input[name=gakin][value='"+result['gakin']+"']").prop("checked",true);
                $("#propinsi").val(result['propinsi']);
                $("#kabupaten").val(result['kabupaten']);
                $("#kecamatan").val(result['kecamatan']);
                $("#desa").val(result['desa']);
                $("#posyandu").val(result['posyandu']);
            },'json');
        });

        $(document).on('change','#tgl_penimbangan', function(){
            var tgl_lahir = $("input[name=tgl_lahir]").val();
            if(tgl_lahir == ''){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Anda belum memilih balita</font>");
                $('#nama_balita').focus();
                return (false);
            }else{
                $.post("penimbangan/getUmurBalita",
                    {tglLahir:tgl_lahir,
                    tglPenimbangan:$("#tgl_penimbangan").val()}, 
                    function(result){
                        var umur_balita = result;
                        $("#umur_bayi").val(result);
                        if(parseInt(umur_balita) > 60 ){
                            $("#obesitas").show();
                        }else{
                            $("#obesitas").hide();
                        }

                        $.post("<?= site_url('Penimbangan/status_gizi/bb_u') ?>", {jenkel:$('input[name=jenkel]:checked').val(),umur:$('#umur_bayi').val(),bb:$("#bb").val()}, function( data ) {
                            if(data['status'] == '1'){
                                $("input[name=bb_u][value='"+data['status_gizi']+"']").prop("checked",true);
                            }
                        },"json");

                        
                        $.post("<?= site_url('Penimbangan/status_gizi/pb_u_tb_u') ?>",
                            {jenkel:$('input[name=jenkel]:checked').val(),
                            umur:$('#umur_bayi').val(),
                            tb:$("#tb").val(),
                            pb:$("#pb").val()}, 
                            function( data ) {
                                if(data['status'] == '1'){
                                    $("input[name=tb_u_pb_u][value='"+data['status_gizi']+"']").prop("checked",true);
                                }
                        },"json");

                        $.post("<?= site_url('Penimbangan/status_gizi/bb_pb_bb_tb') ?>",
                            {jenkel:$('input[name=jenkel]:checked').val(),
                            umur:$('#umur_bayi').val(),
                            bb:$("#bb").val(),
                            tb:$("#tb").val(),
                            pb:$("#pb").val()}, 
                            function( data ) {
                                if(data['status'] == '1'){
                                    $("input[name=bb_tb_bb_pb][value='"+data['status_gizi']+"']").prop("checked",true);
                                }
                        },"json");

                        $.post("<?= site_url('Penimbangan/status_gizi/imt_u') ?>",
                            {jenkel:$('input[name=jenkel]:checked').val(),
                            umur:$('#umur_bayi').val(),
                            bb:$("#bb").val(),
                            tb:$("#tb").val()}, 
                            function( data ) {
                                if(data['status'] == '1'){
                                    $("input[name=imt_u][value='"+data['status_gizi']+"']").prop("checked",true);
                                }
                        },"json");
                });
            }
        });

        $(document).on('keyup','#bb', function(){
            $.post("<?= site_url('Penimbangan/status_gizi/bb_u') ?>", {jenkel:$('input[name=jenkel]:checked').val(),umur:$('#umur_bayi').val(),bb:$("#bb").val()}, function( data ) {
                if(data['status'] == '1'){
                    $("input[name=bb_u][value='"+data['status_gizi']+"']").prop("checked",true);
                }
            },"json");
            $.post("<?= site_url('Penimbangan/status_gizi/bb_pb_bb_tb') ?>",
                {jenkel:$('input[name=jenkel]:checked').val(),
                umur:$('#umur_bayi').val(),
                bb:$("#bb").val(),
                tb:$("#tb").val(),
                pb:$("#pb").val()}, 
                function( data ) {
                    if(data['status'] == '1'){
                        $("input[name=bb_tb_bb_pb][value='"+data['status_gizi']+"']").prop("checked",true);
                    }
            },"json");
            $.post("<?= site_url('Penimbangan/status_gizi/imt_u') ?>",
                {jenkel:$('input[name=jenkel]:checked').val(),
                umur:$('#umur_bayi').val(),
                bb:$("#bb").val(),
                tb:$("#tb").val()}, 
                function( data ) {
                    if(data['status'] == '1'){
                        $("input[name=imt_u][value='"+data['status_gizi']+"']").prop("checked",true);
                    }
            },"json");
        });

        $(document).on('keyup','.hitung_pb_u_tb_u', function(){
            $.post("<?= site_url('Penimbangan/status_gizi/pb_u_tb_u') ?>",
                {jenkel:$('input[name=jenkel]:checked').val(),
                umur:$('#umur_bayi').val(),
                tb:$("#tb").val(),
                pb:$("#pb").val()}, 
                function( data ) {
                    if(data['status'] == '1'){
                        $("input[name=tb_u_pb_u][value='"+data['status_gizi']+"']").prop("checked",true);
                    }
            },"json");

            $.post("<?= site_url('Penimbangan/status_gizi/bb_pb_bb_tb') ?>",
                {jenkel:$('input[name=jenkel]:checked').val(),
                umur:$('#umur_bayi').val(),
                bb:$("#bb").val(),
                tb:$("#tb").val(),
                pb:$("#pb").val()}, 
                function( data ) {
                    if(data['status'] == '1'){
                        $("input[name=bb_tb_bb_pb][value='"+data['status_gizi']+"']").prop("checked",true);
                    }
            },"json");

            $.post("<?= site_url('Penimbangan/status_gizi/imt_u') ?>",
                {jenkel:$('input[name=jenkel]:checked').val(),
                umur:$('#umur_bayi').val(),
                bb:$("#bb").val(),
                tb:$("#tb").val()}, 
                function( data ) {
                    if(data['status'] == '1'){
                        $("input[name=imt_u][value='"+data['status_gizi']+"']").prop("checked",true);
                    }
            },"json");
        });

        $(document).on('keyup','#lila', function(){
            var lila = $("#lila").val();
            if(parseFloat(lila) < 11.5){
                $("input[name=lila_u][value='<11.5 cm']").prop("checked",true);
            }else if(parseFloat(lila) > 11.5){
                $("input[name=lila_u][value='>11.5 cm']").prop("checked",true);
            }else if(lila == ''){
                $("input[name=lila_u]").prop("checked",false);
            }
        });
        
    });

    
</script>



<script type="text/javascript">
	$(function(){
        $(document).on('click','.btn_save',function(e){
            e.preventDefault();
            $('#validasi').html('');
            $('#validasi').show();
            var jenis_form = $('#jenis_form').val();
            var level = $('#level').val();

            if($('#nama_balita').val()=="0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nama Balita Belum Diisi</font>");
                $('#nama_balita').focus();
                return (false);
            }else if($('#tgl_penimbangan').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Tanggal Penimbangan Belum Diisi</font>");
                $('#tgl_penimbangan').focus();
                return (false);
            }else if($('#umur_bayi').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Umur Bayi Belum Diisi</font>");
                $('#umur_bayi').focus();
                return (false);
            }else if($('#bb').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Berat Badan Belum Diisi</font>");
                $('#bb').focus();
                return (false);
            }else if($('#tb').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Tinggi Badan Belum Diisi</font>");
                $('#tb').focus();
                return (false);
            }else if($('#pb').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Panjang Badan Belum Diisi</font>");
                $('#pb').focus();
                return (false);
            }else if($('#lila').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> LILA Belum Diisi</font>");
                $('#lila').focus();
                return (false);
            }else if(!$('input[name=bb_u]').is(':checked')){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> BB/ U Belum Diisi</font>");
                $('input[name=bb_u]').focus();
                return (false);
            }else if(!$('input[name=tb_u_pb_u]').is(':checked')){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> TB/ U Atau PB/ U Belum Diisi</font>");
                $('input[name=tb_u_pb_u]').focus();
                return (false);
            }else if(!$('input[name=bb_tb_bb_pb]').is(':checked')){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> BB/ TB Atau BB/ PB  Belum Diisi</font>");
                $('input[name=bb_tb_bb_pb]').focus();
                return (false);
            }else if(!$('input[name=imt_u]').is(':checked')){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> IMT/ U  Belum Diisi</font>");
                $('input[name=imt_u]').focus();
                return (false);
            }else if(!$('input[name=lila_u]').is(':checked')){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> LILA/ U *  Belum Diisi</font>");
                $('input[name=lila_u]').focus();
                return (false);
            }

            $('.btn_save').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();

            var bb_u = $('input[name=bb_u]:checked').val();
            var tb_u_pb_u = $('input[name=tb_u_pb_u]:checked').val();
            var bb_tb_bb_pb = $('input[name=bb_tb_bb_pb]:checked').val();
            var imt_u = $('input[name=imt_u]:checked').val();

            var param = 'norm='+$('#nama_balita').val()+
                        '&tgl_penimbangan='+$('#tgl_penimbangan').val()+
                        '&umur_bayi='+$('#umur_bayi').val()+
                        '&bb='+$('#bb').val()+
                        '&tb='+$('#tb').val()+
                        '&pb='+$('#pb').val()+
                        '&lila='+$('#lila').val()+
                        '&bb_u='+bb_u+
                        '&tb_u_pb_u='+tb_u_pb_u+
                        '&bb_tb_bb_pb='+bb_tb_bb_pb+
                        '&imt_u='+imt_u+
                        '&lila_u='+$('input[name=lila_u]:checked').val();
            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('penimbangan/save/')?>"+$(this).attr('id'),
                data: param,
                dataType : "json",
                success: function(result) {
                    $('#loading').hide();
                    $('.btn_save').prop('disabled',false);

                    if(result['status'] == "1"){
                        if(result['jenis'] == "simpan"){
                            $('.btn_save').hide();
                            $('#btn_new_input').show();
                            if(bb_u == "Buruk"){
                                var notif_menu = $("#notif_menu").text();
                                $("#notif_menu").text(parseInt(notif_menu)+1);
                                $.toast({
                                    heading: 'Warning',
                                    text: 'Balita ini memiliki gizi buruk',
                                    position: 'top-right',
                                    loaderBg:'#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500
                                    
                                })
                            }else if(tb_u_pb_u == "Sangat Pendek"){
                                var notif_stunting = $("#notif_stunting").text();
                                $("#notif_stunting").text(parseInt(notif_stunting)+1);
                                $.toast({
                                    heading: 'Warning',
                                    text: 'Balita ini memiliki TB/ U Atau PB/ U sangat pendek',
                                    position: 'top-right',
                                    loaderBg:'#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500
                                    
                                })
                            }else if(bb_tb_bb_pb == "Sangat Kurus"){
                                var notif_bb_tb_bb_pb = $("#notif_bb_tb_bb_pb").text();
                                $("#notif_bb_tb_bb_pb").text(parseInt(notif_bb_tb_bb_pb)+1);
                                $.toast({
                                    heading: 'Warning',
                                    text: 'Balita ini memiliki BB/ TB Atau BB/ PB sangat kurus',
                                    position: 'top-right',
                                    loaderBg:'#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500
                                    
                                })
                            }else if(imt_u == "Sangat Kurus"){
                                var notif_imt_u = $("#notif_imt_u").text();
                                $("#notif_imt_u").text(parseInt(notif_imt_u)+1);
                                $.toast({
                                    heading: 'Warning',
                                    text: 'Balita ini memiliki IMT/ U sangat kurus',
                                    position: 'top-right',
                                    loaderBg:'#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500
                                    
                                })
                            }else if(imt_u == "Sangat Gemuk"){
                                var notif_imt_u = $("#notif_imt_u").text();
                                $("#notif_imt_u").text(parseInt(notif_imt_u)+1);
                                $.toast({
                                    heading: 'Warning',
                                    text: 'Balita ini memiliki IMT/ U sangat gemuk',
                                    position: 'top-right',
                                    loaderBg:'#ff6849',
                                    icon: 'error',
                                    hideAfter: 3500
                                    
                                })
                            }
                        }else if(result['jenis'] == "edit"){
                            $("#btn_cancel").hide();
                            $(".btn_hapus").show();
                            //BUTTON SIMPAN
                            $(".btn_save").removeClass("btn_save btn btn-info").addClass("btn_edit btn btn-warning");
                            $("#text_btn").text("");
                            $("#text_btn").append('<i class="fa fa-save"></i> ');
                            $("#text_btn").append('UBAH');

                            $("#form_penimbangan input[type=text]").prop("disabled",true);
                            $("#form_penimbangan input[type=radio]").prop("disabled",true);
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
                url: "<?php echo site_url('penimbangan/delete/') ?>"+$(this).attr('id'),
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


<style>
    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 10px;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
</style>

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
                            <small>&nbsp;</small>
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
                            <small> Diisi Oleh Bidan / Kader </small>
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
                                        <input type="text" id="tb" class="hitung_pb_u_tb_u form-control" value="<?= ((isset($data->tb))? $data->tb:"") ?>">
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
                                        <input type="text" id="pb" class="hitung_pb_u_tb_u form-control" value="<?= ((isset($data->pb))? $data->pb:"") ?>">
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
                                    <label class="custom-control custom-radio">
                                        <input name="bb_u" type="radio" class="custom-control-input" value="Lebih" <?= ((isset($data->bb_u) && $data->bb_u == "Lebih")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Lebih</span>
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
                                    <label class="custom-control custom-radio">
                                        <input name="tb_u_pb_u" type="radio" class="custom-control-input" value="Tinggi" <?= ((isset($data->tb_u_pb_u) && $data->tb_u_pb_u == "Tinggi")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Tinggi</span>
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
                                    <label class="custom-control custom-radio">
                                        <input name="bb_tb_bb_pb" type="radio" class="custom-control-input" value="Gemuk" <?= ((isset($data->bb_tb_bb_pb) && $data->bb_tb_bb_pb == "Gemuk")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Gemuk</span>
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
                                        <input name="lila_u" type="radio" class="custom-control-input" value="<11.5 cm" <?= ((isset($data->lila_u) && $data->lila_u == "<11.5 cm")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">< 11.5 CM</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input name="lila_u" type="radio" class="custom-control-input" value=">11.5 cm" <?= ((isset($data->lila_u) && $data->lila_u == ">11.5 cm")? "checked":"") ?> >
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">>11.5 CM</span>
                                    </label>
                                </div>
                            </div>
                            
                        </div>
                        <!-- END FORM PENIMBANGAN -->
                    </div><!--./row -->                    
                </div><!-- ./ card-body -->
                
                <div class="card-footer">
                    <div class="row">
                        <div id="col_validasi" class="col-md-8 text-left">
                            <div id="validasi"></div>
                        </div>
                        <div id="col_btn" class="col-md-4 text-right">
                            <button id="btn_cancel" class="btn btn btn-secondary" style="display:none"><i class="fa fa-chevron-left"></i> BATAL</button>
                            <button id="btn_new_input" class="btn btn btn-secondary" style="display:none"><i class="fa fa-plus-square"></i> TAMBAH BARU</button>
                            <button class="btn_hapus btn btn-danger"><i class="fa fa-trash"></i> HAPUS</button>
                            <button id="<?php if(isset($data->norm)) echo md5($data->norm).'/'.$data->tglpenimbangan ?>" class="btn_save ">
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
                            <a href="<?= site_url('penimbangan') ?>">
                                <button id="btn_ok" class="btn btn-secondary" style="display:none"style="display:none">OK</button>
                            </a>
                            <button id="btn_cancel_hapus" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
                            <button id="<?php if(isset($data->norm)) echo md5($data->norm).'/'.$data->tglpenimbangan ?>" class="btn_konfrim_hapus btn btn-danger">
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

<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
  <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->



<script type="text/javascript">
    $(document).ready(function(){

        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            language: "id",
            locale: "id",
            todayHighlight: true
        });

        $('.select2').select2();
    })
</script>

<script type="text/javascript">
    $(function(){
        $('#nama_balita').select2({
            placeholder: 'Masukkan nama balita',
            ajax: {
                // type: 'POST',
                url: '<?= site_url("penimbangan/getNamaBalita") ?>',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                return {
                        results: data
                    };
                },
                cache: true
            },
            minLength: 3,
        });
    });
</script>


