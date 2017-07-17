<?php 
    function jmlDesa($param)
    { 
        if (strpos($param, '|') !== false) 
        {   
            $alldesa=explode( "|",$param); 
            foreach ($alldesa as $v) { 
                $each[]=substr($v,0,-1); 
            } 
             
            return substr(implode( "|",$each),0,72); 
        }else
        { 
            return rtrim($param, "."). " - "; 
             
        } 
    } 
?>
<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #1ab394;
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
        // console.log(argument);
        swal({
                title: "Apa anda yakin ?",
                text: "Anda akan menghapus data pengguna ini!",
                type: "warning",
                showCancelButton: true,                
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: false
            },
            function() {
                window.location.href = "<?php echo base_url() ?>setting/user/delete/" + argument;
            });
    }
</script>
<!-- form list user -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title" style="background-color:#ee6e73">
                <h5><span class="fa fa-users"></span> Daftar Pengguna</h5>
                <div align="right">
                    <div class="btn-group ">
                        <a class="btn btn-info btn-xs " type="button" id="btnDaftar"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>
                        <a href="<?php echo base_url();?>setting/user/add" class="btn btn-success btn-xs " type="button"><span class="fa fa-plus"></span> Tambah</a>
                    </div>
                </div>
            </div>
            <div class="ibox-content border-bottom highlight-bas">
            <!-- <div class="hr-line-dashed"></div> -->
                <?php echo $this->session->flashdata('Sukses'); ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Username</th>
                                <th>Hak Akses</th>
                                <th>Kecamatan / Desa</th>
                                <th width="15%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $x=0 ; foreach ($listpengguna as $pengguna) : ?>
                            <tr>
                                <td align="center">
                                    <?php echo ++$x ?>.
                                </td>
                                <td>
                                    <?php echo $pengguna[ 'USERNAME'] ?>
                                </td>
                                <td>
                                    <?php echo $pengguna[ 'HAKAKSES'] ?>
                                </td>
                                <td>
                                    <?php echo jmlDesa($pengguna[ 'DESA']). $pengguna[ 'URAI'] ?>
                                </td>
                                <td align="center">
                                    <a href="<?php echo base_url().'setting/user/edit/'.$pengguna['KD_USER']; ?>" class="btn btn-primary btn-xs bd-rad-0 dim" data-toggle="tooltip" data-placement="bottom" title="Ubah"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="javascript:_apus(<?php echo $pengguna['KD_USER'] ?>)" class="btn btn-danger btn-xs bd-rad-0 dim" data-toggle="tooltip" data-placement="bottom" title="Hapus"><span class="glyphicon glyphicon-remove"></span></a>
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


