<div class="panel bd-rad-0">
	<div class="panel-body">

<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-6 text-right">
		<a href="<?php echo base_url('spp/daftar') ?>" class="btn btn-success bd-rad-0">Daftar</a>
	</div>
</div>
<!-- <br/> -->

<form id="spp_form" method="post" action="<?php echo base_url('spp/simpan') ?>">
	<div class="row">
		<div class="col-md-6">

			<!-- <div class="form-group"><label>Pemerintahan</label></div> -->

			<div class="form-group">
				<label>Organisasi:</label>
				<?php $this->load->view('base/input-kd') ?>
			</div>

			<div class="form-group">
				<label>Kegiatan</label>
				<select name="inp_keg" id="web_inp_keg" class="form-control" required>
					<option value="0">Sebutkan jenis kegiatan...,</option>
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
						<label>Waktu Pelaksanaan</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input type="date" name="WAKTU_PELAKSANAAN" class="form-control" required/>
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
				<label>Jumlah SPP</label>
				<div class="input-group">
					<span class="input-group-addon" style="font-weight:600;">Rp. 0,00</span>
					<input type="number" min="0" step="0.10" name="JUMLAH_SPP" id="inp_jml" class="form-control" required/>
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

			<button type="submit" class="btn btn-info btn-block bd-rad-0">simpan</button>
		</div><!-- col -->
	</div><!-- row -->
</form>

	</div>
</div>

<script>
;winload(function() {

	// css select2
	$("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");


	/*
	$('#spp_form').find('input').each(function() {
		$(this).prop('required',false);
	});
	*/

	$('#inp_jml').prop('title','Koma menggunakan titik. Masukkan angka apa adanya').on('keyup change', function() {
		var v = Number($(this).val());
		$(this).prev().text(format_rupiah(v));
	});

	var $inp_kec = $('#web_inp_kec').children(':first').val('').parent().css('width','100%').select2(),
		$inp_des = $('#web_inp_desa').children(':first').val('').parent().css('width','100%').select2(),
		inp_des_hold = $inp_des.html(),
		ajx_desa = base_url + 'svc/org_desa/',
		ajx_kegiatan = base_url + 'svc/slc2_kegiatan2/';

	// kegiatan
	$('#web_inp_keg').css('width','100%').children(':first').val('').parent().select2({
		minimumInputLength: 3,
		ajax: {
			url: ajx_kegiatan,
			dataType: 'json',
			delay: 500,
			data: function(param) {
				this.url += param.term.replace(/\s+/,'-');
				// return { q: par.term }
			},
			processResults: function(dat) {
				// console.log(data);
				for (var i = 0; i < dat.length; i++) {
					var arrkode = [
						dat[i].KODEBIDANG,
						dat[i].KODEPROGRAM,
						dat[i].KODEKEGIATAN
					];
					dat[i].id = arrkode.join(',');
					dat[i].text = arrkode.map(function(v) { return lzero(v) }).join('.') + ' - ' + dat[i].URAI;
				}
				return { results: dat };
			}
		}
	});

	// kec-desa
	$inp_kec.on('change', function(ev) {

		// jaga2, menawa nek di disabled
		if ($(this).prop('disabled')) return;

		// default: 0. jaga2 menawa attr:value-ne dikosongi
		var v = $(this).val();
		if (v === '' || v === '0') {
			$inp_des.html(inp_des_hold).trigger('change');
			return;
		}

		// disabled sek
		$inp_kec.prop('disabled',true);
		$inp_des.prop('disabled',true);

		$.get(ajx_desa + v, function(dat) {
			var opt_inp = inp_des_hold;
			for (var i = dat.length - 1; i >= 0; i--) {
				var arrkode = [
					dat[i].KODEURUSAN,
					dat[i].KODESUBURUSAN,
					dat[i].KODEORGANISASI,
					dat[i].KODEDESA
				];
				// nggo koma, men iso le mbedakke menowo sak-kode iso akeh kode
				opt_inp += "<option value='" + arrkode.join(',') + "'>"+ arrkode.map(function(v) { return lzero(v) }).join('.') + ' - ' + dat[i].URAI+ "</option>";
			}

			$inp_kec.prop('disabled',false);
			$inp_des.prop('disabled',false).html(opt_inp).trigger('change'); //update select2 desa

		});

	}).trigger('change');

});
</script>
