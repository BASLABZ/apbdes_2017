<script>
function spp_rem_fn(fn) {
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
</script>