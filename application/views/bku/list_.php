<!-- isi js/css  -->
<?php include 'js_bku.php';?>
<!-- halaman list -->
<!-- pencarian -->
<?php echo $this->session->flashdata('Sukses'); ?>
<?php echo $this->session->flashdata('Gagal'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Cari BKU</h5>
            </div>
            <div class="ibox-content">
                <form method="post" action="<?php echo base_url('bku/buku_kas_umum') ?>">
                    <div class="form-group">
                        <div class="col-sm-1" style="width:10%;">
                            <label>Desa</label>                        
                        </div>
                        <div class="col-sm-6">
                            <select id="koderekening" class="select2" style='width: 400px;' name="selectDesa">
                                <option value="0">-- Pilih Kecamatan/Desa --</option>
                                <?php foreach ($data_desa as $value): ?>   
                                <?php $set_select_desa = $value['KODEURUSAN'].".".$value['KODESUBURUSAN'].".".$value['KODEORGANISASI'].".".$value['KODEDESA']; ?>                              
                                <option value="<?php echo $set_select_desa; ?>" 
                                        <?php if ($set_select_desa==$rs_input['koderekening']): ?> selected="selected"   
                                        <?php else: ''?><?php endif ?>>
                                    <?php echo $value['URAI']; ?>
                                </option>
                                <?php endforeach ?> 
                            </select>
                        </div>
                    </div>
                    <br></br>
                <div class="form-group">
                    <div class="col-sm-1" style="width:10%;">
                        <label>Jenis</label>                        
                    </div>
                    <div class="col-sm-6">
                        <select class="selectJurnal" style='width: 200px;' name="jenisJurnal">
                            <option value="SEMUA" <?php if ($rs_input['jenis_jurnal']=='SEMUA'): ?> selected="selected"<?php endif ?>>-- Semua Jenis --</option>
                            <option value="PENERIMAAN" <?php if ($rs_input['jenis_jurnal']=='PENERIMAAN'): ?> selected="selected"<?php endif ?>>SPJ PENERIMAAN</option>
                            <option value="SPJ" <?php if ($rs_input['jenis_jurnal']=='SPJ'): ?> selected="selected"<?php endif ?>>SPJ PENGELUARAN</option>
                            <option value="PAJAK" <?php if ($rs_input['jenis_jurnal']=='PAJAK'): ?> selected="selected"<?php endif ?>>Pajak</option>
                            <option value="PERGESERAN" <?php if ($rs_input['jenis_jurnal']=='PERGESERAN'): ?> selected="selected"<?php endif ?>>Pergeseran</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-sm-1" style="width:10%;">
                        <label>Bulan</label>
                    </div>
                    <div class="col-sm-6">
                        <select id="electBulan" class="selectBulan" name="bulan" style='width: 200px;'>
                            <option value="0" <?php if ($rs_input['bulan']==0): ?> selected="selected"<?php endif ?>>-- Pilih Bulan --</option>
                            <option value="1" <?php if ($rs_input['bulan']==1): ?> selected="selected"<?php endif ?>>Januari</option>
                            <option value="2" <?php if ($rs_input['bulan']==2): ?> selected="selected"<?php endif ?>>Februari</option>
                            <option value="3" <?php if ($rs_input['bulan']==3): ?> selected="selected"<?php endif ?>>Maret</option>
                            <option value="4" <?php if ($rs_input['bulan']==4): ?> selected="selected"<?php endif ?>>April</option>
                            <option value="5" <?php if ($rs_input['bulan']==5): ?> selected="selected"<?php endif ?>>Mei</option>
                            <option value="6" <?php if ($rs_input['bulan']==6): ?> selected="selected"<?php endif ?>>Juni</option>
                            <option value="7" <?php if ($rs_input['bulan']==7): ?> selected="selected"<?php endif ?>>Juli</option>
                            <option value="8" <?php if ($rs_input['bulan']==8): ?> selected="selected"<?php endif ?>>Agustus</option>
                            <option value="9" <?php if ($rs_input['bulan']==9): ?> selected="selected"<?php endif ?>>September</option>
                            <option value="10" <?php if ($rs_input['bulan']==10): ?> selected="selected"<?php endif ?>>Oktober</option>
                            <option value="11" <?php if ($rs_input['bulan']==11): ?> selected="selected"<?php endif ?>>November</option>
                            <option value="12" <?php if ($rs_input['bulan']==12): ?> selected="selected"<?php endif ?>>Desember</option>
                        </select>
                    </div>
                </div>
                <br></br>
            <div class="form-group">
                <div class="col-sm-1" style="width:10%;">
                    <label></label>
                </div>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-primary bd-rad-0">Tampilkan</button>
                </div>
            </div>
            <br>
            </form>
    </div>
</div>
</div>
</div>
<!-- daftar BKU -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Daftar BKU</h5>
            </div>
            <div class="ibox-content border-bottom">
                <div align="right">               
                    <div class="input-group-btn">
                        <?php if ($rs_input['koderekening']==""): ?>
                        <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button" aria-expanded="true" disabled>Tambah <span class="caret"></span></button>
                        <?php else: ?>
                        <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button" aria-expanded="true">Tambah <span class="caret"></span></button>
                        <?php endif ?>                   
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#" data-target="#modalSPJPenerimaan" data-toggle="modal">SPJ Penerimaan</a></li>
                            <li class="divider"></li>
                            <li><a href="#" data-target="#modalSPJ" data-toggle="modal">SPJ Pengeluaran</a></li>
                            <li class="divider"></li>
                            <li><a href="#" data-target="#modalPajak" data-toggle="modal" id="addPajak">Pajak</a></li>
                            <li class="divider"></li>
                            <li><a href="#" data-target="#modalPergeseran" data-toggle="modal" id="tambah_pergeseran">Pergeseran</a></li>  
                        </ul>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="table-responsive">
                    <div class='dataTables_wrapper form-inline dt-bootstrap no-footer'>
                        <table class="table table-bordered" id="datatablebku">
                            <thead>
                                <tr>                                    
                                    <th>No BKU</th>
                                    <th>Tanggal BKU</th>
                                    <th>Urai</th>
                                    <th>Penerimaan</th>
                                    <th>Pengeluaran</th>
                                    <th>Jenis</th>
                                    <th>Bukti</th>
                                    <th></th>
                                    <th class="hide"></th>
                                    <th class="hide"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach ($rs_bku as $result): ?>
                                <tr>                                    
                                    <td align="center" width="5%" id="no_bku"><?php echo $result['NO_BKU'] ?></td>
                                    <td align="center" width="10%" id="tgl_bku"><?php echo date("d-M-Y",strtotime($result['TGL_BKU'])) ?></td>
                                    <td align="left" width="30%" id="uraian"><?php echo $result['URAIAN'] ?></td>
                                    <td align="right" width="10%" id="penerimaan"><?php echo number_format($result['PENERIMAAN'],0,",",".") ?></td>
                                    <td align="right" width="10%" id="pengeluaran"><?php echo number_format($result['PENGELUARAN'],0,",",".") ?></td>
                                    <td align="center" width="10%" id="jenis_bku"><?php echo $result['JENIS_BKU'] ?></td>
                                    <td align="left" width="10%" id="bukti"><?php echo $result['BUKTI'] ?></td>
                                    <td align="center" width="15%">                                        
                                        <?php if ($result['JENIS_BKU']=='SIMPANAN-BANK' || $result['JENIS_BKU']=='KAS-TUNAI'): ?>
                                            <a href="#" data-id="<?php echo $result['NO_BKU'].'|'.$result['BUKTI'].'|'.$result['JENIS_BKU'].'|'.$result['URAIAN'].'|'.number_format($result['PENERIMAAN'],0,",",".").'|'.number_format($result['PENGELUARAN'],0,",",".").'|'.date("d/m/Y",strtotime($result['TGL_BKU'])).'|'.date("d/m/Y",strtotime($result['TGL_BUKTI'])) ?>" data-target="#modalEditPergeseran" data-toggle="modal" class="btn btn-primary btn-xs bd-rad-0" id="ubah_pergeseran" data-placement="bottom" title="Ubah"><span class="glyphicon glyphicon-pencil"></span></a>                                            
                                        <?php elseif($result['JENIS_BKU']=='SPJ' || $result['JENIS_BKU']=='SPP'): ?>
                                            <a href="#" data-id="<?php echo $result['NO_BKU'].'|'.$result['BUKTI'].'|'.$result['JENIS_BKU'].'|'.$result['URAIAN'].'|'.number_format($result['PENERIMAAN'],0,",",".").'|'.number_format($result['PENGELUARAN'],0,",",".").'|'.date("d/m/Y",strtotime($result['TGL_BKU'])).'|'.date("d/m/Y",strtotime($result['TGL_BUKTI'])) ?>" data-target="#modalEditSPJ" data-toggle="modal" class="btn btn-primary btn-xs bd-rad-0" id="ubah_spj" data-placement="bottom" title="Ubah"><span class="glyphicon glyphicon-pencil"></span></a>                                            
                                        <?php elseif($result['JENIS_BKU']=='PENERIMAAN'): ?>
                                            <a href="#" data-id="<?php echo $result['NO_BKU'].'|'.$result['BUKTI'].'|'.$result['JENIS_BKU'].'|'.$result['URAIAN'].'|'.number_format($result['PENERIMAAN'],0,",",".").'|'.number_format($result['PENGELUARAN'],0,",",".").'|'.date("d/m/Y",strtotime($result['TGL_BKU'])).'|'.date("d/m/Y",strtotime($result['TGL_BUKTI'])) ?>" data-target="#modalEditPenerimaan" data-toggle="modal" class="btn btn-primary btn-xs bd-rad-0" id="ubah_spj_penerimaan" data-placement="bottom" title="Ubah"><span class="glyphicon glyphicon-pencil"></span></a>
                                        <?php else: ?>
                                            <a href="#" data-id="<?php echo $result['NO_BKU'].'|'.$result['BUKTI'].'|'.$result['JENIS_BKU'].'|'.$result['URAIAN'].'|'.number_format($result['PENERIMAAN'],0,",",".").'|'.number_format($result['PENGELUARAN'],0,",",".").'|'.date("d/m/Y",strtotime($result['TGL_BKU'])).'|'.date("d/m/Y",strtotime($result['TGL_BUKTI'])) ?>" data-target="#modalEditPajak" data-toggle="modal" class="btn btn-primary btn-xs bd-rad-0" id="ubah_pajak" data-placement="bottom" title="Ubah"><span class="glyphicon glyphicon-pencil"></span></a>                                            
                                        <?php endif ?>                                        
                                        <a href="javascript:_hapus(<?php echo $result['TAHUN'].','.$result['KODEURUSAN'].','.$result['KODESUBURUSAN'].','.$result['KODEORGANISASI'].','.$result['KODEDESA'].','.$result['NO_BKU']?>)" class="btn btn-danger btn-xs bd-rad-0" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="glyphicon glyphicon-remove"></span></a>
                                    </td>
                                    <td id="bulan" class="hide"><?php echo $rs_input['bulan'] ?></td>
                                    <td id="jenis_jurnal" class="hide"><?php echo $rs_input['jenis_jurnal'] ?></td>
                                </tr>
                                <?php endforeach ?>  
                                                              
                            </tbody>
                            <?php if (count($rs_bku) !== 0): ?>
                            <tfoot> 
                                <?php foreach ($rs_total as $total): ?>                       
                                <tr>
                                    <td align="center" width="5%"></td>
                                    <td align="center" width="10%"></td>
                                    <td align="right" width="30%"><b>Jumlah Bulan <?php echo $dataBulan; ?></b></td>
                                    <td align="right" width="10%"><b><?php echo number_format($total['TOTALPENERIMAAN'],0,",",".") ?></b></td>
                                    <td align="right" width="10%"><b><?php echo number_format($total['TOTALPENGELUARAN'],0,",",".") ?></b></td>
                                    <td align="right" width="10%"></td>
                                    <td align="left" width="10%"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="left"><b>Kas Bulan Lalu</b></td>
                                    <td align="right"><b>0,00</b></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" align="left"><b>Kas di Bendahara Pengeluaran</b></td>
                                    <td align="right"><b>0,00</b></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="left" style="border-bottom:none;border-right:none;"><b>TUNAI</b></td>
                                    <td align="left" style="border-bottom:none;border-right:none;"><b>: 0,00</b></td>
                                    <td align="left" style="border-bottom:none;border-right:none;"><b>Surat Berharga</b></td> 
                                    <td colspan="4" align="left" style="border-bottom:none;border-right:none;"><b>: 0,00</b></td>                           
                                </tr>
                                <tr>
                                    <td colspan="2" align="left" style="border-top:none;border-right:none;"><b>SALDO DI BANK</b></td> 
                                    <td align="left" style="border-top:none;border-right:none;"><b>: 0,00</b></td> 
                                    <td colspan="5" style="border-top:none;"></td>                          
                                </tr>   
                                <?php endforeach ?>                         
                            </tfoot>
                            <?php endif ?> 
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal SPJ Penerimaan -->
<div class="modal fade bs-example-modal-lg" id="modalSPJPenerimaan"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/add_spj_penerimaan') ?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Form Tambah SPJ Penerimaan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">                        
                        <div class="form-group"> 
                            <input type="hidden" value="<?php echo $rs_input['koderekening']; ?>" name="koderekening">  
                            <input type="hidden" value="<?php echo $rs_input['bulan']; ?>" name="bulan">                   
                            <input type="hidden" value="<?php echo $rs_input['jenis_jurnal']; ?>" name="jenisJurnal">                   
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>No. BKU</label>
                                            <input type="text" class="form-control" value="<?php echo $nobku; ?>" name="no_bku" required 
                                               oninvalid="this.setCustomValidity('Nomer BKU harus diisi !!')" onchange="this.setCustomValidity('')" readonly>
                                        </div>
                                    </div>
                                    <label>No. Bukti SPJ</label>                                    
                                        <input type="text" class="form-control" id="bukti_penerimaan" placeholder="No Bukti" name="no_bukti" required
                                           oninvalid="this.setCustomValidity('Nomer Bukti SPJ harus diisi !!')" onchange="this.setCustomValidity('')" />
                                                                                    
                                    <label>Uraian</label>
                                    <textarea type="text" class="form-control" id="uraian_spj" style="width:100%;" rows="5" name="uraian" required oninvalid="this.setCustomValidity('Uraian harus diisi !!')" onchange="this.setCustomValidity('')"></textarea>                                                    
                                    <br> 
                                </div>                                    
                                <div class="col-md-6">
                                    <label>Tgl BKU</label>
                                    <div class='input-group date' style="width: 70%;" >
                                        <input type="text" class="form-control tanggal_modal" id="tgl_bku_spj" placeholder="dd/mm/yyyy" name="tgl_bku" required
                                               oninvalid="this.setCustomValidity('Tanggal BKU harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <label>Tgl Bukti</label>
                                    <div class='input-group date' style="width: 70%;">
                                        <input type="text" class="form-control tanggal_modal" id="tgl_bukti_spj" placeholder="dd/mm/yyyy" name="tgl_bukti" required
                                               oninvalid="this.setCustomValidity('Tanggal Bukti harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div> 
                        </div>
                    </div>                    
                        <table class="table table-bordered table-stripted" id="table_trans">
                            <thead>
                                <tr>
                                    <th width="20%">Kode Rekening</th>
                                    <th>Urai Rekening</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="data_spj_penerimaan">
                                <tr>
                                    <td align="left" id="kode_rekening">
                                        <a href="#" data-target="#modal_kode_rekening" data-toggle="modal" class="btn btn-primary btn-xs bd-rad-0" data-placement="bottom" title="Cari Rekening" style="float: right;"><span class="glyphicon glyphicon-search"></span></a>
                                    </td>
                                    <td id="urai_rekening">&nbsp</td>
                                    <td id="jml_rekening">&nbsp</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Jumlah</strong></td>
                                    <td>&nbsp</td>
                                    <td align='right' id='total_penerimaan'><strong id="jumlah_all">0</strong><input type="hidden" name="jumlah_all_terima" id="jumlah_all_terima" value="0" ></td>
                                </tr>
                            </tfoot>
                        </table>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="simpan btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Kode Rekening -->
<div class="modal fade bs-example-modal-lg" id="modal_kode_rekening">
    <div class="modal-dialog modal-xl" style="width: 65%;">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/add_spj_penerimaan') ?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Pilih Rekening</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <table class="table table-bordered table-stripted header-fixed tableRekening" id="datatableRekening">
                            <thead>
                                <tr>
                                    <th width="20%" class="kodeRek">Kode Rekening</th>
                                    <th width="80%" class="uraiRek">Urai Rekening</th>
                                    <!-- <th>Jumlah</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekening as $result): ?>
                                <tr>
                                    <td width="20%"><?php echo $result['KODEREKENING']; ?></td>
                                    <td width="80%"><?php echo $result['URAI']; ?></td>
                                    <!-- <td>0</td> -->
                                </tr>
                            <?php endforeach ?>
                            </tbody>                            
                        </table>     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="simpan btn btn-primary" onclick="pilihRekening()">Pilih</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah SPJ Penerimaan -->
<div class="modal fade bs-example-modal-lg" id="modalEditPenerimaan"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/edit_spj_penerimaan') ?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Form Ubah SPJ Penerimaan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">                        
                        <div class="form-group"> 
                            <input type="hidden" value="<?php echo $rs_input['koderekening']; ?>" name="koderekening">  
                            <input type="hidden" value="<?php echo $rs_input['bulan']; ?>" name="bulan">                   
                            <input type="hidden" value="<?php echo $rs_input['jenis_jurnal']; ?>" name="jenisJurnal">
                            <input type="hidden" value="<?php echo $rs_input['tahun']; ?>" name="tahun">                                      

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>No. BKU</label>
                                            <input type="text" class="form-control" id="edit_no_bku_spj" name="no_bku" required 
                                       oninvalid="this.setCustomValidity('Nomer Bukti SPJ harus diisi !!')" onchange="this.setCustomValidity('')" readonly>
                                        </div>
                                    </div>
                                    <br>
                                    <label>No. Bukti SPJ</label>                                    
                                        <input type="text" class="form-control" id="bukti_penerimaan" placeholder="No Bukti" name="no_bukti" required
                                           oninvalid="this.setCustomValidity('Nomer Bukti SPJ harus diisi !!')" onchange="this.setCustomValidity('')" />
                                    <!-- <label>Jenis Pembayaran</label><br>
                                    <label class="checkbox-inline">
                                        <input type="radio" name='is_pihak_ketiga' value="0" checked> Kas Bendahara </input>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" name='is_pihak_ketiga' value="1"> Pihak Ketiga </input> 
                                    </label>                                    
                                    <br>  -->                                                    
                                    <label>Uraian</label>
                                    <textarea type="text" class="form-control" id="uraian_spj" style="width:100%;" rows="5" name="uraian" required oninvalid="this.setCustomValidity('Uraian harus diisi !!')" onchange="this.setCustomValidity('')"></textarea>                                                    
                                    <br> 
                                </div>                                    
                                <div class="col-md-6">
                                    <label>Tgl BKU</label>
                                    <div class='input-group date' style="width: 70%;" >
                                        <input type="text" class="form-control tanggal_modal" id="tgl_bku_penerimaan" placeholder="dd/mm/yyyy" name="tgl_bku" required
                                               oninvalid="this.setCustomValidity('Tanggal BKU harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                    <label>Tgl Bukti</label>
                                    <div class='input-group date' style="width: 70%;">
                                        <input type="text" class="form-control tanggal_modal" id="tgl_bukti_penerimaan" placeholder="dd/mm/yyyy" name="tgl_bukti" required
                                               oninvalid="this.setCustomValidity('Tanggal Bukti harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div> 
                        </div>
                    </div>                    
                        <table class="table table-bordered table-stripted" id="table_edit_trans">
                            <thead>
                                <tr>
                                    <th width="20%">Kode Rekening</th>
                                    <th>Urai Rekening</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="edit_data_spj_penerimaan">
                                <tr>
                                    <td align="left" id="kode_rekening">
                                        <a href="#" data-target="#modal_edit_kode_rekening" data-toggle="modal" class="btn btn-primary btn-xs bd-rad-0" data-placement="bottom" title="Cari Rekening" style="float: right;"><span class="glyphicon glyphicon-search"></span></a>
                                    </td>
                                    <td id="urai_rekening">&nbsp</td>
                                    <td id="jml_rekening">&nbsp</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Jumlah</strong></td>
                                    <td>&nbsp</td>
                                    <td align='right' id='total_edit_penerimaan'><strong id="jumlah_all_edit">0</strong><input type="hidden" name="jumlah_all_terima_edit" id="jumlah_all_terima_edit" value="0" ></td>
                                </tr>
                            </tfoot>
                        </table>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="simpan btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Ubah Kode Rekening -->
<div class="modal fade bs-example-modal-lg" id="modal_edit_kode_rekening">
    <div class="modal-dialog modal-xl" style="width: 65%;">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/add_spj_penerimaan') ?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Pilih Rekening</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <table class="table table-bordered table-stripted header-fixed tableRekening" id="editDatatableRekening">
                            <thead>
                                <tr>
                                    <th width="20%" class="kodeRek">Kode Rekening</th>
                                    <th width="80%" class="uraiRek">Urai Rekening</th>
                                    <!-- <th>Jumlah</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekening as $result): ?>
                                <tr>
                                    <td width="20%"><?php echo $result['KODEREKENING']; ?></td>
                                    <td width="80%"><?php echo $result['URAI']; ?></td>
                                    <!-- <td>0</td> -->
                                </tr>
                            <?php endforeach ?>
                            </tbody>                            
                        </table>     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="simpan btn btn-primary" onclick="pilihEditRekening()">Pilih</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>

<!-- Modal SPJ-->
<div class="modal fade bs-example-modal-lg" id="modalSPJ"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/add_spj') ?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Form Tambah SPP BKU</h4>
                </div>
                <div class="modal-body">
                    <div class="row">                        
                        <div class="form-group"> 
                            <input type="hidden" value="<?php echo $rs_input['koderekening']; ?>" name="koderekening">  
                            <input type="hidden" value="<?php echo $rs_input['bulan']; ?>" name="bulan">                   
                            <input type="hidden" value="<?php echo $rs_input['jenis_jurnal']; ?>" name="jenisJurnal">                   
                            <div class="col-md-6">
                                <div class="row">
                                <div class="col-md-4">
                                <label>No. BKU</label>
                                <input type="text" class="form-control" id="no_bku_spj" value="<?php echo $nobku; ?>" name="no_bku" required 
                                       oninvalid="this.setCustomValidity('Nomer BKU harus diisi !!')" onchange="this.setCustomValidity('')" readonly>
                                </div>
                                <div class="col-md-8">
                                <label>Jenis Transaksi</label><br>
                                <select class="form-control" name='jenistransaksi' id="jenistransaksi" >
                                    <option value="NUL">--Pilih Jenis Transaksi--</option>
                                    <option value="SPP">SPP</option>
                                    <option value="SPJ">SPJ</option>                                    
                                </select>
                                </div>
                                </div>
                                <br>
                                <label id="judul_no_bku">No. Bukti SPP</label>
                                <select class="nospp form-control" style='width: 100%;' name="selectspp" id="selectspp" onchange="ambilnospp()" required>
                                    <!-- <option value="">-- NO SPP --</option>                                    -->
                                </select>
                                <!-- <input type="text" class="form-control" id="no_bukti_spj" placeholder="No SPP" name="no_bukti" required
                                       oninvalid="this.setCustomValidity('Nomer Bukti harus diisi !!')" onchange="this.setCustomValidity('')"> -->
                                    <label>Jenis Pembayaran</label><br>
                                    <label class="checkbox-inline">
                                        <input type="radio" name='is_pihak_ketiga' value="0" checked> Kas Bendahara </input>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" name='is_pihak_ketiga' value="1"> Pihak Ketiga </input> 
                                    </label>                                    
                                    <br>                                                     
                                <label>Uraian</label>
                                <textarea type="text" class="form-control" id="uraian_spj" style="width:100%;" rows="5" name="uraian" required oninvalid="this.setCustomValidity('Uraian harus diisi !!')" onchange="this.setCustomValidity('')"></textarea>                                                    
                                <label>Kegiatan</label><br>
                                <input type="text" class="form-control" name="kegiatan" id="kegiatan" style="width:100%;" readonly="true">
                                <br> 
                            </div>                                    
                            <div class="col-md-6">
                                <label>Tgl BKU</label>
                                <div class='input-group date' style="width: 70%;" >
                                    <input type="text" class="form-control" id="tgl_bku_spj" placeholder="dd/mm/yyyy" name="tgl_bku" required
                                           oninvalid="this.setCustomValidity('Tanggal BKU harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <label>Tgl Bukti</label>
                                <div class='input-group date' style="width: 70%;">
                                    <input type="text" class="form-control" id="tgl_bukti_spj" placeholder="dd/mm/yyyy" name="tgl_bukti" required
                                           oninvalid="this.setCustomValidity('Tanggal Bukti harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <div class="table-responsive" >
                                <br>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="30%">Rekening</th>
                                            <th width="50%">Urai</th>
                                            <th width="20%">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" id="urai" style="border:0;background:transparent;" value="12/p/spp" readonly></i></td>
                                            <td><input type="text" id="urai" style="border:0;background:transparent;" value="Urai" readonly></td>
                                            <td align="right"><input type="text" id="jumlah" style="border:0;background:transparent;text-align:right;" value="123"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp</td>
                                            <td>&nbsp</td>
                                            <td>&nbsp</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <td align="right"><input type="text" id="jumlah" style="border:0;background:transparent;text-align: right; " value="123" readonly="true"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                        <table class="table table-bordered table-stripted">
                            <thead>
                                <tr>
                                    <th>Kode Rekening</th>
                                    <th>Urai Rekening</th>
                                    <th>Pagu Anggaran</th>
                                    <th id="th_jenis_transaksi">Penerimaan</th>
                                </tr>
                            </thead>
                            <tbody id="data_rek_bku">
                                <tr>
                                    <td colspan="4" align="center">No Data</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Jumlah</strong></td>
                                    <td>&nbsp</td>
                                    <td align='right'><strong id="jumlah_pagu">0</strong><input type="hidden" name="jumlah_all_pagu" id="jumlah_all_pagu" value="0" ></td>
                                    <td align='right'><strong id="jumlah_all">0</strong><input type="hidden" name="jumlah_all_terima" id="jumlah_all_terima" value="0" ></td>
                                </tr>
                            </tfoot>
                        </table>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="simpan btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Ubah SPJ -->
<div class="modal fade bs-example-modal-lg" id="modalEditSPJ"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/ubah_spj') ?>" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="edit_myModalLabel">Form Tambah SPP BKU</h4>
                </div>
                <div class="modal-body">
                    <div class="loader text-right"></div>
                    <div class="row">                        
                        <div class="form-group"> 
                            <input type="hidden" value="<?php echo $rs_input['koderekening']; ?>" name="koderekening">
                             <input type="hidden" value="<?php echo $rs_input['bulan']; ?>" name="bulan">                   
                            <input type="hidden" value="<?php echo $rs_input['jenis_jurnal']; ?>" name="jenisJurnal">    
                            <input type="hidden" id="edit_tahun" name="tahun">                   
                            <div class="col-md-6">
                                <label>No. BKU</label>
                                <input type="text" class="form-control" id="edit_no_bku_spj" name="no_bku" required 
                                       oninvalid="this.setCustomValidity('Nomer BKU harus diisi !!')" onchange="this.setCustomValidity('')" readonly>
                                <label id="edit_judul_no_bku">No. Bukti SPP</label>
                                <select class=" form-control" style='width: 100%;' name="selectspp" id="edit_no_bukti_spj" required readonly>
                                    
                                </select>
                                <!-- <input type="text" class="form-control" id="no_bukti_spj" placeholder="No SPP" name="no_bukti" required
                                       oninvalid="this.setCustomValidity('Nomer Bukti harus diisi !!')" onchange="this.setCustomValidity('')"> -->
                                <label>Jenis Pembayaran</label><br>
                                    <label class="checkbox-inline">
                                        <input type="radio" name='is_pihak_ketiga' value="0" id="edit_kas_bendahara"> Kas Bendahara </input>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" name='is_pihak_ketiga' value="1" id="edit_pihak_ketiga"> Pihak Ketiga </input> 
                                    </label><br>                                                     
                                <label>Uraian</label>
                                <textarea type="text" class="form-control" id="edit_uraian_spj" style="width:100%;" rows="5" name="uraian" required oninvalid="this.setCustomValidity('Uraian harus diisi !!')" onchange="this.setCustomValidity('')"></textarea>                                                    
                                <label>Kegiatan</label><br>
                                <input type="text" class="form-control" name="kegiatan" id="edit_kegiatan" style="width:100%;" readonly="true">
                                <br> 
                            </div>                                    
                            <div class="col-md-6">
                                <label>Tgl BKU</label>
                                <div class='input-group date' style="width: 70%;" >
                                    <input type="text" class="form-control tanggal_modal" id="edit_tgl_bku_spj" placeholder="dd/mm/yyyy" name="tgl_bku" required
                                           oninvalid="this.setCustomValidity('Tanggal BKU harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <label>Tgl Bukti</label>
                                <div class='input-group date' style="width: 70%;">
                                    <input type="text" class="form-control tanggal_modal" id="edit_tgl_bukti_spj" placeholder="dd/mm/yyyy" name="tgl_bukti" required
                                           oninvalid="this.setCustomValidity('Tanggal Bukti harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                 <label>Jenis Transaksi</label><br>
                                    <label class="checkbox-inline">
                                        <input type="radio" name='jenistransaksi' id="edit_jenis_spp" onclick="edit_ganti_judul_spp()" value="SPP"> SPP </input>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="radio" name='jenistransaksi' id="edit_jenis_spj" onchange="edit_ganti_judul_spj()" value="SPJ"> SPJ </input> 
                                    </label><br>       
                                <div class="table-responsive" >
                                <br>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="30%">Rekening</th>
                                            <th width="50%">Urai</th>
                                            <th width="20%">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" id="urai" style="border:0;background:transparent;" value="12/p/spp" readonly></i></td>
                                            <td><input type="text" id="urai" style="border:0;background:transparent;" value="Urai" readonly></td>
                                            <td align="right"><input type="text" id="jumlah" style="border:0;background:transparent;text-align:right;" value="123"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp</td>
                                            <td>&nbsp</td>
                                            <td>&nbsp</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Jumlah</td>
                                            <td align="right"><input type="text" id="jumlah" style="border:0;background:transparent;text-align: right; " value="123" readonly="true"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                        <table class="table table-bordered table-stripted">
                            <thead>
                                <tr>
                                    <th>Kode Rekening</th>
                                    <th>Urai Rekening</th>
                                    <th>Pagu Anggaran</th>
                                    <th id="edit_th_jenis_transaksi" class='edit_td_pengeluaran'>Pengeluaran</th>
                                    <!-- <th id="edit_th_jenis_transaksi" class='edit_td_penerimaan'>Penerimaan</th> -->
                                </tr>
                            </thead>
                            <tbody id="edit_data_rek_bku">
                                <tr>
                                    <td colspan="4" align="center">No Data</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Jumlah</strong></td>
                                    <td>&nbsp</td>
                                    <td align='right'><strong id="edit_jumlah_pagu">0</strong><input type="hidden" name="jumlah_all_pagu" id="edit_jumlah_all_pagu" value="0" ></td>
                                    <td align='right' class='edit_td_jumlah'><strong id="edit_jumlah_all" class="nominal_">0</strong><input type="hidden" name="jumlah_all" id="edit_jumlah_all_" value="0" ></td>
                                    <!-- <td align='right' class='edit_td_penerimaan'><strong id="edit_jumlah_all_penerimaan">0</strong><input type="hidden" name="jumlah_all_terima" id="edit_jumlah_all_terima" value="0" ></td> -->
                                </tr>
                            </tfoot>
                        </table>
                </div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="simpan btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pajak-->
<div class="modal fade bs-example-modal-lg" id="modalPajak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/add_pajak') ?>" method="post"> 
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Pungut Pajak</h4>
                </div>
                <div class="modal-body">
                    <div class="row">                        
                        <div class="form-group"> 
                            <input type="hidden" value="<?php echo $rs_input['koderekening']; ?>" name="koderekening">  
                            <input type="hidden" value="<?php echo $rs_input['bulan']; ?>" name="bulan">                   
                            <input type="hidden" value="<?php echo $rs_input['jenis_jurnal']; ?>" name="jenisJurnal">                   
                            <div class="col-md-8" style="width: 60%;">
                                <label>No BKU</label>
                                <input type="text" class="form-control" id="no_bku_pajak" value="<?php echo $nobku; ?>" name="no_bku" required 
                                       oninvalid="this.setCustomValidity('Nomer BKU harus diisi !!')" onchange="this.setCustomValidity('')" readonly>
                                <label>No Bukti</label>
                                <input type="text" class="form-control" id="no_bukti_pajak" placeholder="No Bukti" name="no_bukti" required
                                       oninvalid="this.setCustomValidity('Nomer Bukti harus diisi !!')" onchange="this.setCustomValidity('')">
                                <label>Jenis</label><br>
                                <select name="jenisPajak" class="form-control" style="width:100%;" >
                                    <option value="1" name="pungut_pajak">PUNGUT-PAJAK</option>
                                    <option value="2" name="setor_pajak">SETOR-PAJAK</option>
                                </select>                        
                                <label>Uraian</label>
                                <textarea type="text" class="form-control" id="uraian_pajak" style="width:100%;" name="uraian" required oninvalid="this.setCustomValidity('Uraian harus diisi !!')" onchange="this.setCustomValidity('')"></textarea>
                                <label>Jenis Pajak</label>
                                <div class="input_fields_wrap">   
                                    <div class="input-group">                                        
                                        <select class="form-control" style="width:60%;" id="select_pajak_1" name="select_name_1">
                                            <?php foreach ($master_pajak as $result): ?>
                                            <?php $set_value_pajak = $result['KODEAKUN'].".".$result['KODEKELOMPOK'].".".$result['KODEJENIS'].".".$result['KODEOBJEK']; ?>                              
                                            <option value="<?php echo $set_value_pajak; ?>"><?php echo $result['SINGKAT']; ?></option>                                            
                                            <?php endforeach ?>
                                        </select>
                                        <input type="hidden" name="count_pajak" class="count_pajak" value="1">
                                        <input type="hidden" name="jumlah_all_pajak" id="jumlah_all_pajak" value="0" >
                                        <input type="text" name="select_pajak_1" class="form-control amount_format sum_amount" style="width:40%; text-align:right;" placeholder="0,00" id="input_pajak">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary"  id="add_field_button"><i class="fa fa-plus"></i></button>  
                                        </span>

                                    </div>                            
                                </div>                      
                            </div>                                    
                            <div class="col-md-offset-4">
                                <label>Tgl BKU</label>
                                <div class='input-group date'>
                                    <input type="text" class="form-control tanggal_modal" style="width: 100%;" id="tgl_bku_pajak" placeholder="dd/mm/yyyy" name="tgl_bku" required
                                           oninvalid="this.setCustomValidity('Tanggal BKU harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <label>Tgl Bukti</label>
                                <div class='input-group date'>
                                    <input type="text" class="form-control tanggal_modal" style="width: 100%;" id="tgl_bukti_pajak" placeholder="dd/mm/yyyy" name="tgl_bukti" required
                                           oninvalid="this.setCustomValidity('Tanggal Bukti harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="simpan btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Ubah Pajak-->
<div class="modal fade bs-example-modal-lg" id="modalEditPajak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/edit_pajak') ?>" method="post"> 
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ubah Pungut Pajak</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group"> 
                            <input type="hidden" value="<?php echo $rs_input['koderekening']; ?>" name="koderekening">  
                            <input type="hidden" value="<?php echo $rs_input['bulan']; ?>" name="bulan">                   
                            <input type="hidden" value="<?php echo $rs_input['jenis_jurnal']; ?>" name="jenisJurnal">                   
                            <div class="col-md-8" style="width: 60%;">
                                <label>No BKU</label>
                                <input type="text" class="form-control" id="edit_no_bku_pajak" value="<?php echo $nobku; ?>" name="no_bku" required 
                                       oninvalid="this.setCustomValidity('Nomer BKU harus diisi !!')" onchange="this.setCustomValidity('')" readonly>
                                <label>No Bukti</label>
                                <input type="text" class="form-control" id="edit_no_bukti_pajak" placeholder="No Bukti" name="no_bukti" required
                                       oninvalid="this.setCustomValidity('Nomer Bukti harus diisi !!')" onchange="this.setCustomValidity('')">
                                <label>Jenis</label><br>
                                <select name="jenisPajak" class="form-control" style="width:100%;" id="edit_jenis_pajak">
                                    <option value="1" name="pungut_pajak">PUNGUT-PAJAK</option>
                                    <option value="2" name="setor_pajak">SETOR-PAJAK</option>
                                </select>                        
                                <label>Uraian</label>
                                <textarea type="text" class="form-control" id="edit_uraian_pajak" style="width:100%;" name="uraian" required oninvalid="this.setCustomValidity('Uraian harus diisi !!')" onchange="this.setCustomValidity('')"></textarea>
                                <label>Jenis Pajak</label>
                                <div class="input_fields_wrap">   
                                    <div class="input-group">
                                        <select class="form-control" style="width:60%;" >
                                            <?php foreach ($master_pajak as $result): ?>
                                            <?php $set_value_pajak = $result['KODEAKUN'].".".$result['KODEKELOMPOK'].".".$result['KODEJENIS'].".".$result['KODEOBJEK']; ?>                              
                                            <option value="<?php echo $set_value_pajak; ?>"><?php echo $result['SINGKAT']; ?></option>                                            
                                            <?php endforeach ?>
                                        </select>                                                                              
                                        <input type="text" name="mytext[]" class="form-control" style="width:40%; text-align:right;" placeholder="0,00" id="edit_input_pajak">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" id="add_field_button"><i class="fa fa-plus"></i></button>  
                                        </span>

                                    </div>                            
                                </div>                      
                            </div>                                    
                            <div class="col-md-offset-4">
                                <label>Tgl BKU</label>
                                <div class='input-group date'>
                                    <input type="text" class="form-control tanggal_modal" style="width: 100%;" id="edit_tgl_bku_pajak" placeholder="dd/mm/yyyy" name="tgl_bku" required
                                           oninvalid="this.setCustomValidity('Tanggal BKU harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <label>Tgl Bukti</label>
                                <div class='input-group date'>
                                    <input type="text" class="form-control tanggal_modal" style="width: 100%;" id="edit_tgl_bukti_pajak" placeholder="dd/mm/yyyy" name="tgl_bukti" required
                                           oninvalid="this.setCustomValidity('Tanggal Bukti harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="simpan btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pergeseran-->
<div class="modal fade bs-example-modal-lg" id="modalPergeseran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/add_pergeseran') ?>" method="post"> 
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Pergeseran</h4>
                </div>
                <div class="modal-body">            
                    <div class="row">                        
                        <div class="form-group"> 
                            <input type="hidden" value="<?php echo $rs_input['koderekening']; ?>" name="koderekening"> 
                            <input type="hidden" value="<?php echo $rs_input['bulan']; ?>" name="bulan">                   
                            <input type="hidden" value="<?php echo $rs_input['jenis_jurnal']; ?>" name="jenisJurnal">
                            <div class="col-md-8" style="width: 60%;">
                                <label>No BKU</label>
                                <input type="text" class="form-control" id="no_bku" value="<?php echo $nobku; ?>" name="no_bku" required 
                                       oninvalid="this.setCustomValidity('Nomer BKU harus diisi !!')" onchange="this.setCustomValidity('')" readonly>
                                <label>No Bukti</label>
                                <input type="text" class="form-control" id="no_bukti" placeholder="No Bukti" name="no_bukti" required
                                       oninvalid="this.setCustomValidity('Nomer Bukti harus diisi !!')" onchange="this.setCustomValidity('')">
                                <label>Jenis</label><br>
                                <select name="simpananBank" class="form-control" style="width:100%;" id="simpananBank">
                                    <option value="1" name="simpanan_bank">SIMPANAN-BANK</option>
                                    <option value="2" name="kas_tunai">KAS-TUNAI</option>
                                </select>                        
                                <label>Uraian</label>
                                <textarea type="text" class="form-control" id="uraian" style="width:100%;" name="uraian" required oninvalid="this.setCustomValidity('Uraian harus diisi !!')" onchange="this.setCustomValidity('')"></textarea>
                                <label>Penerimaan</label>
                                <input type="text" class="form-control amount_format" id="add_penerimaan" placeholder="0,00" style="text-align:right;" name="penerimaan" required
                                       oninvalid="this.setCustomValidity('Penerimaan harus diisi !!')" onchange="this.setCustomValidity('')">
                                <label>Pengeluaran</label>
                                <input type="text" class="form-control amount_format" id="add_pengeluaran" placeholder="0,00" style="text-align:right;" name="pengeluaran" required
                                       oninvalid="this.setCustomValidity('Pengeluaran harus diisi !!')" onchange="this.setCustomValidity('')">                        
                            </div>                                    
                            <div class="col-md-offset-4">
                                <label>Tgl BKU</label>
                                <div class='input-group date'>
                                    <input type="text" class="form-control tanggal_modal" style="width: 100%;" id="tgl_add_bku" placeholder="dd/mm/yyyy" name="tgl_bku" required
                                           oninvalid="this.setCustomValidity('Tanggal BKU harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <label>Tgl Bukti</label>
                                <div class='input-group date'>
                                    <input type="text" class="form-control tanggal_modal" style="width: 100%;" id="tgl_add_bukti" placeholder="dd/mm/yyyy" name="tgl_bukti" required
                                           oninvalid="this.setCustomValidity('Tanggal Bukti harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>                            
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="simpan btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Ubah Pergeseran-->
<div class="modal fade bs-example-modal-lg" id="modalEditPergeseran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/edit_pergeseran') ?>" method="post"> 
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ubah Pergeseran</h4>
                </div>
                <div class="modal-body">            
                    <div class="row">                        
                        <div class="form-group"> 
                            <input type="hidden" value="<?php echo $rs_input['koderekening']; ?>" name="koderekening"> 
                            <input type="hidden" value="<?php echo $rs_input['bulan']; ?>" name="bulan">                   
                            <input type="hidden" value="<?php echo $rs_input['jenis_jurnal']; ?>" name="jenisJurnal">
                            <div class="col-md-8" style="width: 60%;">
                                <label>No BKU</label>
                                <input type="text" class="form-control" id="edit_no_bku" name="no_bku" required 
                                       oninvalid="this.setCustomValidity('Nomer BKU harus diisi !!')" onchange="this.setCustomValidity('')" readonly>
                                <label>No Bukti</label>
                                <input type="text" class="form-control" id="edit_no_bukti" placeholder="No Bukti" name="no_bukti" required
                                       oninvalid="this.setCustomValidity('Nomer Bukti harus diisi !!')" onchange="this.setCustomValidity('')">
                                <label>Jenis</label><br>
                                <select name="simpananBank" class="form-control" style="width:100%;" id="edit_jenis_pergeseran">
                                    <option value="1" name="simpanan_bank">SIMPANAN-BANK</option>
                                    <option value="2" name="kas_tunai">KAS-TUNAI</option>
                                </select>                        
                                <label>Uraian</label>
                                <textarea type="text" class="form-control" id="edit_uraian" style="width:100%;" name="uraian" required oninvalid="this.setCustomValidity('Uraian harus diisi !!')" onchange="this.setCustomValidity('')"></textarea>
                                <label>Penerimaan</label>
                                <input type="text" class="form-control amount_format" id="edit_penerimaan" placeholder="0,00" style="text-align:right;" name="penerimaan" required
                                       oninvalid="this.setCustomValidity('Penerimaan harus diisi !!')" onchange="this.setCustomValidity('')">
                                <label>Pengeluaran</label>
                                <input type="text" class="form-control amount_format" id="edit_pengeluaran" placeholder="0,00" style="text-align:right;" name="pengeluaran" required
                                       oninvalid="this.setCustomValidity('Pengeluaran harus diisi !!')" onchange="this.setCustomValidity('')">                        
                            </div>                                    
                            <div class="col-md-offset-4">
                                <label>Tgl BKU</label>
                                <div class='input-group date'>
                                    <input type="text" class="form-control tanggal_modal" style="width: 100%;" id="tgl_edit_bku" placeholder="dd/mm/yyyy" name="tgl_bku" required
                                           oninvalid="this.setCustomValidity('Tanggal BKU harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <label>Tgl Bukti</label>
                                <div class='input-group date'>
                                    <input type="text" class="form-control tanggal_modal" style="width: 100%;" id="tgl_edit_bukti" placeholder="dd/mm/yyyy" name="tgl_bukti" required
                                           oninvalid="this.setCustomValidity('Tanggal Bukti harus diisi !!')" onchange="this.setCustomValidity('')" maxlength="10">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>                            
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="simpan btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>