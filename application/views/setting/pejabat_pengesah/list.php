<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>
<!-- hapus pejabat pengesah -->
<script type="text/javascript">
    winload(function(){
         // pilih desa
        $('#pilihDesa').on('change',function(){
            $('#tampil').click();
        })
        // css select2
        $("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");                 
        //select 
        $(".select2").select2();
        // tooltip
        $('[data-toggle="tooltip"]').tooltip();
        // disable tombol daftar
        $('#btnDaftar').addClass('disabled');
        // alert auto close
        window.setTimeout(function() {
            $(".alert").fadeTo(1500, 0).slideUp(500, function(){
                $(this).remove(); 
                });
        }, 5000);

    });

    function _hapus(argument) {
        // swal("Here's a message!"+argument);
        var datArr = argument.split(".");
        swal({
            title: "Apa anda yakin ?",
            text: "Anda akan menghapus data pejabat pengesah ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Hapus",
            confirmButtonColor: "#DD6B55",
            cancelButtonText: "Batal",
            closeOnConfirm: false
        },
             function(){
             window.location.href="<?php echo base_url() ?>setting/pejabat_pengesah/hapusPejabat/"+argument;
        });
    }
</script>
<!-- pencarian -->
<div class="row">
    <div class="col-lg-6">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-search"></span> Cari Desa </h5>
            </div>
            <div class="ibox-content border-bottom highlight-bas">
            <form action="<?php echo base_url().'setting/pejabat_pengesah'; ?>" method="POST">
                <div class="form-group">
                    <div class="input-group w-100p">
                        <select name="namadesa" class="select2" style='width: 99%;' required id="pilihDesa">                          
                            <option value="0">-- Pilih Kecamatan/Desa --</option>
                            <?php foreach ($desa as $v): ?>
                            <?php $set_select_desa = $v['KODEURUSAN'].".".$v['KODESUBURUSAN'].".".$v['KODEORGANISASI'].".".$v['KODEDESA']; ?>
                                <option value="<?php echo $set_select_desa ;?>" <?php echo set_select('namadesa', $set_select_desa, ( !empty($get_list_desa) && $get_list_desa == $set_select_desa ? TRUE : FALSE )); ?> ><?php echo $v['URAI'];?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary" id="tampil" data-loading-text="LOADING..." autocomplete="off" style="display:none">TAMPILKAN</button>
                        </div>
                    </div>
                </div>                    
            </form>            
            </div>
        </div>
    </div>
</div>
<!-- list pejabat pengesah -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-users"></span> Daftar Pejabat Pengesah</h5>
                <div align="right">
                    <?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?>  
                    <div class="btn-group">
                        <a class="btn btn-info btn-xs" type="button" id="btnDaftar"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>                       
                        <a href="<?php echo base_url();?>setting/pejabat_pengesah/add" class="btn btn-success btn-xs" type="button"><span class="fa fa-plus"></span> Tambah</a>
                    </div>
                <?php endif ?>
                </div> 
            </div>
            <div class="ibox-content border-bottom highlight-bas">
        <!-- <div class="panel">
            <div class="panel-body"> -->
                <!-- 
                <div class="hr-line-dashed"></div> -->
                <?php echo $this->session->flashdata('sukses'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Kecamatan</th>
                                <th>Desa</th>
                                <th>Nama Pejabat</th>
                                <th>Pangkat</th>
                                <th>Jabatan</th>
                                <th>NIP</th>                                
                                <?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?>  
                                <th width="15%"></th>
                                <?php endif ?>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $no=0; foreach ($listpejabatpengesah as $row) : ?>
                            <tr>
                                <td align="center"><?php echo ++$no; ?>.</td>
                                <td nowrap><?php echo $row['KECAMATAN']; ?></td>
                                <td nowrap><?php echo $row['DESA']; ?></td>
                                <td nowrap><?php echo $row['NAMA']; ?></td>
                                <td nowrap><?php echo $row['PANGKAT']; ?></td>
                                <td nowrap><?php echo $row['JABATAN']; ?>   </td>
                                <td nowrap><?php echo $row['NIP']; ?></td> 
                                <?php if ($this->session->hakakses == 'ADMIN' OR $this->session->hakakses == 'OPERATORDESA'): ?> 
                                <td align="center">
                                 
                                    <a href="<?php echo "pejabat_pengesah/edit/".$row['TAHUN']."/".$row['KODEURUSAN']."/".$row['KODESUBURUSAN']."/".$row['KODEORGANISASI']."/".$row['KODEDESA']."/".$row['JENISSISTEM']."/".$row['ID'] ?>" class="btn btn-primary btn-xs bd-rad-0 dim" data-toggle="tooltip" data-placement="bottom" title="Ubah" ><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="javascript:_hapus('<?php echo $row['TAHUN'].".".$row['KODEURUSAN'].".".$row['KODESUBURUSAN'].".".$row['KODEORGANISASI'].".".$row['KODEDESA'].".".$row['JENISSISTEM'].".".$row['ID'] ?>')" id="hapus"  class="btn btn-danger btn-xs bd-rad-0 dim" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="glyphicon glyphicon-remove"></span></a>         
                                                                                             
                                </td>  
                                <?php endif ?>
                            </tr>   
                            <?php endforeach; ?>                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </div>
</div>