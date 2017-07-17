
<div class="form-group">
	<label>Desa</label>
	<select name="inp_org" class="form-control" id="spp_inp_org" required>
		<option value>-- Pilih Desa --</option>
	</select>
</div>
<div class="form-group">
	<label>Kegiatan</label>
	<select name="inp_keg" id="spp_inp_keg" class="form-control" required></select>
</div>

<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<label>No. SPP: </label>
		      <input type="text" class="form-control" placeholder="Input No SPP" name="NO_SPP" id="orNo_SPP">
		      <span class="input-group-btn">
	      </span>
	       <i><small><b>*Jika No SPP Tampil Di Kolom Maka No SPP Telah Digunakan, Format Penulisan SPP (NO/SPP/DESA/DS2017)</b></small></i>
		</div>
     
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Bulan SPP</label>
			<select name="BULAN" class="form-control" id="spp_inp_bulan" required>
				<option value>-- Pilih Bulan --</option>
			</select>
		</div>
	</div>

</div>
<br>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>Tanggal SPP</label>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				<input type="date" name="TGL_SPP" class="form-control" id="spp_inp_tgl" required/>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Waktu Pelaksanaan</label>
			<input type="text" name="WAKTU_PELAKSANAAN" class="form-control" id="spp_inp_waktup" required/>
		</div>
	</div>
</div>

<div class="form-group">
	<label>Deskripsi SPP:</label>
	<textarea name="DESKRIPSI_SPP" class="form-control"></textarea>
</div>

<div class="form-group">
	<label>Deskripsi pekerjaan:</label>
	<textarea name="DESKRIPSI_PEKERJAAN" class="form-control"></textarea>

</div>
<script>
	winload(function() {
		$('#spp_inp_tgl').each(function() {
			this.type = 'text';
			this.readOnly = true;
			$(this).datepicker();
		});

		$('#orNo_SPP').typeahead({
			
			source:  function (query,process) {
        		return $.get('<?php echo base_url('spp_/cekNOSPP'); ?>',{query:query}, function (data) {
        		data = $.parseJSON(data);
	            return process(data);
	        	});
	    	},afterSelect : function () {
	    		alert('NO SPP TELAH DIGUNAKAN');
	    		$('#orNo_SPP').val("");	
	    	}
		}); 
	
	});
</script>

<?php ob_start() ?>
<div id="bdhr-res">
	<div class="row">
	</div>
	<br/>
	<table class="table table-condensed table-bordered">
		<thead>
			<tr v-el:tr_head><th>Nama</th><th>Rekening</th><th>Bank</th><th>NPWP</th><th class="text-center">Aksi</th></tr>
		</thead>
		<tbody>
			<tr v-for="ppl in $data.list">
				<td>{{ppl.NAMA}}</td>
				<td>{{ppl.NOREKBANK || '-'}}</td>
				<td>{{ppl.NAMABANK || '-'}}</td>
				<td>{{ppl.NPWP || '-'}}</td>
				<td class="text-center">
					<button v-on:click="slc_bdhr(ppl)" data-dismiss="modal" class="btn btn-xs btn-success bd-rad-0">Pilih</button>
				</td>
			</tr>
			<tr v-if="$data.list.length < 1 && $data.is_loading">
				<td v-bind:colspan="dyn_tr_head" class="text-center">Loading...,</td>
			</tr>
			<tr v-if="$data.list.length < 1 && !$data.is_loading">
				<td v-bind:colspan="dyn_tr_head" class="text-center">Bendahara Tidak Tersedia.</td>
			</tr>
		</tbody>
	</table>
</div>
<?php $bdhr_modal_content = ob_get_clean() ?>

<div class="modal fade" id="bdhr-modal">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<?php $this->load->view('spp/spp/index', array(
				'content_title' => 'Pilih Bendahara',
				'content_body' => $bdhr_modal_content
			)) ?>
			<script>
				var bdhr_curr_script = document.currentScript;
				winload(function() {
					$(bdhr_curr_script).parent().each(function() {
						$(this).find('.ibox').css('margin-bottom',0);
					});
				});
			</script>
		</div>
	</div>
</div>
