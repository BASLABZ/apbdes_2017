<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #1ab394;
        color: white !important;
    }
</style>
<!-- pencarian -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Cari Desa</h5>
            </div>
            <div class="ibox-content border-bottom">
            <form action="<?php echo base_url().'verifikasi/pengesahan/index'; ?>" method="POST">
                <div class="form-group">
                    <div class="input-group w-50p">
                        <select name="namadesa" class="select2" style='width: 99%;' required>                          
                            <option value="0">-- Pilih Kecamatan/Desa --</option>
                            <?php foreach ($desa as $v): 
                                $set_select_desa = $v['KODEURUSAN'].".".$v['KODESUBURUSAN'].".".$v['KODEORGANISASI'].".".$v['KODEDESA']; 
                                $cekDesa = ($set_select_desa==$idDesa) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $set_select_desa ;?>" <?php echo $cekDesa; ?>><?php echo $v['URAI'];?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary" id="tampil" data-loading-text="LOADING..." autocomplete="off">TAMPILKAN SPP</button>
                        </div>
                    </div>
                </div>                    
            </form>            
            </div>
        </div>
    </div>
</div>
<!-- daftar pengesahan -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Daftar Pengesahan</h5>
            </div>
            <div class="ibox-content">
                <!-- <div class="hr-line-dashed"></div>
                    <div class="col-sm-12"> -->
                        <form> 
                        <table class="table table-striped table-hover table-bordered mg-y-b-0" id="datatable">
                            <thead>
                                <tr>
                                    <th width="10%">No.SPP</th>
                                    <th width="8%">Tgl SPP</th>
                                    <th width="20%">Keperluan</th>
                                    <th width="8%">Jumlah</th>
                                    <th width="10%">Persetujuan</th>
                                    <th width="10%">Pengesahan</th>
                                    <th width="3%">
                                        <input type="checkbox" onClick="toggle(this)">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($dataspp){
                                 foreach ($dataspp as $v) {
                                 $v['STATUS_PERSETUJUAN']==0 ? 
                                 $status_setuju ="<i class='fa fa-exclamation-triangle text-warning'></i> Belum Disetujui" : 
                                 $status_setuju ="<i class='fa fa-check text-success'></i> Sudah Disetujui";
                                 $v['STATUS_PENGESAHAN']==0 ? 
                                 $status_sah ="<i class='fa fa-exclamation-triangle text-warning'></i> Belum Disahkan" : 
                                 $status_sah ="<i class='fa fa-check text-success'></i> Sudah Disahkan";
                                 // $cekSPP = $v['STATUS_PERSETUJUAN']==1 ? "checked onClick=batalkan('".$v['NO_SPP']."') " : ''; 
                                 $cekSPP = $v['STATUS_PENGESAHAN']==1 ? "<i class='fa fa-times text-danger' style='cursor:pointer;' onClick=batalkan('".$v['NO_SPP']."') ></i>" : "<input type='checkbox' class='sarasvati' name=spp[] value='".$v['NO_SPP']."'>";
                                 $tgl =date('d/m/Y',strtotime($v['TGL_SPP']));

                                     echo "
                                     <tr class='pre'>
                                         <td>".$v['NO_SPP']."</td>
                                         <td>".$tgl."</td>
                                         <td>".$v['DESKRIPSI_PEKERJAAN']."</td>
                                         <td align='right'>".number_format($v['JUMLAH_SPP'],0,",",".")."</td>
                                         <td>".$status_setuju."</td>
                                         <td>".$status_sah."</td>
                                         <td>".$cekSPP."</td>
                                     </tr>
                                     ";
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
                           <button class="btn btn-sm btn-primary" type="submit" id="btnsetujuisend" >PENGESAHAN DRAFT</button>
                        </div><br></br>
                        </form>
                    <!-- </div> -->
            </div>
        </div>
    </div>
</div>
<?php
    function kode($x,$y,$z)
    {
        return $x.".".$y.".".$z." - ";
    }
include 'js_pengesahan.php';
?>
