<div class="input-group w-100p">
	<select name="inp_kec" id="web_inp_kec" class="form-control" required>
		<option value="0"> -- Pilih Kecamatan -- </option>
		<?php foreach ($res_inp_kec as $v):
			$res_kd_org = array($v['KODEURUSAN'], $v['KODESUBURUSAN'], $v['KODEORGANISASI']);
			?>
		<option value="<?php echo implode(',', $res_kd_org) ?>"><?php echo strkode($res_kd_org) .' - '. $v['URAI'] ?></option>
		<?php endforeach ?>
	</select>
	<div class="input-group-btn w-0"></div>
	<select class="form-control" id="web_inp_desa" name="inp_desa" required>
		<option value="0"> -- Pilih Desa -- </option>
	</select>
</div>
