;(function(w,d) {

	// console.log(d);

	w.byid = function(id) {
		return d.getElementById(id);
	}

	var a = function(t,n) {
		var r,l,s;
		if (/^(css|both)$/.test(t)) {
			r = w.base_url+'resource/themes/default/css/plugins/';
			l = d.createElement('link');
			l.rel = 'stylesheet';
			l.href = r+n+'.css';
			document.head.appendChild(l);
		}
		if (/^(js|both)$/.test(t)) {
			jQuery.holdReady(true);
			r = w.base_url+'resource/themes/default/js/plugins/';
			s = d.createElement('script');
			s.src = r+n+'.js';
			s.async = false;
			s.onload = function() { jQuery.holdReady(false); };
			s.onerror = function() { jQuery.holdReady(false); };
			d.body.appendChild(s);
		}
	};
	// fungsi untuk load plugin (css/js) templat
	w.plug = a;

	var b = function(n) {
		jQuery.holdReady(true);
		var s = d.createElement('script');
		s.src = w.base_url+'resource/config/'+n+'.js';
		s.async = false; // http://stackoverflow.com/questions/7308908/waiting-for-dynamically-loaded-script/7308984#7308984
		s.onload = function() { jQuery.holdReady(false); };
		s.onerror = function() { jQuery.holdReady(false); };
		d.body.appendChild(s);
	};
	// fungsi untuk load js, pada module yg elu buat.
	w.module = b; // deprecated
	w.config = b;

	var c = function(f) {
		w.addEventListener('load', f, false);
	};
	// fungsi untuk menjalankan kode-js setelah website/jquery sudah diload
	// pustaka: http://stackoverflow.com/questions/9330102/two-window-onload-on-the-the-site
	w.winload = c;

	// pustaka: http://stackoverflow.com/questions/2998784/how-to-output-integers-with-leading-zeros-in-javascript/2998822#2998822
	var e = function(num, size) {
		size = size || 2;
		return ('000000000' + num).substr(-size);
	};
	w.lzero = e;

	/*
	w.RegExp.escape = function(str) {
		return str.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
	};
	*/

	var f = function(n) { return /\./.test(n.toString()); };
	w.isf = f;

	// ====================================================================

	c(function() {
		jQuery.fn.select2fluid = function(opt) {
			this[0].style['width'] = '100%';
			opt = opt || {};
			var s2opt = {};
			if (opt.nosbox) s2opt.minimumResultsForSearch = Infinity;
			this.select2();
			return this;
		};
		jQuery.fn.unselect2 = function() {
			if (typeof this.data('select2') !== 'undefined') this.select2('destroy');
			return this;
		};
		jQuery.fn.pwidth = function(p_int) {
			this.css('width',p_int);
			return this;
		};
		jQuery.fn.pagingin = function(param) {
			this.hide();
			var opt = {
				format: '[<nncnn>]',
				root: '<ul class="pagination mg-y-b-0"></ul>',
				total: 0,
				limit: 0,
				page: 0,
				act: $.noop
			};
			$.extend(opt, param);
			opt.elm = this.html(opt.root).children();
			// console.log(opt);

			var paging_init = function($elm) {
				var $paging = $elm.paging(opt.total, {
					format: opt.format,
					perpage: opt.limit,
					page: opt.page,
					onSelect: function(page) {
						// page tidak-sama-dengan opt.page
						if (page !== opt.page) {
							// console.log(opt.act(page));
							if (opt.act(page) === false) return;
							location.href = opt.act(page);
						}
					},
					onFormat: function(type) {
						switch (type) {
							case 'block': // n and c
								if (this.page === this.value) {
									return '<li class="active"><a>' + this.value + '</a></li>';
								} else {
									return '<li><a>' + this.value + '</a></li>';
								}
							case 'prev': // <
								if (this.page === this.value || this.value === 0) {
									return '<li class="disabled"><a>&lsaquo;</a></li>';
								} else {
									return '<li title="Laman: '+this.value+'"><a>&lsaquo;</a></li>';
								}
							case 'next': // >
								if (this.page === this.value || this.value === 0) {
									return '<li class="disabled"><a>&rsaquo;</a></li>';
								} else {
									return '<li title="Laman: '+this.value+'"><a>&rsaquo;</a></li>';
								}
							case 'first': // [
								if (this.page === this.value || this.value === 0) {
									return '<li class="disabled"><a class="bd-rad-0-force">&laquo;</a></li>';
								} else {
									return '<li title="Laman: '+this.value+'"><a class="bd-rad-0-force">&laquo;</a></li>';
								}
							case 'last': // ]
								if (this.page === this.value || this.value === 0) {
									return '<li class="disabled"><a class="bd-rad-0-force">&raquo;</a></li>';
								} else {
									return '<li title="Laman: '+this.value+'"><a class="bd-rad-0-force">&raquo;</a></li>';
								}
						}
					}
				});
			};

			if (opt.total > opt.limit) {
				this.show();
				if (typeof $.fn.paging === 'undefined') {
					$.getScript(w.base_url + "resource/jquery.paging.min.js", function() {
						paging_init(opt.elm);
					});
				} else {
					paging_init(opt.elm);
				}
			}

			return this;
		};
	});

})(window,document);

// http://stackoverflow.com/questions/12820312/equivalent-to-php-function-number-format-in-jquery-javascript/34817120#34817120
function number_format(number,decimals,dec_point,thousands_sep) {
	var str = number.toFixed(decimals?decimals:0).toString().split('.');
	var parts = [];
	for ( var i=str[0].length; i>0; i-=3 ) {
		parts.unshift(str[0].substring(Math.max(0,i-3),i));
	}
	str[0] = parts.join(thousands_sep?thousands_sep:',');
	return str.join(dec_point?dec_point:'.');
}
function format_rupiah(idr, rp) {
	rp = rp || false;
	var uang;
	if (idr === '' || idr === '0' || isNaN(idr)) {
		uang = "0,00";
	} else {
		uang = number_format(Number(idr),2,',','.');
	}
	if (rp) {
		return "Rp. " + uang;
	} else {
		return uang;
	}
}

// deprecated
function loader(dirfname) {
	var js = document.createElement('script');
	js.src = ginapp.url+'resource/config/'+dirfname+'.js';
	document.head.appendChild(js);
}

// deprecated
function plugger(ty,dirfname) {
	var proot,js,css;
	if (/^(css|both)$/.test(ty)) {
		proot = ginapp.url+'resource/themes/default/css/plugins/';
		css = document.createElement('link');
		css.rel = 'stylesheet';
		css.href = proot+dirfname+'.css';
		document.head.appendChild(css);
	}
	if (/^(js|both)$/.test(ty)) {
		proot = ginapp.url+'resource/themes/default/js/plugins/';
		js = document.createElement('script');
		js.src = proot+dirfname+'.js';
		document.head.appendChild(js);
	}
}

var id_nama_bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
var id_dttable = {
	lengthMenu: '_MENU_',
	info: 'Halaman _PAGE_ dari _PAGES_',
	infoEmpty: "Tidak ada data.",
	search: 'Pencarian',
	zeroRecords: 'Data tidak ditemukan.',
	paginate: { "next": "&rsaquo;", "previous": "&lsaquo;" },
	infoFiltered: "(filter dari _MAX_ item)"
};
