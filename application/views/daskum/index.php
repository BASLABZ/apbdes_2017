<?php $this->load->view('base/select-2') ?>
<?php $this->load->view('base/ibox') ?>

<div class="ibox"><div class="ibox-title"><h5>Cari Desa</h5></div>
	<div class="ibox-content">
		<form id="daskum_from">
			<div class="input-group w-50p">
				<select id="spp-inp-inst" style='width: 99%;'>
					<option value="0/0">-- Pilih Kecamatan/Desa --</option>
					<?php foreach ($daskum_kec as $v): ?><option value="<?php echo str_replace('-', '/', $v['KODE_PEN']) ?>"><?php echo $v['URAI'] ?></option><?php endforeach ?>
				</select>
				<div class="input-group-btn">
				<button type="submit" class="btn btn-sm btn-primary bd-rad-0">TAMPILKAN</button>
				</div>
			</div>
			<!-- <div class="form-group">
				<div class="input-group">
					<select name="namadesa" class="select2" style='width: 99%;' required>
						<option value="0">-- Pilih Kecamatan/Desa --</option>
						<?php //foreach ($desa as $v): ?>
						<?php //$set_select_desa = $v['KODEURUSAN'].".".$v['KODESUBURUSAN'].".".$v['KODEORGANISASI'].".".$v['KODEDESA']; ?>
							<option value="<?php //echo $set_select_desa ;?>" <?php //echo set_select('namadesa', $set_select_desa, ( !empty($get_list_desa) && $get_list_desa == $set_select_desa ? TRUE : FALSE )); ?> ><?php //echo $v['URAI'];?></option>
						<?php //endforeach ?>
					</select>
					<div class="input-group-btn">
					<button class="btn btn-sm btn-primary" id="tampil" data-loading-text="LOADING..." autocomplete="off">TAMPILKAN</button>
					</div>
				</div>
			</div> -->
		</form>
	</div>
</div>

<div class="ibox">
	<div class="ibox-title"><h5>Daftar Dasar Hukum</h5></div>
	<div class="ibox-content">

		<div class="text-right">
			<a class="btn btn-info btn-xs bd-rad-0" type="button" id="btnDaftar"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>
			<a href="<?php echo base_url('daskum/tambah') ?>" id="btntbnvvsdjbk" class="btn btn-success btn-xs bd-rad-0" type="button"><span class="fa fa-plus"></span> Tambah</a>
		</div>


		<!-- <div class="row">
			<div class="col-md-8">
				<form id="daskum_from" class="row">
					<div class="col-md-8">
						<?php //$this->load->view('daskum/input-kec-desa') ?>
						<select class="form-control input-sm" id="spp-inp-inst">
							<option value="0/0"> -- Pilih Desa -- </option>
							<?php //foreach ($daskum_kec as $v): ?><option value="<?php //echo str_replace('-', '/', $v['KODE_PEN']) ?>"><?php //echo $v['URAI'] ?></option><?php //endforeach ?>
						</select>
					</div>
					<div class="col-md-4">
						<button type="submit" class="btn btn-sm btn-primary bd-rad-0">tampilkan</button>
					</div>
				</form>
			</div>
			<div class="col-md-4 text-right">
				<a href="<?php //echo base_url('daskum/tambah') ?>" class="btn btn-success btn-xs bd-rad-0" type="button"><span class="fa fa-plus"></span> Tambah</a>
			</div>
		</div> -->

		<div class="hr-line-dashed"></div>

		<?php if ($this->uri->segment(2) === 'daftar') $this->load->view('daskum/paginasi'); ?>

	</div>
</div>

<script>
winload(function() {
	// disable tombol daftar
    $('#btnDaftar').addClass('disabled');
    
	$form = $('#daskum_from');
	$slc = $('#spp-inp-inst');
	$tmbh = $('#btntbnvvsdjbk').each(function() {
		this.dataset.initurl = this.href;
	});

	$form.find('select').addClass('input-sm');

	$slc.select2().each(function() {
		if (url_segment['3'] && url_segment['4']) {
			var kd = url_segment['3'] + '/' + url_segment['4'];
			$(this).val(kd);
		}
		$(this).on('change', function() {
			$tmbh.prop('href', $tmbh.data('initurl') + '/' + $slc.val());
		}).trigger('change');
	});
	

	(function(w, $) {
		/*
		var $kec_input = $('#daskum_kec_input');
		var $desa_input = $('#daskum_desa_input');
		*/

		/*
		// harus
		if (/^(ubah|tambah)$/.test(url_segment['2'])) {
			$kec_input.prop('required',true).children(':first')[0].value = '';
			$desa_input.prop('required',true).children(':first')[0].value = '';
		}
		var desa_input_holder = $desa_input.html();

		// 3 ada, 3 bukan 0 (string), ok: kec select 3
		(url_segment['3'] && url_segment['3'] !== '0') && $kec_input.val(url_segment['3']);
		*/
		/*
		$kec_input.on('change',function() {
			// 0 == '', men ora bentrok ke load kabeh
			if($kec_input.val() === '0' || $kec_input.val() === '') {
				$desa_input.html(desa_input_holder); //kosongke desa
				return;
			}

			$kec_input.prop('disabled',true);
			$desa_input.prop('disabled',true);

			var ajx_kd_url = base_url+'daskum/ajx_desa/'+$kec_input.val();
			// appaned url
			if (/^ubah$/.test(url_segment['2'])) ajx_kd_url += '/' + url_segment['4'];;

			$.get(ajx_kd_url,function(dat) {
				$desa_input.children().remove();
				var slc_opt = desa_input_holder;
				for (var i = dat.length - 1; i >= 0; i--) {
					slc_opt += "<option value='"+dat[i].KODEDESA+"'>"+dat[i].URAI+"</option>";
				}
				$kec_input.prop('disabled',false);
				$desa_input.prop('disabled',false).append(slc_opt);

				// 3 ada, 4 ada, 4 bukan 0 (string), kec harus select 3, ok: desa select 4
				(url_segment['3'] && url_segment['4'] && url_segment['4'] !== '0' && url_segment['3'] === $kec_input.val()) && $desa_input.val(url_segment['4']);

				if (/^ubah$/.test(url_segment['2'])) {
					$kec_input.prop('disabled',true).off('change');
					$desa_input.prop('disabled',true);
				}

			});
		}).trigger('change');
		*/

		$form.on('submit',function(ev) {
			ev.preventDefault();
			location.href = base_url + url_segment['1'] + '/daftar/' + $slc.val();
			// location.href = base_url + url_segment['1'] + '/daftar/' + $kec_input.val() + '/' + $desa_input.val();
		});

	})(window, jQuery);

});

function daskum_fn_delete($elm) {
	swal({
		title: "Apa anda yakin ?",
		text: "Anda akan menghapus data dasar hukum ini!",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Hapus",
		confirmButtonColor: "#DD6B55",
		cancelButtonText: "Batal"
	},function(ya) {
		if (ya) location.href = $elm.data('href');
	});
};
</script>