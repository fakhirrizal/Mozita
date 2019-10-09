<script type="text/javascript">
    $(function(){   
        $(document).on('change','#file',function(){
            $("#message").empty(); // To remove the previous error message
            $('#image_preview').show();
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
                $('#previewing').attr('src','noimage.png');
                $('#validasi').show();
                $("#validasi").html("<font color='#FF2626'>"
                                    +"<i class='fa fa-close (alias)'>&nbsp;</i>"
                                    +"<strong>ERROR, Gambar Hanya .JPG .JPEG .PNG</strong></font>");
                return false;
            }
            else{
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
                $('#validasi').hide();
            }
        }); 
    });

    function imageIsLoaded(t) {
        $("#file").css("color","#FFFFFF");
        $('#image_preview').css("display", "block");
        $('#previewing').attr('src', t.target.result);
        $('#previewing').attr('width', '100%');
        $('#previewing').attr('height', 'auto');
    };
</script>



<script type="text/javascript">
	$(function(){
        $(document).on('submit','#form_pp',function(e){
            e.preventDefault();
            $('#validasi').html('');
            $('#validasi').show();

            if($('[name=nama]').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nama tidak boleh kosong</font>");
                $('[name=nama]').focus();
                return (false);
            }else if($('[name=phone]').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nomor seluler tidak boleh kosong</font>");
                $('[name=phone]').focus();
                return (false);
            }else if($('[name=email]').val()==""){
                $('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Email tidak boleh kosong</font>");
                $('[name=email]').focus();
                return (false);
            }

            $('.btn_save').prop('disabled',true);
            $('#text_btn').hide();
            $('#loading').show();

            var param = new FormData(this);
            
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('profil/save')?>",
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
                    if(result['url_foto'] != ''){
                        $('#profil_header').attr('src',result['url_foto']);
                        $('#profil_sub_header').attr('src',result['url_foto']);
                        $('#profil_mobile').attr('src',result['url_foto']);
                    }
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
            <form id="form_pp">
                <div id="form_input" class="p-b-10 card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Nama</label>
                        </div>
                        <div class="col-md-5">
                            <input name="nama" type="text" class="form-control" value="<?php if(isset($data->nama)) echo $data->nama ?>">
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-2">
                            <label>Nomor Seluler</label>                            
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="phone" class="form-control" value="<?= ((isset($data->phone))? $data->phone : "") ?>">
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-md-2">
                            <label>Email</label>                            
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="email" class="form-control" value="<?= ((isset($data->email))? $data->email : "") ?>">
                        </div>
                    </div>

                    <div class="row p-t-20">
                        <div class="col-md-2">
                            <label class="control-label">Foto Profil</label>
                        </div>
                        <div class=" col-md-5">
                            <div class="row">
                                <div id="image_preview">
                                    <?php
                                        if (empty($data->foto)){
                                            $src = base_url('images/default-user.png');
                                        }else{
                                            $src = $data->foto;
                                        }
                                    ?>
                                    <img id="previewing" src="<?= $src ?>" style="width:150px; border:1px solid black; margin-left:10px"/>
                                </div>
                                <div class="col-md-2">
                                    <div class="fileUpload btn btn-secondary">
                                        <span>Unggah Foto Profil</span>
                                        <input type="file" name="foto_profil" id="file" class="upload" />
                                    </div>
                                </div>
                            </div>
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

