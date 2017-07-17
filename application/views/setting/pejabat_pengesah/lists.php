<?php
$this->load->view('base/select-2');
$this->load->view('base/ibox');
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

<div class="row">
	<div class="col-md-6">
		<div class="ibox"><div class="ibox-title"><h5><span class="fa fa-search"></span> Cari Desa</h5></div>
	<div class="ibox-content highlight-bas">
		<form action="javasript:void(0);" class="form-inline">
			<select class="form-control" id="dh-inst" style="width: 99%;">
				<option value="0"> -- Pilih Instansi -- </option>
				 <?php foreach ($instansi as $v): ?><option value="<?php echo @$v['KODE_PAN'] ?>"><?php echo @$v['URAI'] ?></option><?php endforeach ?>
			</select>
		</form>
	</div>
</div>
	</div>
</div>
<div class="ibox"><div class="ibox-title"><h5><span class="fa fa-book"></span> Daftar Pejabat Pengesah</h5></div>
	<div class="ibox-content highlight-bas">
		
		<div class="hr-line-dashed"></div>

		<div class="table-responsive">
			<script>var tbkosong = false;</script>
			<table class="table table-bordered mg-y-b-0" id="tb">
				 <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Kecamatan</th>
                                <th>Desa</th>
                                <th>Nama Pejabat</th>
                                <th>Pangkat</th>
                                <th>Jabatan</th>
                                <th>NIP</th>                                
                                <?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?>  
                                <th width="15%"></th>
                                <?php endif ?>
                            </tr>
                        </thead>
				<tbody>
				<?php foreach ($pengesah as  $val) : ?>
					<tr>
						<td><?php echo $val['TAHUN']; ?></td>
					</tr>
				<?php endforeach; ?>
						<script>var tbkosong = true;</script>
						<tr><td colspan="6" class="text-center">Dasar Hukum Tidak Tersedia.</td></tr>
					
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
	// $btnadd = $('#act-add');
	if (url_segment[3]) {
		var v = cond_param + '-' + url_segment[3];
		$slc.val(v);
	}

	var first = true;

	$slc.select2().on('change', function() {
		if (this.value === null || this.value === '') return;
		var v = this.value.substr(cond_param.length+1);
		var daftar_u = base_url + 'setting/pengesah/index/' + v;
		$slcbtn.prop('href', daftar_u);
		// if (/\-/.test(v)) {
		// 	var u = base_url + 'daskum/tambah/' + v.split('-').join('/');
		// 	$btnadd.prop('href', u);

		// 	if (!first) location.href = daftar_u;
		// } else {
		// 	$btnadd.prop('href', base_url + 'daskum/tambah');
		// }

		if (first) first = false;

	}).trigger('change');

	// TABEL
	// if (tbkosong === false) {
	// 	$tbl = $('#tb');

	// 	$tbl.find('td.usingtoollllltip').children('a').tooltip();

	// 	$tbl.dataTable({
	// 		order: [],
	// 		bLengthChange: false,
	// 		language: id_dttable
	// 	});
	// }

});
</script>