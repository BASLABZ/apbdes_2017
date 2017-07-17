<!--
dirapikan dengan: http://anovsiradj.96.lt/snippets/editor.html
Cara:
copas kode ke editor -> klik pada editor -> CTRL+A -> SHIFT+TAB
-->
<style scoped>
	#daskum-table_wrapper {
		padding-bottom: 0px !important;
	}
</style>

<table class="table table-bordered table-condensed table-hover" id="daskum-table">
	<thead>
		<tr>
			<th width="5%">No.</th>
			<th>Kecamatan</th>
			<th>Desa</th>
			<th>Dasar</th>
			<th>Nomor</th>
			<th>Tahun</th>
			<th>Tanggal</th>
			<th>Tentang</th>
			<th width="15%"></th>
		</tr>
	</thead>
	<tbody>
		<?php $is_kosong = true; $a = 1;foreach ($daftar_daskum['data'] as $v): $is_kosong = false; ?>
		<tr>
			<td align="center"><?php echo $a ?>.</td>
			<td><?php echo $v['URAI_KEC'] ?></td>
			<td><?php echo $v['URAI_DESA'] ?></td>
			<td><?php echo $v['DASARHUKUM'] ?></td>
			<td><?php echo $v['NOMOR_DASARHUKUM'] ?></td>
			<td align="center"><?php echo $v['TAHUN'] ?></td>
			<td title="<?php echo $v['TANGGAL_DITETAPKAN'] ?>" align="center"><?php echo date_id($v['TANGGAL_DITETAPKAN']) ?></td>
			<td class="w-max-40p"><?php echo $v['TENTANG'] ?></td>
			<td class="text-center w-10p">
				<!-- <a href="<?php echo base_url('daskum/lihat/'.$v['KODEORGANISASI'].'/'.$v['KODEDESA'].'/'.$v['ID_DASARHUKUM']) ?>" class="btn btn-success btn-xs bd-rad-0"><span class="glyphicon glyphicon-eye-open"></span></a> -->
				<a href="<?php echo base_url('daskum/ubah/'.$v['KODEORGANISASI'].'/'.$v['KODEDESA'].'/'.$v['ID_DASARHUKUM']) ?>" class="btn btn-primary btn-xs bd-rad-0" data-toggle="tooltip" title="Ubah" ><span class="glyphicon glyphicon-pencil"></span></a>
				<a onclick="daskum_fn_delete($(this));" data-href="<?php echo base_url('daskum/hapus/'.$v['KODEORGANISASI'].'/'.$v['KODEDESA'].'/'.$v['ID_DASARHUKUM']) ?>" class="btn btn-danger btn-xs bd-rad-0" data-toggle="tooltip" title="Hapus"><span class="glyphicon glyphicon-remove"></span></a>
			</td>
		</tr>
		<?php $a++; endforeach ?>
		<?php if (count($daftar_daskum['data']) < 1): ?>
		<tr><td colspan=9 class="text-center">Dasar Hukum Tidak Tersedia.</td></tr>
		<?php endif ?>
	</tbody>
</table>

<?php if (!$is_kosong): ?>
	<script>
	winload(function() {
		var is_kosong = Boolean(<?php echo (int)$is_kosong ?>);

		if (is_kosong) return;
		$('#daskum-table').dataTable({
			order: [],
			bLengthChange: false,
			language: id_dttable
		}).find('[data-toggle=tooltip]').tooltip();

	});
	</script>
<?php endif ?>
