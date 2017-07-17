<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>
<!-- fuungsi delete -->
<script>
    winload(function(){
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
    
    function _apus(argument) {
        // swal("Here's a message!"+argument);
        swal({
                title: "Apa anda yakin ?",
                text: "Anda akan menghapus data pejabat ini!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Hapus",
                cancelButtonText:"Batal",
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: false
            },
            function() {
                window.location.href = "<?php echo base_url() ?>setting/jabatan/hapus/" + argument;
            });
    }
</script>
<!-- form list jabatan -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-list"></span> Daftar Jabatan</h5>
                  <div align="right">
                    <div class="btn-group">
                        <a class="btn btn-info btn-xs" type="button" id="btnDaftar"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>                       
                        <a href="<?php echo base_url();?>setting/jabatan/add" class="btn btn-success btn-xs" type="button"><span class="fa fa-plus"></span> Tambah</a>

                    </div>
                </div> 
            </div>
            <div class="ibox-content border-bottom highlight-bas">
              <!-- 
                <div class="hr-line-dashed"></div> -->
                <?php echo $this->session->flashdata('Sukses'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>                                
                                <th>Uraian</th>
                                <th width="15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $x=0 ; foreach ($listjabatan as $value) : ?>
                            <tr>
                                <td align="center"><?php echo ++$x ?>.</td>                                
                                <td><?php echo $value['URAI']; ?></td>
                                <td align="center">
                                    <a href="<?php echo base_url().'setting/jabatan/edit/'.$value['URUT']; ?>" class="btn btn-primary btn-xs bd-rad-0 dim" data-toggle="tooltip" data-placement="bottom" title="Ubah"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="javascript:_apus(<?php echo $value['URUT']; ?>)" id="hapus"  class="btn btn-danger btn-xs bd-rad-0 dim" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="glyphicon glyphicon-remove"></span></a>                                                                      
                                </td>  
                            </tr>   
                            <?php endforeach; ?>                          
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
</div>


