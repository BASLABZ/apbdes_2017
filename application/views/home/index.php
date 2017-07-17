			<div class="row">
					<div class="col-md-3">
						<div class="widget red-bg p-lg text-center dim">
		                    <div class="row">
		                        <div class="col-xs-4">
		                            <i class="fa fa-edit fa-5x"></i>
		                        </div>
		                        <div class="col-xs-8 text-right">
		                            <span> Pembuatan Data </span>
		                            
		                            <h3 class="font-bold">SPP </h3>
		                            <p><a href="<?php echo base_url('spp') ?>" style="color: white;">Lihat Data  <span class="fa fa-arrow-right"></span></a> </p>
		                        </div>
		                    </div>
                		</div>
					</div>

					<div class="col-md-3">
						<div class="widget navy-bg p-lg text-center dim">
		                    <div class="row">
		                        <div class="col-xs-4">
		                            <i class="fa fa-check-square-o fa-5x"></i>
		                        </div>
		                        <div class="col-xs-8 text-right">
		                            <span> Informasi  </span>
		                            <h3 class="font-bold">Verifikasi SPP </h3>
		                            <p><a href="<?php echo base_url('verifikasi/persetujuan') ?>" style="color: white;">Lihat Data  <span class="fa fa-arrow-right"></span></a> </p>
		                        </div>
		                    </div>
                		</div>
					</div>

					<div class="col-md-3">
						<div class="widget widget style1 lazur-bg p-lg text-center dim">
		                    <div class="row">
		                        <div class="col-xs-4">
		                            <i class="fa fa-file-text fa-5x"></i>
		                        </div>
		                        <div class="col-xs-8 text-right">
		                            <span> Informasi </span>
		                            <h3 class="font-bold">Buku Kas Umum</h3>
		                            <p><a href="<?php echo base_url('bku/buku_kas_umum') ?>" style="color: white;">Lihat Data  <span class="fa fa-arrow-right"></span></a> </p>
		                        </div>
		                    </div>
                		</div>
					</div>

					<div class="col-md-3">
						<div class="widget widget style1 yellow-bg p-lg text-center dim">
		                    <div class="row">
		                        <div class="col-xs-4">
		                            <i class="fa fa-files-o fa-5x"></i>
		                        </div>
		                        <div class="col-xs-8 text-right">
		                            <span>  Laporan </span>
		                            <h3 class="font-bold"> Buku Kas Umum</h3>
		                            <p><a href="<?php echo base_url('laporan/laporan_bku') ?>" style="color: white;">Lihat Data  <span class="fa fa-arrow-right"></span></a> </p>
		                        </div>
		                    </div>
                		</div>
					</div>

				</div>
				<!-- <pre><?php //print_r($this->session->userdata()); ?></pre> -->
				<div class="ibox ">
					<div class="ibox-title" style="background-color:#ee6e73 ;color:white !important;">
						<h5><span class="fa fa-th-large"></span> Dashboard</h5>
					</div>	
					<div class="ibox-content highlight-bas">
						<div class="row">
							<div class="col-md-6 highlight-bas">
								<div id="container"  style="min-width: 310px; height: 400px; margin: 0 auto" ></div>
							</div>
							<div class="col-md-6 highlight-bas">
								<div id="containers"  style="height: 400px"></div>
							</div>
							<div class="col-md-12">
									<div class="hr-line-dashed"></div>
									<div id="jemb"><?php echo date('d F Y - H:i:s') ?></div>
							</div>
						</div>
						<!-- <h1>Selamat Datang <b><?php //echo $this->session->username ?></b> (<?php //echo $this->session->hakakses ?>)</h1> -->
						<?php echo "<pre>"; print_r($this->session->all_userdata()); echo "</pre>"; 
							echo "<pre>";
							print_r($this->input->user_agent());
							print_r($this->encrypt->encryption_key);
							echo "</pre>";

						?> 
					</div>
				</div>

				<script>
				(function() {
					var jm = byid('jemb');
					var dt = new Date('<?php echo date('D M d Y H:i:s O') ?>');
					setInterval(function() {
						var s = dt.getSeconds() + 1;
						dt.setSeconds(s);
						updt(s);
					},1000);

					function updt(s) {
						var tgl = lzero(dt.getDate()) + ' ' + [id_nama_bulan[dt.getMonth()]] + ' ' + dt.getFullYear();
						var wkt = lzero(dt.getHours()) + ':' + lzero(dt.getMinutes()) + ':' + lzero(s > 59 ? 0 : s);
						jm.innerText = tgl + ' - ' + wkt;
					}

				})();
				</script>
				<?php foreach ($totalsppall as  $value) : $JUMLAHSPP =  $value['JUMLAHSPP']; endforeach;  foreach ($SppVerifikasi as  $keyvalue) : $TOTOTALVERIFIKASI = $keyvalue['TOTOTALVERIFIKASI']; endforeach; 
				 foreach ($dataSppBelumVerifikasi as  $valuesppbelumverifikasi) : 
								$TOTOTALBELUMVERIFIKASI = $valuesppbelumverifikasi['TOTALSPPBELUMDIVERIFIKASI']; endforeach;
					foreach ($dinas as  $valueDinas) : $pemda = $valueDinas['PEMDA']; endforeach?>
				<script>
				//chart
					 winload(function(){
								    Highcharts.chart('container', {
								        chart: {
								            type: 'column',
								            backgroundColor: 'rgba(68, 236, 202, 0.88)'
								        },
								         credits: {
										      enabled: false
										  },
										colors: ['#23c6c8', '#ed5565'],
								        title: {
								            text: 'Charting SPP & Verifikasi'
								        },
								        subtitle: {
								            text: '<?php echo $pemda; ?>'
								        },
								        xAxis: {
								            categories: [
								                'SPP',
								               	'SPP yang di Setujui',
								               	'Spp lain'
								            ],
								            crosshair: true
								        },
								        yAxis: {
								            min: 0,
								            title: {
								                text: 'Jumlah'
								            }
								        },
								        tooltip: {
								            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
								            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
								                '<td style="padding:0"><b>{point.y:.1f} data</b></td></tr>',
								            footerFormat: '</table>',
								            shared: true,
								            useHTML: true
								        },
								        plotOptions: {
								            column: {
								                pointPadding: 0.2,
								                borderWidth: 0
								            }
								        },

								        series: [{
								           // name: 'Total SPP',
								          //  data: [<?php echo $JUMLAHSPP; ?>]

								        //}, {
								            name: 'Verifikasi',
								            data: [<?php echo $TOTOTALVERIFIKASI; ?>]

								        }, {
								            name: 'Belum Disetujui',
								            data: [<?php echo $TOTOTALBELUMVERIFIKASI; ?>]

								        }]

								    });
								    Highcharts.chart('containers', {
									    chart: {
									        type: 'pie',
								            backgroundColor: 'rgba(68, 236, 202, 0.88)',
									        options3d: {
									            enabled: true,
									            alpha: 45,
									            beta: 0
									        }
									    },
									    colors: ['#ed5565','#23c6c8'],
									    title: {
									        text: 'Pie Chart SPP & Verifikasi'
									    },
									    tooltip: {
									        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
									    },
									    plotOptions: {
									        pie: {
									            allowPointSelect: true,
									            cursor: 'pointer',
									            depth: 35,
									            dataLabels: {
									                enabled: true,
									                format: '{point.name}'
									            }
									        }
									    },
									    series: [{
									        type: 'pie',
									        name: 'Total',
									        data: [
									            //['Total SPP', <?php echo $JUMLAHSPP; ?>],
									            {
									                name: 'SPP Belum Disetujui',
									                y: <?php echo $TOTOTALBELUMVERIFIKASI; ?>,
									                sliced: true,
									                selected: true
									            },
									            ['SPP Terverfikasi', <?php echo $TOTOTALVERIFIKASI; ?>]
									        ]
									    }]
									});
								});
				</script>
