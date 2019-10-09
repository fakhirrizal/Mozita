<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<!-- Favicon icon -->
		<link rel="icon" type="image/png" href="<?= base_url() ?>images/fav.png">
		<title>Aplikasi Monitoring Gizi Balita</title>
		<!-- Bootstrap Core CSS -->
		<link href="<?= base_url() ?>assets/bootstrap.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="<?= base_url() ?>assets/style.css" rel="stylesheet">
		<!-- You can change the theme colors from here -->
		<link href="<?= base_url() ?>assets/colors/blue.css" id="theme" rel="stylesheet">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<style type="text/css">
			html, body, #wrapper {
				height: 100%;
			}
		</style>
	</head>

	<body onload="getLocation()">
		<!-- ============================================================== -->
		<!-- Preloader - style you can find in spinners.css -->
		<!-- ============================================================== -->
		<div class="preloader">
			<svg class="circular" viewBox="25 25 50 50">
				<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
		</div>
		<!-- ============================================================== -->
		<!-- Main wrapper - style you can find in pages.scss -->
		<!-- ============================================================== -->
		<section id="wrapper">
			<div class="login-register" style="background-image:url(<?= base_url() ?>images/bg-login-mozita.jpg);">
				<div class="login-box">
					<center>
						<h1><b>MOZITA</b></h1>
						<h4>Aplikasi Monitoring Gizi Balita</h4>
					</center>
					<div class="card-body" style="background-color: transparent;">
						<?php echo form_open("login/cek_login"); ?>
							<p id="getLocation"></p>
							<div class="form-group ">
								<div class="col-xs-12">
									<input type="text" name="username" class="form-control btn-rounded" placeholder="Email / Nomor Seluler" required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<input type="password" name="password" class="form-control btn-rounded" placeholder="Kata Sandi" required>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12 font-14">
									<button type="submit" class="btn btn-info waves-effect waves-light btn-rounded text-uppercase btn-block" style="padding-left: 30px; padding-right: 30px;">
										MASUK
									</button>
								</div>
							</div>
							<div class="text-center">
								<small><?= ((isset($validasi))? $validasi : "") ?></small>
							</div>
							<div class="text-center m-t-20">
								<center  style="font-size: 12px;">
									Copyright 2018 © Aplikasi Monitoring Gizi Balita
								</center>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<!-- ============================================================== -->
		<!-- End Wrapper -->
		<!-- ============================================================== -->
		<!-- ============================================================== -->
		<!-- All Jquery -->
		<!-- ============================================================== -->
		<script>
			var view = document.getElementById("getLocation");
			function getLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showPosition);
				} else {
					view.innerHTML = "";
				}
			}
			function showPosition(position) {
				view.innerHTML = "<input type='hidden' name='location' value='" + position.coords.latitude + ", " + position.coords.longitude +"' />";
			}
		</script>
		<script src="<?= base_url() ?>assets/jquery.min.js"></script>
		<!-- Bootstrap tether Core JavaScript -->
		<script src="<?= base_url() ?>assets/popper.min.js"></script>
		<script src="<?= base_url() ?>assets/bootstrap.min.js"></script>
		<!-- slimscrollbar scrollbar JavaScript -->
		<script src="<?= base_url() ?>assets/jquery.slimscroll.js"></script>
		<!--Wave Effects -->
		<script src="<?= base_url() ?>assets/waves.js"></script>
		<!--Menu sidebar -->
		<script src="<?= base_url() ?>assets/sidebarmenu.js"></script>
		<!--stickey kit -->
		<script src="<?= base_url() ?>assets/sticky-kit.min.js"></script>
		<script src="<?= base_url() ?>assets/jquery.sparkline.min.js"></script>
		<!--Custom JavaScript -->
		<script src="<?= base_url() ?>assets/custom.min.js"></script>
		<!-- ============================================================== -->
		<!-- Style switcher -->
		<!-- ============================================================== -->
		<script src="<?= base_url() ?>assets/jQuery.style.switcher.js"></script>
	</body>

</html>