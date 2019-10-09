<!-- START TAMPIL MODAL -->
<script type="text/javascript">
    $(function(){
        $(document).on('change','#kabupaten', function(){
            var id = $("#kabupaten").val();
            $.post("<?= site_url('laporan/combobox/kecamatan/') ?>"+id,{id_kab:id}, function(result){
                $("#kecamatan").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#kecamatan', function(){
            var id = $("#kecamatan").val();
            $.post("<?= site_url('laporan/combobox/puskesmas/') ?>"+id,{id_kecamatan:id}, function(result){
                $("#puskesmas").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#puskesmas', function(){
            var id = $("#puskesmas").val();
            $.post("<?= site_url('laporan/combobox/desa/') ?>"+id,{id_puskesmas:id}, function(result){
                $("#desa").html(result);
                $('.select2').select2();
            });
        });

        $(document).on('change','#desa', function(){
            var id = $("#desa").val();
            $.post("<?= site_url('laporan/combobox/posyandu/') ?>"+id,{id_desa:id}, function(result){
                $("#posyandu").html(result);
                $('.select2').select2();
            });
        });
    });
</script>
<!-- END TAMPIL MODAL -->

<!-- START TAMPIL MODAL -->
<script type="text/javascript">
	$(function(){
        $(document).on('click','#btn_tampilkan',function(){
            $('#tampil_data').html('');
            if($('#blnpenimbangan').val() == ''){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Bulan Penimbangan Harus Belum Diisi</font>");
                $('#blnpenimbangan').focus();
                return false;
            }
            $('#btn_tampilkan').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();

            var param = 'propinsi='+$('#propinsi').val()+
                        '&kabupaten='+$('#kabupaten').val()+
                        '&kecamatan='+$('#kecamatan').val()+
                        '&puskesmas='+$('#puskesmas').val()+
                        '&desa='+$('#desa').val()+
                        '&posyandu='+$('#posyandu').val()+
                        '&blnpenimbangan='+$('#blnpenimbangan').val();
            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('laporan/view')?>",
                data: param,
                success: function(result) {

                    $('#loading').hide();
                    $('#btn_tampilkan').prop('disabled',false);
                    $('#text_btn').show();
                    $('#tampil_data').html(result);
                    
                },
                error: function(result) {
                    $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Terjadi Kesalahan Sistem</font>");
                    $('.btn_save').prop('disabled',false);
                    $('#loading').hide();
                    $('#text_btn').show();
                }
            });
        });

        $(document).on('click','#unduh_excel',function(){

            var param = 'propinsi='+$('#propinsi').val()+
                        '&kabupaten='+$('#kabupaten').val()+
                        '&kecamatan='+$('#kecamatan').val()+
                        '&puskesmas='+$('#puskesmas').val()+
                        '&desa='+$('#desa').val()+
                        '&posyandu='+$('#posyandu').val()+
                        '&blnpenimbangan='+$('#blnpenimbangan').val();
            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('laporan/unduh_excel')?>",
                data: param
            });
        });
	 });
</script>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row m-t-10">
                            <div class="col-md-6">
                                <label>Periode Penimbangan</label>
                                <input type="text" id="blnpenimbangan" class="datepicker form-control" placeholder="mm-yyyy">
                            </div>
                        </div>
                        <div class="row m-t-10" <?= (($_SESSION['level'] == 3)?" style='display:none'":"") ?> >
                            <div id="form_propinsi" class="col-md-6">
                                <label>Propinsi </label>
                                <input type="text" id="propinsi" class="form-control" value="<?= $propinsi ?>" readonly>
                            </div>
                            <div id="form_kab" class="col-md-6">
                                <label>Kabupaten / Kota</label>
                                <select id="kabupaten" class="select2 form-control" style="width:100%" <?= ((in_array($_SESSION['level'], array('2','4')))?" disabled":"") ?>>
                                    <option value="semua">Pilih Semua</option>
                                    <?php
                                        if($_SESSION['level'] == 2 or $_SESSION['level'] == 4){
                                            echo '<option value="'.$data_kab->id.'" selected>'.$data_kab->name.'</option>';
                                        }else{
                                            foreach($data_kab as $rows_kab){
                                                echo '<option value="'.$rows_kab->id.'" '.(($data->id_kab == $rows_kab->id)?"selected":"").'>'.$rows_kab->name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row m-t-10" <?= (($_SESSION['level'] == 3)?" style='display:none'":"") ?>>
                            <div id="form_kec" class="col-md-6">
                                <label>Kecamatan</label>
                                <select id="kecamatan" class="select2 form-control" style="width:100%" <?= ((in_array($_SESSION['level'], array('2')))?" disabled":"") ?>>
                                    <option value="semua">Pilih Semua</option>
                                    <?php
                                        if($_SESSION['level'] == 2){
                                            echo '<option value="'.$data_kec->id.'" selected>'.$data_kec->name.'</option>';
                                        }else if($_SESSION['level'] == 4){
                                            foreach($data_kec as $rows_kec){
                                                echo '<option value="'.$rows_kec->id.'">'.$rows_kec->name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div id="form_puskesmas" class="col-md-6">
                                <label>Puskesmas</label>
                                <select id="puskesmas" class="select2 form-control" style="width:100%" <?= ((in_array($_SESSION['level'], array('2')))?" disabled":"") ?>>
                                    <option value="semua">Pilih Semua</option>
                                    <?php
                                        if($_SESSION['level'] == 2){
                                            echo '<option value="'.$data_pusk->idpusk.'" selected>'.$data_pusk->namapusk.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row m-t-10">
                            <div id="form_desa" class="col-md-6">
                                <label>Desa</label>
                                <select id="desa" class="select2 form-control" style="width:100%" <?= ((in_array($_SESSION['level'], array('2')))?" disabled":"") ?>>
                                    <option value="semua">Pilih Semua</option>
                                    <?php
                                        if($_SESSION['level'] == 2){
                                            echo '<option value="'.$data_desa->id.'" selected>'.$data_desa->name.'</option>';
                                        }else if($_SESSION['level'] == 3){
                                            foreach ($data_desa as $rows_desa) {
                                                echo '<option value="'.$rows_desa->id.'">'.$rows_desa->name.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label>Posyandu *</label>
                                <select id="posyandu" class="select2 form-control" style="width:100%" <?= ((in_array($_SESSION['level'], array('2')))?" disabled":"") ?>>
                                    <option value="semua">Pilih Semua</option>
                                    <?php
                                        if($_SESSION['level'] == 2){
                                            echo '<option value="'.$data_posy->idpos.'" selected>'.$data_posy->namapos.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                    </div><!-- ./col -->
                </div><!-- ./row -->
            </div><!-- ./card-body -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-2">
                        <button id="btn_tampilkan" class="btn btn-info">
                            <div id="loading" class="spinner" style="display:none">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                                <div class="rect4"></div>
                                <div class="rect5"></div>
                            </div>
                            <a id="text_btn">TAMPILKAN</a>
                        </button>
                    </div>
                </div><!-- ./row -->
            </div><!-- ./card-footer -->

        </div><!-- ./card -->
    </div><!-- ./col -->
</div><!-- ./row -->


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <div class="row table-responsive-md">
                    <div id="tampil_data" class="col-md-12">
                    </div>
                </div>
            </div><!-- ./card-body -->
        </div><!-- ./card -->
    </div><!-- ./col -->
</div><!-- ./row -->



<script>
    $(document).ready(function(){
        $('.select2').select2();
    });

    $(function() {
        $('.datepicker').datepicker( {
            autoclose: true,
            language: "id",
            locale: "id",
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });
    });
    
</script>

