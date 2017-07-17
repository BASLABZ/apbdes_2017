<!-- css/javascript -->
<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>
<!-- form ubah user -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5><span class="fa fa-key"></span> Ubah Pengguna</h5>
            </div>
            <div class="ibox-content border-bottom">
                <div align="right">
                    <div class="btn-group">
                        <a href="#" class="btn btn-info btn-xs" type="button"><span class="glyphicon glyphicon-th-list"></span> Daftar</a>
                        <a href="#" class="btn btn-success btn-xs" type="button" id="btnTambah"><span class="fa fa-plus"></span> Tambah</a>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <?php echo $this->session->flashdata('exist'); ?>
                <?php echo validation_errors( "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>", "</div>"); ?>
                <?php foreach ($dataEdit as $data) :?>
                <?php echo form_open( 'setting/user/editPass/'.$data[ 'KD_USER'],array( 'class'=> 'form-horizontal', 'id' => 'validform')) ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-3">
                        <input type="hidden" name="tahun" value="<?php echo $data['TAHUN'] ?>">
                        <input type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $data['USERNAME']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-3">
                        <input type="Password" name="password" value="<?php echo $pasdecode; ?>" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Lengkap</label>
                    <div class="col-sm-3">
                        <input type="text" name="nama_lengkap" value="<?php echo $data['NAMA'] ?>" class="form-control">
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-danger" type="button" onclick="history.back()">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close() ?>
<?php endforeach; ?>