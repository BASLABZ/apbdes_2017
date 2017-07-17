<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #1ab394;
        color: white !important;
    }
</style>
<!-- form tambah -->
<div class="ibox">
            <div class="ibox-title">
                <h5>Tambah SPP</h5>
            </div>
            <div class="ibox-content">
<div align="right">
                    <div class="btn-group">
                        <a href="<?php echo base_url('spp3/index') ?>" class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
		<div class="row">
			<div class="col-md-6"></div>
			
		</div>

<form id="spp_form" method="post" action="<?php echo base_url('spp2/simpan') ?>">
	<?php $this->load->view('base/select-2') ?>
	<input type="hidden" name="KODEURUSAN" class="spp-org"/>
	<input type="hidden" name="KODESUBURUSAN" class="spp-org"/>
	<input type="hidden" name="KODEORGANISASI" class="spp-org"/>
	<input type="hidden" name="KODEDESA" class="spp-org"/>
	<!-- kegiatan -->
	<input type="hidden" name="KODEBIDANG" class="spp-prog"/>
	<input type="hidden" name="KODEPROGRAM" class="spp-prog"/>
	<input type="hidden" name="KODEKEGIATAN" class="spp-prog"/>

	<div class="row">
		<div class="col-md-6">

			<div class="form-group">
				<label>Organisasi:</label>
				<select class="form-control" id="spp-inp-inst" required>
					<option value>-- pilih instansi --</option>
					<?php foreach ($res_inst['data'] as $v): ?>
					<option value="<?php echo @$v['KODE_PAN'] ?>"><?php echo @$v['URAI'] ?></option>
					<?php endforeach ?>
				</select>
			</div>

			<div class="form-group">
				<label>Kegiatan</label>
				<select name="inp_keg" id="web_inp_keg" class="form-control" required>
					<option value>-- tulis kode/kata kunci kegiatan --</option>
				</select>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>No. SPP:</label>
						<input name="NO_SPP" class="form-control" required/>
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

<script>

;winload(function() {

	/*
	catatan:
	kegiatan, harus brdasarkan desa
	*/

	var ajx_kegiatan = base_url + 'svc/slc2_kegiatan3/';
	$form = $('#spp_form');
	$inp_inst = $('#spp-inp-inst');
	$inp_keg = $('#web_inp_keg');//.select2().prop('disabled', true);

	$inp_keg.select2({
		// minimumInputLength: 1,
		ajax: {
			url: ajx_kegiatan,
			dataType: 'json',
			allowClear: true,
			cache: true,
			// delay: 500,
			data: function(param) {
				this.url += $inp_inst.val();
				if (param.term && param.term !== '') {
					this.url += '/' + param.term.replace(/\s+/g,'-');
				}
				console.log(this.url)
			},
			processResults: function(dat) {
				for (var i = 0; i < dat.length; i++) {
					var arrkode = [
						dat[i].KODEBIDANG,
						dat[i].KODEPROGRAM,
						dat[i].KODEKEGIATAN
					];
					dat[i].id = arrkode.join(',');
					// dat[i].text = arrkode.map(function(v) { return lzero(v) }).join('.') + ' - ' + dat[i].URAI;
					dat[i].text = dat[i].KEGIATAN;
				}
				return { results: dat };
			}
		}
	}).on('change', function() {
		var v = ($(this).val() || '').split(','); // empty-result: [''] / ['0']
		if (v.length > 1) {
			$form.find('.spp-prog').each(function(idx, elm) {
				elm.value = v[idx];
			});
		}
	});

	if(url_segment[3] && /\-/.test(url_segment[3])) {
		$inp_inst.val('1-20-'+ url_segment[3]);
	}
	$inp_inst.select2().on('change', function() {
		$inp_keg.prop('disabled', true);
		var v = $(this).val();
		if (v !== '') {
			var kode = v.split('-');
			var elm = $form[0].elements;
			elm.KODEURUSAN.value = kode[0];
			elm.KODESUBURUSAN.value = kode[1];
			elm.KODEORGANISASI.value = kode[2];
			elm.KODEDESA.value = kode[3];

			$inp_keg.val(null).prop('disabled', false).trigger("change");
		}
	}).trigger('change');


	$('#spp_inp_bulan').select2({
		data:$.map(id_nama_bulan, function(item, idx) {
			return {
				id: (idx+1),
				text: item
			}
		})
	});

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

});
</script>
