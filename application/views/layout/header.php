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
    <title>Aplikasi Monitoring Gizi Balita - <?=$judul?></title>

    <!-- Select2 -->
    <link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css')?>" rel="stylesheet">
    
    <!-- Datatables -->
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables/dataTables.bootstrap.min.css">

     <!-- Date picker plugins css -->
     <link href="<?= base_url() ?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <!-- <link href="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"> -->
    <link href="<?= base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>assets/bootstrap.css" rel="stylesheet">
    <!-- Toast-master -->
    <link href="<?= base_url() ?>assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="<?= base_url() ?>assets/morris.css" rel="stylesheet">
    <!-- Popup CSS -->
    <link href="<?= base_url() ?>assets/magnific-popup.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="<?= base_url() ?>assets/sweetalert.css" rel="stylesheet" type="text/css">

    <!-- CSS File Upload -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/dropify.css">

    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?= base_url() ?>assets/css/colors/megna.css" id="theme" rel="stylesheet">

    <style>
        .spinner {
            /* margin: 100px auto; */
            width: 50px;
            height: 20px;
            text-align: center;
            font-size: 10px;
            opacity: 0.8;
                filter: alpha(opacity=20); 
        }

        .spinner > div {
            background-color: #fff;
            height: 100%;
            width: 6px;
            display: inline-block;
            
            -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
            animation: sk-stretchdelay 1.2s infinite ease-in-out;
        }

        .spinner .rect2 {
            -webkit-animation-delay: -1.1s;
            animation-delay: -1.1s;
        }

        .spinner .rect3 {
            -webkit-animation-delay: -1.0s;
            animation-delay: -1.0s;
        }

        .spinner .rect4 {
            -webkit-animation-delay: -0.9s;
            animation-delay: -0.9s;
        }

        .spinner .rect5 {
            -webkit-animation-delay: -0.8s;
            animation-delay: -0.8s;
        }

        @-webkit-keyframes sk-stretchdelay {
            0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
            20% { -webkit-transform: scaleY(1.0) }
        }

        @keyframes sk-stretchdelay {
            0%, 40%, 100% { 
                transform: scaleY(0.4);
                -webkit-transform: scaleY(0.4);
            }  20% { 
                transform: scaleY(1.0);
                -webkit-transform: scaleY(1.0);
            }
        }
    </style>

    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url() ?>assets/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
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
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                    
                    <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            
                            <a class="nav-link" style="font-size:20px; font-weight:bold;">
                                Monitoring Gizi Balita
                            </a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->

                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0 hidden-sm-down">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        
                        <!-- <li class="nav-item" style="padding-top: 7px;">
                            <a class="nav-link" href="javascript:void(0)">
                                <img src="<?= base_url() ?>image/users/1.jpg" alt="user" class="profile-pic" style="float: right;" />
                                <div style="float: right;padding-top: 15px;padding-right: 10px;">
                                    <div style="line-height: 0px;text-align: right;">
                                        Admin
                                    </div>
                                </div>
                            </a>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown" style="padding-top: 7px;">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img id="profil_header" src="<?= $_SESSION['foto'] ?>" class="profile-pic" style="float: right; padding-top: 7px;" />
                                <!-- <i class="mdi mdi-settings"></i> -->
                                <div style="float: right;padding-top: 15px;padding-right: 10px;">
                                    <div style="line-height: 0px;text-align: right; color: #fff;">
                                        <?= $_SESSION['nama'] ?>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img id="profil_sub_header" src="<?= $_SESSION['foto'] ?>"></div>
                                            <div class="u-text">
                                                <h4><?= $_SESSION['nama'] ?></h4>
                                                <p class="text-muted"><?= $_SESSION['email'] ?></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?= site_url('profil') ?>"><i class="ti-user"></i> Lihat Profil</a></li>
                                    <li><a href="<?= site_url('ganti-kata-sandi') ?>"><i class="ti-key"></i> Ganti Password</a></li>
                                    <li><a href="<?= site_url() ?>/logout"><i class="fa fa-power-off"></i> Keluar</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile hidden-md-up">
                    <!-- User profile image -->
                    <div class="profile-img"> <img id="profil_mobile" src="<?= $_SESSION['foto'] ?>" alt="user" />
                    </div>
                    <!-- User profile text-->
                    <div class="profile-text">
                        <h5>
                            <b>ADMIN</b>
                        </h5>
                        <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
                        <!-- <a href="app-email.html" class="" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a> -->
                        <a href="<?= site_url() ?>/logout" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                        <div class="dropdown-menu animated flipInY">
                            <!-- text-->
                            <a href="<?= site_url('profil') ?>" class="dropdown-item"><i class="ti-user"></i> Lihat Profil</a>
                            <a href="<?= site_url('ganti-kata-sandi') ?>" class="dropdown-item"><i class="ti-key"></i> Ganti Password</a>
                        </div>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider hidden-md-up"></li>
                        <?php
                            if($_SESSION['level'] == 1){
                                $this->load->view('menu/level_1');
                            }else if($_SESSION['level'] == 2){
                                $this->load->view('menu/level_2');
                            }else if($_SESSION['level'] == 3){
                                $this->load->view('menu/level_3');
                            }else if($_SESSION['level'] == 4){
                                $this->load->view('menu/level_4');
                            }else if($_SESSION['level'] == 5){
                                $this->load->view('menu/level_5');
                            }
                        ?>
                                           
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><?=$judul?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?=$menu?></a></li>
                        <li class="breadcrumb-item active" style="color:#59955C"><?=$sub_menu?></li>
                    </ol>
                </div>
                <!-- <div>
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div> -->
            </div>
            
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">