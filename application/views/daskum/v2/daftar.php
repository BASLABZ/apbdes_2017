<?php
// $is_allow_edit = in_array($this->session->hakakses, array('ADMIN','OPERATORDESA'));
$this->load->view('base/select-2');
$this->load->view('base/ibox');
$this->load->view('daskum/rm');
?>
<style scoped>
#tb_wrapper { padding-bottom: 0px !important; }
#tb_info { padding-top: 0px; }

</style>
<style type="text/css">
	.ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>

<?php $vd = $this->session->flashdata('daskum_flash'); if ($vd !== null): ?>
	<div class="alert alert-<?php echo $vd['alert'] ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $vd['msg'] ?>
	</div>
<?php endif ?>

<div class="row">
	<div class="col-md-6">
		<div class="ibox"><div class="ibox-title"><h5><span class="fa fa-search"></span> Cari Desa</h5></div>
	<div class="ibox-content highlight-bas">
		<form action="javasript:void(0);" class="form-inline">
			<select class="form-control" id="dh-inst" style="width: 99%;">
				<option value="0"> -- Pilih Instansi -- </option>
				<?php foreach ($instansi as $v): ?><option value="<?php echo @$v['KODE_PAN'] ?>"><?php echo @$v['URAI'] ?></option><?php endforeach ?>
			</select>
			<!-- <a href="<?php //echo base_url('daskum2/index') ?>" id="act-search" data-href="<?php //echo base_url('daskum2/index') ?>" class="btn btn-sm btn-primary bd-rad-0">Tampilkan</a> -->
		</form>
	</div>
</div>
	</div>
</div>

<div class="ibox"><div class="ibox-title">
				<h5><span class="fa fa-book"></span> Daftar Dasar Hukum</h5>
				<?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?>  
				<p class="text-right">
					<a id="act-add" href="<?php echo base_url('spp_/tambah') ?>" class="btn btn-success btn-xs bd-rad-0"><span class="fa fa-plus"></span> Tambah</a>
				</p>
				<?php endif ?>
		</div>
	<div class="ibox-content highlight-bas">
		<!-- 
		<div class="hr-line-dashed"></div> -->

		<div class="table-responsive">
			<script>var tbkosong = false;</script>
			<table class="table table-bordered mg-y-b-0" id="tb">
				<thead>
					<tr>
						<th>Tentang</th>
						<th>Dasar</th>
						<th>Nomor</th>
						<th>Tahun</th>
						<th>Tanggal</th>
						<?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?>  
						<th class="text-center">Aksi</th>
						<?php endif ?>
					</tr>
				</thead>
				<tbody>
					<?php $kosong = true; foreach ($daskum as $v): $kosong = false; ?>
						<tr>
							<td class="w-max-40p"><?php echo $v['TENTANG'] ?></td>
							<td><?php echo $v['DASARHUKUM'] ?></td>
							<td><?php echo $v['NOMOR_DASARHUKUM'] ?></td>
							<td><?php echo $v['TAHUN'] ?></td>
							<td title="<?php echo $v['TANGGAL_DITETAPKAN'] ?>"><?php echo current(explode(' ', $v['TANGGAL_DITETAPKAN'])) ?></td>
							<?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?>  
							<td class="text-center w-10p usingtoollllltip">
								<!-- <a title="Lihat" href="<?php //echo base_url('daskum/lihat/'.$v['KODEORGANISASI'].'/'.$v['KODEDESA'].'/'.$v['ID_DASARHUKUM']) ?>" class="btn btn-success btn-xs bd-rad-0"><span class="glyphicon glyphicon-eye-open"></span></a> -->
								<a title="Ubah" href="<?php echo base_url('daskum/ubah/'.$v['KODEORGANISASI'].'/'.$v['KODEDESA'].'/'.$v['ID_DASARHUKUM']) ?>" class="btn btn-primary btn-xs bd-rad-0 dim"><span class="glyphicon glyphicon-pencil"></span></a>
								<a title="Hapus" onclick="daskum_fn_delete($(this));" data-href="<?php echo base_url('daskum/hapus/'.$v['KODEORGANISASI'].'/'.$v['KODEDESA'].'/'.$v['ID_DASARHUKUM']) ?>" class="btn btn-danger btn-xs bd-rad-0 dim"><span class="glyphicon glyphicon-remove"></span></a>
							</td>
							<?php endif ?>
						</tr>
					<?php endforeach; if ($kosong): ?>
						<script>var tbkosong = true;</script>
						<tr><td colspan="6" class="text-center">Dasar Hukum Tidak Tersedia.</td></tr>
					<?php endif ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
var cond_param = <?php echo json_encode(implode('-', $cond)); ?>;
winload(function() {
	$slc = $('#dh-inst');
	$slcbtn = $('#act-search');
	$btnadd = $('#act-add');
	if (url_segment[3]) {
		var v = cond_param + '-' + url_segment[3];
		$slc.val(v);
	}

	var first = true;

	$slc.select2().on('change', function() {
		if (this.value === null || this.value === '') return;
		var v = this.value.substr(cond_param.length+1);
		var daftar_u = base_url + 'daskum2/index/' + v;
		$slcbtn.prop('href', daftar_u);
		if (/\-/.test(v)) {
			var u = base_url + 'daskum/tambah/' + v.split('-').join('/');
			$btnadd.prop('href', u);

			if (!first) location.href = daftar_u;
		} else {
			$btnadd.prop('href', base_url + 'daskum/tambah');
		}

		if (first) first = false;

	}).trigger('change');

	// TABEL
	if (tbkosong === false) {
		$tbl = $('#tb');

		$tbl.find('td.usingtoollllltip').children('a').tooltip();

		$tbl.dataTable({
			order: [],
			bLengthChange: false,
			language: id_dttable
		});
	}

});
</script>
