// ‎2016‎05‎, 201606041258, 201606061200 - Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>

;(function(w,$) {

	var $kec_input = $('#daskum_kec_input');
	var $desa_input = $('#daskum_desa_input');

	// harus
	if (/^(ubah|tambah)$/.test(w.url_segment['2'])) {
		$kec_input.prop('required',true).children(':first')[0].value = '';
		$desa_input.prop('required',true).children(':first')[0].value = '';
	}
	var desa_input_holder = $desa_input.html();

	// 3 ada, 3 bukan 0 (string), ok: kec select 3
	(w.url_segment['3'] && w.url_segment['3'] !== '0') && $kec_input.val(w.url_segment['3']);

	$kec_input.on('change',function() {

		// 0 == '', men ora bentrok ke load kabeh
		if($kec_input.val() === '0' || $kec_input.val() === '') {
			$desa_input.html(desa_input_holder); //kosongke desa
			return;
		}

		$kec_input.prop('disabled',true);
		$desa_input.prop('disabled',true);

		var ajx_kd_url = w.base_url+'daskum/ajx_desa/'+$kec_input.val();
		// appaned url
		if (/^ubah$/.test(w.url_segment['2'])) ajx_kd_url += '/' + w.url_segment['4'];;

		$.get(ajx_kd_url,function(dat) {
			$desa_input.children().remove();
			var slc_opt = desa_input_holder;
			for (var i = dat.length - 1; i >= 0; i--) {
				slc_opt += "<option value='"+dat[i].KODEDESA+"'>"+dat[i].URAI+"</option>";
			}
			$kec_input.prop('disabled',false);
			$desa_input.prop('disabled',false).append(slc_opt);

			// 3 ada, 4 ada, 4 bukan 0 (string), kec harus select 3, ok: desa select 4
			(w.url_segment['3'] && w.url_segment['4'] && w.url_segment['4'] !== '0' && w.url_segment['3'] === $kec_input.val()) && $desa_input.val(w.url_segment['4']);

			if (/^ubah$/.test(w.url_segment['2'])) {
				$kec_input.prop('disabled',true).off('change');
				$desa_input.prop('disabled',true);
			}

		});

	}).trigger('change');

	$('#daskum_from').on('submit',function(ev) {
		ev.preventDefault();
		location.href = w.base_url + w.url_segment['1'] + '/daftar/' + $kec_input.val() + '/' + $desa_input.val();
	});

	w.daskum_fn_delete = function($elm) {
		swal({
			title: "Hapus Data?",
			type: "error",
			showCancelButton: true,
			confirmButtonText: "Ya",
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Tidak"
		},function(ya) {
			if (ya) w.location.href = $elm.data('href');
		});
	};

})(window,jQuery);