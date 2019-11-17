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
			$(".btn_save").prop("type", "button");
			$(".btn_save").removeClass("btn_save").addClass("btn_edit btn btn-warning");
			$("#text_btn").append('<i class="fa fa-edit"></i> ');
			$("#text_btn").append('UBAH');

			$("#form_input input[type=text]").prop("disabled",true);
			$('input[name="jenkel"]').attr('disabled', true);
			$('input[name="gakin"]').attr('disabled', true);
			$('input[name="kms"]').attr('disabled', true);
			$('#kabupaten').select2().prop("disabled",true);
			$('#kecamatan').select2().prop("disabled",true);
			$('#desa').select2().prop("disabled",true);
			$('#posyandu').select2().prop("disabled",true);
			$('.fileUpload').hide();
			$('input[name="aktif"]').attr('disabled', true);
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

		$(document).on('change','#kabupaten', function(){
			var id = $("#kabupaten").val();
			$.post("<?= site_url('balita/combobox/kecamatan/') ?>"+id,{id_kab:id}, function(result){
				$("#kecamatan").html(result);
				$('.select2').select2();
			});
		});

		$(document).on('change','#kecamatan', function(){
			var id = $("#kecamatan").val();
			$.post("<?= site_url('balita/combobox/desa/') ?>"+id,{id_kecamatan:id}, function(result){
				$("#desa").html(result);
				$('.select2').select2();
			});
		});

		$(document).on('change','#desa', function(){
			var id = $("#desa").val();
			$.post("<?= site_url('balita/combobox/posyandu/') ?>"+id,{id_desa:id}, function(result){
				$("#posyandu").html(result);
				$('.select2').select2();
			});
		});

		$(document).on('click','#btn_new_input', function(){
			$("#form_input input[type=text]").val('');
			$('input[name="jenkel"]').prop('checked', false);
			$('input[name="gakin"]').prop('checked', false);
			$('input[name="kms"]').prop('checked', false);
			$("#alamat").val("");
			$('#kabupaten').select2("val","0");
			$('#kecamatan').select2("val","0");
			$('#desa').select2("val","0");
			$('input[name="aktif"]').prop('checked', false);
			$('.btn_save').show();
			$('#btn_new_input').hide();
			$('#validasi').hide();
			$('#previewing').prop('src', '<?= base_url()."images/default-user.png" ?>');
		});

		$(document).on('click','.btn_edit', function(e){
			e.preventDefault();
			$("#btn_cancel").show();
			$(".btn_hapus").hide();

			$(".btn_edit").removeClass("btn_edit btn btn-warning").addClass("btn_save btn btn-info");
			$("#text_btn").text("");
			$("#text_btn").append('<i class="fa fa-save"></i> ');
			$("#text_btn").append('SIMPAN');
			$(".btn_save").prop("type", "submit");

			$("#form_input input[type=text]").prop("disabled",false);
			$('input[name="jenkel"]').attr('disabled', false);
			$('input[name="gakin"]').attr('disabled', false);
			$('input[name="kms"]').prop('disabled', false);
			$('#kabupaten').select2().prop("disabled",false);
			$('#kecamatan').select2().prop("disabled",false);
			$('#desa').select2().prop("disabled",false);
			$('input[name="aktif"]').prop('disabled', false);
			$('#posyandu').select2().prop("disabled",false);
			$('.fileUpload').show();
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
		$(document).on('submit','#form_balita',function(e){
			e.preventDefault();
			$('#validasi').html('');
			$('#validasi').show();
			var jenis_form = $('#jenis_form').val();
			var level = $('#level').val();

			if($('[name=nama_balita]').val()==""){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nama Balita Belum Diisi</font>");
				$('[name=nama_balita]').focus();
				return (false);
			}else if($('[name=tgl_lahir]').val()==""){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Tanggal Lahir Belum Diisi</font>");
				$('[name=tgl_lahir]').focus();
				return (false);
			}else if(!$('[name=jenkel]').is(':checked')){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Jenis Kelamin Belum Diisi</font>");
				$('[name=jenkel]').focus();
				return (false);
			}else if($('[name=nama_ortu]').val()==""){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Nama Orang Tua Belum Diisi</font>");
				$('[name=nama_ortu]').focus();
				return (false);
			}else if($('[name=nik_ortu]').val()==""){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> NIK Orang Tua Belum Diisi</font>");
				$('[name=nik_ortu]').focus();
				return (false);
			}else if(!$('[name=gakin]').is(':checked')){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Keluarga Miskin Tua Belum Diisi</font>");
				$('[name=gakin]').focus();
				return (false);
			}else if(!$('[name=kms]').is(':checked')){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> KMS Tua Belum Diisi</font>");
				$('[name=kms]').focus();
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
			}else if($('#posyandu').val() == "0"){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Posyandu Belum Diisi</font>");
				$('#posyandu').focus();
				return (false);
			}else if(!$('[name=aktif]').is(':checked')){
				$('#validasi').html("<font style='color:red'><i class='fa fa-exclamation-triangle'></i> Aktif Belum Diisi</font>");
				$('[name=aktif]').focus();
				return (false);
			}

			$('.btn_save').prop('disabled',true);
			$('#text_btn').hide();
			$('#loading').show();

			var param = new FormData(this);

			$.ajax({
				type: 'POST',
				url: "<?php echo site_url('balita/save/')?>"+$(this).attr('id'),
				data: param,
				contentType: false,
				cache: false,
				processData:false,
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
							$(".btn_save").prop("type", "button");
							$(".btn_save").removeClass("btn_save btn btn-info").addClass("btn_edit btn btn-warning");
							$("#text_btn").text("");
							$("#text_btn").append('<i class="fa fa-save"></i> ');
							$("#text_btn").append('UBAH');

							$("#form_input input[type=text]").prop("disabled",true);
							$('input[name="jenkel"]').attr('disabled', true);
							$('input[name="gakin"]').attr('disabled', true);
							$('input[name="kms"]').attr('disabled', true);
							$('#kabupaten').select2().prop("disabled",true);
							$('#kecamatan').select2().prop("disabled",true);
							$('#desa').select2().prop("disabled",true);
							$('#posyandu').select2().prop("disabled",true);
							$('.fileUpload').hide();
							$('input[name="aktif"]').attr('disabled', true);
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
				url: "<?php echo site_url('balita/delete/') ?>"+$(this).attr('id'),
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

<?php
$lat = '';
$lng = '';
if(isset($data->lat)){
	$lat = $data->lat;
}else{
	$lat = '-6.982859';
}
if(isset($data->lng)){
	$lng = $data->lng;
}else{
	$lng = '110.409475';
}
?>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<form id="form_balita">
				<div id="form_input" class="p-b-10 card-body">
					<input name="norm" type="hidden" value="<?php if(isset($data->norm)) echo $data->norm ?>">
					<div class="row">
						<div class="col-md-2">
							<label>Nama Balita *</label>
						</div>
						<div class="col-md-5">
							<input name="nama_balita" type="text" class="form-control" value="<?php if(isset($data->nama)) echo $data->nama ?>">
						</div>
					</div>

					<div class="row m-t-20">
						<div class="col-md-2">
							<label>Tanggal Lahir *</label>
						</div>
						<div class="col-md-5">
						<input type="text" name="tgl_lahir" class="datepicker form-control" placeholder="dd-mm-yyyy" value="<?= ((isset($data->tgllahir))? date_format(date_create($data->tgllahir),"d-m-Y") : "") ?>">
						</div>
					</div>

					<div class="row m-t-20">
						<div class="col-md-2">
							<label>Jenis Kelamin *</label>
						</div>
						<div class="col-md-5">
							<label class="custom-control custom-radio">
								<input name="jenkel" type="radio" class="custom-control-input" value="Laki-laki" <?= ((isset($data->jenkel) && $data->jenkel == 'Laki-laki')?"checked":"") ?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Laki - laki</span>
							</label>
							<label class="custom-control custom-radio">
								<input name="jenkel" type="radio" class="custom-control-input" value="Perempuan" <?= ((isset($data->jenkel) && $data->jenkel == 'Perempuan')?"checked":"") ?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Perempuan</span>
							</label>
						</div>
					</div>

					<div class="row m-t-20">
						<div class="col-md-2">
							<label>Nama Orang tua *</label>
						</div>
						<div class="col-md-5">
							<input name="nama_ortu" type="text" class="form-control" value="<?php if(isset($data->nmortu)) echo $data->nmortu ?>">
						</div>
					</div>

					<div class="row m-t-20">
						<div class="col-md-2">
							<label>NIK Orang tua *</label>
						</div>
						<div class="col-md-5">
							<input name="nik_ortu" type="text" class="form-control" value="<?php if(isset($data->nikortu)) echo $data->nikortu ?>">
						</div>
					</div>

					<div class="row m-t-20">
						<div class="col-md-2">
							<label>Nomor WA Orang tua *</label>
						</div>
						<div class="col-md-5">
							<input name="wa_ortu" type="text" class="form-control" value="<?php if(isset($data->wa_ortu)) echo $data->wa_ortu ?>">
						</div>
					</div>

					<div class="row m-t-20">
						<div class="col-md-2">
							<label>Keluarga Miskin *</label>
						</div>
						<div class="col-md-5">
							<label class="custom-control custom-radio">
								<input name="gakin" type="radio" class="custom-control-input" value="Ya" <?= ((isset($data->gakin) && $data->gakin == 'Ya')?"checked":"") ?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Ya</span>
							</label>
							<label class="custom-control custom-radio">
								<input name="gakin" type="radio" class="custom-control-input" value="Tidak" <?= ((isset($data->gakin) && $data->gakin == 'Tidak')?"checked":"") ?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Tidak</span>
							</label>
						</div>
					</div>

					<div class="row m-t-20">
						<div class="col-md-2">
							<label>Memiliki KMS *</label>
						</div>
						<div class="col-md-5">
							<label class="custom-control custom-radio">
								<input name="kms" type="radio" class="custom-control-input" value="Ya" <?= ((isset($data->kms) && $data->kms == 'Ya')?"checked":"") ?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Ya</span>
							</label>
							<label class="custom-control custom-radio">
								<input name="kms" type="radio" class="custom-control-input" value="Tidak" <?= ((isset($data->kms) && $data->kms == 'Tidak')?"checked":"") ?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Tidak</span>
							</label>
						</div>
					</div>

					<?php
						if($_SESSION['level'] != 2){
					?>
							<div class="row m-t-20">
								<div class="col-md-2">
									<label>Propinsi *</label>
								</div>
								<div class="col-md-5">
									<select id="propinsi" class="select2 form-control" style="width:100%" disabled>
										<option><?= $propinsi ?></option>
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
											if(isset($data->id_kab)){
												$idkab = $data->id_kab;
											}else{
												$idkab = "";
											}
												foreach($data_kab as $rows_kab){
													echo '<option value="'.$rows_kab->id.'" '.(($idkab == $rows_kab->id)?"selected":"").'>'.$rows_kab->name.'</option>';
											}
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

							<div class="row m-t-20">
								<div class="col-md-2">
									<label>Desa *</label>
								</div>
								<div class="col-md-5">
									<select id="desa" class="select2 form-control" style="width:100%">
										<option value="0">Pilih</option>
										<?php
											if(isset($data->id_desa)){
												foreach($data_desa as $rows_desa){
													echo '<option value="'.$rows_desa->id.'" '.(($data->id_desa == $rows_desa->id)?"selected":"").'>'.$rows_desa->name.'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>

							<div class="row m-t-20">
								<div class="col-md-2">
									<label>Posyandu *</label>
								</div>
								<div class="col-md-5">
									<select id="posyandu" name="posyandu" class="select2 form-control" style="width:100%">
										<option value="0">Pilih</option>
										<?php
											if(isset($data->idpos)){
												foreach($data_posyandu as $rows_pos){
													echo '<option value="'.$rows_pos->idpos.'" '.(($data->idpos == $rows_pos->idpos)?"selected":"").'>'.$rows_pos->namapos.'</option>';
												}
											}
										?>
									</select>
								</div>
							</div>
					<?php   } ?>
					<div class="row m-t-20">
						<div class="col-md-2">
							<label>Marker *</label>
						</div>
						<div class="col-md-10">
							<div id="map"></div>
						</div>
					</div>
					<div class="row m-t-20">
						<div class="col-md-2">
							<label></label>
						</div>
						<div class="col-md-2">
							<label>Garis lintang</label>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" name='lat' id='latitude' value="<?php if(isset($data->lat)) echo $data->lat ?>" required >
						</div>
						<div class="col-md-2">
							<label>Garis bujur</label>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" name='lng' id='longitude' value="<?php if(isset($data->lng)) echo $data->lng ?>" required >
						</div>
					</div>
					<div class="row p-t-20">
						<div class="col-md-2">
							<label class="control-label">Foto Balita</label>
						</div>
						<div class=" col-md-5">
							<div class="row">
								<div id="image_preview">
									<?php
										if (empty($data->fotobayi)){
											$src = base_url('images/default-user.png');
										}else{
											$src = $data->fotobayi;
										}
									?>
									<img id="previewing" src="<?= $src ?>" style="width:150px; border:1px solid black; margin-left:10px"/>
								</div>
								<div class="col-md-2">
									<div class="fileUpload btn btn-secondary">
										<span>Unggah Foto Balita</span>
										<input type="file" name="foto_balita" id="file" class="upload" />
										<input type="hidden" name="foto_lama" value="<?= ((isset($data->fotobayi))?$data->fotobayi:"") ?>">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row m-t-20">
						<div class="col-md-2">
							<label>Aktif *</label>
						</div>
						<div class="col-md-5">
							<label class="custom-control custom-radio">
								<input name="aktif" type="radio" class="custom-control-input" value="Ya" <?= ((isset($data->aktif) && $data->aktif == 'Ya')?"checked":"") ?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Ya</span>
							</label>
							<label class="custom-control custom-radio">
								<input name="aktif" type="radio" class="custom-control-input" value="Tidak" <?= ((isset($data->aktif) && $data->aktif == 'Tidak')?"checked":"") ?>>
								<span class="custom-control-indicator"></span>
								<span class="custom-control-description">Tidak</span>
							</label>
						</div>
					</div>

				</div><!-- ./ card-body -->

				<div class="card-footer">
					<div class="row">
						<div id="col_validasi" class="col-md-4 text-left">
							<div id="validasi"></div>
						</div>
						<div id="col_btn" class="col-md-3 text-right">
							<button id="btn_cancel" class="btn btn btn-secondary" style="display:none"><i class="fa fa-chevron-left"></i> BATAL</button>
							<button type="button" id="btn_new_input" class="btn btn btn-secondary" style="display:none"><i class="fa fa-plus-square"></i> TAMBAH BARU</button>
							<button class="btn_hapus btn btn-danger"><i class="fa fa-trash"></i> HAPUS</button>
							<button type="submit" id="<?php if(isset($data->norm)) echo md5($data->norm) ?>" class="btn_save ">
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
			</form>
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
							<a href="<?= site_url('data-balita') ?>">
								<button id="btn_ok" class="btn btn-secondary" style="display:none"style="display:none">OK</button>
							</a>
							<button id="btn_cancel_hapus" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
							<button id="<?php if(isset($data->norm)) echo md5($data->norm) ?>" class="btn_konfrim_hapus btn btn-danger">
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
<style type="text/css">
	#map {
		height: 300px;
	}
</style>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize&key=AIzaSyCnjlDXASsyIUKAd1QANakIHIM8jjWWyNU"></script>

<script type="text/javascript">
	function updateMarkerPosition(latLng) {
		document.getElementById('latitude').value = [latLng.lat()]
		document.getElementById('longitude').value = [latLng.lng()]
	}

	var map = new google.maps.Map(document.getElementById('map'), {
	zoom: 15,
	center: new google.maps.LatLng(<?= $lat.','.$lng ?>),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	var latLng = new google.maps.LatLng(<?= $lat.','.$lng ?>);

	var marker = new google.maps.Marker({
		position : latLng,
		title : 'lokasi',
		map : map,
		draggable : true
	});

	updateMarkerPosition(latLng);
	google.maps.event.addListener(marker, 'drag', function() {
		updateMarkerPosition(marker.getPosition());
	});
</script>

<script>
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