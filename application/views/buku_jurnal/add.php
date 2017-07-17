<style type="text/css">
    .ibox-title{
        background-color: #ee6e73;
        color: white !important;
    }
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox">
			<div class="ibox-title"><h5><span class="fa fa-pencil"></span> Tambah Data Buku Jurnal </h5></div>
			<div class="ibox-content border-bottom highlight-bas">
			<div class="hr-line-dashed"></div>
				<div class="row">
					<div class="col-md-12">
							<form class="role" method="POST">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<label>Desa</label>
								<select class="form-control">
									<option value="">-Pilih Desa-</option>
								</select>
							</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Jenis Jurnal</label>
									<input type="text" class="form-control" value="PENYESUAIAN" disabled>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>No Bukti</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Tanggal Bukti</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>No BKU</label>
								<input type="text" class="form-control">
							</div>
							<div class="col-md-6">
								<label>Keterangan</label>
								<textarea class="form-control"></textarea>
							</div>
						</div>
						<div class="hr-line-dashed"></div>
						<div class="row">
							<div class="col-md-12">
								<table class="table table-stripped table-bordered table-responsive">
									<thead>
										<th>Kode Rekening</th>
										<th>Uraian</th>
										<th>Debit</th>
										<th>Kredit</th>
										<th>Aksi</th>
									</thead>
									<tbody>
										<tr>
											<td>
												 <a href="#" data-target="#modal_kode_rekening" data-toggle="modal" class="btn btn-primary btn-xs bd-rad-0" data-placement="bottom" title="Cari Rekening" style="float: right;"><span class="glyphicon glyphicon-search"></span></a>
											</td>
											<td>...</td>
											<td><input type="number"></td>
											<td><input type="number"></td>
											<td><a href="" class="btn btn-danger btn-xs bd-rad-0"><span class="fa fa-times"></span></a> </td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Master Rekening -->
<div class="modal fade bs-example-modal-lg" id="modal_kode_rekening">
    <div class="modal-dialog modal-xl" style="width: 65%;">
        <div class="modal-content">
            <form action="<?php echo base_url('bku/buku_kas_umum/add_spj_penerimaan') ?>" method="post">
                <div class="modal-header"  style="background-color: #ee6e73; color: white;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Pilih Rekening </h4>
                </div>
                <div class="modal-body highlight-bas">

                    <div class="row">
  						<table class="table table-bordered table-stripted header-fixed tableRekening" id="datatableRekening">                            <thead>
                                <tr>
                                    <th width="20%" class="kodeRek">Kode Rekening</th>
                                    <th width="80%" class="uraiRek">Urai Rekening</th>
                                    <!-- <th>Jumlah</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rekening as $result): ?>
                                    <tr>
                                        <td width="20%"><?php echo $result['KODEREKENING']; ?></td>
                                        <td width="80%"><?php echo $result['URAI']; ?></td>
                                        <!-- <td>0</td> -->
                                    </tr>
                                <?php endforeach ?>
                            </tbody>                            
                        </table>     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger dim" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                        <button type="button" class="simpan btn btn-primary dim" onclick="pilihRekening()"><span class="fa fa-check"></span> Pilih</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>
