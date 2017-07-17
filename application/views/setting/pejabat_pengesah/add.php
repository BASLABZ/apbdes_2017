<!-- css/javascript -->
<script>
    winload(function(){
        // css select2
        $("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");                 
        //select 
        $(".select2").select2();
        // disable tombol tambah
        $('#btnTambah').addClass('disabled');
        // alert auto close
        window.setTimeout(function() {
            $(".alert").fadeTo(1500, 0).slideUp(500, function(){
                $(this).remove(); 
                });
        }, 5000);
    })
</script>
<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }    
</style>
<!-- form tambah -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-user-plus"></span> Tambah Pejabat Pengesah</h5>
                <div align="right">
                    <div class="btn-group">
                        <a href="<?php echo base_url('setting/pejabat_pengesah') ?>" class="btn btn-info btn-xs" type="button" ><span class="glyphicon glyphicon-th-list"></span> Daftar</a>                       
                        <a href="<?php echo base_url();?>setting/pejabat_pengesah/add" class="btn btn-success btn-xs" type="button" id="btnTambah"><span class="fa fa-plus"></span> Tambah</a>
                    </div>
                </div>
            </div>
            <div class="ibox-content border-bottom highlight-bas">
        <!-- <div class="panel">
            <div class="panel-body"> -->
                <!--  
                <div class="hr-line-dashed"></div> -->
                <?php echo $this->session->flashdata('exist'); ?>
                <?php echo validation_errors("<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>","</div>"); ?>

                <?php echo form_open('setting/pejabat_pengesah/add',array('class'=>'form-horizontal')) ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Desa</label>
                    <div class="col-sm-4">
                        <select class="form-control select2" name="namadesa" required>
                            <option value="">-- Pilih Kecamatan/Desa --</option>
                            <?php foreach ($desa as $v): ?>
                            <?php $set_select_desa = $v['KODEURUSAN'].".".$v['KODESUBURUSAN'].".".$v['KODEORGANISASI'].".".$v['KODEDESA']; ?>
                                <option value="<?php echo $set_select_desa ;?>" <?php echo set_select('namadesa', $set_select_desa, ( !empty($get_list_desa) && $get_list_desa == $set_select_desa ? TRUE : FALSE )); ?> ><?php echo $v['URAI'];?></option>
                            <?php endforeach ?>
                        </select>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Pejabat</label>
                    <div class="col-sm-4">
                        <input type="text" name="nama_pejabat" placeholder="Nama Pejabat" class="form-control" value="<?php echo set_value('nama_pejabat');?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Jabatan</label>
                    <div class="col-sm-4">
                        <select class="form-control select2" name="jabatan" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <?php foreach ($jabatan as $v): ?>
                            <?php $set_select_jbt = $v['JENISSISTEM'].".".$v['URUT'].".".$v['URAI']; ?>
                            <option value="<?php echo $set_select_jbt; ?>"  <?php echo set_select('jabatan', $set_select_jbt, ( !empty($get_list_jabatan) && $get_list_jabatan == $set_select_jbt ? TRUE : FALSE )); ?> > <?php echo $v['URAI']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">NIP</label>
                    <div class="col-sm-4">
                        <input type="text" name="nip" placeholder="NIP" class="form-control" value="<?php echo set_value('nip'); ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Pangkat</label>
                    <div class="col-sm-4">
                        <input type="text" name="pangkat" placeholder="Pangkat" class="form-control" value="<?php echo set_value('pangkat'); ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">NPWP</label>
                    <div class="col-sm-4">
                        <input type="text" name="npwp" placeholder="NPWP" class="form-control" value="<?php echo set_value('npwp'); ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nomor Rekening</label>
                    <div class="col-sm-4">
                        <input type="text" name="norek" placeholder="Nomor Rekening" class="form-control" value="<?php echo set_value('norek'); ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Bank</label>
                    <div class="col-sm-4">
                        <input type="text" name="nama_bank" placeholder="Nama Bank" class="form-control" value="<?php echo set_value('nama_bank'); ?>" required>
                    </div>                            
                </div>


                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-danger dim" onclick="window.history.back()"><span class="fa fa-times"></span> Batal</button>
                        <button class="btn btn-primary dim" type="submit"><span class="fa fa-save"></span> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>


