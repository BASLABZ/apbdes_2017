<?php
// debug($spppot);

$is_allow_edit = in_array($this->session->hakakses, array('ADMIN','OPERATORDESA'));
if ($dataspp['STATUS_PERSETUJUAN'] == true) {
	$is_allow_edit = false;
}
$keg = $dataspp['KODEBIDANG'] . '-' . $dataspp['KODEPROGRAM'] . '-' . $dataspp['KODEKEGIATAN'];
$this->load->view('base/select-2');
$this->load->view('base/ibox');
?>
<style type="text/css">
#spp-rincian-table_wrapper {
	padding-bottom: 0px;
}
.ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }

</style>

<div class="ibox">
	<?php echo $this->session->flashdata('Sukses'); ?>
		<div class="ibox-title">
				<h5><span class="glyphicon glyphicon-align-justify"></span> Rincian SPP</h5>
				<div class="pull-right">
					<?php  if ($is_allow_edit): ?>
					<?php endif ?>
				    <a href="<?php echo base_url('spp3/index') ?>/<?php echo $dataspp['KODEORGANISASI']; ?>-<?php echo $dataspp['KODEDESA']; ?>" class="btn btn-info btn-xs bd-rad-0"><span class="glyphicon glyphicon-th-list"></span> Daftar </a>
			</div>

		</div>

	<div class="ibox-content highlight-bas">
		<div class="row">
			<div class="col-md-8">
				<style scoped> #sppinfo, #sppinfo tr, #sppinfo td { border: none; } </style>
				<table class="table table-condensed mg-0 h5" id="sppinfo">
					<tr>
						<td>Kecamatan/Desa</td>
						<td>:</td>
						<td><b><?php echo $dataspp['URAI_KEC'], ' - ', $dataspp['URAI_DESA'] ?> <?php echo $dataspp['KODEORGANISASI']; ?></b></td>
					</tr>
					<tr>
						<td>Kegiatan</td>
						<td>:</td>
						<td><b><?php echo str_replace('-', '.', $keg),' - ',$dataspp['URAI_PROG'] ?></b></td>
					</tr>
					<tr>
						<td>No. SPP</td>
						<td>:</td>
						<td><b><?php echo $dataspp['NO_SPP'] ?></b></td>
					</tr>
				</table>
			</div>
		</div>
		<template id="tpl_pajak" hidden>
			<div class="row">
				<input name="JENIS_POT[]" type="hidden" class="jp" />
				<input name="REKENINGPOTONGAN[]" type="hidden" class="rp" />
				<div class="col-md-6">
					<div class="form-group">
						<label>Aturan:</label>
						<p class="form-control-static pd-0"></p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Jumlah:</label>
						<div class="input-group">
							<input name="JUMLAH_POT[]" type="number" min="0" step="0.01" class="form-control" required/>
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" onclick="$(this).parents('.row:first').remove()">&times;</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</template>

		<form action="<?php echo base_url('spp3/rincian_simpan') ?>" method="post" id="spprform">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group" id='pajak-kosong-hide-this' style="display:none;">
						<label>Potongan pajak: </label>
						<select class="form-control" id="spp-inp-pajak">
							<option value>-- Pilih Pajak --</option>
						</select>
					</div>

					<div id="form_pajak"></div>

					<table class="table table-bordered mg-0" id="list_pajak">
						<thead>
							<tr>
								<th>Uraian</th>
								<th class="text-right">Jumlah</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<?php $kosong = true; foreach ($spppot as $v): $kosong = false; ?>
							<tr>
								<td><?php echo $v['JENISPOTONGAN'] ?></td>
								<td class="text-right"><?php echo format_rupiah($v['JUMLAH'], false) ?></td>
								<td class="text-center">
									 <a class="btn btn-primary btn-sm" href="javascript:_ubah_potongan_pajak(
									 <?php echo $v['TAHUN']; ?>,
									 <?php echo $v['KODEURUSAN']; ?>,
									 <?php echo $v['KODESUBURUSAN']; ?>,
									 '<?php echo $v['KODEORGANISASI']; ?>',
									 '<?php echo $v['KODEDESA']; ?>',
									 '<?php echo $v['REKENINGPOTONGAN']; ?>',
									 '<?php  echo $v['NO_SPP']; ?>',
									 '<?php echo $v['JUMLAH']; ?>'
									 )">
									 <span class="fa fa-pencil"></span></a>

									 <a class="btn btn-danger btn-sm" href="javascript:_hapus_potongan(
									 <?php echo $v['TAHUN']; ?>,
									 <?php echo $v['KODEURUSAN']; ?>,
									 <?php echo $v['KODESUBURUSAN']; ?>,
									 '<?php echo $v['KODEORGANISASI']; ?>',
									 '<?php echo $v['KODEDESA']; ?>',
									 '<?php echo str_replace(".", "-", $v['REKENINGPOTONGAN']); ?>',
									 '<?php  echo str_replace("/", "-", $v['NO_SPP']); ?>' )">
									 <span class="fa fa-trash"></span></a>


								</td>
							</tr>
						<?php endforeach ?>
						<?php if ($kosong): ?><tr><td class="text-center" colspan="3">Pajak Tidak Tersedia.</td></tr><?php endif ?>
					</table>
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<!-- spp -->
			<input type="hidden" name="TAHUN" value="<?php echo $dataspp['TAHUN'] ?>"/>
			<input type="hidden" name="KODEURUSAN" value="<?php echo $dataspp['KODEURUSAN'] ?>"/>
			<input type="hidden" name="KODESUBURUSAN" value="<?php echo $dataspp['KODESUBURUSAN'] ?>"/>
			<input type="hidden" name="KODEORGANISASI" value="<?php echo $dataspp['KODEORGANISASI'] ?>"/>
			<input type="hidden" name="KODEDESA" value="<?php echo $dataspp['KODEDESA'] ?>"/>
			<input type="hidden" name="KODEBIDANG" value="<?php echo $dataspp['KODEBIDANG'] ?>"/>
			<input type="hidden" name="KODEPROGRAM" value="<?php echo $dataspp['KODEPROGRAM'] ?>"/>
			<input type="hidden" name="KODEKEGIATAN" value="<?php echo $dataspp['KODEKEGIATAN'] ?>"/>
			<input type="hidden" name="NO_SPP" value="<?php echo $dataspp['NO_SPP'] ?>"/>
			<input type="hidden" name="TANGGAL" value="<?php echo $dataspp['TGL_SPP'] ?>"/>
			<!-- jarene kosongi -->
			<input type="hidden" name="KODESUB1" value="0"/>
			<input type="hidden" name="KODESUB2" value="0"/>
			<input type="hidden" name="KODESUB3" value="0"/>
			<!-- rincian -->
			<textarea name="URAIAN" class="hidden"></textarea>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered table-hover mg-y-b-0" id="spp-rincian-table">
				<thead>
					<tr>
						<th>Rekening</th>
						<th>Uraian</th>
						<th class="text-right">Anggaran</th>
						<th class="text-right">SPP Lalu</th>
						<!-- <th class="text-right">SPP Sekarang</th> -->
						<th class="text-right">SPP Sekarang</th>
						<th class="text-right">Jumlah SPP</th>
						<th class="text-right">Sisa Anggaran</th>
					</tr>
				</thead>
				<?php $is_kosong = true; $_id_td = 0; foreach ($datasppr as $v): $is_kosong = false; ?>
					<tr>
						<td><?php echo $v['KODEREKENING'] ?></td>
						<td>
							<?php echo $v['URAI'] ?>
							<input type="hidden" form="spprform" name="KODEAKUN[]" value="<?php echo $v['KODEAKUN'] ?>"/>
							<input type="hidden" form="spprform" name="KODEKELOMPOK[]" value="<?php echo $v['KODEKELOMPOK'] ?>"/>
							<input type="hidden" form="spprform" name="KODEJENIS[]" value="<?php echo $v['KODEJENIS'] ?>"/>
							<input type="hidden" form="spprform" name="KODEOBJEK[]" value="<?php echo $v['KODEOBJEK'] ?>"/>
						</td>
						<td class="text-right"><?php echo format_rupiah($v['ANGGARAN'], false) ?></td>
						<td class="text-right"><?php echo format_rupiah($v['LALU'], false) ?></td>
						<!--
						<td class="text-right">
							<div onclick="dnfle1(this)" data-past-value="<?php //echo $v['SEKARANG'] ?>" data-now-value="<?php //echo $v['SEKARANG'] ?>" data-max-value="<?php //echo $v['ANGGARAN'] ?>"><?php //echo format_rupiah($v['SEKARANG'], false) ?></div>
							<input type="hidden" form="spprform" name="nilai_sekarang[]" value="<?php //echo $v['SEKARANG'] ?>"/>
							<input type="hidden" form="spprform" name="nilai_lama[]" value="<?php //echo $v['SEKARANG'] ?>"/>
						</td>//
						-->
						<td class="text-right" id="td<?php echo $_id_td ?>">
							<!-- INPUT RINCIAN v2 -->
							<input onfocus="_rincian_arep(this)" onkeyup="_rincian_nulis(this,event)" onblur="_rincian_uwes(this)" onmousewheel="event.preventDefault()" onchange="$(this).trigger('keyup')" class="input-fake" form="spprform" value="<?php echo format_rupiah($v['SEKARANG'],false) ?>" step="0.01" min="0" max="<?php echo $v['SISA'] ?>" required/>
							<input type="hidden" form="spprform" name="nilai_sekarang[]" value="<?php echo $v['SEKARANG'] ?>"/>
							<input type="hidden" form="spprform" name="nilai_lama[]" value="<?php echo $v['SEKARANG'] ?>"/>
						</td>
						<td class="text-right"><?php echo format_rupiah($v['JUMLAH'], false) ?></td>
						<td class="text-right"><?php echo format_rupiah($v['SISA'], false) ?></td>
					</tr>
				<?php $_id_td++; endforeach; if ($is_kosong): ?>
					<tr><td colspan="7" class="text-center"><b>Data Kosong</b></td></tr>
				<?php endif ?>
			</table>
		</div>
		<?php if (!$is_kosong && $is_allow_edit): ?>
			<script>document.getElementById('pajak-kosong-hide-this').style.display = '';</script>
			<div class="hr-line-dashed"></div>
			<div class="row">
				<div class="col-md-6">&nbsp;</div>
				<div class="col-md-6 text-right">
					<button type="submit" class="btn btn-primary bd-rad-0 btn-sm" form="spprform">Simpan</button>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>
<div class="modal fade bs-example-modal-sm in" id="ubahpotonganpajak" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="fa fa-pencil"></span> Ubah Jumlah Potongan Pajak</h4>
        </div>
        <div class="modal-body">
             <?php echo form_open( 'spp2/ubah_potongan_pajak',array( 'class'=> 'form-horizontal', 'id')) ?>
          	<div class="row">
          		<center>
          			<div class="col-md-2">
          				<input type="hidden" id="txtkodeurusan" name="txtkodeurusan">
          				<input type="hidden" id="txtkodesuburusan" name="txtkodesuburusan">
          				<input type="hidden" id="textkodeorganisasi" name="textkodeorganisasi">
          				<input type="hidden" id="textkddesa" name="textkddesa">
          				<input type="hidden" id="textrekeningpotongan" name="textrekeningpotongan">
          				<input type="hidden" id="textno_spp" name="textno_spp">
          			</div>
          			<div class="col-md-6"><input type="number" class="form-control" name="textjumlah" id="textjumlah"></div>
          			<div class="col-md-4"><p align="left"><button type="submit" class="btn btn-info"><span class="fa fa-save"></span></button></p></div>
          		</center>
          	</div>
          	
          <?php echo form_close(); ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

<?php //$this->load->view('spp/misc/js-rem'); ?>
<?php //$this->load->view('spp/misc/print'); ?>
<?php if (!$is_kosong): ?>
<script>
winload(function() {
	$('#spp-rincian-table').dataTable({
		order: [],
		bLengthChange: false,
		language: id_dttable
	});
});
</script>
<?php endif ?>

<script>

/* FORM PAJAK */
var data_aturan_pajak = <?php echo json_encode(utf8ize($spprek)) ?>;
winload(function() {
	$.map(data_aturan_pajak, function(o) {
		o.id = o.KODEAKUN + '.' + o.KODEKELOMPOK + '.' + o.KODEJENIS + '.' + o.KODEOBJEK;
		o.text = o.id + ' - ' + o.URAI + ' (' + o.SINGKAT + ')';
	});
	$('#spp-inp-pajak').select2({
		data:data_aturan_pajak
	}).on('change', function() {
		var v = $(this).val(); if (v === '') return;
		var id = 'pjk_' + v.replace(/\./g,'-');
		if ($('#form_pajak').children('#' + id).length < 1) {
			$($('#tpl_pajak').html()).appendTo('#form_pajak').prop('id', id).each(function() {
				for (var i = 0; i < data_aturan_pajak.length; i++) {
					if (data_aturan_pajak[i]['id'] === v) {
						var d = data_aturan_pajak[i];
						$(this).find('p.form-control-static:first').text(d.URAI + ' ('+ d.SINGKAT +')');
						$(this).children('input.jp:first').val(d.SINGKAT);
						$(this).children('input.rp:first').val(v);
						break;
					}
				}
			});
		// } else {
			// $('#form_pajak').children('#' + id).remove();
		}
	});

});

/* RINCIAN INPUT-HANDLE */
var elm_allow_submit = {};
var rincian_allow = Boolean(<?php echo (int)$is_allow_edit ?>);
// nggo dataset, jquery-ne ora iso njukokke
function dnfle1(elm) {
	if (!rincian_allow) return;
	var $container = $(elm);
	var v = elm.dataset.nowValue; // data (now)
	var m = elm.dataset.maxValue; // data (max)
	var i = $container.parent().parent()[0].rowIndex;
	if(m < 1) return;
	if ($container.children('input:first').length > 0) return;
	$container.html('<input onkeyup="dnfle2(this,event)" onchange="dnfle2(this,event)" type="number" step="0.01" min="0" max="' + m + '"/><small class="show"/>');
	$container.children('input').val(v).prop('id', 'spprduit' + i).trigger('keyup').focus();
}
function dnfle2(elm,e) {
	// nek enter
	if (e.keyCode && e.keyCode === 13) { dnfle3(elm); return; }
	var $inp = $(elm);
	var v = Number(elm.value)+0;
	$inp.next().text(format_rupiah(v, false)).parent()[0].dataset.nowValue = v;
	$inp.parent().next().val(v);
}
function dnfle3(elm) {
	if(!elm.checkValidity()) {
		elm_allow_submit[elm.id] = false;
		elm.style.border = "2px solid red";
		return;
	}
	elm_allow_submit[elm.id] = true;
	$inp = $(elm);
	if ($inp.parent()[0].dataset.nowValue === $inp.parent()[0].dataset.pastValue) {
		delete elm_allow_submit[elm.id];
	}

	var v = Number(elm.value)+0;
	$inp.parent().html(format_rupiah(v, false));
}

/* SPP SUBMIT-HANDLE */
winload(function() {
	$('#spprform').on('submit', function(e) {
		var allow_submit = true;
		if (Object.keys(elm_allow_submit).length > 0) {
			for(var i in elm_allow_submit) {
				if (elm_allow_submit[i] === false) {
					allow_submit = false;
					break;
				}
			}
		} else {
			allow_submit = false;
			if ($('#form_pajak').children().length > 0) allow_submit = true; // pajak ning kene
		}
		if (!allow_submit) e.preventDefault();
	});
});

var dataspp = <?php echo json_encode(utf8ize($dataspp)) ?>;

/* SPP CETAK PDF */
/*
winload(function() {
	var kode = url_segment[3].split('-');
	cetak_get_pejabat(kode);

	current_cetak_url = url_cetak + '&nospp=' + dataspp.NO_SPP;
	current_cetak_url += '&tahun=' + dataspp.TAHUN;

	current_cetak_url += '&kodeurusan=' + kode[0];
	current_cetak_url += '&kodesuburusan=' + kode[1];
	current_cetak_url += '&kodeorganisasi=' + kode[2];
	current_cetak_url += '&kodedesa=' + kode[3];
});
*/

/* RINCIAN INPUT-HANDLE */
winload(function() {
	if (!rincian_allow) {
		$('#spp-rincian-table').find('.input-fake').prop('disabled', true);
	}
});
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
function _rincian_nulis(elm, ev) {
	if (ev.keyCode == 13) {
		ev.preventDefault();
	}
	if (elm.checkValidity()) {
		var v = Number(elm.value); if (isf(v)) v = v.toFixed(2);
		$(elm).next().val(v);
		elm.style.borderColor = '';
		var td_id = $(elm).parent().prop('id');
		var v_skrg = Number($(elm).next().val());
		var v_lama = Number($(elm).next().next().val());
		elm_allow_submit[td_id] = true;
		if (v_skrg === v_lama) delete elm_allow_submit[td_id];
	} else {
		elm.style.borderColor = 'red';
	}
}
// ubah potongan pajak 
	function _ubah_potongan_pajak(tahun, kdurusan, kdsuburusan, kdorganisasi, kddesa, rekeningpotongan,no_spp,jumlah) {
		$("#ubahpotonganpajak").modal();
			var jumlahpotongan = $('#textjumlah').val(jumlah);
			var txtkodeurusan = $('#txtkodeurusan').val(kdurusan);
			var txtkodesuburusan = $('#txtkodesuburusan').val(kdsuburusan);
			var textkodeorganisasi = $('#textkodeorganisasi').val(kdorganisasi);
			var textkddesa = $('#textkddesa').val(kddesa);
			var textrekeningpotongan = $('#textrekeningpotongan').val(rekeningpotongan);
			var textno_spp = $('#textno_spp').val(no_spp);
			var str = no_spp.replace(/_/g, "_");
			
		
		// $.ajax({
		// 	type :"POST",
		// 	url  :"<?php echo base_url()?>spp2/ubah_potongan_pajak/"+ tahun + '/' + kdurusan + '/' + kdsuburusan+ '/' + kdorganisasi +'/' + kddesa + '/' + rekeningpotongan + '/' + str + '/' +jumlah              
		// })

	}

// hapus potongan pajak
 function _hapus_potongan(tahun, kdurusan, kdsuburusan, kdorganisasi, kddesa, rekeningpotongan,no_spp) {
         var res = encodeURIComponent(no_spp);
         var decode = decodeURIComponent(res);
         var str = no_spp.replace(/_/g, "_");
       	swal({
       		title: "Apa anda yakin ?",
            text: "Anda akan menghapus data Rekening Potongan " + rekeningpotongan + " !",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal",
            closeOnConfirm: false
       	},
       	  function(isConfirm){ 
       	  		
       	  			if (isConfirm) {
       	  				$.ajax({

							type :"POST",
	                        url  :"<?php echo base_url()?>spp2/hapus_potongan_pajak/"+ tahun + '/' + kdurusan + '/' + kdsuburusan+ '/' + kdorganisasi +'/' + kddesa + '/' + rekeningpotongan + '/' + str,
	                        dataType :"html",
	                        cache :"false",
	                           success: function(isConfirm){
                                            swal({
                                                   title :"Informasi",
                                                   text : "Potongan Pajak Telah Dihapus.",
                                                   type : "success"
                                                },
                                                function(){
                                                    window.location.reload();
                                                })
                                            
                                        }
       	  			})
       	  			}else{
       	  				
       	  			}
       	  		
       	  }
       	// ,
       	// 	function () { 	
       	// 		window.location.href="<?php echo base_url(); ?>spp2/hapus_potongan_pajak/"+ tahun + '/' + kdurusan + '/' + kdsuburusan+ '/' + kdorganisasi +'/' + kddesa + '/' + rekeningpotongan + '/' + str
       	// 	}
       	);
      
    }
</script>
