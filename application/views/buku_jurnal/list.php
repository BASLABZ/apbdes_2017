<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>

<div class="row">
	<div class="col-md-6">
		<div class="ibox">
			<div class="ibox-title"> <h5><span class="fa fa-search"></span> Cari Desa</h5></div>
			<div class="ibox-content border-bottom highlight-bas">
				<div class="form-group">
                    <div class="input-group w-100p">
                        <select name="namadesa" class="select2" style='width: 99%;' required id="pilihDesa">
                        	<option>-Pilih Desa-</option>
                        </select>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-title"><h5><span class="fa fa-book"></span> Buku Jurnal </h5></div>
			<div class="ibox-content border-bottom highlight-bas">
			<p class="text-right">
				<a href="<?php echo base_url('buku_jurnal/buku_jurnal/add'); ?>" class="btn btn-success btn-xs bd-rad-0"><span class="fa fa-plus"></span> Tambah</a>
			</p>
				<table class="table table-striped table-hover table-bordered mg-y-b-0" id="datatable">
					<thead>
						<th>No</th>
						<th>No Bukti</th>
						<th>Tanggal Bukti</th>
						<th>No BKU</th>
						<th>Jenis Jurnal</th>
						<th>Posting</th>
						<th>Keterangan</th>
						<th>Aksi</th>
					</thead>
					<tbody>
						
					</tbody>
				</table> 
			</div>
		</div>
	</div>
</div>