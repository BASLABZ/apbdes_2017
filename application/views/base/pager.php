<ul class="pagination mg-y-b-0" id="paginaarr"></ul>

<script>
winload(function() {
	jQuery.fn.gin_paging = function(param) {

		// console.log($); // jq-object

		var opt = {
			format: '[<nncnn>]'
		};
		$.extend(opt, param);

		// console.log(opt);

		var paging_init = function() {
		};

		if (typeof $.fn.paging === 'undefined') {
			$.getScript("//cdn.io/plugin/jquery.paging.min.js", function() {
				paging_init();
			});
		} else {
			paging_init();
		}
	};

	$('#paginaarr').gin_paging({
		page: 1
	});
});
</script>
