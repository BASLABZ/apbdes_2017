<!DOCTYPE html><html><head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php echo app::get('web_title') ?></title>
        <link href="<?php echo base_url('resource/themes/default/css/bootstrap.min.css') ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/font-awesome/css/font-awesome.css') ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/css/plugins/dataTables/datatables.min.css') ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/css/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/css/animate.css') ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/css/style.css') ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/css/plugins/select2/select2.min.css') ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/css/plugins/datapicker/datepicker3.css') ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/css/plugins/footable/footable.core.css') ?>" rel="stylesheet"/>
        <link href="<?php echo base_url('resource/themes/default/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') ?>" rel="stylesheet"/>
        <!-- custom -->
        <style type="text/css">
            .wrapper-content {
                padding: 10px 5px 10px;
            }
            .ibox {
                clear: both;
                margin-bottom: 10px;
                margin-top: 0;
                padding: 0;
            }
            .page-heading {
                border-top: 0;
                padding: 0 5px 5px 0px;
            }
            .navbar-default .nav > li > a:hover, .navbar-default .nav > li > a:focus {
                    background-color: #20b2b3;
                    color: white;}
            .highlight-bas {
                                    -webkit-box-shadow: 0 8px 31px 0 rgba(0,0,0,.1);
                                    -moz-box-shadow: 0 8px 31px 0 rgba(0,0,0,.1);
                                    -ms-box-shadow: 0 8px 31px 0 rgba(0,0,0,.1);
                                    -o-box-shadow: 0 8px 31px 0 rgba(0,0,0,.1);
                                    box-shadow: 0 8px 31px 0 rgba(0,0,0,.1);}
            .nav > li.active{   border-left: 4px solid #d8e03f; }
            .ibox-title {
                            background-color: #1ab394;
                            color: white !important;}
            .dim { box-shadow: inset 0 0 0 #16987e, 0 5px 0 0 #16987e, 0 10px 5px #999999;}</style>
        <link href="<?php echo base_url('resource/main.css') ?>" rel="stylesheet"/>
        <script>
                    var base_url = '<?php echo base_url() ?>',
                    // url_segment = ["<?php echo implode('","', $this->uri->segment_array()) ?>"],
                    url_segment = <?php echo json_encode($this->uri->segment_array()) ?>,
                    // url_segment = <?php echo json_encode(array_values($this->uri->segment_array())) ?>,
                    ginapp = {url: '<?php echo base_url() ?>'}; //deprecated
        </script>
        <script src="<?php echo base_url('resource/main.js') ?>"></script>
    </head>
    <!-- <body class="md-skin fixed-navbar" landing-scrollspy id="page-top"> -->
    <body class="pace-done fixed-navbar" landing-scrollspy id="page-top" style="background-color: #ee6e73; ">
        <div id="wrapper" style="">
            <nav class="navbar-default navbar-static-side" role="navigation" style="">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element" >
                                <span>
                                    <img alt="image" class="img-circle" src="<?php echo base_url('resource/themes/default/images/pengguna.png') ?>">
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear">
                                        <span class="block m-t-xs">Selamat Datang, <strong class="font-bold"><?php echo $this->session->username ?></strong>
                                        </span>
                                        <span class="text-muted text-xs block" style="color: white;"><?php echo $this->session->hakakses ?>
                                            <b class="caret"></b>
                                        </span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs" style="background-color: #ee6e73;">
                                    <li><a href="<?php echo base_url('setting/user/editPass') ?>/<?php echo $this->session->kd_user ?>" style="background-color: #f8ac59; color: white;"><span class="fa fa-key"></span> Ubah Password</a></li>	                            
                                    <li class="divider"></li>
                                    <li><a href="" class="logout" style="background-color:#ee6e73;">  Logout
                                    <span class="fa fa-sign-out"></span></a></li>
                                </ul>
                                </div>
                                <!-- <a href="javascript:void(0);" style="font-size:18px;font-weight:600;">Sistem Informasi Keuangan Desa Kabupaten Nabire</a> -->
                            
                            <div class="logo-element">SIKDes</div>
                        </li>
                        <li><a href="<?php echo base_url('home') ?>"><i class="fa fa-home"></i> <span class="nav-label">Beranda</span></a></li>
                        <li>
                            <a href="#"><i class="fa fa-cog"></i><span class="nav-label">Pengaturan</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <?php if ($this->session->hakakses == 'ADMIN'): ?>	
                                    <li><a href="<?php echo base_url('setting/user') ?>"><i class="fa fa-user"></i> Pengguna</a></li>							 
                                    <li><a href="<?php echo base_url('setting/jabatan') ?>"><i class="fa fa-user"></i> Master Jabatan</a></li>
                                <?php endif ?>	
                                <li><a href="<?php echo base_url('setting/pejabat_pengesah') ?>"><i class="fa fa-users"></i>Pejabat Pengesah</a></li>
                                <li><a href="<?php echo base_url('daskum') ?>"><i class="fa fa-book"></i>Dasar Hukum</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url('spp') ?>"><i class="fa fa-edit"></i> <span class="nav-label">SPP</span></a></li>
                        <li>
                            <a href="#"><i class="fa fa-check-square-o"></i> <span class="nav-label">Verifikasi</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                                <li><a href="<?php echo base_url('verifikasi/persetujuan') ?>"><i class="fa fa-file-text"></i> Persetujuan</a></li>
                                <!--
                                <li><a href="<?php //echo base_url('verifikasi/pengesahan') ?>"><i class="fa fa-pencil-square-o"></i> Pengesahan</a></li>
                                -->
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url('bku/buku_kas_umum') ?>"><i class="fa fa-files-o"></i> <span class="nav-label">Buku Kas Umum</span></a></li>
                        <!--
                        <li><a href="<?php echo base_url('buku_jurnal/buku_jurnal') ?>"><i class="fa fa-files-o"></i> <span class="nav-label">BUKU JURNAL</span></a></li>
                        -->
                        <li><a href="<?php echo base_url('laporan/laporan_bku') ?>"><i class="fa fa-files-o"></i> <span class="nav-label">Laporan</span></a></li>
                    </ul>
                </div>
            </nav>
            <div id="page-wrapper" class="gray-bg" style="min-height: 768px;">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top highlight-bas" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="javascript:void(0)" onclick="toggle_collapse_menu()" style="background-color: #ee6e73; border-color: #FFFFFF; color: #FFFFFF;"><i class="fa fa-bars"></i></a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li ><a href="" class="logout" style="color: white;"><i class="fa fa-sign-out" style="color: white;"></i> Keluar</a></li>
                        </ul>
                    </nav>
                </div>
