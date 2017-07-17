<?php $data = $data[0] ?>
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <a onclick="daskum_fn_delete($(this));" data-href="<?php echo base_url('daskum/hapus/'.$data['KODEORGANISASI'].'/'.$data['KODEDESA'].'/'.$data['ID_DASARHUKUM']) ?>" class="btn btn-danger btn-xs bd-rad-0 pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                <p><?php echo $data['URAI_KEC'] ?> - <?php echo $data['URAI_DESA'] ?></p>
                <h2 class="mg-0" style="font-weight:600;"><?php echo $data['TENTANG'] ?></h2>
                <br/>
            </div>
            <div class="col-md-6">
                <p>dasar: <?php echo $data['DASARHUKUM'] ?></p>
                <p>nomor: <?php echo $data['NOMOR_DASARHUKUM'] ?></p>
                <p>ditetapkan pada: <?php echo current(explode(' ', $data['TANGGAL_DITETAPKAN'])) ?></p>
            </div>
            <div class="col-md-6">
                <!-- <p>dibuat oleh: <a href="<?php echo base_url('pengguna/lihat/'.$data['USER_ID']) ?>"><?php echo $data['USER_NAME'] ?></a></p> -->
                <p>dibuat oleh: <?php echo $data['USER_NAME'] ?></p>
                <p title="<?php echo $data['TANGGAL_DIBUAT'] ?>">dibuat pada: <?php echo date_id($data['TANGGAL_DIBUAT']) ?></p>
                <p title="<?php echo $data['LAST_UPDATE'] ?>">terahir diubah pada: <?php echo date_id($data['LAST_UPDATE']) ?></p>
            </div>
        </div>
    </div>
</div>

<script>
winload(function() {
    loader('daskum');
});
</script>

<!-- Array
(
    [0] => Array
        (
            [TAHUN] => 2016
            [KODEURUSAN] => 0
            [KODESUBURUSAN] => 1
            [KODEORGANISASI] => 12
            [KODEDESA] => 04
            [ID_DASARHUKUM] => 12
            [NOMOR_DASARHUKUM] => ddddddd
            [DASARHUKUM] => UU
            [TENTANG] => ffffffffffffffff
            [PERUBAHAN] => 0
            [LAST_UPDATE] => 2016-06-01 11:08:17
            [USER_NAME] => admin
            [USER_ID] => 1
            [TANGGAL_DITETAPKAN] => 1858-11-17 00:00:00
            [TANGGAL_DIBUAT] => 1858-11-17 00:00:00
            [URAI_KEC] => Kecamatan Majalengka
            [URAI_DESA] => Cibodas
        )

) -->