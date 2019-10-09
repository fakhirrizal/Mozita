<!-- START TAMPIL MODAL -->
<script type="text/javascript">
	$(function(){
        $(document).on('click','.btn_save',function(){
            $('#validasi').html('');

            if($('#kode_propinsi').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kode Propinsi Belum Diisi</font>");
                $('#kode_propinsi').focus();
                return (false);
            }else if($('#nama_propinsi').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nama Propinsi Belum Diisi</font>");
                $('#nama_propinsi').focus();
                return (false);
            }

            $('.btn_save').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();

            var param = 'kode_propinsi='+$('#kode_propinsi').val()+
                        '&nama_propinsi='+$('#nama_propinsi').val();            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('data_propinsi/save/')?>"+$(this).attr("id"),
                data: param,
                dataType:'json',
                success: function(result) {
                    if(result['success']=='1'){
                        $(".btn_save").attr("id",result['id']);
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

    });
</script>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="p-b-10 card-body">
                <div class="row">
                    <div class="col-md-2">
                        <label>Kode Propinsi *</label>
                    </div>
                    <div class="col-md-4">
                        <input id="kode_propinsi" type="text" class="form-control" value="<?php if(isset($data->id)) echo $data->id ?>">
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-2">
                        <label>Nama Propinsi *</label>
                    </div>
                    <div class="col-md-4">
                        <input id="nama_propinsi" type="text" class="form-control" value="<?php if(isset($data->name)) echo $data->name ?>">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div id="validasi" class="col-md-4"></div>
                    <div class="col-md-2">
                        <button id="<?php if(isset($data->id)) echo $data->id ?>" class="btn_save btn btn-warning pull-right">
                            <div id="loading" class="spinner" style="display:none">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                                <div class="rect4"></div>
                                <div class="rect5"></div>
                            </div>
                            <a id="text_btn">UBAH</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>