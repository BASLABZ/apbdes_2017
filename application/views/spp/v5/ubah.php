<style scoped>
    .ibox-title{
        background-color: #1ab394;
        color: white !important;
    }
</style>

<div class="ibox">

	<div class="ibox-title"><h5>Ubah SPP</h5></div>
	<div class="ibox-content">

		<div class="row">
			<div class="col-md-6">
				<h4><?php echo $spp['URAI_ORG'] ?></h4>
				<h3 class="mg-b-0">No. SPP: <b><?php echo $spp['NO_SPP'] ?></b></h3>
			</div>
			<div class="col-md-6 text-right">
				<!-- <a onclick="spp_rem_fn(function() { location.href = location.href.replace(/ubah/, 'hapus') })" class="btn btn-danger btn-xs bd-rad-0"><span class="glyphicon glyphicon-remove"></span> Hapus</a> -->
				<a onclick="location.href = location.href.replace(/spp5\/ubah/, 'spp2/rincian')" class="btn btn-primary btn-xs bd-rad-0"><span class="glyphicon glyphicon-align-justify"></span> Rincian</a>
				<a href="<?php echo base_url('spp3/index') ?>" class="btn btn-info btn-xs bd-rad-0"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>
			</div>
		</div>

		<div class="hr-line-dashed"></div>

		<form id="spp_form" method="post" action="<?php echo base_url('spp5/simpan_ubah') ?>">
			<?php $this->load->view('base/select-2') ?>
			<input type="hidden" name="TAHUN"/>
			<input type="hidden" name="KODEURUSAN"/>
			<input type="hidden" name="KODESUBURUSAN"/>
			<input type="hidden" name="KODEORGANISASI"/>
			<input type="hidden" name="KODEDESA"/>
			<!-- kegiatan -->
			<input type="hidden" name="KODEBIDANG" class="spp-prog"/>
			<input type="hidden" name="KODEPROGRAM" class="spp-prog"/>
			<input type="hidden" name="KODEKEGIATAN" class="spp-prog"/>

			<input type="hidden" name="NO_SPP"/>

			<div class="row">
				<div class="col-md-6">

					<div class="form-group">
						<label>Kegiatan</label>
						<select name="inp_keg" id="web_inp_keg" class="form-control" required>
							<option value>-- pilih kegiatan --</option>
							<?php $is_kosong = true; foreach ($keg as $v): $is_kosong = false; ?>
								<option value="<?php echo $v['KODEBIDANG'] . ',' . $v['KODEPROGRAM'] . ',' . $v['KODEKEGIATAN'] ?>"><?php echo $v['KEGIATAN'] ?></option>
							<?php endforeach; if ($is_kosong): ?>
								<option value>-- kegiatan tidak tersedia --</option>
							<?php endif ?>
						</select>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Tanggal SPP</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="date" name="TGL_SPP" class="form-control" required/>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Waktu Pelaksanaan</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input type="text" name="WAKTU_PELAKSANAAN" class="form-control" id="spp_inp_waktup" required/>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Bulan SPP</label>
								<select name="BULAN" class="form-control" id="spp_inp_bulan" required>
									<option value>-- pilih bulan --</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Oleh bendahara:</label>
								<input name="NAMA_BENDAHARA" class="form-control" required/>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>No. rekening bendahara:</label>
								<input name="NOREK_BENDAHARA" class="form-control" required/>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label>Deskripsi SPP:</label>
						<textarea name="DESKRIPSI_SPP" class="form-control"></textarea>
					</div>

					<div class="form-group">
						<label>Deskripsi pekerjaan:</label>
						<textarea name="DESKRIPSI_PEKERJAAN" class="form-control"></textarea>
					</div>

				</div><!-- col -->

				<div class="col-md-6">

					<!-- <div class="form-group"><label>Pihak ketiga</label></div> -->

					<div class="form-group">
						<label>Nama perusahaan:</label>
						<input name="NAMA_PERUSAHAAN" class="form-control" required/>
					</div>
					<div class="form-group">
						<label>Alamat perusahaan:</label>
						<input name="ALAMAT_PERUSAHAAN" class="form-control" required/>
					</div>
					<div class="form-group">
						<label>No. rekening perusahaan:</label>
						<input name="NOREK_PERUSAHAAN" class="form-control" required/>
					</div>

					<button type="submit" class="btn btn-sm btn-success bd-rad-0">Simpan</button>
				</div><!-- col -->
			</div><!-- row -->
		</form>
	</div>


</div>

<?php $this->load->view('spp/misc/js-rem'); ?>
<script>
var data_spp = <?php echo json_encode(utf8ize($spp)) ?>;


winload(function() {
	$('#spp_inp_bulan').select2({
		data:$.map(id_nama_bulan, function(item, idx) {
			return {
				id: (idx+1),
				text: item
			}
		})
	});
});

winload(function() {

	$( $('#spp_form')[0].elements ).each(function() {
		var n = $(this).prop('name') || '';
		var d = data_spp[n] || '';
		if (n === '' || d === '') return;

		if (n === 'TGL_SPP') {
			var t = d.split(' ');
			this.value = t[0];
			return;
		}
		// console.log(n);
		$(this).val(d).trigger('change');
	});
});

// dijalankan setelah form terisi dari json
winload(function() {
	var kodekeg = [data_spp.KODEBIDANG, data_spp.KODEPROGRAM, data_spp.KODEKEGIATAN];
	$('#web_inp_keg').val(kodekeg.join(',')).on('change', function() {
		$(this).prop('title', $(this.selectedOptions[0]).text());
	}).select2().trigger('change');

	(function() {
		var dt = $('#spp_inp_waktup').val().split(' '), dt_b;
		for (var i = 0; i < id_nama_bulan.length; i++) {
			if (id_nama_bulan[i] === dt[1]) {
				dt[1] = i+1;
				break;
			}
		}
		$('#spp_inp_waktup')[0].dataset.iso = dt[2] + '-' + lzero(dt[1]) + '-' + lzero(dt[0]);
	})();

	$('#spp_inp_waktup').on('focus', function() {
		this.type = 'date';
		this.value = this.dataset.iso || null;
	}).on('blur', function() {
		if (this.checkValidity()) {
			var dt = new Date(this.value);
			this.dataset.iso = dt.toISOString().slice(0,10);
			this.type = 'text';
			this.value = lzero(dt.getDate()) + ' ' + id_nama_bulan[dt.getMonth()] + ' ' + dt.getFullYear();
		} else {
			this.type = 'text';
			this.value = null;
		}
	});

	/*
	var is_kosong = Boolean(<?php //echo (int)$is_kosong ?>);
	if (is_kosong) return;

	var curr_prog = [];
	$inp_prog = $('#spp_form').children('.spp-prog').each(function() {
		curr_prog.push($(this).val());
	});
	curr_prog = curr_prog.join(',');
	$('#web_inp_keg').val(curr_prog).select2().on('change', function() {
		var v = $(this).val().split(',');
		$inp_prog.each(function(i,e) {
			e.value = v[i];
		});
	});
	*/

})
</script>
