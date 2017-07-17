<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<title><?php echo $title ? $title : "Authentication"; ?></title>

	<link href="<?php echo base_url('resource/themes/default/css/bootstrap.min.css') ?>" rel="stylesheet"/>
	<link href="<?php echo base_url('resource/themes/default/font-awesome/css/font-awesome.css') ?>" rel="stylesheet"/>
	 <!-- Sweet Alert -->
	<link href="<?php echo base_url('resource/themes/default/css/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet"/>

	<link href="<?php echo base_url('resource/themes/default/css/animate.css') ?>" rel="stylesheet"/>
	<link href="<?php echo base_url('resource/themes/default/css/style.css') ?>" rel="stylesheet"/>
	<script>var ginapp = {url:'<?php echo base_url() ?>'};</script>
	<script src="<?php echo base_url('resource/main.js') ?>"></script>
	<style type="text/css">
		.loginscreen.middle-box { width: 600px; }
	</style>

</head>

<body class="gray-bg">
	<div clas='test'></div>
	<div class="middle-box text-center loginscreen animated fadeInDown" style="padding-top: 5% !important;">

		<?php echo $contents ?>
	</div>
	
	<script src="<?php echo base_url('resource/themes/default/js/jquery-2.1.1.js') ?>"></script>
	<!-- Sweet alert -->
	<script src="<?php echo base_url('resource/themes/default/js/plugins/sweetalert/sweetalert.min.js') ?>"></script>
	<!-- Mainly scripts -->
	<script src="<?php echo base_url('resource/themes/default/js/bootstrap.min.js') ?>"></script>
	
	
</body>
</html>

<style>
    body {
    	background-image : url("resource/themes/default/images/depan1.jpg");
        background-image : repeat;
        background-color : #ffffff;
        background-size	 : 100% 100%;
        opacity: 0.9;        
    }

</style>
