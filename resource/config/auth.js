(function() {

	// dapatkan tahun sekarang
	var tahun_ini = (new Date).getFullYear();

	// otomatis pilih tahunnya.
	// jadi tidak perlu select tahun lagi.
	$('#auth_pilih_tahun').val(tahun_ini);

})();
