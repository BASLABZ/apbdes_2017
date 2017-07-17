<!-- <style scoped>
	#formpajak a {
		position: absolute;
		right: 0px;
	}
</style> -->
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Potongan pajak:</label>
			<select class="form-control" id="spp_inp_pjk">
				<option value>-- Tambah Pajak --</option>
			</select>
		</div>
	</div>
</div>

<div class="row"><div id="formpajak" class="col-md-6"></div></div>

<script>
winload(function() {
	(function(sppot) {
		var _opt = '';
		for (var i = 0; i < sppot.length; i++) {
			var _kode = [];
			for (var k in sppot[i]) {
				if (/^KODE/.test(k)) _kode.push(sppot[i][k]);
			}
			sppot[i].KODEREK = _kode.join('.');
			sppot[i].URAIREK = sppot[i].URAI + ' (' + sppot[i].SINGKAT + ')';
			_opt += '<option value="' + sppot[i].KODEREK + '">' + sppot[i].URAIREK + '</option>';
		}
		$('#spp_inp_pjk').append(_opt);
	})(data.pot);

	// $('#formpajak').html(byid('spp_tpl_pjk').innerHTML);
	$('#spp_inp_pjk').on('change', function() {
		var idx, v = this.value; if (v === '') return;
		var dat = (function(sppot) {
			for (var i = 0; i < sppot.length; i++) {
				if (v === sppot[i].KODEREK) {
					idx = i;
					return sppot[i];
				}
			}
		})(data.pot);
		if (data.pot[idx].ACTIVE === true) return;

		var $tpl = $(byid('spp_tpl_pjk').innerHTML).appendTo('#formpajak');
		$tpl.find('.form-control-static:first').text(data.pot[idx].URAIREK);
		$tpl.find('.rekpot:first').val(data.pot[idx].KODEREK);
		$tpl.find('.jenispot:first').val(data.pot[idx].SINGKAT);
		$tpl.find('button:first').on('click', function() {
			data.pot[idx].ACTIVE = false;
			$tpl.remove();
		});

		data.pot[idx].ACTIVE = true;
	});
});
</script>