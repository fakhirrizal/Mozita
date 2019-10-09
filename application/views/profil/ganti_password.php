<script type="text/javascript">
	$(function(){
        $(document).on('submit','#form_pp',function(e){
            e.preventDefault();
            $('#validasi').html('');
            $('#validasi').show();

            if($('[name=old_password]').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kata sandi tidak boleh kosong</font>");
                $('[name=old_password]').focus();
                return (false);
            }else if($('[name=confirm_new_password]').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kata sandi baru tidak sama dengan konfirmasi kata sandi baru</font>");
                $('[name=confirm_new_password]').focus();
                return (false);
            }else if($('[name=new_password]').val() != $('[name=confirm_new_password]').val()){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Kata sandi baru tidak sama dengan konfirmasi kata sandi baru</font>");
                $('[name=confirm_new_password]').focus();
                return (false);
            }

            $('.btn_save').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();

            var param = new FormData(this);
            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('profil/ubah_sandi')?>",
                data: param,
                contentType: false,
				cache: false, 
				processData:false,
                dataType : "json",
                success: function(result) {
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
            <form id="form_pp">
                <div id="form_input" class="p-b-10 card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Kata Sandi Lama</label>
                        </div>
                        <div class="col-md-4">
                            <input name="old_password" type="password" class="form-control">
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-3">
                            <label>Kata Sandi baru</label>
                        </div>
                        <div class="col-md-4">
                            <input name="new_password" type="password" class="form-control">
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-3">
                            <label>Konfirmasi Kata Sandi baru</label>
                        </div>
                        <div class="col-md-4">
                            <input name="confirm_new_password" type="password" class="form-control" >
                        </div>
                    </div>
                </div><!-- ./ card-body -->
                
                <div class="card-footer">
                    <div class="row">
                        <div id="col_validasi" class="col-md-4 text-left">
                            <div id="validasi"></div>
                        </div>
                        <div id="col_btn" class="col-md-3 text-right">
                            <button type="submit" id="<?php if(isset($data->norm)) echo md5($data->norm) ?>" class="btn_save btn btn-warning">
                                <div id="loading" class="spinner" style="display:none">
                                    <div class="rect1"></div>
                                    <div class="rect2"></div>
                                    <div class="rect3"></div>
                                    <div class="rect4"></div>
                                    <div class="rect5"></div>
                                </div>
                                <a id="text_btn"><i class="fa fa-edit"></i> UBAH</a>
                            </button>
                        </div>
                    </div><!-- ./row -->
                </div><!-- ./ card-footer -->
            </form>
        </div><!-- ./ card -->
    </div><!-- ./ col -->
</div><!-- ./ row -->

