<script>
var $form,
	$form_active_tab,
	$form_active_link,
	$form_nav_tab,
	$form_nav_link;

winload(function() {
	$form = $('#form');
	$form_nav_tab = $form.children('.tab-content').children('fieldset');
	$form.children('.nav-tabs:first').each(function() {
		$form_nav_link = $(this).find('a').each(function() {
			$(this).on('click', function(ev) {
				ev.preventDefault();
				$(this).tab('show');
			});
		});
	});
});

winload(function() {
	$form_nav_link.on('shown.bs.tab', function (ev) {
		// console.log(ev.relatedTarget)
		$form_active_link = $(ev.target);
		$form_active_tab = $(ev.target.hash);
	});
});

winload(function() {
	$form_nav_link.get(0).click(); // bukak tab
});

var sppinfo;
winload(function() {
	sppinfo = new Vue({
		el: '#spp_aan_info',
		data: {
			spp: null,
			kegiatan: null,
			nospp:''
		}
	});
	sppinfo.$el.style.display = '';
});

</script>

<?php /* template input pajak */ ?>
<template  id="spp_tpl_pjk" hidden>
	<div class="row">
		<input name="JENISPOTONGAN_POT[]" type="hidden" class="jenispot" /><?php /* singkatan */ ?>
		<input name="REKENINGPOTONGAN_POT[]" type="hidden" class="rekpot" /><?php /* kode-join nggo titik */ ?>
		<div class="col-md-7">
			<div class="form-group">
				<label>Aturan:</label>
				<p class="form-control-static"></p>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group">
				<label>Jumlah:</label>
				<div class="input-group">
					<input name="JUMLAH_POT[]" type="number" min="0" step="0.01" class="form-control" required/>
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">&times;</button>
					</span>
				</div>
			</div>
		</div>
	</div>
</template>

<div class="row">
	<div class="col-md-10">

		<style scoped> #spp_aan_info, #spp_aan_info tr, #spp_aan_info td { border: none; } </style>
		<table class="table table-condensed mg-0 h5" id="spp_aan_info" style="display:none;">
			<tr class="t-spp" v-show="spp !== null">
				<td>Kecamatan/Desa</td>
				<td>:</td>
				<td><b v-text="spp"></b></td>
			</tr>
			<tr class="t-keg" v-show="kegiatan !== null">
				<td>Kegiatan</td>
				<td>:</td>
				<td><b v-text="kegiatan"></b></td>
			</tr>
			<tr class="t-nospp" v-show="nospp.length > 0">
				<td>No. SPP</td>
				<td>:</td>
				<td><b v-text="nospp"></b></td>
			</tr>
		</table>
	</div>
	<div class="col-md-2 text-right">
		 <?php
		 	   $currentPath = $_SERVER['PHP_SELF']; 
		 	   $strpath = substr($currentPath, 36);
		  ?>
		<a href="<?php echo base_url('spp3/index') ?><?php echo $strpath; ?>" class="btn btn-info btn-xs bd-rad-0"><span class="glyphicon glyphicon-th-list"></span> Daftar </a>
		
	</div>
</div>

<div class="hr-line-dashed"></div>

<form id="form" method="post">
	<?php $this->load->view('base/select-2') ?>
	<ul class="nav nav-tabs" role="tablist" style="visibility:hidden;height:0px !important;overflow:hidden;">
		<li role="presentation"><a href="#spp_tab1">Informasi SPP</a></li>
		<li role="presentation"><a href="#spp_tab2">Rincian SPP</a></li>
	</ul>

	<div class="tab-content">
		<fieldset role="tabpanel" class="tab-pane" id="spp_tab1"><?php $this->load->view('spp/spp/tambah/form1', array('perusahaan' => $perusahaan)) ?></fieldset>
		<fieldset role="tabpanel" class="tab-pane" id="spp_tab2"><?php $this->load->view('spp/spp/tambah/form2') ?></fieldset>
	</div>

</form>
