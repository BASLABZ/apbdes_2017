<?php if($this->session->flashdata('salah')) : ?>
	<script type="text/javascript">
		winload(function() {
			swal("<?php echo $this->session->flashdata('salah'); ?>","", "warning");
		});
	</script>
<?php endif;?>
<?php echo validation_errors('<p>','</p>'); ?>

<div class="panel panel-danger">
	<div class="panel-heading">
		<img src="<?php echo base_url('resource/themes/default/images/logo.png'); ?>">
		<h2 style="color: white;">SIM APBDES KAB. MAJALENGKA</h2>
	</div>
	<div class="panel-body">

		<form class="m-t" role="form" method="post" action="">
			<div class="form-group">
				<select class="form-control" name="tahun" id="auth_pilih_tahun">
						<?php foreach($tahun_ as $row):?>
							<option value="<?php echo $row['TAHUN']; ?>"><?php echo $row['TAHUN']; ?></option>
						<?php endforeach ?>
				</select>
			</div>
			<div class="form-group">
				<input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus/>
			</div>
			<div class="form-group">
				<input type="password" name="pwd" class="form-control" placeholder="Password" required />
			</div>
			<button type="submit" class="btn btn-danger block full-width m-b">Login <span class="fa fa-sign-in"></span></button>
		</form>
	</div>
	<div class="panel-footer">
		@Copyright PT.GlobalIntermedia
	</div>
</div>
<script>winload(function() { loader('auth'); }); </script>