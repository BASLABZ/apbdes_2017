<?php  $this->load->view('base/header'); ?>
<?php $web_breadcrumb = app::get('web_breadcrumb'); ?>
<?php  if (count($web_breadcrumb)>1) {  ?>

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?php echo app::get('web_heading') ?></h2>

		<?php if (count($web_breadcrumb) > 0): ?>
		<ol class="breadcrumb">
			<?php foreach ($web_breadcrumb as $v): ?>
			<li><a href="<?php echo empty($v[1]) ? current_url() : base_url($v[1]) ?>"><?php echo $v[0]; ?></a></li>
			<?php endforeach ?>
		</ol>
		<?php endif ?>

	</div>
</div>
<?php  } ?>
<div class="wrapper wrapper-content animated fadeInRight">
	<?php echo $contents ?>
</div>

<?php  $this->load->view('base/footer'); ?>