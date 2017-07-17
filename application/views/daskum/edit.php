<?php $this->load->view('daskum/buat_baru') ?>

<script>
	winload(function() {
		var data = <?php echo json_encode($data[0]) ?>;
		_form = $('#daskum_form_add').prop(
			'action',
			base_url+'daskum/simpan_ubah/'+ url_segment[3] + '/' + url_segment[4] + '/' + url_segment[5]
		)[0];
		for (var k in data) {

			if (typeof k === 'undefined') continue;

			if (k === 'TANGGAL_DITETAPKAN') {
				// var d = data[k].split(' ')[0]
				// _form.elements[k].value = d;

				// var elm = _form.elements[k];

				$(_form.elements[k]).datepicker('setDate',(new Date(data[k])));

				// elm.type = 'text';
				// elm.readOnly = true;
				// $(elm).datepicker({
				// // 	format:'dd/mm/yyyy'
				// });.datepicker('setDate', (new Date(d)));

				continue;
			}
			if(_form.elements[k]) _form.elements[k].value = data[k];
		}

		_form.elements.inst.title = data.URAI_KEC + ' - ' + data.URAI_DESA;
		$(_form.elements.inst).val(data.KODEURUSAN + '-' + data.KODESUBURUSAN + '-' + data.KODEORGANISASI + '-' + data.KODEDESA)[0].disabled = true;
	});
</script>

<!-- <script>
	
	if (location.href.indexOf('ubah') > -1) {
		var d = form.TANGGAL_DITETAPKAN.value.split('-').reverse().join('/');
		console.log(d);
		// form.TANGGAL_DITETAPKAN.value = d;
	}
	$(form.TANGGAL_DITETAPKAN).each(function() {
		this.type = 'text';
		this.readOnly = true;
		$(this).datepicker();
	});

</script> -->