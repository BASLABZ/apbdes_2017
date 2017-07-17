<script>
function cetak(){ 
    var d = new Date();
    var tahun = d.getFullYear();      
    var file = 'SPP/SPP.fr3';
    window.open('<?php echo base_url() ?>resource/report/?report_type=pdf&file='+file+'&tahun='+tahun);
}
</script>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">                
                <div align="left">
                    <div class="btn-group">
                        <button class="btn btn-success" type="submit" onclick="cetak()"><i class="fa fa-print"></i>&nbsp;&nbsp;<span class="bold">Cetak</span></button>
                    </div>
                </div>                                                
            </div>
        </div>
    </div>
</div>

