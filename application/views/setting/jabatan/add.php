<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>

<script>
    winload(function(){
        // disable tombol tambah
        $('#btnTambah').addClass('disabled');
        // alert auto close
        window.setTimeout(function() {
            $(".alert").fadeTo(1500, 0).slideUp(500, function(){
                $(this).remove(); 
                });
        }, 5000);
          $(".pos-demo").notify(
              "Uraian Jabatan Harus Diisi", 
              { position:"right" }
          );
    });

</script>
<!-- form tambah jabatan -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-plus"></span> Tambah Jabatan</h5>
                 <div align="right">
                    <div class="btn-group">
                        <a href="<?php echo base_url('setting/jabatan') ?>" class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>
                        <a href="<?php echo base_url();?>setting/jabatan/add" class="btn btn-success btn-xs" type="button" id="btnTambah"><span class="fa fa-plus"></span> Tambah</a>
                    </div>
                </div>
            </div>
            <div class="ibox-content border-bottom highlight-bas">
               <!-- 
                <div class="hr-line-dashed"></div> -->
                <?php echo $this->session->flashdata('exist'); ?>
                <!-- <?php //echo validation_errors( "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>", "</div>"); ?> -->
                <?php echo form_open( 'setting/jabatan/add',array( 'class'=> 'form-horizontal', 'id')) ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Id Jabatan</label>
                    <div class="col-sm-3">
                        <input type="text" name="urut" placeholder="Urut" class="form-control" value="<?php echo $urut['URUT']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Uraian</label>
                    <div class="col-sm-3">
                        <input type="text" name="uraian" placeholder="Uraian" class="form-control pos-demo" autofocus>
                    </div>
                </div>                
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-danger dim" type="button" onclick="history.back()"><span class="fa fa-times"></span> Batal</button>
                        <button class="btn btn-primary dim" type="submit"><span class="fa fa-save"></span> Simpan</button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            </div>
        </div>
    </div>
</div>
