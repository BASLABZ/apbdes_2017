<?php $this->load->view('base/ibox') ?>
<?php $this->load->view('base/select-2') ?>
<style type="text/css">
	  .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }  
</style>
<div class="ibox">
				<div class="ibox-title">
						<h5><span class="fa fa-pencil"></span> <?php echo $title ?> Dasar Hukum</h5>
						<p class="text-right">
						<a href="javascript:history.back()" class="btn btn-info btn-xs bd-rad-0"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>
					</p>
						
				</div>
	<div class="ibox-content highlight-bas">
		<!-- <div class="hr-line-dashed"></div> -->

		<form id="daskum_form_add" method="post" autocomplete="off" action="<?php echo base_url('daskum/simpan') ?>" class="form-horizontal">

			<div class="form-group">
				<label class="col-sm-2 control-label">Nama Desa</label>
				<div class="col-sm-4">
					<select class="form-control" name="inst" id="daskum_inp_org" required>
						<option value>-- Pilih Kecamatan/Desa --</option>
						<?php foreach ($daskum_kec as $v): ?>
							<option value="<?php echo $v['KODE_PAN'] ?>" ><?php echo $v['URAI'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Dasar Hukum</label>
				<div class="col-sm-4">
					<input class="form-control" name="DASARHUKUM" required/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Ditetapkan</label>
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="date" name="TANGGAL_DITETAPKAN" class="form-control" required/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Nomor</label>
				<div class="col-sm-4">
					<input class="form-control" name="NOMOR_DASARHUKUM" placeholder="No. N Tahun N" required/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Tentang</label>
				<div class="col-sm-4">
					<textarea name="TENTANG" class="form-control" required></textarea>
				</div>
			</div>

			<div class="hr-line-dashed"></div>

			<div class="form-group">
				<label class="col-sm-2 control-label">&nbsp;</label>
				<div class="col-sm-4">
					<!-- <a onclick="history.back()" class="btn btn-danger dim">Batal</a>
					<button type="submit" class="btn btn-primary dim">simpan</button> -->
					<button class="btn btn-danger dim" onclick="history.back()"><span class="fa fa-times"></span> Batal</button>
                        <button class="btn btn-primary dim" type="submit"><span class="fa fa-save"></span> Simpan</button>
				</div>
			</div>

			<!--
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Kecamatan - Desa</label>
						<?php //$this->load->view('daskum/input-kec-desa') ?>
					</div>
					<div class="form-group">
						<label>Dasar Hukum</label>
						<input class="form-control" name="DASARHUKUM" required/>
					</div>
					<div class="form-group">
						<label>Ditetapkan</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input type="date" name="TANGGAL_DITETAPKAN" class="form-control" required/>
						</div>
						<input class="form-control" name="TANGGAL" placeholder="Tanggal Bulan Yahun"/>
					</div>
				</div>
				<div class="col-md-6">
			
					<div class="form-group">
						<label>Nomor</label>
						<input class="form-control" name="NOMOR_DASARHUKUM" placeholder="No. N Tahun N" required/>
					</div>
					<div class="form-group">
						<label>Tentang</label>
						<textarea name="TENTANG" class="form-control" required></textarea>
					</div>
			
					<button type="submit" class="btn btn-primary bd-rad-0">simpan</button>
				</div>
			</div>
			-->
		</form>
	</div>
</div>

<script>
winload(function() {
	form = byid('daskum_form_add');

	$(form.elements).each(function() {
		if (!this.placeholder) {
			this.placeholder = $(this).parent().prev('label').text();
		}
	});

	form.elements.TANGGAL_DITETAPKAN.type = 'text';
	form.elements.TANGGAL_DITETAPKAN.readOnly = true;
	$(form.elements.TANGGAL_DITETAPKAN).datepicker('format', 'dd/mm/yyyy');

	if (/^tambah$/.test(url_segment[2])) {
		if (url_segment[3] && url_segment[4]) {
			$(form.elements.inst.children).each(function() {
				if (this.value.indexOf(url_segment[3] + '-' + url_segment[4]) > -1) {
					this.selected = true;
				}
			});
		}
		$(form.elements.inst).select2();
	}

	/*
	$form = $('#daskum_form_add');
	url_slc_active = (url_segment[3] || 0) + '/' + (url_segment[4] || 0);
	if (url_slc_active !== '0/0') {
		url_slc_active = '1-20-' + url_slc_active.replace('/', '-');
	}
	$($form.get(0).elements.inst).select2().on('change', function() {
	});
	*/

	/*
	var $kec_input = $('#daskum_kec_input');
	var $desa_input = $('#daskum_desa_input');

	// harus
	if (/^(ubah|tambah)$/.test(url_segment['2'])) {
		$kec_input.prop('required',true).children(':first')[0].value = '';
		$desa_input.prop('required',true).children(':first')[0].value = '';
	}
	var desa_input_holder = $desa_input.html();

	// 3 ada, 3 bukan 0 (string), ok: kec select 3
	(url_segment['3'] && url_segment['3'] !== '0') && $kec_input.val(url_segment['3']);

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
});
</script>
