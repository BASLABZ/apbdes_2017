<?php 
//    print_r($this->session->userdata());
    $hak = $this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'SEKDES';
 ?>
<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>
<!-- pencarian -->
<div class="row">
    <div class="col-lg-6">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-search"></span> Cari Desa</h5>
            </div>
            <div class="ibox-content border-bottom highlight-bas">
            <form action="<?php echo base_url().'verifikasi/persetujuan/index'; ?>" method="POST">
                <div class="form-group">
                    <div class="input-group w-100p">
                        <select name="namadesa" class="select2" style='width: 99%;' required id="pilihDesa">                          
                            <option value="0">-- Pilih Kecamatan/Desa --</option>
                            <?php foreach ($desa as $v): 
                                $set_select_desa = $v['KODEURUSAN'].".".$v['KODESUBURUSAN'].".".$v['KODEORGANISASI'].".".$v['KODEDESA']; 
                                $cekDesa = ($set_select_desa==$idDesa) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $set_select_desa ;?>" <?php echo $cekDesa; ?>><?php echo $v['URAI'];?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary" id="tampil" data-loading-text="LOADING..." autocomplete="off" style="display:none">TAMPILKAN SPP</button>
                        </div>
                    </div>
                </div>                    
            </form>            
            </div>
        </div>
    </div>
</div>
<!-- daftar persetujuan -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-file-text"></span> Daftar Persetujuan</h5>
            </div>
            <div class="ibox-content highlight-bas">
                <!-- <div class="hr-line-dashed"></div> -->
                    <!-- <div class="col-sm-12"> -->
                        <form> 
                        <input type="hidden" id="id_persetujuan" name="id_persetujuan" value="<?php echo $this->session->userdata('kd_user'); ?>">
                        <table class="table table-striped table-hover table-bordered mg-y-b-0" id="datatable">
                            <thead>
                                <tr>
                                    <th width="10%">No.SPP</th>
                                    <th width="8%">Tgl SPP</th>
                                    <th width="17%">Keperluan</th>
                                    <th width="8%">Jumlah</th>
                                    <th width="10%">Persetujuan</th>
                                    <!-- <th width="10%">Pengesahan</th> -->
                                    <?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'SEKDES'): ?> 
                                    <th width="3%">
                                        <input type="checkbox" onClick="toggle(this)">
                                    </th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if($dataspp){
                                foreach ($dataspp as $v) {
                                $v['STATUS_PERSETUJUAN']==0 ? 
                                $status_setuju ="<span class='label label-warning'><i class='fa fa-exclamation-triangle text-danger' style='color:white;'></i> Belum Disetujui</span>" : 
                                $status_setuju ="<span class='label label-primary'><i class='fa fa-check text-success' style='color:white;'></i> Sudah Disetujui </span>";
                                $v['STATUS_PENGESAHAN']==0 ? 
                                $status_sah ="<i class='fa fa-exclamation-triangle text-warning'></i> Belum Disahkan" : 
                                $status_sah ="<i class='fa fa-check text-success'></i> Sudah Disahkan";
                                if ($v['STATUS_PERSETUJUAN']==0 && $v['STATUS_PENGESAHAN']==0 ) {
                                    $cekSPP = "<input type='checkbox' class='sarasvati' name=spp[] value='".$v['NO_SPP']."'>";
                                }else if ($v['STATUS_PERSETUJUAN']==1 && $v['STATUS_PENGESAHAN'] ==0) {
                                    $cekSPP = "<i class='fa fa-times text-danger' style='cursor:pointer;' onClick=batalkan('".$v['NO_SPP']."') ></i>";
                                }else{
                                    $cekSPP = "<i class='fa fa-times text-mute' style='cursor:pointer;'></i>";
                                }
                                // $cekSPP = $v['STATUS_PERSETUJUAN']==0 && $v['STATUS_PENGESAHAN']==0 ? "<i class='fa fa-times text-danger' style='cursor:pointer;' onClick=batalkan('".$v['NO_SPP']."') ></i>" : "<input type='checkbox' class='sarasvati' name=spp[] value='".$v['NO_SPP']."'>"; 
                                // $cekSPP = $v['STATUS_PERSETUJUAN']==1 && $v['STATUS_PENGESAHAN'] ==0 ? "<i class='fa fa-times text-danger' style='cursor:pointer;' onClick=batalkan('".$v['NO_SPP']."') ></i>" : "<input type='checkbox' class='sarasvati' name=spp[] value='".$v['NO_SPP']."'>"; 
                                // $cekSPP = $v['STATUS_PERSETUJUAN']==1 && $v['STATUS_PENGESAHAN'] ==1 ? "<i class='fa fa-times text-mute' style='cursor:pointer;'></i>" : "<input type='checkbox' class='sarasvati' name=spp[] value='".$v['NO_SPP']."'>"; 
                                
                                $tgl =date('d/m/Y',strtotime($v['TGL_SPP']));
                                    if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'SEKDES') {
                                        echo "
                                     <tr class='pre'>
                                         <td>".$v['NO_SPP']."</td>
                                         <td>".$tgl."</td>
                                         <td>".$v['DESKRIPSI_PEKERJAAN']."</td>
                                         <td align='right'>".number_format($v['JUMLAH_SPP'],0,",",".")."</td>
                                         <td>".$status_setuju."</td>
                                         <!-- <td>".$status_sah."</td> -->
                                         <td>".$cekSPP."</td>
                                     </tr>
                                     ";
                                    }else{

                                     echo "<tr class='pre'>
                                         <td>".$v['NO_SPP']."</td>
                                         <td>".$tgl."</td>
                                         <td>".$v['DESKRIPSI_PEKERJAAN']."</td>
                                         <td align='right'>".number_format($v['JUMLAH_SPP'],0,",",".")."</td>
                                         <td>".$status_setuju."</td>
                                         <!-- <td>".$status_sah."</td> -->
                                         
                                     </tr>
                                     ";
                                        }
                                    }
                                }else{
                                 echo "
                                   
                                 ";
                                }
                            ?>
                            </tbody>
                        </table>
                        <div style="margin-top:20px"></div>
                        <div class="form-group pull-right">
                            <?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'SEKDES'): ?> 
                                <button class="btn btn-sm btn-primary dim" type="submit" id="btnsetujuisend"  >
                                <span class="fa fa-check"></span> SETUJUI DRAFT</button>
                            <?php endif ?>
                        </div><br></br>
                        </form>
                    <!-- </div> -->
            </div>
        </div>
    </div>
</div>
<?php
    function kode($x,$y,$z) {
        return $x.".".$y.".".$z." - ";
    }
    include 'js_persetujuan.php';