<div class="form-group">
	<label>Desa</label>
	<select name="inp_org" class="form-control" id="spp_inp_org" required>
		<option value>-- pilih desa --</option>
	</select>
</div>
<div class="form-group">
	<label>Kegiatan</label>
	<select name="inp_keg" id="spp_inp_keg" class="form-control" required></select>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>No. SPP:</label>
			<input class="form-control" required id="inp_spp_nospp" />
			<script>byid('inp_spp_nospp').value = data.spp.NO_SPP;byid('inp_spp_nospp').disabled = true;</script>
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
				<input type="date" name="TGL_SPP" class="form-control" id="spp_inp_tgl" required/>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Waktu Pelaksanaan</label>
			<input type="text" name="WAKTU_PELAKSANAAN" class="form-control" id="spp_inp_waktup" required/>
		</div>
	</div>
</div>

<!-- <div class="row">
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
</div> -->

<div class="form-group">
	<label>Deskripsi SPP:</label>
	<textarea name="DESKRIPSI_SPP" class="form-control"></textarea>
</div>

<div class="form-group">
	<label>Deskripsi pekerjaan:</label>
	<textarea name="DESKRIPSI_PEKERJAAN" class="form-control"></textarea>
</div>

<script>
winload(function() {
	$('#spp_inp_tgl').each(function() {
		this.type = 'text';
		this.readOnly = true;
		$(this).datepicker();
	});
});


// SET INPUT BEHAVIOR
winload(function() {
	$('#pihak').on('change',function () {
		if(this.value == "Bendahara") {
          $('#bendahara').show();
          $('#pihakketiga').hide();
          
        }else if (this.value == "pihakkeketiga") {
        	$('#bendahara').hide();
          	$('#pihakketiga').show();	

        }
})
	$('#spp_aan_info').find('.t-nospp').html('<td>No. SPP</td><td>:</td><td><b>' + data.spp.NO_SPP + '</b></td>');


	var kd = [data.spp.KODEURUSAN, data.spp.KODESUBURUSAN, data.spp.KODEORGANISASI, data.spp.KODEDESA]
	$('#spp_inp_org').html('<option value=' + kd.join('-') + '>' + data.spp.URAI_KEC + ' - ' + data.spp.URAI_DESA + '</option>').addClass('disabled').prop('disabled', true).select2();

	$('#spp_aan_info').find('.t-spp').html('<td>Kecamatan/Desa</td><td>:</td><td><b>' + $('#spp_inp_org').text() + '</b></td>');

	// $( $form[0].elements.NO_SPP ).prop('disabled', true);

	$('#spp_inp_keg').select2({
		data: $.map(data.keg, function(o) {
			o.id = o.KODEBIDANG + '-' + o.KODEPROGRAM + '-' + o.KODEKEGIATAN;
			o.text = o.KEGIATAN;
			return o;
		})
	}).on('change', function() {
		_ready_rician();

		$('#spp_aan_info').find('.t-keg').html('<td>Kegiatan</td><td>:</td><td><b>' + $(this).children(':selected').text() + '</b></td>');

	}).val(data.spp.KODEBIDANG + '-' + data.spp.KODEPROGRAM + '-' + data.spp.KODEKEGIATAN);

	$('#spp_inp_bulan').select2({
		data: $.map(id_nama_bulan, function(item, idx) {
			return { id: (idx+1), text: item };
		})
	});
});
</script>
