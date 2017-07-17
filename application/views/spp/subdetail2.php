<?php
$kodeorg = array(
	$dataspp['KODEURUSAN'],
	$dataspp['KODESUBURUSAN'],
	$dataspp['KODEORGANISASI'],
	$dataspp['KODEDESA']
);
$kodeprog = array(
	$dataspp['KODEBIDANG'],
	$dataspp['KODEPROGRAM'],
	$dataspp['KODEKEGIATAN']
);
// debug($kode_org);
?>
<div class="panel bd-rad-0">
	<div class="panel-body">

		<div class="row">
			<div class="col-sm-6">
				<h4 class="mg-y-t-0"><?php echo app::strkode($kodeorg), ' - ', $dataspp['URAI_DESA'] ?></h4>
				<h3 class="mg-0"><?php echo app::strkode($kodeprog), ' - ', $dataspp['URAI_PROG'] ?></h3>
			</div>
			<div class="col-sm-6 text-right">
				<a href="<?php echo base_url('spp2/index') ?>" class="btn btn-sm btn-info bd-rad-0">Daftar</a>
			</div>
		</div>
		<hr/>

<form class="form-horizontal" id="sppr_form" method="post">
	<?php // spp ?>
	<input type="hidden" name="TAHUN" value="<?php echo $dataspp['TAHUN'] ?>"/>
	<input type="hidden" name="KODEURUSAN" value="<?php echo $dataspp['KODEURUSAN'] ?>"/>
	<input type="hidden" name="KODESUBURUSAN" value="<?php echo $dataspp['KODESUBURUSAN'] ?>"/>
	<input type="hidden" name="KODEORGANISASI" value="<?php echo $dataspp['KODEORGANISASI'] ?>"/>
	<input type="hidden" name="KODEDESA" value="<?php echo $dataspp['KODEDESA'] ?>"/>
	<input type="hidden" name="KODEBIDANG" value="<?php echo $dataspp['KODEBIDANG'] ?>"/>
	<input type="hidden" name="KODEPROGRAM" value="<?php echo $dataspp['KODEPROGRAM'] ?>"/>
	<input type="hidden" name="KODEKEGIATAN" value="<?php echo $dataspp['KODEKEGIATAN'] ?>"/>
	<input type="hidden" name="NO_SPP" value="<?php echo $dataspp['NO_SPP'] ?>"/>
	<input type="hidden" name="TANGGAL" value="<?php echo $dataspp['TGL_SPP'] ?>"/>
	<?php // anggr ?>
	<input type="hidden" name="KODEAKUN"/>
	<input type="hidden" name="KODEKELOMPOK"/>
	<input type="hidden" name="KODEJENIS"/>
	<input type="hidden" name="KODEOBJEK"/>
	<?php // jarene dikosongi wae ?>
	<input type="hidden" name="KODESUB1" value="0"/>
	<input type="hidden" name="KODESUB2" value="0"/>
	<input type="hidden" name="KODESUB3" value="0"/>

	<?php //foreach ($dataspp as $k => $v): ?>
	<!-- <input type="hidden" name="<?php //echo $k ?>" value="<?php //echo $v ?>"/> -->
	<?php //endforeach ?>

	<div class="form-group">
		<label class="col-sm-2 control-label">Anggaran:</label>
		<div class="col-sm-10">
			<select name="web_inp_anggrek" id="spp_inp_anggrek" class="form-control" required>
				<option value> - </option>
				<?php foreach ($dataanggr['data'] as $v):
					// $kodeangg = [$v['KODEBIDANG'], $v['KODEBIDANG'], $v['KODEKEGIATAN']];
					$kodeangg = array($v['KODEAKUN'], $v['KODEKELOMPOK'], $v['KODEJENIS'], $v['KODEOBJEK']);
					?>
				<option value="<?php echo implode(',', $kodeangg) ?>"><?php echo app::strkode($kodeangg) ,' - ', $v['URAI_REKENING'] ?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
	<div class="form-group hideable">
		<label class="col-sm-2 control-label">Jumlah:</label>
		<div class="col-sm-10">
			<div class="input-group">
				<span class="input-group-addon" style="font-weight:600;"></span>
				<input type="number" name="JUMLAH" min="0" step="0.10" id="sppr_jumlah" class="form-control" required/>
				<span class="input-group-addon" style="font-weight:600;"></span>
			</div>
		</div>
	</div>

	<div class="form-group hideable">
		<label class="col-sm-2 control-label">Keterangan:</label>
		<div class="col-sm-10">
			<textarea name="URAIAN" class="form-control" required></textarea>
		</div>
	</div>

	<div class="form-group hideable">
		<label class="col-sm-2 control-label"></label>
		<div class="col-sm-10">
			<button type="submit" class="btn btn-sm btn-success bd-rad-0">simpan</button>
		</div>
	</div>

</form>
<br/>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Rekening</th>
			<th>Uraian</th>
			<th class="text-right">Anggaran</th>
			<th class="text-right">SPP Lalu</th>
			<th class="text-right">SPP Sekarang</th>
			<th class="text-right">Jumlah SPP</th>
			<th class="text-right">Sisa Anggaran</th>
		</tr>
	</thead>
	<?php foreach ($datasppr as $v): //foreach ($datasppr['data'] as $v):
		$kode_rek = array($v['KODEAKUN'], $v['KODEKELOMPOK'], $v['KODEJENIS'], $v['KODEOBJEK']);
		// debug($kode_rek);
		?>
		<tr>
			<td><?php echo app::strkode($kode_rek) ?></td>
			<td><?php echo $v['URAI'] ?></td>
			<td class="text-right"><?php echo $v['ANGGARAN'] //echo format_rupiah($v['JUMLAH_ANGG']) ?></td>
			<td class="text-right"><?php echo $v['LALU'] //echo format_rupiah($v['JUMLAH']) ?></td>
			<td class="text-right"><?php echo $v['SEKARANG'] ?></td>
			<td class="text-right"><?php echo $v['JUMLAH'] //echo format_rupiah($v['JUMLAH_ANGG'] - $v['JUMLAH']) ?></td>
			<td class="text-right"><?php echo $v['SISA'] ?></td>
		</tr>
		<!--
		<tr>
			<?php //foreach ($v as $v): ?>
				<td><?php //echo $v ?></td>
			<?php //endforeach ?>
		</tr>
		-->
	<?php endforeach ?>
	<?php if (count($datasppr) < 1): //if (count($datasppr['data']) < 1): ?>
		<tr><td colspan="4" class="text-center"><b>Data Kosong</b></td></tr>
	<?php endif ?>
</table>

	</div>
</div>

<?php //debug($datasppr['data'], false, false) ?>
<?php //debug($dataanggr['data'], false, false) ?>
<script>
var dataanggr = <?php echo json_encode(utf8ize($dataanggr['data'])) ?>;
winload(function() {
	$sppr = $('#sppr_form');
	$anggr = $('#spp_inp_anggrek');
	$jumlah = $('#sppr_jumlah');

	$sppr.prop('action', base_url + 'spp2/rincian_simpan');

	$jumlah.on('keyup change', function() {
		var v = $(this).val();
		$(this).prev().text(format_rupiah(v));
	});

	$anggr.on('change', function() {
		// console.log();
		var idx = $(this).children(':selected').index()-1;
		if (idx >= 0) {
			// console.log(dataanggr[idx]);
			var dat = dataanggr[idx];
			$sppr[0].KODEAKUN.value = dat.KODEAKUN;
			$sppr[0].KODEKELOMPOK.value = dat.KODEKELOMPOK;
			$sppr[0].KODEJENIS.value = dat.KODEJENIS;
			$sppr[0].KODEOBJEK.value = dat.KODEOBJEK;

			$jumlah.prop('max', Number(dat.JUMLAH)).next().text('Batas: ' + format_rupiah(dat.JUMLAH));
			$jumlah.trigger('change');
			// console.log(dat.JUMLAH);

			$sppr.children('.hideable').show();
		} else {
			$sppr.children('.hideable').hide();
		}
	}).trigger('change');
});
</script>
