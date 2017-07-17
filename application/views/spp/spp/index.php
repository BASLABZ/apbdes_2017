<?php if (isset($content_script)): ?>
	<?php echo $content_script ?>
<?php endif ?>

<div class="ibox"> 
	<?php if (isset($content_title)): ?>
		<div class="ibox-title" style="background-color:#ee6e73;color:white !important;">
			<h5><span class="fa fa-pencil"></span> <?php echo $content_title ?></h5>
			
		</div>
	<?php endif ?>

	<?php if (isset($content_body)): ?>
		<div class="ibox-content highlight-bas">
			<?php echo $content_body ?>
		</div>
	<?php endif ?>
</div>
