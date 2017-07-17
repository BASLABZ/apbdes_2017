<?php
//debug($sppdata);
// boleh edit atau tidak (berdasarkan hak akses)
$is_allow_edit = in_array($this->session->hakakses, array('ADMIN','OPERATORDESA'));
$this->load->view('base/select-2');
$this->load->view('base/ibox');
?>
<style scoped>
#spp_listtbgl_wrapper { padding-bottom: 0px !important; }
#spp_listtbgl_info { padding-top: 0px; }
</style>
<style type="text/css">
	.ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>

<?php $vd = $this->session->flashdata('spp_flash'); if ($vd !== null): ?>
	<div class="alert alert-<?php echo $vd['alert'] ?> alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<?php echo $vd['msg'] ?>
	</div>
<?php endif ?>

<div class="row">
	<div class="col-md-6">
		<div class="ibox"><div class="ibox-title"><h5><span class="fa fa-search"></span> Cari Desa</h5></div>
	<div class="ibox-content highlight-bas">
		<form action="javasript:void(0);" class="form-inline" id="spp-form">
			<select class="form-control input-sm" style="width: 99%" id="spp-inp-inst">
				<option value="0"> -- Pilih Kecamatan/Desa -- </option>
				<?php foreach ($res_inp_kec as $v): ?><option value="<?php echo implode('-', array($v['KODEORGANISASI'], $v['KODEDESA'])) ?>"><?php echo $v['URAI'] ?></option><?php endforeach ?>
			</select>
			<!-- <button type="submit" class="btn btn-sm btn-primary bd-rad-0">Tampilkan</button> -->
		</form>
	</div>
</div>
	</div>
</div>

<div class="ibox">

	<div class="ibox-title">
			<h5><span class="fa fa-list"></span> Daftar SPP</h5>
			<?php if ($is_allow_edit): ?>
			<?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?>  
			<p class="text-right">
				<a href="<?php echo base_url('spp_/tambah') ?>" class="btn btn-success btn-xs bd-rad-0" id="spp-inp-tambah"><span class="fa fa-plus"></span> Tambah</a>
			</p>
			<!-- <div class="hr-line-dashed"></div> -->
			<?php endif ?>	
		<?php endif ?>
		
	</div>
	<div class="ibox-content highlight-bas">
		<table class="table table-bordered table-hover" id="spp_listtbgl" width="100%">
			<thead>
				<tr>
					<th>No. SPP</th>
					<th>Tanggal</th>
					<th>Desa</th>
					<th>Perihal</th>
					<th class="text-right" style="width:84px !important;">Jumlah (Rp)</th>
					<!-- <th class="text-center w-10p">Tgl Dibuat</th> -->
					<th class="text-center w-10p" style="width:128px !important;">Aksi</th>

				</tr>
			</thead>
			<tbody>

		<?php $is_kosong = true; foreach ($sppdata['data'] as $v): $is_kosong = false;
			$org = array($v['KODEURUSAN'],$v['KODESUBURUSAN'],$v['KODEORGANISASI'],$v['KODEDESA']);
			$keg = array($v['KODEBIDANG'],$v['KODEPROGRAM'],$v['KODEKEGIATAN']);
		?><tr data-tahun="<?php echo $v['TAHUN'] ?>" data-kodeorg="<?php echo implode(',', $org); ?>" data-kodeprog="<?php echo implode(',', $keg) ?>" data-nospp="<?php echo urlencode($v['NO_SPP']) ?>">
			<td><?php echo $v['NO_SPP'] ?></td>
			<td><?php echo date_id($v['TGL_SPP']) ?></td>
			<td><?php echo $v['URAI_KEC'], ' - ', $v['URAI_DESA'] ?></td>
			<td><?php echo $v['URAI_PROG'] ?></td>
			<td class="text-right" data-sort="<?php echo $v['JUMLAH_SPP'] ?>"><?php echo format_rupiah($v['JUMLAH_SPP'], false) ?></td>
			<!-- <td class="text-center" title="<?php //echo $v['TGL_SPP'] ?>"><?php //echo explode(' ', $v['TGL_SPP'])[0] ?></td> -->
			<td class="text-center">
				
				<button onclick="spp_rincian_href($(this))" class="btn btn-primary btn-xs bd-rad-0 dim" data-toggle="tooltip" title="Rincian"><span class="glyphicon glyphicon-align-justify"></span></button>
				<button onclick="spp_print($(this))" class="btn btn-success btn-xs bd-rad-0 dim" data-toggle="tooltip" title="Cetak">
					<span class="glyphicon glyphicon-print"></span>
				</button>
				<?php if ($is_allow_edit): ?>
					<?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?> 
						<?php if ($v['STATUS_PERSETUJUAN'] == false): ?>
							<button onclick="spp_dit_href($(this))" class="btn btn-warning btn-xs bd-rad-0 dim" data-toggle="tooltip" title="Ubah">
								<span class="glyphicon glyphicon-pencil"></span>
							</button>
						<?php endif ?>
						<button onclick="spp_rem_href($(this))" class="btn btn-danger btn-xs bd-rad-0 dim" data-toggle="tooltip" title="Hapus">
							<span class="glyphicon glyphicon-remove"></span>
						</button>
					<?php endif ?>
				<?php endif ?>
			</td>
		</tr>
		<?php endforeach; if ($is_kosong): ?>
			<tr><td colspan="6" class="text-center">SPP Tidak Tersedia.</td></tr>
		<?php endif ?>

			</tbody>
		</table>
	</div>
</div>

<div class="modal fade modal-xl" id="idmodal-print" role="dialog">
    <div class="modal-dialog modal-xl" style="width: 65%;">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #ee6e73; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="fa fa-file"></span> CETAK</h4>
        </div>
        <div class="modal-body">
        		<?php if (!$is_kosong): ?><?php $this->load->view('spp/misc/print'); ?>
					<script>
					winload(function() {
						$('#spp_listtbgl').dataTable({
							order: [],
							bLengthChange: false,
							language: id_dttable
						}).find('[data-toggle="tooltip"]').tooltip();
					});
					</script><?php endif ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      
    </div>
  </div>


<?php //$this->load->view('spp/misc/js-rem'); ?><script>
var current_cetak_tr;

function spp_print($elm) {
	$('#idmodal-print').modal();
	var _tr = $elm.parent().parent()[0];
	var kd = _tr.dataset.kodeorg.split(',');
	var th = _tr.dataset.tahun;
	current_cetak_url = url_cetak + '&nospp=' + _tr.dataset.nospp;
	current_cetak_url += '&tahun=' + th;
	current_cetak_url += '&kodeurusan=' + kd[0];
	current_cetak_url += '&kodesuburusan=' + kd[1];
	current_cetak_url += '&kodeorganisasi=' + kd[2];
	current_cetak_url += '&kodedesa=' + kd[3];
	current_cetak_tr = _tr;
	cetak_get_pejabat(kd, function() {
		ke_cetak_form();
	});
}

function spp_rincian_href($elm) {
	var d = $elm.parent().parent().data();
	var u = base_url + 'spp2/rincian/' + d.kodeorg.split(',').join('-') + '?nomor=' + d.nospp;
	window.location.href = u;
};

function spp_dit_href($elm) {
	var d = $elm.parent().parent().data();
	var u = base_url + 'spp_/ubah/' + d.kodeorg.split(',').join('-') + '?nomor=' + d.nospp;
	window.location.href = u;
};
function spp_rem_fn(no_spp,fn) {
	
	swal({
		title: "Hapus SPP?",
		text: 'SPP akan dihapus beserta rincian-nya.',
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Ya",
		confirmButtonColor: "#DD6B55",
		cancelButtonText: "Tidak",
		cancelButtonColor: "#222222"
	},function(ya) {
		if (ya) fn();
	});
}
function spp_rem_href($elm) {
	var d = $elm.parent().parent().data();
	var nospp_old = d.nospp;
	var no_spp_deleted  = decodeURIComponent(nospp_old);
	swal({
		title: "Hapus SPP ?",
		text: 'SPP akan dihapus beserta rincian-nya, No SPP:'+no_spp_deleted,
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Ya",
		confirmButtonColor: "#DD6B55",
		cancelButtonText: "Tidak",
		cancelButtonColor: "#222222"
	},
	function (isConfirm) {
		if (isConfirm) {
				$.ajax({
					type :"POST",
                    url  :'<?php echo base_url()?>spp5/hapus/'+ d.kodeorg.split(',').join('-') + '?nomor=' + d.nospp,
                    dataType :"html",
                    cache :"false",
                    success: function(isConfirm){
	                    swal({
	                           title :"Informasi",
	                           text : "Potongan Pajak Telah Dihapus.",
	                           type : "success"
	                        },
	                        function(){
	                            // window.location.reload();
	                            var u = base_url + 'spp5/hapus/' + d.kodeorg.split(',').join('-') + '?nomor=' + d.nospp;
							    window.location.href = u;
							    
	                        })
	                    
	                }
				})
		}else{

		}
	}
	// ,function(ya) {
	// 	if (ya) {
	// 		var u = base_url + 'spp5/hapus/' + d.kodeorg.split(',').join('-') + '?nomor=' + d.nospp;
	// 		window.location.href = u;
	// 	}
	// }

	);
	
};

winload(function() {

	var $form = $('#spp-form'),
		$b_tambah = $('#spp-inp-tambah'),
		slc_seg3 = "<?php echo $slc_seg3 ?>",
		slc_val = /\-/.test(slc_seg3) ? slc_seg3 : 0;
		console.log(slc_val);

	var first = true;

	$('#spp-inp-inst').val(slc_val).select2().on('change', function() {
		var v = $(this).val();
		var u_index = base_url + 'spp3/index/' + v;
		$form.prop('action', u_index);
		console.log(u_index);
		if (/\-/.test(v)) {
			var u_tambah = base_url + 'spp_/tambah/' + v;
			console.log(u_tambah);
			// $b_tambah.prop('href', u_tambah);

		}

		// console.log(slc_val,v)
		if (slc_val != v) location.href = u_index;
		if (first) first = false;
			
		// if (slc_val === 0) {
		// 	location.href = u_index;
		// }

	}).trigger('change');

});
</script>

