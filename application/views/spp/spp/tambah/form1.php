<input type="hidden" name="KODEURUSAN" class="spp-org"/>
<input type="hidden" name="KODESUBURUSAN" class="spp-org"/>
<input type="hidden" name="KODEORGANISASI" class="spp-org"/>
<input type="hidden" name="KODEDESA" class="spp-org"/>
<!-- kegiatan -->
<input type="hidden" name="KODEBIDANG" class="spp-prog"/>
<input type="hidden" name="KODEPROGRAM" class="spp-prog"/>
<input type="hidden" name="KODEKEGIATAN" class="spp-prog"/>

<div class="row">
	<div class="col-md-6"><?php $this->load->view('spp/spp/tambah/form1-kanan') ?></div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-6">
					<div class="form-group">
						<label>Penerima</label>
						<select class="form-control" id="pihak">
							<option value="Bendahara">Bendahara</option>
							<option value="pihakkeketiga">Pihak Ketiga</option>
						</select>
					</div>
			 </div>
		 </div>
		 <div id="bendahara">
		 		<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Bendahara:</label>
							<div class="input-group">
								<input name="NAMA_BENDAHARA" class="form-control inp-elm-bendahara" />
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" id="bdhr-entrypoint">
										<span class="glyphicon glyphicon-search"></span>
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>No. Rekening Bendahara:</label>
							<input name="NOREK_BENDAHARA" class="form-control inp-elm-bendahara" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>NPWP Bendahara:</label>
							<input name="NPWP_BENDAHARA" class="form-control inp-elm-bendahara" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama BANK:</label>
							<input name="NAMA_BANK" class="form-control inp-elm-bendahara" />
						</div>
					</div>
				</div>
		  </div>
		  <div id="pihakketiga" hidden>
		  <div class="form-group">
		  	<label>Penerima</label>
		  	<input type="text" class="form-control">
		  </div>
		
		  <div class="row">
		  	<div class="col-md-6">
		  		  <div class="form-group">
					<label>No. Rekening Perusahaan:</label>
					<input name="NOREK_PERUSAHAAN" class="form-control"/>
				</div>
		  	</div>
		  	<div class="col-md-6">
		  		<div class="form-group">
				  	<label>Nama BANK</label>
				  	<input type="text" class="form-control" name="NAMA_BANK" >
				</div>
		  	</div>
		  </div>
		<div class="form-group">
			<label>Nama Perusahaan:</label>
			<input name="NAMA_PERUSAHAAN" class="form-control" list="prshn_data" id="prshn"/>
			<datalist id="prshn_data">
				<?php foreach ($perusahaan as $v): ?>
					<option value="<?php echo $v['NAMA_PERUSAHAAN'] ?>" data-alamat="<?php echo $v['ALAMAT_PERUSAHAAN'] ?>" data-norek="<?php echo $v['NOREK_PERUSAHAAN'] ?>"></option>
				<?php endforeach ?>
			</datalist>
			<script>
				winload(function() {
					var timer;
					var $src = $('#prshn_data');
					var $tgt = $('.res-prshn', document.forms[0]);
					$('#prshn').on('input', function(ev) {
						var elm = this;
						timer && clearTimeout(timer);
						timer = setTimeout(function() {
							uudate(elm.value);
						}, 100);
					});

					function uudate(v) {
						if (v == '' || v == null || !v) return;
						var bad = true;
						$src.children().each(function() {
							if (this.value === v) {
								bad = false;
								var dat = this.dataset;
								for(var d in dat) {
									$tgt.map(function() {
										if (this.name.toLowerCase().indexOf(d) > -1) {
											this.value = dat[d];
										}
									});
								}
							}
						});
						if (bad) $tgt.val('');
					}
				});
			</script>
		</div>
		<!-- <div class="form-group">
			<label>NPWP Perusahaan:</label>
			<input name="NPWP_BENDAHARA" class="form-control" required/>
			
		</div> -->
		<div class="form-group">
			<label>Alamat Perusahaan:</label>
			<input name="ALAMAT_PERUSAHAAN" class="form-control res-prshn"/>
		</div>
		</div>
	</div>
</div>
	<div class="hr-line-dashed"></div>
	<p class="text-right"><button type="button" onclick="spp_btn_next1()" class="btn btn-sm btn-success bd-rad-0">Selanjutnya &rsaquo;</button></p>
<script>

function spp_btn_next1() {
	var b = true;
	$($form_active_tab.get(0).elements).map(function() {
		if (this.required === true) {
			if (this.value === '' || this.value === null) {
				b = false;
				return;
			}
		}
	});
	if (b) {
		$form_nav_link.get(1).click();
	} else {
		$('#form_btn_submit').trigger('click');
	}
}

winload(function() {
$('#pihak').on('change',function () {
		if(this.value == "Bendahara") {
          $('#bendahara').show();
          $('#pihakketiga').hide();
          
        }else if (this.value == "pihakkeketiga") {
        	$('#bendahara').hide();
          	$('#pihakketiga').show();	

        }
})
	function bdhrClass() {
		var cthat = this;
		this.$inp = $('input.inp-elm-bendahara', $form[0]).on('keydown', function(ev) {
			ev.preventDefault();
		});
		this.$btn = $('#bdhr-entrypoint');
		this.$mdl = $('#bdhr-modal').appendTo(document.body);
		this.$res = new Vue({
			el: '#bdhr-res',
			data: {
				list: [],
				search_query: '',
				is_loading: false,
				tr_head_trigger: 0,
				curr_kode: ''
			},
			watch: {
				curr_kode: function(a) {
					this.$data.is_loading = true;

					var vthat = this;
					$.get(base_url + 'svc2/get_bdhr_desa/' + a, function(d) {
						// console.log(d);
						vthat.$set('list', d);
					}).always(function() {
						vthat.$data.is_loading = false;
					});
					// this.$data.$set('list', []);
				}
			},
			computed: {
				dyn_tr_head: function() {
					if (typeof this.$els.tr_head !== 'undefined') {
						if (this.$data.tr_head_trigger !== this.$els.tr_head.children.length) {
							this.$data.tr_head_trigger = this.$els.tr_head.children.length;
						}
					} else {
						this.$nextTick(function() {
							this.$data.tr_head_trigger++;
						});
					}
					return this.$data.tr_head_trigger;
				}
			},
			methods: {
				slc_bdhr: function(obj) {
					obj.NAMA_BENDAHARA = obj.NAMA;
					obj.NPWP_BENDAHARA = obj.NPWP;
					obj.NAMA_BANK = obj.NAMABANK;
					obj.NOREK_BENDAHARA = obj.NOREKBANK;
					cthat.set(obj);
				}
			}
		});

		this.$btn.on('click', function() {
			cthat.$mdl.modal('show');
		});
	}
	bdhrClass.prototype.allow = function() {
		this.$btn.prop('disabled', false);
		this.reset();
	};
	bdhrClass.prototype.forbid = function() {
		this.$btn.prop('disabled', true);
		this.reset();
	};
	bdhrClass.prototype.reset = function() {
		this.$inp.val('');
	};
	bdhrClass.prototype.run = function(mtd) {
		this[mtd]();
	};
	bdhrClass.prototype.set = function(obj) {
		this.$inp.map(function() {
			this.value = obj[this.name];
		});
	};
	var bdhr = new bdhrClass();

	$form.prop('action', base_url + 'spp_/simpan_tambah');

	$.map(data.org, function(o) {
		o.id = o.KODE_PAN;
		o.text = o.URAI;
		return o;
	});

	$('#spp_inp_keg').select2({
		placeholder: '-- Pilih Kegiatan --',
		// minimumInputLength: 1,
		ajax: {
			url: (base_url + 'svc/slc2_kegiatan3/'),
			dataType: 'json',
			cache: true,
			data: function(param) {
				this.url += $('#spp_inp_org').val();
				if (param.term && param.term !== '') {
					this.url += '/' + param.term.replace(/\s+/g,'-');
				}
			},
			processResults: function(data) {
				$.map(data, function(o) {
					var kd = [
						o.KODEBIDANG,
						o.KODEPROGRAM,
						o.KODEKEGIATAN
					];
					o.id = kd.join('-');
					o.text = o.KEGIATAN;
				});
				return { results: data };
			}
		}
	}).on('change', function() {
		var v = $(this).val();
		if (v !== null) {
			sppinfo.$set('kegiatan', $(this).children(':selected').text());
			v = v.split('-');
			$form_active_tab.children('.spp-prog').each(function(i,o) {
				o.value = v[i];
			});
		} else {
			sppinfo.$set('kegiatan', null);
		}
		_ready_rician();
	});

	$('#spp_inp_org').select2({
		data: data.org
	}).on('change', function() {
		var v = $(this).val();
		$('#spp_inp_keg').val(null).trigger('change'); // reset kegiatan
		if (v === '') {
			$('#spp_inp_keg').prop('disabled', true);
			sppinfo.$set('spp', null);
			bdhr.run('forbid');
		} else {
			$('#spp_inp_keg').prop('disabled', false);

			sppinfo.$set('spp', $(this).children(':selected').text());

			bdhr.run('allow');
			bdhr.$res.$data.curr_kode = v;

			v = v.split('-');
			$form_active_tab.children('.spp-org').each(function(i,o) {
				o.value = v[i];
			});
		}
	}).trigger('change');

	$($form[0].NO_SPP).on('keyup', function() {
		sppinfo.$set('nospp', $(this).val());
	});

	$([$form[0].NO_SPP, $form[0].TGL_SPP]).on('change', function() {
		_ready_rician();
	});

	$($form[0].BULAN).select2({
		data:$.map(id_nama_bulan, function(item, idx) {
			return {
				id: (idx+1),
				text: item
			}
		})
	});

});


</script>