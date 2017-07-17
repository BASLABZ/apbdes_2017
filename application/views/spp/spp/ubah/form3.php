<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Potongan pajak:</label>
			<select class="form-control" id="spp_inp_pjk">
				<option value>-- ubah/tambah pajak --</option>
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div id="formpajak"></div>
		<table class="table table-bordered mg-0" id="list_pajak">
			<thead>
				<tr>
					<th>Uraian</th>
					<th class="text-right">Jumlah</th>
					<th class="text-center">Aksi</th>
				</tr>
			</thead>
			<tr v-for="v in pajak">
				<td>{{ v.JENISPOTONGAN }}</td>
				<td class="text-right">{{ v._JUMLAH }} </td>
				<td class="text-center">
				<a  href="<?php echo base_url('spp_/hapus_potongan_pajak'); ?>/<?php echo "{{v.KODEURUSAN}}-{{v.KODESUBURUSAN}}-
					{{v.KODEORGANISASI}}-{{v.KODEDESA}}?norek={{v.REKENINGPOTONGAN}}&nomor={{v.NO_SPP}}"; ?>"  class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> 
				
				 </a>
				 </td>
						
			</tr>
			<tr v-if="pajak.length < 1"><td>Pajak Tidak tersedia.</td></tr>
		</table>
	</div>
</div>

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


winload(function() {


	var pjk = new Vue({
		el: '#list_pajak',
		data: {
			pajak: $.map(data.pjk, function(o) {
				o._JUMLAH = format_rupiah(o.JUMLAH);

				return o;
			})
		}
	});
});
</script>