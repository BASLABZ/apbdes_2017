<input type="hidden" name="NO_SPP"/>
<input type="hidden" name="TAHUN"/>
<!-- organisasi -->
<input type="hidden" name="KODEURUSAN" class="spp-org"/>
<input type="hidden" name="KODESUBURUSAN" class="spp-org"/>
<input type="hidden" name="KODEORGANISASI" class="spp-org"/>
<input type="hidden" name="KODEDESA" class="spp-org"/>
<!-- kegiatan -->
<input type="hidden" name="KODEBIDANG" class="spp-prog"/>
<input type="hidden" name="KODEPROGRAM" class="spp-prog"/>
<input type="hidden" name="KODEKEGIATAN" class="spp-prog"/>

<div class="row">
	<div class="col-md-6"><?php $this->load->view('spp/spp/ubah/form1-kanan') ?></div>

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
				  	<input type="text" class="form-control" name="NAMA_BANK">
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
		<div class="form-group">
			<label>NPWP Perusahaan:</label>
			<input name="NPWP_BENDAHARA" class="form-control inp-elm-bendahara" required/>
		</div>
		<div class="form-group">
			<label>Alamat Perusahaan:</label>
			<input name="ALAMAT_PERUSAHAAN" class="form-control res-prshn"/>
		</div>
		<!-- <div class="form-group">
			<label>Nama perusahaan:</label>
			<input name="NAMA_PERUSAHAAN" class="form-control"/>
		</div>
		<div class="form-group">
			<label>Alamat perusahaan:</label>
			<input name="ALAMAT_PERUSAHAAN" class="form-control"/>
		</div>
		<div class="form-group">
			<label>No. rekening perusahaan:</label>
			<input name="NOREK_PERUSAHAAN" class="form-control"/>
		</div> -->

		<div class="hr-line-dashed"></div>

		<p class="text-right"><button type="button" onclick="spp_btn_next1()" class="btn btn-sm btn-success bd-rad-0">Selanjutnya &rsaquo;</button></p>

	</div>
</div>

<?php ob_start() ?>
<div id="bdhr-res">
	<div class="row">
	</div>
	<br/>
	<table class="table table-condensed table-bordered">
		<thead>
			<tr v-el:tr_head><th>Nama</th><th>Rekening</th><th>Bank</th><th>NPWP</th><th class="text-center">Aksi</th></tr>
		</thead>
		<tbody>
			<tr v-for="ppl in $data.list">
				<td>{{ppl.NAMA}}</td>
				<td>{{ppl.NOREKBANK || '-'}}</td>
				<td>{{ppl.NAMABANK || '-'}}</td>
				<td>{{ppl.NPWP || '-'}}</td>
				<td class="text-center">
					<button v-on:click="slc_bdhr(ppl)" data-dismiss="modal" class="btn btn-xs btn-success bd-rad-0">Pilih</button>
				</td>
			</tr>
			<tr v-if="$data.list.length < 1 && $data.is_loading">
				<td v-bind:colspan="dyn_tr_head" class="text-center">Loading...,</td>
			</tr>
			<tr v-if="$data.list.length < 1 && !$data.is_loading">
				<td v-bind:colspan="dyn_tr_head" class="text-center">Bendahara Tidak Tersedia.</td>
			</tr>
		</tbody>
	</table>
</div>
<?php $bdhr_modal_content = ob_get_clean() ?>

<div class="modal fade" id="bdhr-modal">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<?php $this->load->view('spp/spp/index', array(
				'content_title' => 'Pilih Bendahara',
				'content_body' => $bdhr_modal_content
			)) ?>
			<script>
				var bdhr_curr_script = document.currentScript;
				winload(function() {
					$(bdhr_curr_script).parent().each(function() {
						$(this).find('.ibox').css('margin-bottom',0);
					});
				});
			</script>
		</div>
	</div>
</div>
<script>

function spp_btn_next1() {
	if ($form_active_tab.get(0).checkValidity()) {
		$form_nav_link.get(1).click();
	} else {
		$('#form_btn_submit').trigger('click');
	}
}

// SET INPUT VALUE
winload(function() {
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

	$( $form_nav_tab.get(0).elements ).each(function() {
		var n = $(this).prop('name') || ''; if (n === '') return;
		var v = data.spp[n] || ''; if (v === '') return;

		if (/^TGL/.test(n)) {
			this.value = v.split(' ')[0];
			return;
		}

		this.value = v;
		if (/^(BULAN)/.test(n)) $(this).trigger('change');
	});
});

// RINCIAN-HANDLE
winload(function() {
	$( $form[0].TGL_SPP ).on('change', function() {
		_ready_rician();
	});

	$('#spp_inp_keg').trigger('change');
});
</script>