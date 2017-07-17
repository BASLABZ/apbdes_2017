<script>
var curr_param_keg = null, is_wroking_keg = false;
var data = <?php echo json_encode(utf8ize($data)) ?>;

data.keg = {};

winload(function() {
	setTimeout(function() {
		var seg3 = url_segment['3'] || url_segment[3];
		if (seg3 && /\-/.test(seg3)) {
			var kdpan = '1-20-' + seg3;
		}
		$('#spp_inp_org').val(kdpan).trigger('change');
	}, 0);

});

// ============================================================= testing dummy data
/*
setTimeout(function() {
	winload(function() {
		var tgl_spp = '1996-05-22'; // untuk dummy waktu pelaksanaan
		$('#spp_inp_org').val('1-20-13-03').trigger('change'); // pilih organisasi

		$($form_nav_tab.get(0).elements).each(function() {
			var n = this.name;
			if (this.type === 'hidden' || /^inp/.test(n)) return; // skip

			if (/^TGL/.test(this.name)) {
				this.value = (new Date()).toISOString().slice(0,10);
				tgl_spp = this.value;
				return;
			}
			if (/^WAKTU/.test(n)) {
				if (tgl_spp) this.value = tgl_spp;
				$(this).blur();
				return;
			}
			if (/^BULAN/.test(this.name)) {
				var v = Math.floor(Math.random() * 10 + 3);
				$(this).val(v).trigger('change');
				return;
			}
			this.value = this.name + '-' + Math.random().toString().slice(2,7);
		});
	});
},0);
*/
</script>
