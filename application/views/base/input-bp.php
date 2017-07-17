<div class="input-group w-100p">
	<select name="inp_bid" id="web_inp_bid" class="form-control" required>
		<option value="0"> -- Pilih Bidang -- </option>
		<?php foreach ($result_inp_bid as $v): ?>
			<option value="<?php echo $v['KODEBIDANG'] ?>"><?php echo $v['URAI'] ?></option>
		<?php endforeach ?>
	</select>
	<div class="input-group-btn w-0"></div>
	<select name="inp_prog" id="web_inp_prog" class="form-control" required>
		<option value="0"> -- Pilih Program -- </option>
	</select>
</div>