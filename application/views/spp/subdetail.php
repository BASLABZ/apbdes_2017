<?php
$kode_org = array(
	$data_spp['KODEURUSAN'],
	$data_spp['KODESUBURUSAN'],
	$data_spp['KODEORGANISASI'],
	$data_spp['KODEDESA']
);

// debug($kode_org);
?>
<div class="panel bd-rad-0">
	<div class="panel-body">

<div class="row">
	<div class="col-sm-6">
		<h4><?php echo app::strkode($kode_org), ' - ', $data_spp['URAI_DESA'] ?></h4>

		<h3 class="mg-0"><?php echo $data_spp['URAI_PROG'] ?></h3>
	</div>
	<div class="col-sm-6 text-right">
		<a href="<?php echo base_url('spp/daftar') ?>" class="btn btn-success bd-rad-0">Daftar</a>
	</div>
</div>

<hr/>

<form class="form-horizontal" id="spp_rincian_form">
	<?php foreach ($data_spp as $k => $v): ?>
		<input type="hidden" name="<?php echo $k ?>" value="<?php echo $v ?>"/>
	<?php endforeach ?>

	<div class="form-group">
		<label class="col-sm-2 control-label">A</label>
		<div class="col-sm-10">
			<select name="asd" id="spp_inp_rek" class="form-control" required>
				<option value="0">-- Pilih Anggaran --</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">angg_belanja:jumlah</label>
		<div class="col-sm-10">
			<div class="input-group">
				<span class="input-group-addon" style="font-weight:600;">Rp. 0,00</span>
				<input type="number" min="0" step="0.10" id="spp_uang_a" class="form-control" required/>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">+ spp:jumlah_spp</label>
		<div class="col-sm-10">
			<div class="input-group">
				<span class="input-group-addon" style="font-weight:600;">Rp. 0,00</span>
				<input type="number" min="0" step="0.10" id="spp_uang_b" class="form-control" required/>
			</div>
		</div>
	</div>

	<button type="submit" class="btn btn-default">Sign in</button>

</form>
<br/>

<table class="table table-bordered">
	<?php foreach ($data_spprincian['data'] as $rinci): ?>
		<tr>
			<?php foreach ($rinci as $v): ?>
				<td><?php echo $v ?></td>
			<?php endforeach ?>
		</tr>
	<?php endforeach ?>
	<?php if (count($data_spprincian['data']) < 1): ?>
		<tr>
			<td>Data kosong</td>
		</tr>
	<?php endif ?>
</table>

	</div>
</div>

<h1 class="mg-0">data SPP:</h1>
<pre id="spp_obj"></pre>

<h1 class="mg-0">data angg_rekening:</h1>
<pre id="anggrek_obj"></pre>

<script>
(function(w) {
	w.jsonify = function(obj) { return w.JSON.stringify(obj, undefined, 4); };
})(window);

;winload(function() {
	// css select2
	$("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");

	$('#spp_uang_a, #spp_uang_b').on('change', function() {
		$(this).prev().text(format_rupiah($(this).val()));
	});

	var spp = <?php echo json_encode(utf8ize($data_spp)) ?>, angg_rek;
	var $spp_inp_rek = $('#spp_inp_rek').children().prop('value','').parent().addClass('w-100p').select2({
		minimumResultsForSearch: -1
	}).on('change', function(i) {
		var idx = $(this).children(':selected').index() - 1; // tekmen ono holder-option
		if (idx >= 0) {
			// console.log(idx);
			// console.log(angg_rek[idx].JUMLAH);
			$('#spp_uang_a').val(angg_rek[idx].JUMLAH).trigger('change');
			$('#spp_uang_b').val(angg_rek[idx].JUMLAH+spp.JUMLAH_SPP).trigger('change');
		}
	});

	var angg_rek_url = base_url +'svc2/spp_angg_rek2/'+ spp.TAHUN +'/'+ spp.KODEORGANISASI +'-'+ spp.KODEDESA +'/'+ spp.KODEBIDANG +'-'+ spp.KODEPROGRAM +'-'+ spp.KODEKEGIATAN;

	$.getJSON(angg_rek_url, function(dat) {
		angg_rek = dat;
		var kd, kd_prog, slc_opt = '';
		for (var i = 0; i < dat.length; i++) {
			kd = [dat[i].KODEAKUN, dat[i].KODEKELOMPOK, dat[i].KODEJENIS, dat[i].KODEOBJEK];
			slc_opt += '<option value="'+ kd.join(',') + '">';
			slc_opt += kd.map(function(i) { return lzero(i); }).join('.');
			slc_opt += ' - ' + dat[i].URAI_REKENING;
			slc_opt += '</option>';
			// console.log(dat[i]);
		}
		// console.log(dat);
		$spp_inp_rek.append(slc_opt).trigger('change');

		$('#anggrek_obj').text(jsonify(dat));
	});
	$('#spp_obj').text(jsonify(spp));
});
</script>