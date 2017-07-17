<!-- isi js/css  -->
<script>
    winload(function () {
        $(".selectJurnal").select2({
            placeholder: "-- Pilih Jurnal --",
            allowClear: true
        });
    });

    function divFunction() {
        var objfrm = document.getElementById("formJurnal");
        var id_pilih = objfrm.jenisJurnal.selectedIndex;

        $.post('add',
                {id: id_pilih},
                function (html) {
                    if (id_pilih === 1) {
                        $("#modalSPJ").modal('show');
                    } else if (id_pilih === 2) {
                        $("#modalPajak").modal('show');
                    } else {
                        $("#modalPergeseran").modal('show');
                    }
                    ;
                }
        );


    }

</script>
<!-- halaman list -->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Tambah Jurnal</h5>
                <div align="right">
                    <div class="btn-group">
                        <a href="<?php echo base_url('bku/buku_kas_umum') ?>" class="btn btn-info btn-xs" type="button" ><span class="glyphicon glyphicon-th-list"></span> Daftar</a>                       
                    </div>
                </div> 
            </div>
            <div class="ibox-content">
                <form method="post" action="add" id="formJurnal">               
                    <div class="form-group">
                        <div class="col-sm-1" style="width:10%;">
                            <label>Jenis Jurnal</label>                        
                        </div>
                        <div class="col-sm-6">
                            <select class="selectJurnal" style='width: 200px;' name="jenisJurnal">
                                <option value="0" data-id="0">-- Pilih Jurnal --</option>
                                <option value="1" data-id="1">SPJ</option>
                                <option value="2" data-id="2">Pajak</option>
                                <option value="3" data-id="3">Pergeseran</option>
                            </select>
                        </div>
                    </div>
                    <br></br>               
                    <div class="form-group">
                        <div class="col-sm-1" style="width:10%;">
                            <label></label>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn btn-primary bd-rad-0" class="myModal" onClick="divFunction()">Tampilkan</div>
                        </div>
                    </div>
                    <br></br>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal SPJ-->
<div class="modal fade" id="modalSPJ" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah SPJ</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-8" style="width: 60%;">
                                <label>No BKU</label>
                                <input type="text" class="form-control" id="no_bku">
                                <label>No Bukti</label>
                                <input type="text" class="form-control" id="no_bukti">
                                <label>Jenis</label>
                                <select name="selectSimpanan">
                                    <option value="1" name="simpanan_bank">SIMPANAN-BANK</option>
                                    <option value="2" name="kas_tunai">KAS-TUNAI</option>
                                </select>
                                <label>Uraian</label>
                                <textarea type="text" class="form-control" id="uraian"></textarea>
                            </div>                                    
                            <div class="col-md-offset-4">
                                <label>Tgl BKU</label>
                                <input type="text" class="form-control" id="tgl_bku" style="width: 50%;">
                                <label>Tgl Bukti</label>
                                <input type="text" class="form-control" id="tgl_bukti" style="width: 50%;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="simpan btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pajak-->
<div class="modal fade bs-example-modal-lg" id="modalPajak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah Pajak</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="simpan btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Pergeseran-->
<div class="modal fade bs-example-modal-lg" id="modalPergeseran" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah Pergeseran</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="simpan btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>