<?php $this->load->view('spp/spp/tambah/form3') ?>

<div class="hr-line-dashed"></div>

<style scoped>
	#rincian_wrapper {
		padding-bottom: 0px;
	}
</style>

<table id="rincian" class="table table-condensed table-bordered table-hover" style="width:100%;">
	<thead>
		<tr>
			<th>Rekening</th>
			<th>Uraian</th>
			<th>Anggaran</th>
			<th>SPP lalu</th>
			<th>SPP Sekarang</th>
			<th>Jumlah SPP</th>
			<th>Sisa Anggaran</th>
		</tr>
	</thead>
</table>

<div class="hr-line-dashed"></div>

<div class="row">
	<div class="col-md-6">
		<button type="button" onclick="spp_btn_prev2()" class="btn btn-sm btn-success bd-rad-0">&lsaquo; Sebelumnya</button>
	</div>
	<div class="col-md-6 text-right">
		<button type="submit" id="form_btn_submit" class="btn btn-sm btn-primary bd-rad-0">Simpan</button>
	</div>
</div>

<script>
function spp_btn_prev2() {
	$form_nav_link.get(0).click();
}

winload(function() {
	$form.on('submit', function(ev) {
		if (!_rinci_data_ok) {
			ev.preventDefault();
		}
	});
});

var RincianData, _rinci_data_ok = false;
function _ready_rician() {
	var v1 = $('#spp_inp_org').val();
	var v2 = $('#spp_inp_keg').val();
	var p1 = $form[0].NO_SPP.value;
	var p2 = $form[0].TGL_SPP.value;
	var param = v1 + '/' + v2 + '?nomor=' + encodeURIComponent(p1) + '&tanggal=' + p2;

	// console.log(param);
	// return;

	if (v1 !== '0' && v2 !== null && p1 !== '' && p2 !== '') { // buat tabel
		_get_rincian(param);
	} else { // reset tabel
		RincianData = $('#rincian').DataTable({
			destroy: true,
			aaSorting: [],
			bLengthChange: false,
			data: [],
			language: $.extend({}, id_dttable, {zeroRecords: "Isi <b>Instansi</b>, <b>Kegiatan</b>, <b>Nomor SPP</b> dan <b>Tanggal SPP</b> untuk menampilkan rincian."})
		});
	}
}
function _get_rincian(param) {
	is_wroking_keg = true;
	if (typeof data.keg[param] === 'undefined') {
		$.get(base_url + 'svc/spp_angg/' + param, function(dat) {
			$.map(dat, function(o) {
				o._ANGGARAN = format_rupiah(o.ANGGARAN);
				o._LALU = format_rupiah(o.LALU);
				o._JUMLAH = format_rupiah(o.JUMLAH);
				o._SISA = format_rupiah(o.SISA);
			});
			data.keg[param] = dat;
			_table_rincian(dat);
		});
	} else {
		_table_rincian(data.keg[param]);
	}
}
function _table_rincian(data) {
	_rinci_data_ok = (data.length > 0);

	console.log(data)

	RincianData = $('#rincian').DataTable({
		destroy: true,
		aaSorting: [],
		bLengthChange: false,
		data: data,
		language: $.extend({}, id_dttable),
		columns: [
			{data: 'KODEREKENING'},
			{data: 'URAI'},
			{data: '_ANGGARAN', sClass: 'text-right'},
			{data: '_LALU', sClass: 'text-right'},
			{
				data: 'SEKARANG',
				// item: dari data[i].nilai_input, type: jenis render (ada display, filter), row: data[i]
				render: function(item, type, row) {
					if (type !== 'display') return item; var str = '';
					str += '<input type="hidden" name="URAIAN[]" value="' + row.URAI + '"/>';
					str += '<input type="hidden" name="KODEAKUN[]" value="' + row.KODEAKUN + '"/>';
					str += '<input type="hidden" name="KODEKELOMPOK[]" value="' + row.KODEKELOMPOK + '"/>';
					str += '<input type="hidden" name="KODEJENIS[]" value="' + row.KODEJENIS + '"/>';
					str += '<input type="hidden" name="KODEOBJEK[]" value="' + row.KODEOBJEK + '"/>';
					str += '<input name="inp_nilai_awal[]" type="hidden" value="'+Number(item)+'"/>';
					str += '<input name="inp_nilai[]" style="zoom:1.1;" step="0.01" min="0" max="' + Number(row.SISA) + '" value="'+format_rupiah(item)+'" class="input-fake" onfocus="_rincian_arep(this)" onblur="_rincian_uwes(this)" onkeyup="_rincian_nulis(this,$(this).next(), $(this).parents(\'tr\'))" onmousewheel="event.preventDefault()" onchange="$(this).trigger(\'keyup\')" required/>';
					str += '<input name="nilai[]" type="hidden" value="'+Number(item)+'"/>';
					return str;
				},
				sClass: 'text-right'
			},
			{data: '_JUMLAH', sClass: 'text-right'},
			{data: '_SISA', sClass: 'text-right'}
		]
	});
	is_wroking_keg = false;
}

/* RINCIAN INPUT-HANDLE */
var _rincian_error = [];
function _rincian_arep(elm) {
	if (elm.type !== 'number') {
		elm.value = $(elm).next().val();
		elm.type = 'number';
	}
}
function _rincian_uwes(elm) {
	if (elm.checkValidity()) {
		elm.type = 'text';
		elm.value = format_rupiah($(elm).next().val());
	}
}
function _rincian_nulis(elm, $nex, $tr) {
	if (elm.checkValidity()) {
		var d = RincianData.row($tr).data();
		var v = Number(elm.value); if (isf(v)) v = v.toFixed(2);
		d.SEKARANG = v;
		$nex.val(v);

		elm.style.borderColor = '';
	} else {
		elm.style.borderColor = 'red';
	}
}

</script>