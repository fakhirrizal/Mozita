<!-- START TAMPIL DATA TABLE -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#list_data').load("<?php echo site_url('data_user/list_data') ?>");
    });
</script>
<!-- END TAMPIL DATA TABLE -->

<!-- START TAMPIL MODAL -->
<script type="text/javascript">
    $(function(){           
        // START FORM MODAL INPUT
        $(document).on('click','.btn_input',function(){  
            $('#tampil_form').load("<?php echo site_url('data_user/form') ?>",function(){
                $('#modal_form').modal('show');
                $(".title").text("Tambah Pengguna");
                $(".btn_save").addClass("btn_save btn btn-primary");
                $("#text_btn").append('<i class="fa fa-save"></i> ');
                $("#text_btn").append('SIMPAN');
                $("#btn_new_input").hide();
            }); 
        });
        // START FORM MODAL EDIT
        $(document).on('click','.btn_edit',function(){
            $('#tampil_form').load("<?php echo site_url('data_user/form/') ?>"+$(this).attr('id'),function(){
                $('#modal_form').modal('show');
                $(".title").text("Form Ubah Data");
                $(".btn_save").addClass("btn_save btn btn-warning");
                $("#text_btn").append('<i class="fa fa-edit (alias)"></i> ');
                $("#text_btn").append('UBAH');
                $("#btn_new_input").hide();
            });
        });
        // START FORM MODAL DELETE
        $(document).on('click','.btn_delete',function(){
            $('#tampil_form').load("<?php echo site_url('data_user/form').'/' ?>"+$(this).attr('id'),function(){
                $('#modal_form').modal('show');
                $(".title").text("Apakah Anda Ingin Menghapus Pengguna Ini?");
                $("#form_input input[type=text]").prop("disabled",true);
                $("#form_input input[type=password]").prop("disabled",true);
                $("#form_input select").prop("disabled",true);
                $("#text_btn").append('<i class="fa fa-trash-o"></i> ');
                $("#text_btn").append('HAPUS');
                $( ".btn_save" ).removeClass( "btn_save" ).addClass( "btn_hapus btn btn-danger" );
                $("#btn_new_input").hide();
            });
        });

        // START FORM MODAL AKTIF / NON AKTIF USER
        $(document).on('click','.btn_aktif',function(){
            var split_id = $(this).attr('id').split("-");
            var status_user = split_id[0];
            var id_user = split_id[1];

            if(status_user == "ya"){
                var title = "Apakah Anda Ingin Menonaktifkan Pengguna Ini?";
                var text_button = " Nonaktifkan ";
                var class_btn = " btn_a_n btn btn-danger ";
            }else{
                var title = "Apakah Anda Ingin Mengaktifkan Pengguna Ini?";
                var text_button = " Aktifkan ";
                var class_btn = " btn_a_n btn btn-info";
            }
            
            $('#tampil_form').load("<?php echo site_url('data_user/form').'/' ?>"+id_user,function(){
                $('#modal_form').modal('show');         
                $(".title").text(title);
                $("#form_input input[type=text]").prop("disabled",true);
                $("#form_input input[type=password]").prop("disabled",true);
                $("#form_input select").prop("disabled",true);
                $("#text_btn").append(text_button);
                $( ".btn_save" ).removeClass( "btn_save" ).addClass(class_btn);
                $("#btn_new_input").hide();
            });
        });

        // CHANGE LEVEL
        $(document).on('change','#level',function(){
            var level = $("#level").val();
            // $("#kabupaten").select2("val","0");
            $("#kecamatan").select2("val","0");
            $("#puskesmas").select2("val","");
            $("#desa").select2("val","0");
            $("#posyandu").select2("val","0");

            if(level == '2'){
                $("#form_propinsi").show();
                $("#form_kab").show();
                $("#form_kec").show();
                $("#form_puskesmas").show();
                $("#form_desa").show();
                $("#form_posyandu").show();
            }else if(level == '3'){
                $("#form_propinsi").show();
                $("#form_kab").show();
                $("#form_kec").show();
                $("#form_puskesmas").show();
                $("#form_desa").hide();
                $("#form_posyandu").hide();
            }else if(level == '4'){
                $("#form_propinsi").show();
                $("#form_kab").show();
                $("#form_kec").hide();
                $("#form_puskesmas").hide();
                $("#form_desa").hide();
                $("#form_posyandu").hide();
            }else if(level == '5'){
                $("#form_propinsi").show();
                $("#form_kab").hide();
                $("#form_kec").hide();
                $("#form_puskesmas").hide();
                $("#form_desa").hide();
                $("#form_posyandu").hide();
            }else{
                $("#form_propinsi").hide();
                $("#form_kab").hide();
                $("#form_kec").hide();
                $("#form_puskesmas").hide();
                $("#form_desa").hide();
                $("#form_posyandu").hide();
            }
        });

        $(document).on('change','#propinsi', function(){
            var id = $("#propinsi").val();
            $.post("<?= site_url('data_user/combobox/kota/') ?>"+id,{id_propinsi:id}, function(result){
                $("#kabupaten").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#kabupaten', function(){
            var id = $("#kabupaten").val();
            $.post("<?= site_url('data_user/combobox/kecamatan/') ?>"+id,{id_kab:id}, function(result){
                $("#kecamatan").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#kecamatan', function(){
            var id = $("#kecamatan").val();
            $.post("<?= site_url('data_user/combobox/puskesmas/') ?>"+id,{id_kecamatan:id}, function(result){
                $("#puskesmas").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#puskesmas', function(){
            var id = $("#puskesmas").val();
            $.post("<?= site_url('data_user/combobox/desa/') ?>"+id,{id_puskesmas:id}, function(result){
                $("#desa").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#desa', function(){
            var id = $("#desa").val();
            $.post("<?= site_url('data_user/combobox/posyandu/') ?>"+id,{id_desa:id}, function(result){
                $("#posyandu").html(result);
                $('.select2').select2();
            });
        });
        

        $(document).on('click','#btn_new_input', function(){
            $("#form_input input[type=text]").val('');
            $("#form_input input[type=password]").val('');
            $("#level").val("0");
            $("#form_propinsi").hide();
            $("#form_kab").hide();
            $("#form_kec").hide();
            $("#form_puskesmas").hide();
            $("#form_desa").hide();
            $("#form_posyandu").hide();
            $('.btn_save').show();
            $('#btn_new_input').hide();
            $('#validasi').hide();
        });
    });
</script>
<!-- END TAMPIL MODAL -->

<!-- START TAMPIL MODAL -->
<script type="text/javascript">
	$(function(){
        $(document).on('click','.btn_save',function(){
            $('#validasi').html('');
            $('#validasi').show();
            var jenis_form = $('#jenis_form').val();
            var level = $('#level').val();

            if($('#name').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nama Lengkap Belum Diisi</font>");
                $('#name').focus();
                return (false);
            }else if($('#phone').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nomor Seluler Belum Diisi</font>");
                $('#phone').focus();
                return (false);
            }else if($('#email').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Email Belum Diisi</font>");
                $('#email').focus();
                return (false);
            }else if(jenis_form == "tambah" && $('#password').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kata Sandi Belum Diisi</font>");
                $('#password').focus();
                return (false);
            }else if(level == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Level Belum Diisi</font>");
                $('#level').focus();
                return (false);
            }else if(jQuery.inArray(level,['1','2','3','4','5']) >= 0 && $('#propinsi').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Propinsi Belum Diisi</font>");
                $('#propinsi').focus();
                return (false);
            }else if(jQuery.inArray(level,['2','3','4']) >= 0 && $('#kabupaten').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kabupaten Belum Diisi</font>");
                $('#kabupaten').focus();
                return (false);
            }else if(jQuery.inArray(level,['2','3']) >= 0 && $('#kecamatan').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kecamatan Belum Diisi</font>");
                $('#kecamatan').focus();
                return (false);
            }else if(jQuery.inArray(level,['2','3']) >= 0 && $('#puskesmas').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Puskesmas Belum Diisi</font>");
                $('#puskesmas').focus();
                return (false);
            }else if(jQuery.inArray(level,['2']) >= 0 && $('#desa').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Desa Belum Diisi</font>");
                $('#desa').focus();
                return (false);
            }else if(jQuery.inArray(level,['2']) >= 0 && $('#posyandu').val() == "0"){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Posyandu Belum Diisi</font>");
                $('#posyandu').focus();
                return (false);
            }else if(jenis_form == "tambah" && $('#password').val() != $('#confrim_password').val()){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kata Sandi Tidak Sama</font>");
                $('#confrim_password').focus();
                return (false);
            }else if(jenis_form == "edit"){
                if($("#new_password").val() != "" && $("#new_password").val() != $("#confrim_new_password").val()){
                    $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kata Sandi Baru Tidak Sama</font>");
                    $('#confrim_new_password').focus();
                    return (false);
                }
            }

            $('.btn_save').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();
            // var param = '';

            var param = 'nama='+$('#name').val()+
                        '&nip='+$('#nip').val()+
                        '&phone='+$('#phone').val()+
                        '&email='+$('#email').val()+
                        '&password='+$('#password').val()+
                        '&new_password='+$('#new_password').val()+
                        '&level='+$('#level').val()+
                        '&propinsi='+$('#propinsi').val()+
                        '&kabupaten='+$('#kabupaten').val()+
                        '&kecamatan='+$('#kecamatan').val()+
                        '&puskesmas='+$('#puskesmas').val()+
                        '&desa='+$('#desa').val()+
                        '&posyandu='+$('#posyandu').val();
            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('data_user/save/')?>"+$(this).attr('id'),
                data: param,
                dataType : "json",
                success: function(result) {
                    if(result['status'] == "1"){
                        if(result['jenis'] == "simpan"){
                            $('.btn_save').hide();
                            $('#btn_new_input').show();
                            $('#list_data').load("<?php echo site_url('data_user/list_data') ?>");
                        }                        
                    }
                    
                    $('#loading').hide();
                    $('.btn_save').prop('disabled',false);
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
        $(document).on('click','.btn_hapus',function(){
            $('.btn_save').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('data_user/delete/') ?>"+$(this).attr('id'),
                success: function(result) {
                    $('.btn_save').prop('disabled',false);
                    $('#text_btn').show();
                    $('#loading').hide();
                    $('#tampil_form').html(result);
                    $('#list_data').load("<?php echo site_url('data_user/list_data') ?>");
                }
            });
        });

        // PROSES AKTIF / NON AKTIF USER
        $(document).on('click','.btn_a_n',function(){
            $('.btn_a_n').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();
            var param = 'aktif='+$('#aktif').val();
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('data_user/aktif_nonaktif_user/') ?>"+$(this).attr('id'),
                data: param,
                dataType : "json",
                success: function(result) {
                    $('#loading').hide();
                    $('.btn_a_n').prop('disabled',false);
                    $('#text_btn').show();
                    if(result['success'] == '1'){
                        if(result['button'] == 'ya'){
                            $('#aktif').val('Tidak');
                            $('#text_btn').text('Aktifkan');
                            $(".btn_a_n" ).removeClass( "btn_a_n btn btn-danger" ).addClass("btn_a_n btn btn-info");
                        }else{
                            $('#aktif').val('Ya');
                            $('#text_btn').text('Nonaktifkan');
                            $(".btn_a_n" ).removeClass( "btn_a_n btn btn-info" ).addClass("btn_a_n btn btn-danger");
                        }
                        
                        $('#list_data').load("<?php echo site_url('data_user/list_data') ?>");
                    }  
                    $('#validasi').html(result['message']);
                }
            });
        });
	 });
</script>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <button class="btn_input btn btn-info"><i class="fa fa-plus-square"></i> TAMBAH PENGGUNA</button>
                <div id="list_data"></div>
        </div>
    </div>
</div>

<!-- START TAMPIL MODAL -->
<div id="modal_form" class="modal">
    <div class="modal-danger">
        <div class="modal-dialog modal-lg">
        <!-- Modal content-->
            <div class="modal-content">
                <div id="tampil_form"></div>
            </div>
        </div>
    </div>
</div>
<!-- END TAMPIL MODAL -->