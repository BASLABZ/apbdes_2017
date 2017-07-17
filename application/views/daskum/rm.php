<script>
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