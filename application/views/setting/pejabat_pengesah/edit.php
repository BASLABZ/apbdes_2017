<!-- css/javascript -->
<script>
    winload(function(){
        // css select2
        $("head").append("<style>[class^='select2']{border-radius: 0px !important;}</style>");                 
        //select 
        $(".select2").select2();
        // alert auto close
        window.setTimeout(function() {
            $(".alert").fadeTo(1500, 0).slideUp(500, function(){
                $(this).remove(); 
                });
        }, 5000);

    });
</script>
<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>
<!-- form ubah -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-pencil"></span> Ubah Pejabat Pengesah</h5>
                <div align="right">
                    <div class="btn-group">
                        <a href="<?php echo base_url('setting/pejabat_pengesah') ?>" class="btn btn-info btn-xs" type="button" ><span class="glyphicon glyphicon-th-list"></span> Daftar</a>                       
                        <a href="<?php echo base_url();?>setting/pejabat_pengesah/add" class="btn btn-success btn-xs" type="button" id="btnTambah"><span class="fa fa-plus"></span> Tambah</a>
                    </div>
                </div> 
            </div>
            <div class="ibox-content  border-bottom highlight-bas">
        <!-- <div class="panel">
            <div class="panel-body"> -->
                <!-- 
                <div class="hr-line-dashed"></div> -->
                <?php echo $this->session->flashdata('exist'); ?>
                <?php echo validation_errors("<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>","</div>"); ?>
                <?php foreach ($edit_pejabat as $r): ?>  
                     <?php echo form_open('setting/pejabat_pengesah/edit/'.$r['TAHUN']."/".$r['KODEURUSAN']."/".$r['KODESUBURUSAN']."/".$r['KODEORGANISASI']."/".$r['KODEDESA']."/".$r['JENISSISTEM']."/".$r['ID'] ,array('class'=>'form-horizontal')) ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Desa</label>
                    <div class="col-sm-4">
                        <select class="form-control select2" name="namadesa" required>
                            <?php $selected_desa = $r['KODEURUSAN'].".".$r['KODESUBURUSAN'].".".$r['KODEORGANISASI'].".".$r['KODEDESA']; ?>
                            <?php foreach ($desa as $v): ?>
                            <?php $set_select_desa = $v['KODEURUSAN'].".".$v['KODESUBURUSAN'].".".$v['KODEORGANISASI'].".".$v['KODEDESA']; ?>
                                <option value="<?php echo $set_select_desa ;?>" <?php if($selected_desa==$set_select_desa ){echo 'selected';} ?> ><?php echo $v['URAI'];?></option>
                            <?php endforeach ?>
                        </select>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Pejabat</label>
                    <div class="col-sm-4">
                        <input type="text" name="nama_pejabat" placeholder="Nama Pejabat" class="form-control" value="<?php echo $r['NAMA']; ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Jabatan</label>
                    <div class="col-sm-4">
                        <select class="form-control select2" name="jabatan" required>
                            <?php $selected_jbt = $r['JENISSISTEM'].".".$r['ID'].".".$r['JABATAN']; ?>
                            <?php foreach ($jabatan as $v): ?>
                            <?php $set_select_jbt = $v['JENISSISTEM'].".".$v['URUT'].".".$v['URAI']; ?>
                            <option value="<?php echo $set_select_jbt; ?>"  <?php if($selected_jbt==$set_select_jbt){echo 'selected';} ?> > <?php echo $v['URAI']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">NIP</label>
                    <div class="col-sm-4">
                        <input type="text" name="nip" placeholder="NIP" class="form-control" value="<?php echo $r['NIP']; ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Pangkat</label>
                    <div class="col-sm-4">
                        <input type="text" name="pangkat" placeholder="Pangkat" class="form-control" value="<?php echo $r['PANGKAT']; ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">NPWP</label>
                    <div class="col-sm-4">
                        <input type="text" name="npwp" placeholder="NPWP" class="form-control" value="<?php echo $r['NPWP']; ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nomor Rekening</label>
                    <div class="col-sm-4">
                        <input type="text" name="norek" placeholder="Nomor Rekening" class="form-control" value="<?php echo $r['NOREKBANK']; ?>" required>
                    </div>                            
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Bank</label>
                    <div class="col-sm-4">
                        <input type="text" name="nama_bank" placeholder="Nama Bank" class="form-control" value="<?php echo $r['NAMABANK']; ?>" required>
                    </div>                            
                </div>

                <?php endforeach ?>
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


