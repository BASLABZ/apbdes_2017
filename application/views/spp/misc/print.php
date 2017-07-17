<div class="ibox">
<!-- <div class="ibox-title"><h5>Cetak</h5></div> -->
	<!-- <div class="ibox-content"> -->
		<form id="print_cetak_form" action="javascript:void(0);">
			<div id="sppcetakform" class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Kepala Desa</label>
						<select id="ctk-pjbt" class="form-control" required>
							<option value>-- Pilih Kepala Desa --</option>
						</select>
					</div>
					<div class="hidden" hidden>
						<input type="hidden" name="Nama_Pejabat"/>
						<input type="hidden" name="NIP_Pejabat"/>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Bendahara</label>
						<select id="ctk-bdhr" class="form-control" required>
							<option value>-- Pilih Bendahara --</option>
						</select>
					</div>
					<div class="hidden" hidden>
						<input type="hidden" name="Nama_Bendahara"/>
						<input type="hidden" name="NIP_Bendahara"/>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group mg-b-0">
						<label>Tanggal Cetak:</label>
						<div class="input-group">
						    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						    <input type="text" name="tgl_cetak" class="form-control" id="print_tgl_cetak" required/>
						</div>
					</div>
				</div>
			</div>

			<div class="hr-line-dashed"></div>

			<button type="submit" class="btn btn-primary bd-rad-0">Cetak</button>

		</form>
	<!-- </div> -->
</div>

<div class="modal fade" id="print_modal_iframe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document" style="width:96%;">
		<div class="modal-content">
			<div class="modal-body pd-0">
				<style scoped> iframe#cetak_iframe { width: 100%; } </style>
				<iframe id="cetak_iframe" src="javascript:void(0)" frameborder="0" marginwidth="0" marginheight="0"></iframe>
			</div>
		</div>
	</div>
</div>

<script>
var current_cetak_orang_dinas = [];
var url_cetak_pejabat = base_url + 'laporan/laporan_bku/all_pejabat/';
var url_cetak = base_url + 'resource/report/?report_type=pdf&file=SPP/SPP.fr3'
var current_cetak_url;

winload(function() {

	// gede. tur ora ono scroll
	$('#cetak_iframe').css('height', (document.body.offsetHeight-72) + 'px');

	// reset iframe pdf, men ora gawe bingung user
	$('#print_modal_iframe').on('hidden.bs.modal', function (e) {
		$('#cetak_iframe')[0].src = 'javascript:void(0)';
	});

	$('#print_cetak_form').on('submit', function() {
		var pjb = $(this).serialize();
		var src_ifr = current_cetak_url + '&' + pjb;

		$('#cetak_iframe')[0].src = src_ifr;

		$('#print_modal_iframe').modal('show');
		$('#idmodal-print').modal('hide');
	});

	var currentDate = new Date();
	$('#print_tgl_cetak').datepicker({
	    format : 'dd MM yyyy'
	}).datepicker("setDate",currentDate);

	$('#ctk-pjbt').on('change', function() {
		var v = Number($(this).val());
		var w = $(this).parent().next('.hidden');
		for (var i = 0; i < current_cetak_orang_dinas.length; i++) {
			if (v === current_cetak_orang_dinas[i].ID) {
				w.find('input[name=Nama_Pejabat]').val(current_cetak_orang_dinas[i].NAMA);
				w.find('input[name=NIP_Pejabat]').val(current_cetak_orang_dinas[i].NIP || '-');
				break;
			}
		}
	});

	$('#ctk-bdhr').on('change', function() {
		var v = Number($(this).val());
		var w = $(this).parent().next('.hidden');
		for (var i = 0; i < current_cetak_orang_dinas.length; i++) {
			if (v === current_cetak_orang_dinas[i].ID) {
				w.find('input[name=Nama_Bendahara]').val(current_cetak_orang_dinas[i].NAMA);
				w.find('input[name=NIP_Bendahara]').val(current_cetak_orang_dinas[i].NIP || '-');
				break;
			}
		}
	});

});

function cetak_get_pejabat(kd, fn) {
	var u = base_url + 'laporan/laporan_bku/all_pejabat/' + kd.join('/');
	$.get(u, function(dat) {
		var inp = '';
		current_cetak_orang_dinas = dat;
		for (var i = 0; i < dat.length; i++) {
			inp += '<option value="' + dat[i].ID + '">' + dat[i].NAMA + ' (' + (dat[i].JABATAN || 'jabatan -') + ')</option>';
		}
		$('#ctk-pjbt').html(inp).trigger('change');
		$('#ctk-bdhr').html(inp).trigger('change');

		if (fn) fn();
	});
}

function ke_cetak_form() {
	$(document.body).animate({ scrollTop: $('#print_cetak_form').offset().top }, 1000);

}
</script>


