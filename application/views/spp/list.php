<div class="panel bd-rad-0">
	<div class="panel-body">

		<div class="row">
			<div class="col-md-6"></div>
			<div class="col-md-6 text-right">
				<a href="<?php echo base_url('spp/index') ?>" class="btn btn-primary bd-rad-0">Tambah</a>
			</div>
		</div>
		<br/>

		<table class="table table-bordered mg-y-b-0">
			<thead>
				<tr>
					<th>NO. SPP</th>
					<th>Kegiatan</th>
					<th>Organisasi</th>
					<th class="text-center w-10p">Tanggal</th>
					<th class="text-center w-10p">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($daftar_spp['data'] as $v): ?>
				<tr>
					<td><?php echo $v['NO_SPP'] ?></td>
					<td><?php echo $v['URAI_PROG'] ?></td>
					<td><?php echo $v['URAI_KEC'] ?> - <?php echo $v['URAI_DESA'] ?></td>
					<td class="text-center"><?php echo current(explode(' ', $v['TGL_SPP'])) ?></td>
					<td class="text-center">
						<a href="<?php echo base_url('spp/data/lihat/'.$v['TAHUN'].'/'.$v['KODEORGANISASI'].'-'.$v['KODEDESA'].'?nomor='.urlencode($v['NO_SPP'])) ?>" class="btn btn-success btn-xs bd-rad-0" title="Lihat"><span class="glyphicon glyphicon-eye-open"></span></a>
						<a href="<?php echo base_url('spp/rincian/'.$v['TAHUN'].'/'.$v['KODEORGANISASI'].'-'.$v['KODEDESA'].'?nomor='.urlencode($v['NO_SPP'])) ?>" class="btn btn-primary btn-xs bd-rad-0" title="Rincian"><span class="glyphicon glyphicon-align-justify"></span></a>
						<a onclick="spp_fn_delete($(this));" data-href="<?php echo base_url('spp/data/hapus/'.$v['TAHUN'].'/'.$v['KODEORGANISASI'].'-'.$v['KODEDESA'].'?nomor='.urlencode($v['NO_SPP'])) ?>" class="btn btn-danger btn-xs bd-rad-0"><span class="glyphicon glyphicon-remove"></span></a>
					</td>
				</tr>
				<?php endforeach ?>
				<?php if (count($daftar_spp['data']) < 1): ?>
					<tr><td colspan="6" class="text-center"><b>Data Kosong</b></td></tr>
				<?php endif ?>
			</tbody>
		</table>

		<?php //$this->load->view('base/pager') ?>

		<!-- <ul class="pagination mg-y-b-0" id="paginaarr"></ul> -->
		<p id="paginaarr" class="mg-0 text-right"></p>
		
	</div>
</div>

<script>
winload(function() {
	config('spp');
});

winload(function() {
	$('#paginaarr').pagingin({
		page: <?php echo $daftar_spp['page'] ?>,
		total: <?php echo $daftar_spp['total'] ?>,
		limit: <?php echo $daftar_spp['limit'] ?>,
		act: function(p) {
			var u = base_url + 'spp/daftar';
			for (var i = 3; i < 6; i++) {
				url_segment[String(i)] && (u += '/'+ url_segment[String(i)]);
			}
			return (u + '?page=' + p);
		}
	});
});
</script>
