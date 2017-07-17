(function(w,$) {
	w.spp_fn_delete = function($elm) {
		swal({
			title: "Hapus Data?",
			type: "error",
			showCancelButton: true,
			confirmButtonText: "Ya",
			confirmButtonColor: "#DD6B55",
			cancelButtonText: "Tidak"
		},function(ya) {
			if (ya) w.location.href = $elm.data('href');
		});
	};
})(window, jQuery);
