</div>
</div>
<!-- Mainly scripts -->
<script src="<?php echo base_url('resource/themes/default/js/jquery-2.1.1.js') ?>"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js">
        </script>
<script src="<?php echo base_url('resource/themes/default/js/plugins/metisMenu/jquery.metisMenu.js') ?>"></script>
<!-- Custom and plugin javascript -->
<script src="<?php echo base_url('resource/themes/default/js/inspinia.js') ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/plugins/pace/pace.min.js') ?>"></script>
<!-- Secondary scripts -->
<script src="<?php echo base_url('resource/other/vue.js') ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/plugins/slimscroll/jquery.slimscroll.min.js') ?>"></script>
<!-- Plugin scripts -->
<script src="<?php echo base_url('resource/themes/default/js/plugins/sweetalert/sweetalert.min.js') ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/plugins/dataTables/datatables.min.js') ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/plugins/select2/select2.full.min.js') ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/plugins/datapicker/bootstrap-datepicker.js') ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/plugins/jquery.aphanumeric/autonumeric.js') ?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
<script src="//code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!-- koneversi rupiah -->
<script src="<?php echo base_url('resource/themes/default/js/konversirupiahLib.js'); ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/notify.min.js'); ?>"></script>
<!-- hightchart -->
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="<?php echo base_url('resource/themes/default/js/bootstrap3-typeahead.js'); ?>"></script>
<script src="<?php echo base_url('resource/themes/default/js/bootstrap3-typeahead.min.js'); ?>"></script>

<script>
$(".logout").click(function(e) {
	e.preventDefault();
	swal({
		title: "",
		text: "Apa anda yakin akan keluar dari sistem ?",
		type: "warning",
		showCancelButton: true,
		cancelButtonText: "Tidak",
		confirmButtonText: "Ya",
		confirmButtonColor: "#DD6B55"
	},
	function(isConfirm) {
		if (isConfirm) window.location.href = base_url+'auth/logout';
	});
});

//datatable
$("#datatable").DataTable({
	"language": {
        // "lengthMenu": "_MENU_ item per halaman",
        "lengthMenu": "",
        "zeroRecords": "Data tidak ditemukan",
        "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
        "infoEmpty": "Tidak ada data",
        "sSearch": "Pencarian",
        "infoFiltered": "(Filter dari _MAX_ total item)"
    }
});

</script>
</body></html>