<div class="panel bd-rad-0">
	<div class="panel-body">

<div class="row">
	<div class="col-sm-6">
		<a href="<?php echo base_url('spp/daftar') ?>" class="btn btn-success bd-rad-0">Daftar</a>
	</div>
	<div class="col-sm-6 text-right">
		<a onclick="spp_fn_delete($(this));" data-href="<?php echo base_url('spp/data/hapus/'.$data_spp['TAHUN'].'/'.$data_spp['KODEORGANISASI'].'-'.$data_spp['KODEDESA'].'?nomor='.urlencode($data_spp['NO_SPP'])) ?>" class="btn btn-danger bd-rad-0">Hapus</a>
		<a href="<?php echo base_url('spp/index') ?>" class="btn btn-primary bd-rad-0">Tambah</a>
	</div>
</div>
<br/>

<table>
	<?php foreach ($data_spp as $k => $v): ?>
	<tr>
		<th><?php echo $k ?></th>
		<td><?php echo $v ?></td>
	</tr>
	<?php endforeach ?>
</table>

	</div>
</div>

<script>
winload(function() {
	config('spp');
});
</script>