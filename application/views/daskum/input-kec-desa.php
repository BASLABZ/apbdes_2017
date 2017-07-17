<div class="input-group w-100p">
	<select name="inp_kec" id="daskum_kec_input" class="form-control">
		<option value="0"> -- Pilih Kecamatan -- </option>
		<?php foreach ($daskum_kec as $v): ?>
			<option value="<?php echo $v['KODEORGANISASI'] ?>"><?php echo $v['URAI'] ?></option>
		<?php endforeach ?>
	</select>
	<div class="input-group-btn w-0"></div>
	<select class="form-control" id="daskum_desa_input" name="inp_desa" required><option value="0"> -- Pilih Desa -- </option></select>
</div>