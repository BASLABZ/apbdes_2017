<!-- isi js/css  -->
<?php
include 'js_report_bku.php';

function kode($x, $y, $z) {
    return $x . "." . $y . "." . $z . " - ";
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-search"></span> Cari Laporan</h5>
            </div>
            <div class="ibox-content border-bottom highlight-bas">
                <form id="print_cetak_form" action="javascript:void(0);">
                <!-- <form action="<?php echo base_url() . 'laporan/laporan_bku/cetak'; ?>" method="POST"> -->
                    <div class="row highlight-bas" >
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Desa </label>
                                <div class="input-group w-100p"> 
                                    <select name="namadesa" class="select2" style='width: 100%;'  id="selectDesa"  required
                                       oninvalid="this.setCustomValidity('Desa Harus Dipilih !!')" onchange="this.setCustomValidity('')">                          
                                        <option value="">-- Pilih Kecamatan/Desa --</option>
                                        <?php foreach ($desa as $v): ?>
                                            <?php $set_select_desa = $v['KODEURUSAN'] . "." . $v['KODESUBURUSAN'] . "." . $v['KODEORGANISASI'] . "." . $v['KODEDESA']; ?>
                                            <option value="<?php echo $set_select_desa; ?>" <?php echo set_select('namadesa', $set_select_desa, (!empty($get_list_desa) && $get_list_desa == $set_select_desa ? TRUE : FALSE)); ?> ><?php echo $v['URAI']; ?></option>
                                        <?php endforeach ?>
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label> Jenis Laporan </label>
                                <div class="input-group w-100p">
                                    <select name="jenis_laporan" class="selectJenisLaporan" style='width: 100%;' required id="jenis_laporan" 
                                       oninvalid="this.setCustomValidity('Jenis Laporan Harus Dipilih !!')" onchange="this.setCustomValidity('')">
                                        <option value="" <?php if ($jnslaporan == "0"): ?> selected="selected" <?php endif ?>>-- Pilih Jenis Laporan --</option>
                                        <option value="1" <?php if ($jnslaporan == "1"): ?> selected="selected" <?php endif ?>>Laporan Buku Kas Umum</option>
                                        <option value="2" <?php if ($jnslaporan == "2"): ?> selected="selected" <?php endif ?>>Laporan Buku Kas Pembantu Kegiatan</option>
                                        <option value="3" <?php if ($jnslaporan == "3"): ?> selected="selected" <?php endif ?>>Laporan Buku Kas Pembantu Pajak</option>
                                        <option value="4" <?php if ($jnslaporan == "4"): ?> selected="selected" <?php endif ?>>Laporan Pembantu Simpanan Bank</option>
                                        <option value="5" <?php if ($jnslaporan == "5"): ?> selected="selected" <?php endif ?>>Laporan Pembantu Kas Tunai</option>
                                        <option value="6" <?php if ($jnslaporan == "6"): ?> selected="selected" <?php endif ?>>Laporan Buku Bank Desa</option>
                                        <option value="7" <?php if ($jnslaporan == "7"): ?> selected="selected" <?php endif ?>>Laporan Realisasi Semester Pertama</option>
                                        <option value="8" <?php if ($jnslaporan == "8"): ?> selected="selected" <?php endif ?>>Laporan Realisasi Semester Akhir</option>
                                        <option value="9" <?php if ($jnslaporan == "9"): ?> selected="selected" <?php endif ?>>Laporan Pertanggungjawaban Realisasi</option>
                                        <option value="10" <?php if ($jnslaporan == "10"): ?> selected="selected" <?php endif ?>>Lampiran I (Laporan Pertanggungjawaban Realisasi APBDesa)</option>
                                        <option value="11" <?php if ($jnslaporan == "11"): ?> selected="selected" <?php endif ?>>Lampiran II (Laporan Kekayaan Milik Desa)</option>
                                        <option value="12" <?php if ($jnslaporan == "12"): ?> selected="selected" <?php endif ?>>Lampiran III (Program Sektoral dan Program Daerah yang masuk ke Desa)</option>


                                    </select>
                                </div>                  
                            </div>
                        </div>
                        <div class="col-md-3" id="bulan" hidden>
                            <div class="form-group">
                                <label>Bulan </label>
                                <div class="input-group w-100p">
                                    <select name="bulanCetak"  class="selectBulanCetak" style='width: 100%;' 
                                       oninvalid="this.setCustomValidity('Bulan Harus Dipilih !!')" onchange="this.setCustomValidity('')">
                                        <option value="">-- Pilih Bulan --</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <!--                            <div class="input-group date">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar" id="tglfrom"></i>
                                                                </span>
                                                                <input type="text" placeholder="Bulan" class="form-control" id="tgl_awal" name="tgl_awal" style="width: 40% !important;" readonly>                         
                                                                <span class="input-group-addon"> s/d </span>
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar" id="tglto"></i>
                                                                </span>
                                                                <input type="text" placeholder="Tanggal Akhir" class="form-control" id="tgl_akhir" name="tgl_akhir">                                
                                                            </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Kepala Desa</label>
                                <div class="col-lg-10">
                                    <select name="kepala_desa" class="selectKepDesa" style='width:100%;' id="KepalaDesa" required
                                       oninvalid="this.setCustomValidity('Kepala Desa Harus Dipilih !!')" onchange="this.setCustomValidity('')">
                                        <option value="0">-- Pilih --</option>
                                    </select> 
                                </div><br></br>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nama</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Nama" class="form-control" name="namaKepdes" id="namaKepdes">
                                </div><br></br>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">NIP</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="NIP" class="form-control" name="nipKepdes" id="nipKepdes">
                                </div><br></br>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Tgl Cetak</label>
                                <div class="col-lg-10">
                                    <div class="input-group date">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar" id="tglcetak"></i>
                                        </span>
                                        <input type="text" placeholder="Tanggal Cetak" class="form-control" id="tgl_cetak" name="tgl_cetak" readonly>
                                    </div>
                                </div><br></br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bendahara</label>
                                <div class="col-lg-10">
                                    <select name="bendahara_desa" class="selectBendDesa" style='width: 100%;' id="BendaharaDesa">
                                        <option value="0">-- Pilih --</option>
                                    </select>
                                </div><br></br>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nama</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="Nama" class="form-control" id="namaBendes" name="namaBendes">
                                </div><br></br>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">NIP</label>
                                <div class="col-lg-10">
                                    <input type="text" placeholder="NIP" class="form-control" id="nipBendes" name="nipBendes">
                                </div><br></br>
                            </div>                                                
                        </div>
                    </div> 
                    <div class="col-sm-6"> 
                        <div class="form-group">
                            <label class="col-lg-2 control-label"></label>
                            <div class="col-lg-10">
                                <button class="btn btn-success dim" type="submit"><i class="fa fa-print"></i>&nbsp;&nbsp;<span class="bold">Cetak</span></button>                    
                            </div>
                        </div>
                    </div> <br></br>                  
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 100%; height: 100%">
        <div class="modal-content">
            <div class="modal-body pd-0">
                <style scoped>
                    iframe {
                        width: 100%;
                        height: 700px;
                    }
                </style>
                <iframe id="print_ifrm" src="javascript:void(0)" frameborder="0" marginwidth="0" marginheight="0"></iframe>
            </div>
        </div>
    </div>
</div>

