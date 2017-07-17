<?php
// debug($sppdata);
?>

<div class="panel bd-rad-0">
	<div class="panel-body">

		<div class="row">
			<div class="col-sm-6"></div>
			<div class="col-sm-6 text-right">
				<a href="<?php echo base_url('spp2/tambah') ?>" class="btn btn-sm btn-info bd-rad-0">Tambah</a>
			</div>
		</div>
		<br/>

<table class="table table-bordered mg-y-b-0">
	<thead>
		<tr>
			<th>No. SPP</th>
			<th>Desa</th>
			<th>Perihal</th>
			<th class="text-right">Jumlah</th>
			<th class="text-center w-10p">Tgl Dibuat</th>
			<th class="text-center w-10p">Aksi</th>
		</tr>
	</thead>
	<tbody>

<?php foreach ($sppdata['data'] as $v):
	$org = array($v['KODEURUSAN'],$v['KODESUBURUSAN'],$v['KODEORGANISASI'],$v['KODEDESA']);
	$keg = array($v['KODEBIDANG'],$v['KODEPROGRAM'],$v['KODEKEGIATAN']);
?><tr data-tahun="<?php echo $v['TAHUN'] ?>" data-kodeorg="<?php echo implode(',', $org); ?>" data-kodeprog="<?php echo implode(',', $keg) ?>" data-nospp="<?php echo urlencode($v['NO_SPP']) ?>">
	<td><?php echo $v['NO_SPP'] ?></td>
	<td title="<?php echo $v['URAI_KEC'] ?>"><?php echo app::strkode($org), ' - ', $v['URAI_DESA']; ?></td>
	<td><?php echo app::strkode($keg), ' - ', $v['URAI_PROG'] ?></td>
	<td class="text-right"><?php echo format_rupiah($v['JUMLAH_SPP']) ?></td>
	<td class="text-center" title="<?php echo $v['TGL_SPP'] ?>"><?php echo current(explode(' ', $v['TGL_SPP'])) ?></td>
	<td class="text-center">
		<button onclick="spp_rincian_href($(this))" class="btn btn-primary btn-xs bd-rad-0" title="Rincian"><span class="glyphicon glyphicon-align-justify"></span></button>
	</td>
</tr>
<?php endforeach ?>
<?php if (count($sppdata['data']) < 1): ?>
<tr><td colspan="5" class="text-center">Data Kosong</td></tr>
<?php endif ?>

	</tbody>
</table>
<p id="paginaarr" class="mg-0 text-right"></p>
	</div>
</div>

<script>
function spp_rincian_href($elm) {
	var d = $elm.parent().parent().data();
	var u = base_url + 'spp2/rincian/' + d.kodeorg.split(',').join('-') + '?nomor=' + d.nospp;
	window.location.href = u;
	// console.log(u)
};

winload(function() {
	$('#paginaarr').pagingin({
		page: <?php echo $sppdata['page'] ?>,
		total: <?php echo $sppdata['total'] ?>,
		limit: <?php echo $sppdata['limit'] ?>,
		act: function(p) {
			var u = base_url + 'spp2';
			/*for (var i = 3; i < 6; i++) {
				url_segment[String(i)] && (u += '/'+ url_segment[String(i)]);
			}*/
			return (u + '?page=' + p);
		}
	});
});
</script>