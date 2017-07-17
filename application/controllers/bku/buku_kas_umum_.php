<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  created by aan (kurnianto.tn@gin.co.id)
*/


class buku_kas_umum extends CI_Controller
{
	
	private $page_name = "Buku Kas Umum";
	function __construct()
	{
		parent::__construct();
		$this->libauth->cek_login();
		//load model
		$this->load->model('m_bku');
		//load library
		$this->load->library('pagination');
		// $this->load->library('session');
		//
		app::set('web_heading',$this->page_name);
		app::bc($this->page_name,'/bku/buku_kas_umum');
	}

	//index
	public function index(){
		app::bc('Daftar BKU','/bku/buku_kas_umum');
		//all desa
		$tahun = date('Y');
		if ($this->session->userdata('hakakses')=="OPERATORDESA") {
			$data_organisasi = $this->m_bku->get_one_data_organisasi($this->session->userdata('kd_urusan'),
				$this->session->userdata('kd_suburusan'),$this->session->userdata('kd_organisasi'),
				$this->session->userdata('kd_desa'));
		} else {
			$data_organisasi = $this->m_bku->getNamaDesa($tahun);
		}
		
		// data rekening penerimaan
		$data_spp ='';		
		$data_rekening = $this->m_bku->get_all_rekening_penerimaan($tahun);

		if ($this->input->post('selectDesa') !== null && $this->input->post('selectDesa')!=0) {
			
			//explode koderekening
			$koderekening = explode('.', $this->input->post('selectDesa'));
			$kodeurusan = $koderekening[0];
			$kodesuburusan = $koderekening[1];
			$kodeorganisasi = $koderekening[2];
			$kodedesa = $koderekening[3];
			$kd_rekening = $this->input->post('selectDesa');

			//nomor otomatis
			$params = array(strval($tahun),$kodeurusan,$kodesuburusan,strval($kodeorganisasi),strval($kodedesa));
			$number = $this->m_bku->get_no_bku_by_desa($params);
			if(isset($number['NOBKU']) or $number['NOBKU'] != ''){
				$number = $number['NOBKU'];
			}else{
				$number = 1;
			}
			
			//data by desa			
			$bulan=$this->input->post('bulan');
			if($bulan==1){$data_bulan = "Januari";
			}elseif ($bulan==2){$data_bulan = "Februari";
			}elseif ($bulan==3){$data_bulan = "Maret";
			}elseif ($bulan==4){$data_bulan = "April";
			}elseif ($bulan==5){$data_bulan = "Mei";
			}elseif ($bulan==6){$data_bulan = "Juni";
			}elseif ($bulan==7){$data_bulan = "Juli";
			}elseif ($bulan==8){$data_bulan = "Agustus";
			}elseif ($bulan==9){$data_bulan = "September";
			}elseif ($bulan==10){$data_bulan = "Oktober";
			}elseif ($bulan==11){$data_bulan = "November";
			}else{$data_bulan = "Desember";
			}

			// master pajak
			$pajak = $this->m_bku->getPajakPotongan($tahun);			
			// input
			$jenis_jurnal = $this->input->post('jenisJurnal');
			$rs_input = array('koderekening' => $kd_rekening, 
				'tahun' => $tahun, 'bulan' => $bulan,
				'jenis_jurnal' => $jenis_jurnal);

			$data_spp = $this->m_bku->get_all_spp_valid($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$this->input->post('bulan'));
			$list_data_by_desa = $this->m_bku->get_all_data_by_desa($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$bulan,$jenis_jurnal);
			$total_data_by_desa = $this->m_bku->get_total_data_by_desa($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$bulan,$jenis_jurnal);
			$this->template->view('bku/list',array(
				'data_desa' => $data_organisasi, 'rs_bku' => $list_data_by_desa,
				'rs_input'=>$rs_input,'rs_total' => $total_data_by_desa,'dataBulan'=>$data_bulan,
				'nobku'=>$number,'nospp'=>$data_spp,'id_bulan'=>$this->input->post('bulan'),'rekening'=>$data_rekening,
				'master_pajak'=>$pajak
			));
		}else{
			$rs_input = array('koderekening' => 0 , 
				'tahun' => $tahun, 'bulan' => 0,
				'jenis_jurnal' => '');

			$list_data_by_desa = $this->m_bku->get_all_data_by_desa($tahun,0,0,0,0,0,'');
			$this->template->view('bku/list',array('data_desa' => $data_organisasi, 'rs_bku' => $list_data_by_desa,'rs_input'=>$rs_input,'id_bulan'=>date('m')));
		}
		
 	}

 	/* search */
 	public function search($tahun="",$kodeurusan="",$kodesuburusan="",$kodeorganisasi="",$kodedesa="",$bulan="",$jenis_jurnal=""){ 		
		$tahun= date('Y');		
 		$data_spp = $this->m_bku->get_all_spp_valid($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$bulan);
 		$data_organisasi = $this->m_bku->getNamaDesa($tahun);
 		$data_rekening = $this->m_bku->get_all_rekening_penerimaan($tahun);
 		
 		if(!empty($tahun) && !empty($kodeurusan) && !empty($kodesuburusan) && !empty($kodeorganisasi)
 			&& !empty($kodedesa)&& !empty($bulan)&& !empty($jenis_jurnal)){ 
 			//nomor otomatis
			$params = array(strval($tahun),$kodeurusan,$kodesuburusan,strval($kodeorganisasi),strval($kodedesa));
			$number = $this->m_bku->get_no_bku_by_desa($params);
			if(isset($number['NOBKU']) or $number['NOBKU'] != ''){
				$number = $number['NOBKU'];
			}else{
				$number = 1;
			}

			//data by desa
			if($bulan==1){$data_bulan = "Januari";
			}elseif ($bulan==2){$data_bulan = "Februari";
			}elseif ($bulan==3){$data_bulan = "Maret";
			}elseif ($bulan==4){$data_bulan = "April";
			}elseif ($bulan==5){$data_bulan = "Mei";
			}elseif ($bulan==6){$data_bulan = "Juni";
			}elseif ($bulan==7){$data_bulan = "Juli";
			}elseif ($bulan==8){$data_bulan = "Agustus";
			}elseif ($bulan==9){$data_bulan = "September";
			}elseif ($bulan==10){$data_bulan = "Oktober";
			}elseif ($bulan==11){$data_bulan = "November";
			}else{$data_bulan = "Desember";
			}

			// master pajak
			$pajak = $this->m_bku->getPajakPotongan($tahun);
			// rekening
			$kd_rekening = $kodeurusan.'.'.$kodesuburusan.'.'.$kodeorganisasi.'.'.$kodedesa;
 			$rs_input = array('koderekening' => $kd_rekening, 
				'tahun' => $tahun, 'bulan' => $bulan,
				'jenis_jurnal' => $jenis_jurnal);


 			$list_data_by_desa = $this->m_bku->get_all_data_by_desa($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$bulan,$jenis_jurnal);
			$total_data_by_desa = $this->m_bku->get_total_data_by_desa($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$bulan,$jenis_jurnal);
			$id_bulan = date('m');
			$this->template->view('bku/list',array(
				'data_desa' => $data_organisasi, 'rs_bku' => $list_data_by_desa,
				'rs_input'=>$rs_input,'rs_total' => $total_data_by_desa,'dataBulan'=>$data_bulan,
				'nobku'=>$number,'nospp'=>$data_spp, 'id_bulan'=>$id_bulan,'rekening'=>$data_rekening,
				'master_pajak'=>$pajak
			));
 		}else{
 			$rs_input = array('koderekening' => 0 , 
				'tahun' => $tahun, 'bulan' => 0,
				'jenis_jurnal' => '');

			$list_data_by_desa = $this->m_bku->get_all_data_by_desa($tahun,0,0,0,0,0,'');
			$this->template->view('bku/list',array('data_desa' => $data_organisasi, 'rs_bku' => $list_data_by_desa,'rs_input'=>$rs_input));
 		}
 	}

 	// tambah spj penerimaan
 	public function add_spj_penerimaan(){ 		

 		$this->form_validation->set_rules('no_bku', 'Nomer BKU', 'trim|required');
 		$this->form_validation->set_rules('no_bukti', 'Nomer Bukti', 'trim|required');
 		// $this->form_validation->set_rules('is_pihak_ketiga','Jenis Pembayaran','required');
 		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required'); 		
 		$this->form_validation->set_rules('tgl_bku', 'Tanggal BKU', 'trim|required');
 		$this->form_validation->set_rules('tgl_bukti', 'Tanggal Bukti', 'trim|required');
 		
 		//tgl bku
 		$tgl_bku = $this->input->post('tgl_bku');
 		$exp_tgl_bku = explode('/', $tgl_bku);
 		$tanggal_bku = $exp_tgl_bku[1].'/'.$exp_tgl_bku[0].'/'.$exp_tgl_bku[2];
 		//tgl bukti
 		$tgl_bukti = $this->input->post('tgl_bukti');
 		$exp_tgl_bukti = explode('/', $tgl_bukti);
 		$tanggal_bukti = $exp_tgl_bukti[1].'/'.$exp_tgl_bukti[0].'/'.$exp_tgl_bukti[2];

 		//explode koderekening
		$koderekening = explode('.', $this->input->post('koderekening'));
		$kodeurusan = $koderekening[0];
		$kodesuburusan = $koderekening[1];
		$kodeorganisasi = $koderekening[2];
		$kodedesa = $koderekening[3];
		// jumlah total rincian		
		$total_rincian = $this->input->post('jumlah_all_terima');
		// $jml_total= str_replace('.', '', $total_convert);
		// $substr_total = substr($jml_total, 0, -3);

		$tahun = date('Y');
 		if ($this->form_validation->run() == FALSE) {
			$this->template->view('bku/list');
			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data SPJ Penerimaan Gagal Disimpan. </div>");
		} else {	
			$data_tabel = $this->input->post('jumlah_all_terima');		
			$data = array(
	 			'TAHUN' => date('Y'),
	 			'KODEURUSAN' => $kodeurusan,
	 			'KODESUBURUSAN' => $kodesuburusan,
	 			'KODEORGANISASI' => $kodeorganisasi,
	 			'KODEDESA' => $kodedesa,
	 			'NO_BKU' => $this->input->post('no_bku'),
	 			'TGL_BKU' => $tanggal_bku,
	 			'URAIAN' => $this->input->post('uraian'),
	 			'BUKTI' => $this->input->post('no_bukti'),
	 			'TGL_BUKTI' => $tanggal_bukti,	 
	 			'JENIS_BKU' => 'PENERIMAAN',	
	 			'SIMPANANBANK' => 1,	
	 			'PENERIMAAN' => $total_rincian,
	 			'PENGELUARAN' => 0,	
	 			'LOCKED' => 0,
	 			'USERNAME' => $this->session->username,
	 			'IS_PIHAK_KETIGA' => 0); 
	 		if($data_tabel != 0){
	 			if ($this->m_bku->insert_spj($data)){
	 		// 	//notif success
	 			$rekening_rincian = $this->input->post('rekening_rincian');
	 			$uraian_rincian = $this->input->post('urai_rincian');	 			
	 			$jumlah_penerimaan = $this->input->post('jml_penerimaan');	 				 			
	 			
	 			if(isset($jumlah_penerimaan)){	 

	 				// for ($i=0; $i < $jumlah_convert ; $i++) {
	 				for($i=0; $i<sizeof($jumlah_penerimaan); $i++){	 					
	 					$explode_rekening = explode('.', $this->input->post('rekening_rincian_'.$i));
				 		$kodeakun = $explode_rekening[0];
				 		$kodekelompok = $explode_rekening[1];
				 		$kodejenis = $explode_rekening[2];
				 		$kodeobjek = $explode_rekening[3];
	 					
	 					// convert money to int
	 					$rincian_convert = $this->input->post('jml_rincian_'.$i);						
						$substr_jumlah = $this->MoneyToInt($rincian_convert);
						
			 			$data_rinci = array(
			 				'TAHUN' => date('Y'),
				 			'KODEURUSAN' => $kodeurusan,
				 			'KODESUBURUSAN' => $kodesuburusan,
				 			'KODEORGANISASI' => $kodeorganisasi,
				 			'KODEDESA' => $kodedesa,
				 			'NO_BKU' => $this->input->post('no_bku'),
				 			'KODEBIDANG' =>0,
				 			'KODEPROGRAM' =>0,
				 			'KODEKEGIATAN' =>0,
				 			'KODEAKUN' =>$kodeakun,
				 			'KODEKELOMPOK'=>$kodekelompok,
				 			'KODEJENIS' =>$kodejenis,
				 			'KODEOBJEK'=>$kodeobjek,
				 			'PENERIMAAN' =>$substr_jumlah,
				 			'PENGELUARAN' =>0
	 					);
			 			// print_r($data_rinci);
	 					$this->m_bku->insert_spj_rinci($data_rinci);
			 			
			 		}
	 			}				
	 					
	 		

	 			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU SPJ Penerimaan Berhasil Disimpan. </div>");
	 		}else{
	 			//notif error
	 			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU SPJ Penerimaan Gagal Disimpan. </div>");
	 		}

	 		}else{
	 			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU SPJ Penerimaan Gagal Disimpan. </div>");
	 		} 	

	 			 
		}
		//redirect
		$bulan = $this->input->post('bulan');
		$jenis_jurnal = $this->input->post('jenisJurnal');
		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);
 	}

 	/*tambah spj*/
 	public function add_spj()
 	{
 		//$this->template->view('bku/add');
 		$this->form_validation->set_rules('no_bku', 'Nomer BKU', 'trim|required');
 		$this->form_validation->set_rules('selectspp', 'Nomer Bukti', 'trim|required');
 		// $this->form_validation->set_rules('is_pihak_ketiga','Jenis Pembayaran','required');
 		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required');
 		$this->form_validation->set_rules('kegiatan', 'Kegiatan', 'trim|required');
 		$this->form_validation->set_rules('tgl_bku', 'Tanggal BKU', 'trim|required');
 		$this->form_validation->set_rules('tgl_bukti', 'Tanggal Bukti', 'trim|required');
 		$this->form_validation->set_rules('jenistransaksi', 'Jenis Transaksi', 'required');

 		//tgl bku
 		$tgl_bku = $this->input->post('tgl_bku');
 		$exp_tgl_bku = explode('/', $tgl_bku);
 		$tanggal_bku = $exp_tgl_bku[1].'/'.$exp_tgl_bku[0].'/'.$exp_tgl_bku[2];
 		//tgl bukti
 		$tgl_bukti = $this->input->post('tgl_bukti');
 		$exp_tgl_bukti = explode('/', $tgl_bukti);
 		$tanggal_bukti = $exp_tgl_bukti[1].'/'.$exp_tgl_bukti[0].'/'.$exp_tgl_bukti[2];
 		
 		//explode koderekening
		$koderekening = explode('.', $this->input->post('koderekening'));
		$kodeurusan = $koderekening[0];
		$kodesuburusan = $koderekening[1];
		$kodeorganisasi = $koderekening[2];
		$kodedesa = $koderekening[3];

 		$tahun = date('Y');
 		if ($this->form_validation->run() == FALSE) {
			$this->template->view('bku/list');
			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data SPJ Gagal Disimpan. </div>");
		} else {

			$jml_penerimaan = ($this->input->post('jenistransaksi') == "SPP") ? $this->input->post('jumlah_all_terima') : 0 ;
			$jml_pengeluaran = ($this->input->post('jenistransaksi') == "SPJ") ? $this->input->post('jumlah_all_terima') : 0 ;
	 		$data = array(
	 			'TAHUN' => date('Y'),
	 			'KODEURUSAN' => $kodeurusan,
	 			'KODESUBURUSAN' => $kodesuburusan,
	 			'KODEORGANISASI' => $kodeorganisasi,
	 			'KODEDESA' => $kodedesa,
	 			'NO_BKU' => $this->input->post('no_bku'),
	 			'TGL_BKU' => $tanggal_bku,
	 			'URAIAN' => $this->input->post('uraian'),
	 			'NO_BUKTI' => $this->input->post('selectspp'),
	 			'TGL_BUKTI' => $tanggal_bukti,
	 			'JENIS_BKU' => $this->input->post('jenistransaksi'),
	 			'SIMPANANBANK' => 1,
	 			'PENERIMAAN' => $jml_penerimaan,
	 			'PENGELUARAN' => $jml_pengeluaran,
	 			'LOCKED' => 0,
	 			'USERNAME' => $this->session->username,
	 			'IS_PIHAK_KETIGA' => 0);
	 			
	 			
	 			
	 		
	 		if ($this->m_bku->insert_spj($data)){
	 			//notif success
	 			$jum_rincian = sizeof($this->input->post('jml_rincian'));
	 			//die();
	 		
	 			for ($i=0; $i < $jum_rincian ; $i++) {
	 			$penerimaan = $this->input->post('penerimaan_pengeluaran_'.$i);
				$pengeluaran = $this->input->post('penerimaan_pengeluaran_'.$i); 
	 				if($this->input->post('jenistransaksi') == "SPP"){
	 					$jml_penerimaan = $penerimaan;
	 					$jml_pengeluaran = 0;
	 				}else{
	 					$jml_penerimaan = 0;
	 					$jml_pengeluaran = $pengeluaran;
	 				}

	 				$data_rinci = array(
	 				'TAHUN' => date('Y'),
		 			'KODEURUSAN' => $kodeurusan,
		 			'KODESUBURUSAN' => $kodesuburusan,
		 			'KODEORGANISASI' => $kodeorganisasi,
		 			'KODEDESA' => $kodedesa,
		 			'NO_BKU' => $this->input->post('no_bku'),
		 			'KODEBIDANG' =>$this->input->post('kode_bidang_'.$i),
		 			'KODEPROGRAM' =>$this->input->post('kode_program_'.$i),
		 			'KODEKEGIATAN' =>$this->input->post('kode_kegiatan_'.$i),
		 			'KODEAKUN' =>$this->input->post('kode_akun_'.$i),
		 			'KODEKELOMPOK'=>$this->input->post('kode_kelompok_'.$i),
		 			'KODEJENIS' =>$this->input->post('kode_jenis_'.$i),
		 			'KODEOBJEK'=>$this->input->post('kode_objek_'.$i),
		 			'PENERIMAAN' =>$jml_penerimaan,
		 			'PENGELUARAN' =>$jml_pengeluaran
	 				);
	 				$this->m_bku->insert_spj_rinci($data_rinci);	
	 			}
	 			
	 			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU SPJ/SPP Berhasil Disimpan. </div>");
	 		}else{
	 			//notif error
	 			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU SPJ/SPP Gagal Disimpan. </div>");
	 		}	 
		}
		//redirect
		$bulan = $this->input->post('bulan');
		$jenis_jurnal = $this->input->post('jenisJurnal');
		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);
 	}
 	/* tambah pergeseran */
 	public function add_pergeseran(){ 		
 		//$this->template->view('bku/add');
 		$this->form_validation->set_rules('no_bku', 'Nomer BKU', 'trim|required');
 		$this->form_validation->set_rules('no_bukti', 'Nomer Bukti', 'trim|required');
 		$this->form_validation->set_rules('tgl_bku', 'Tanggal BKU', 'trim|required');
 		$this->form_validation->set_rules('tgl_bukti', 'Tanggal Bukti', 'trim|required');
 		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required');
 		$this->form_validation->set_rules('penerimaan', 'Penerimaan', 'trim|required');
 		$this->form_validation->set_rules('pengeluaran', 'Pengeluaran', 'trim|required');

 		//tgl bku
 		$tgl_bku = $this->input->post('tgl_bku');
 		$exp_tgl_bku = explode('/', $tgl_bku);
 		$tanggal_bku = $exp_tgl_bku[1].'/'.$exp_tgl_bku[0].'/'.$exp_tgl_bku[2];
 		//tgl bukti
 		$tgl_bukti = $this->input->post('tgl_bukti');
 		$exp_tgl_bukti = explode('/', $tgl_bukti);
 		$tanggal_bukti = $exp_tgl_bukti[1].'/'.$exp_tgl_bukti[0].'/'.$exp_tgl_bukti[2];
 		// koderekening
 		//explode koderekening
		$koderekening = explode('.', $this->input->post('koderekening'));
		$kodeurusan = $koderekening[0];
		$kodesuburusan = $koderekening[1];
		$kodeorganisasi = $koderekening[2];
		$kodedesa = $koderekening[3];
		$simpanan_bank = $this->input->post('simpananBank');
		// jumlah
		$penerimaan_pergeseran = str_replace('.', '', $this->input->post('penerimaan'));
		$pengeluaran_pergeseran = str_replace('.', '', $this->input->post('pengeluaran'));	


 		$tahun = date('Y');
 		if ($this->form_validation->run() === TRUE) {
			$this->template->view('bku/list');
			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Gagal Disimpan. </div>");
		} else {	
			if($simpanan_bank==1){
	 			// simpanan bank
	 			$penerimaan=0;
	 			$pengeluaran = $pengeluaran_pergeseran; 			
	 		}else if($simpanan_bank==2){
	 			// kas tunai
	 			$penerimaan = $penerimaan_pergeseran;	 			
	 			$pengeluaran=0;
	 		}

	 		$data = array(
	 			'TAHUN' => date('Y'),
	 			'KODEURUSAN' => $kodeurusan,
	 			'KODESUBURUSAN' => $kodesuburusan,
	 			'KODEORGANISASI' => $kodeorganisasi,
	 			'KODEDESA' => $kodedesa,
	 			'NO_BKU' => $this->input->post('no_bku'),
	 			'TGL_BKU' => $tanggal_bku,
	 			'URAIAN' => $this->input->post('uraian'),
	 			'NO_BUKTI' => $this->input->post('no_bukti'),
	 			'TGL_BUKTI' => $tanggal_bukti,
	 			'JENIS_BKU' => 'PERGESERAN',
	 			'SIMPANANBANK' => $simpanan_bank,
	 			'PENERIMAAN' => $penerimaan,
	 			'PENGELUARAN' => $pengeluaran,
	 			'LOCKED' => 0,
	 			'USERNAME' => $this->session->username,
	 			'IS_PIHAK_KETIGA' => 0);
	 		// print_r($data);
	 		if ($this->m_bku->insert_spj($data)){
	 			//notif success
	 			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Berhasil Disimpan. </div>");
	 		}else{
	 			//notif error
	 			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Gagal Disimpan. </div>");
	 		}	 
		}
		//redirect
		$bulan = $this->input->post('bulan');
		$jenis_jurnal = $this->input->post('jenisJurnal');
		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);

 	}

 	/* tambah pajak */
 	public function add_pajak(){ 		
 		//validasi
 		$this->form_validation->set_rules('no_bku', 'Nomer BKU', 'trim|required');
 		$this->form_validation->set_rules('no_bukti', 'Nomer Bukti', 'trim|required');
 		$this->form_validation->set_rules('tgl_bku', 'Tanggal BKU', 'trim|required');
 		$this->form_validation->set_rules('tgl_bukti', 'Tanggal Bukti', 'trim|required');
 		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required');
 		//$this->form_validation->set_rules('mytext[]', 'Pajak', 'required'); 

 		//tgl bku
 		$tgl_bku = $this->input->post('tgl_bku');
 		$exp_tgl_bku = explode('/', $tgl_bku);
 		$tanggal_bku = $exp_tgl_bku[1].'/'.$exp_tgl_bku[0].'/'.$exp_tgl_bku[2];
 		//tgl bukti
 		$tgl_bukti = $this->input->post('tgl_bukti');
 		$exp_tgl_bukti = explode('/', $tgl_bukti);
 		$tanggal_bukti = $exp_tgl_bukti[1].'/'.$exp_tgl_bukti[0].'/'.$exp_tgl_bukti[2];		
 		//explode koderekening
		$koderekening = explode('.', $this->input->post('koderekening'));
		$kodeurusan = $koderekening[0];
		$kodesuburusan = $koderekening[1];
		$kodeorganisasi = $koderekening[2];
		$kodedesa = $koderekening[3];			
		//sum nilai pajak
		$total = $this->input->post('jumlah_all_pajak');
 		// $total = str_replace('.', '', $pajak);	 		
 		// $total = array_sum($pajak_convert);
 		//penerimaan
 		$jenis_pajak = $this->input->post('jenisPajak');
 		if ($jenis_pajak==1) {
 			$penerimaan = $total;
 			$pengeluaran = 0;
 			$jenis_bku = 'PUNGUT-PAJAK';
 		} else {
 			$penerimaan = 0;
 			$pengeluaran = $total;
 			$jenis_bku = 'SETOR-PAJAK';
 		}

 		$tahun = date('Y');
 		if ($this->form_validation->run() == FALSE) {
			$this->template->view('bku/list');
			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Gagal Disimpan. </div>");
		} else {	
	 		//parameter bku
	 		$data = array(
	 			'TAHUN' => date('Y'),
	 			'KODEURUSAN' => $kodeurusan,
	 			'KODESUBURUSAN' => $kodesuburusan,
	 			'KODEORGANISASI' => $kodeorganisasi,
	 			'KODEDESA' => $kodedesa,
	 			'NO_BKU' => $this->input->post('no_bku'),
	 			'TGL_BKU' => $tanggal_bku,
	 			'URAIAN' => $this->input->post('uraian'),
	 			'NO_BUKTI' => $this->input->post('no_bukti'),
	 			'TGL_BUKTI' => $tanggal_bukti,
	 			'JENIS_BKU' => $jenis_bku,
	 			'SIMPANANBANK' => 1,
	 			'PENERIMAAN' => $penerimaan,
	 			'PENGELUARAN' => $pengeluaran,
	 			'LOCKED' => 0,
	 			'USERNAME' => $this->session->username,
	 			'IS_PIHAK_KETIGA'=>0);

	 		// explode rekening
			$count_pajak = $this->input->post('count_pajak');
			// echo "<pre>";
			// print_r($count_pajak+1);
			// die();			
			for($i=1; $i<($count_pajak+1); $i++){	 					
				$explode_rekening = explode('.', $this->input->post('select_name_'.$i));
		 		$kodeakun = $explode_rekening[0];
		 		$kodekelompok = $explode_rekening[1];
		 		$kodejenis = $explode_rekening[2];
		 		$kodeobjek = $explode_rekening[3];	
		 		// convert money to int
				$rincian_convert = $this->input->post('select_pajak_'.$i);						
				$substr_jumlah = $this->MoneyToInt($rincian_convert);	
				if ($jenis_pajak==1) {
		 			$penerimaan = $substr_jumlah;
		 			$pengeluaran = 0;		 			
		 		} else {
		 			$penerimaan = 0;
		 			$pengeluaran = $substr_jumlah;		 			
		 		}		
				// parameter bku rincian
		 		$data_rinci = array(
	 				'TAHUN' => date('Y'),
		 			'KODEURUSAN' => $kodeurusan,
		 			'KODESUBURUSAN' => $kodesuburusan,
		 			'KODEORGANISASI' => $kodeorganisasi,
		 			'KODEDESA' => $kodedesa,
		 			'NO_BKU' => $this->input->post('no_bku'),
		 			'KODEBIDANG' =>0,
		 			'KODEPROGRAM' =>0,
		 			'KODEKEGIATAN' =>0,
		 			'KODEAKUN' =>$kodeakun,
		 			'KODEKELOMPOK'=>$kodekelompok,
		 			'KODEJENIS' =>$kodejenis,
		 			'KODEOBJEK'=>$kodeobjek,
		 			'PENERIMAAN' =>$penerimaan,
		 			'PENGELUARAN' =>$pengeluaran);

		 		$this->m_bku->insert_spj_rinci($data_rinci);
				
			}

	 		if($this->m_bku->insert_spj($data)){
	 			//notif success	 
	 			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Berhasil Disimpan. </div>");			
	 		}else{
	 			//notif gagal
	 			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Gagal Disimpan. </div>");
	 		}
		}
		//redirect
		$bulan = $this->input->post('bulan');
		$jenis_jurnal = $this->input->post('jenisJurnal');		
		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);
 	}

 	/* ubah pergeseran */
 	public function edit_pergeseran(){
 		$this->form_validation->set_rules('no_bku', 'Nomer BKU', 'trim|required');
 		$this->form_validation->set_rules('no_bukti', 'Nomer Bukti', 'trim|required');
 		$this->form_validation->set_rules('tgl_bku', 'Tanggal BKU', 'trim|required');
 		$this->form_validation->set_rules('tgl_bukti', 'Tanggal Bukti', 'trim|required');
 		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required');
 		$this->form_validation->set_rules('penerimaan', 'Penerimaan', 'trim|required');
 		$this->form_validation->set_rules('pengeluaran', 'Pengeluaran', 'trim|required');

 		//tgl bku
 		$tgl_bku = $this->input->post('tgl_bku');
 		$exp_tgl_bku = explode('/', $tgl_bku);
 		$tanggal_bku = $exp_tgl_bku[1].'/'.$exp_tgl_bku[0].'/'.$exp_tgl_bku[2];
 		//tgl bukti
 		$tgl_bukti = $this->input->post('tgl_bukti');
 		$exp_tgl_bukti = explode('/', $tgl_bukti);
 		$tanggal_bukti = $exp_tgl_bukti[1].'/'.$exp_tgl_bukti[0].'/'.$exp_tgl_bukti[2];
 		//explode koderekening
		$koderekening = explode('.', $this->input->post('koderekening'));
		$kodeurusan = $koderekening[0];
		$kodesuburusan = $koderekening[1];
		$kodeorganisasi = $koderekening[2];
		$kodedesa = $koderekening[3];
		$simpanan_bank = $this->input->post('simpananBank');
		// jumlah
		$penerimaan_pergeseran = str_replace('.', '', $this->input->post('penerimaan'));
		$pengeluaran_pergeseran = str_replace('.', '', $this->input->post('pengeluaran'));
 		
 		$tahun = date('Y');
 		if ($this->form_validation->run() == FALSE) {
			$this->template->view('bku/list');
			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Gagal Disimpan. </div>");
		} else {	
	 		if($simpanan_bank==1){
	 			// simpanan bank
	 			$penerimaan=0;
	 			$pengeluaran = $pengeluaran_pergeseran; 			
	 		}else if($simpanan_bank==2){
	 			// kas tunai
	 			$penerimaan = $penerimaan_pergeseran;	 			
	 			$pengeluaran=0;
	 		}

	 		$data = array(
	 			'NO_BUKTI' => $this->input->post('no_bukti'),
	 			'JENIS_BKU' => 'PERGESERAN',
	 			'SIMPANANBANK' => $simpanan_bank,
	 			'URAIAN' => $this->input->post('uraian'),
	 			'PENERIMAAN' => $penerimaan,
	 			'PENGELUARAN' => $pengeluaran,
	 			'TGL_BKU' => $tanggal_bku,
	 			'TGL_BUKTI' => $tanggal_bukti,
	 			'TAHUN' => date('Y'),
	 			'KODEURUSAN' => $kodeurusan,
	 			'KODESUBURUSAN' => $kodesuburusan,
	 			'KODEORGANISASI' => $kodeorganisasi,
	 			'KODEDESA' => $kodedesa,
	 			'NO_BKU' => $this->input->post('no_bku'));
	 		
	 		if ($this->m_bku->edit($data)){
	 			//notif success
	 			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Berhasil Disimpan. </div>");
	 		}else{
	 			//notif error
	 			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Gagal Disimpan. </div>");
	 		}	 
		}
		//redirect
		$bulan = $this->input->post('bulan');
		$jenis_jurnal = $this->input->post('jenisJurnal');
		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);
 	}

 	/* ubah pajak */
 	public function edit_pajak(){
 		$this->form_validation->set_rules('no_bku', 'Nomer BKU', 'trim|required');
 		$this->form_validation->set_rules('no_bukti', 'Nomer Bukti', 'trim|required');
 		$this->form_validation->set_rules('tgl_bku', 'Tanggal BKU', 'trim|required');
 		$this->form_validation->set_rules('tgl_bukti', 'Tanggal Bukti', 'trim|required');
 		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required');

 		//tgl bku
 		$tgl_bku = $this->input->post('tgl_bku');
 		$exp_tgl_bku = explode('/', $tgl_bku);
 		$tanggal_bku = $exp_tgl_bku[1].'/'.$exp_tgl_bku[0].'/'.$exp_tgl_bku[2];
 		//tgl bukti
 		$tgl_bukti = $this->input->post('tgl_bukti');
 		$exp_tgl_bukti = explode('/', $tgl_bukti);
 		$tanggal_bukti = $exp_tgl_bukti[1].'/'.$exp_tgl_bukti[0].'/'.$exp_tgl_bukti[2];		

 		$tahun = date('Y');
 		if ($this->form_validation->run() == FALSE) {
			$this->template->view('bku/list');
			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Gagal Disimpan. </div>");
		} else {			
			//explode koderekening
			$koderekening = explode('.', $this->input->post('koderekening'));
			$kodeurusan = $koderekening[0];
			$kodesuburusan = $koderekening[1];
			$kodeorganisasi = $koderekening[2];
			$kodedesa = $koderekening[3];
			//sum nilai pajak
			$pajak = $this->input->post('mytext');
	 		$pajak_convert = str_replace('.', '', $pajak);	 		
	 		$total = array_sum($pajak_convert);
	 		//penerimaan
	 		$jenis_pajak = $this->input->post('jenisPajak');
	 		if ($jenis_pajak==1) {
	 			$penerimaan = $total;
	 			$pengeluaran = 0;
	 			$jenis_bku = 'PUNGUT-PAJAK';
	 		} else {
	 			$penerimaan = 0;
	 			$pengeluaran = $total;
	 			$jenis_bku = 'SETOR-PAJAK';
	 		}	

	 		//data array
	 		$data = array(
	 			'NO_BUKTI' => $this->input->post('no_bukti'),
	 			'JENIS_BKU' => $jenis_bku,
	 			'SIMPANANBANK' => 1,
	 			'URAIAN' => $this->input->post('uraian'),
	 			'PENERIMAAN' => $penerimaan,
	 			'PENGELUARAN' => $pengeluaran,
	 			'TGL_BKU' => $tanggal_bku,
	 			'TGL_BUKTI' => $tanggal_bukti,
	 			'TAHUN' => date('Y'),
	 			'KODEURUSAN' => $kodeurusan,
	 			'KODESUBURUSAN' => $kodesuburusan,
	 			'KODEORGANISASI' => $kodeorganisasi,
	 			'KODEDESA' => $kodedesa,
	 			'NO_BKU' => $this->input->post('no_bku')); 		 		

	 		if($this->m_bku->edit($data)){
	 			//notif success	 
	 			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Berhasil Disimpan. </div>");			
	 		}else{
	 			//notif gagal
	 			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pergeseran Gagal Disimpan. </div>");
	 		}
		}
		//redirect
		$bulan = $this->input->post('bulan');
		$jenis_jurnal = $this->input->post('jenisJurnal');		
		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);
 	}	

 	// ubah spj
 	public function ubah_spj()
 	{
		$this->form_validation->set_rules('no_bku', 'Nomer BKU', 'trim|required');
 		//$this->form_validation->set_rules('no_bukti', 'Nomer Bukti', 'trim|required');
 		$this->form_validation->set_rules('tgl_bku', 'Tanggal BKU', 'trim|required');
 		$this->form_validation->set_rules('tgl_bukti', 'Tanggal Bukti', 'trim|required');
 		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required');

 		//tgl bku
 		$tgl_bku = $this->input->post('tgl_bku');
 		$exp_tgl_bku = explode('/', $tgl_bku);
 		$tanggal_bku = $exp_tgl_bku[1].'/'.$exp_tgl_bku[0].'/'.$exp_tgl_bku[2];
 		//tgl bukti
 		$tgl_bukti = $this->input->post('tgl_bukti');
 		$exp_tgl_bukti = explode('/', $tgl_bukti);
 		$tanggal_bukti = $exp_tgl_bukti[1].'/'.$exp_tgl_bukti[0].'/'.$exp_tgl_bukti[2];	
 		//explode koderekening
		$koderekening = explode('.', $this->input->post('koderekening'));
		$kodeurusan = $koderekening[0];
		$kodesuburusan = $koderekening[1];
		$kodeorganisasi = $koderekening[2];
		$kodedesa = $koderekening[3];
		$tahun = $this->input->post('tahun');

 		if ($this->form_validation->run() == FALSE) {
			$this->template->view('bku/list');
			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Gagal Diubah. </div>");
		} else {			
			
 			// var_dump($koderekening);
 			$penerimaan = $this->input->post('jumlah_all');
			$pengeluaran = $this->input->post('jumlah_all');
			if($this->input->post('jenistransaksi') == "SPP"){
	 					$jml_penerimaan = $penerimaan;
	 					$jml_pengeluaran = 0;
	 				}else{
	 					$jml_penerimaan = 0;
	 					$jml_pengeluaran = $pengeluaran;
	 				}
			//die($jml_penerimaan);
 			$params = array(
 					  'JENIS_BKU' => $this->input->post('jenistransaksi'),
 					  'URAIAN' => $this->input->post('uraian'),
 					  'TGL_BKU' =>$tanggal_bku,
 					  'TGL_BUKTI' => $tanggal_bukti,
 					  'IS_PIHAK_KETIGA' => 0,
 					  'PENERIMAAN' => $jml_penerimaan,
 					  'PENGELUARAN' => $jml_pengeluaran
 				);
 			$whereparams = array(
 					   'TAHUN' => $tahun,
 					  'KODEURUSAN' => $kodeurusan,
 					  'KODESUBURUSAN' => $kodesuburusan,
 					  'KODEORGANISASI' => $kodeorganisasi,
 					  'KODEDESA' => $kodedesa,
 					  'NO_BKU' => $this->input->post('no_bku')
 						);
 			//die(var_dump($params));
 			if ($this->m_bku->edit_spj($whereparams,$params)) {
 				$jum_rincian = sizeof($this->input->post('jml_rincian'));
	 			//die();
	 		
	 			for ($i=0; $i < $jum_rincian ; $i++) {
	 			$penerimaan = $this->input->post('penerimaan_pengeluaran_'.$i);
				$pengeluaran = $this->input->post('penerimaan_pengeluaran_'.$i); 
	 				if($this->input->post('jenistransaksi') == "SPP"){
	 					$jml_penerimaan = $penerimaan;
	 					$jml_pengeluaran = 0;
	 				}else{
	 					$jml_penerimaan = 0;
	 					$jml_pengeluaran = $pengeluaran;
	 				}

	 				$data_rinci = array(
		 			'PENERIMAAN' =>$this->MoneyToInt($jml_penerimaan),
		 			'PENGELUARAN' =>$this->MoneyToInt($jml_pengeluaran)
	 				);
	 				$whereparams_rinci = array(
	 				'TAHUN' => $tahun,
		 			'KODEURUSAN' => $kodeurusan,
		 			'KODESUBURUSAN' => $kodesuburusan,
		 			'KODEORGANISASI' => $kodeorganisasi,
		 			'KODEDESA' => $kodedesa,
		 			'NO_BKU' => $this->input->post('no_bku'),
		 			'KODEBIDANG' =>$this->input->post('kode_bidang_'.$i),
		 			'KODEPROGRAM' =>$this->input->post('kode_program_'.$i),
		 			'KODEKEGIATAN' =>$this->input->post('kode_kegiatan_'.$i),
		 			'KODEAKUN' =>$this->input->post('kode_akun_'.$i),
		 			'KODEKELOMPOK'=>$this->input->post('kode_kelompok_'.$i),
		 			'KODEJENIS' =>$this->input->post('kode_jenis_'.$i),
		 			'KODEOBJEK'=>$this->input->post('kode_objek_'.$i)
	 					);
	 				$this->m_bku->ubah_spj_rinci($whereparams_rinci,$data_rinci);	
	 			}
 				$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Berhasil Diubah. </div>");
 			}else{
 				$this->session->set_flashdata('Sukses', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Gagal Diubah. </div>");
 			}
		}

		//redirect
		$bulan = $this->input->post('bulan');
		$jenis_jurnal = $this->input->post('jenisJurnal');		
		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);
 			
 	}

 	// ubah spj penerimaan
 	public function edit_spj_penerimaan()
 	{
		$this->form_validation->set_rules('no_bku', 'Nomer BKU', 'trim|required');
		$this->form_validation->set_rules('no_bukti', 'Nomer Bukti', 'trim|required');
 		$this->form_validation->set_rules('tgl_bku', 'Tanggal BKU', 'trim|required');
 		$this->form_validation->set_rules('tgl_bukti', 'Tanggal Bukti', 'trim|required');
 		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|required');

 		//tgl bku
 		$tgl_bku = $this->input->post('tgl_bku');
 		$exp_tgl_bku = explode('/', $tgl_bku);
 		$tanggal_bku = $exp_tgl_bku[1].'/'.$exp_tgl_bku[0].'/'.$exp_tgl_bku[2];
 		//tgl bukti
 		$tgl_bukti = $this->input->post('tgl_bukti');
 		$exp_tgl_bukti = explode('/', $tgl_bukti);
 		$tanggal_bukti = $exp_tgl_bukti[1].'/'.$exp_tgl_bukti[0].'/'.$exp_tgl_bukti[2];	
 		//explode koderekening
		$koderekening = explode('.', $this->input->post('koderekening'));
		$kodeurusan = $koderekening[0];
		$kodesuburusan = $koderekening[1];
		$kodeorganisasi = $koderekening[2];
		$kodedesa = $koderekening[3];
		$tahun = $this->input->post('tahun');

 		if ($this->form_validation->run() == FALSE) {
			$this->template->view('bku/list');
			$this->session->set_flashdata('Gagal', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Gagal Diubah. </div>");
		} else {			
			
 			// var_dump($koderekening);
 			$penerimaan = $this->input->post('jumlah_all_terima_edit');
 			$jml_penerimaan = str_replace('.', '', $penerimaan);	
			// $pengeluaran = $this->input->post('jumlah_all');

 			$params = array(
 					  'JENIS_BKU' => 'PENERIMAAN',
 					  'BUKTI' => $this->input->post('no_bukti'),
 					  'URAIAN' => $this->input->post('uraian'),
 					  'TGL_BKU' =>$tanggal_bku,
 					  'TGL_BUKTI' => $tanggal_bukti,
 					  'IS_PIHAK_KETIGA' => 0,
 					  'PENERIMAAN' => $jml_penerimaan,
 					  'PENGELUARAN' => 0
 				);

 			$whereparams = array(
 					   	'TAHUN' => $tahun,
	 					'KODEURUSAN' => $kodeurusan,
	 					'KODESUBURUSAN' => $kodesuburusan,
	 					'KODEORGANISASI' => $kodeorganisasi,
	 					'KODEDESA' => $kodedesa,
	 					'NO_BKU' => $this->input->post('no_bku')
 				);

 			//die(var_dump($params));
 			if ($this->m_bku->edit_spj($whereparams,$params)) {
 				$jumlah_penerimaan = $this->input->post('jml_penerimaan');
	 			//die();

	 			if(isset($jumlah_penerimaan)){	 			 				
	 				// for ($i=0; $i < $jumlah_convert ; $i++) {
	 				for($i=0; $i<sizeof($jumlah_penerimaan); $i++){	 					
	 					$explode_rekening = explode('.', $this->input->post('rekening_rincian_'.$i));
				 		$kodeakun = $explode_rekening[0];
				 		$kodekelompok = $explode_rekening[1];
				 		$kodejenis = $explode_rekening[2];
				 		$kodeobjek = $explode_rekening[3];
	 					
	 					
	 					$rincian_convert = $this->input->post('jml_rincian_'.$i);
						// $jml_rincian= str_replace('.', '', $rincian_convert);
						// $substr_jumlah = substr($jml_rincian, 0, -3);
	 					$substr_jumlah = $this->MoneyToInt($rincian_convert);
						// print_r($substr_jumlah);
						// die();			 			

	 					$data_rinci = array(
				 			'PENERIMAAN' =>$substr_jumlah,
				 			'PENGELUARAN' =>0
	 					);
		 				$whereparams_rinci = array(
			 				'TAHUN' => $tahun,
				 			'KODEURUSAN' => $kodeurusan,
				 			'KODESUBURUSAN' => $kodesuburusan,
				 			'KODEORGANISASI' => $kodeorganisasi,
				 			'KODEDESA' => $kodedesa,
				 			'NO_BKU' => $this->input->post('no_bku'),
				 			'KODEBIDANG' =>0,
				 			'KODEPROGRAM' =>0,
				 			'KODEKEGIATAN' =>0,
				 			'KODEAKUN' =>$kodeakun,
				 			'KODEKELOMPOK'=>$kodekelompok,
				 			'KODEJENIS' =>$kodejenis,
				 			'KODEOBJEK'=>$kodeobjek
		 				);

	 					$this->m_bku->ubah_spj_rinci($whereparams_rinci,$data_rinci);	
			 			
			 		}
	 			}	 		
	 			
 				$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Berhasil Diubah. </div>");
 			}else{
 				$this->session->set_flashdata('Sukses', "<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Gagal Diubah. </div>");
 			}
		}

		//redirect
		$bulan = $this->input->post('bulan');
		$jenis_jurnal = $this->input->post('jenisJurnal');		
		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);
 			
 	}

 	//ambil data penerimaan mau di edit
 	public function view_edit_penerimaan(){
 		if (isset($_POST['tahun'])) {
 			$data_spj_by_nobku = $this->m_bku->view_spjpenerimaan_nobku($_POST['tahun'],$_POST['kodeurusan'],$_POST['kodesuburusan'],$_POST['kodeorganisasi'],$_POST['kodedesa'],$_POST['no_bku']);

 			$jsondata=array();
 			if (sizeof($data_spj_by_nobku) > 0) {
 				header('Content-Type: application/json; charset=utf-8', true);
 				foreach ($data_spj_by_nobku as $val) {
 						$jsondata[] = array(
 									'KODEBIDANG'=>$val['KODEBIDANG'],
 									'KODEPROGRAM'=>$val['KODEPROGRAM'],
 									'KODEKEGIATAN'=>$val['KODEKEGIATAN'],
 									'KEGIATAN' => $val['KEGIATAN'],
 									'KODEAKUN'=>$val['KODEAKUN'],
 									'KODEKELOMPOK'=>$val['KODEKELOMPOK'],
 									'KODEJENIS'=>$val['KODEJENIS'],
 									'KODEOBJEK'=>$val['KODEOBJEK'],
 									'REKENING'=>$val['REKENING'],
 									'URAI_REKENING'=>$val['URAI_REKENING'],
 									'TGL_BKU' =>$val['TGL_BKU'],
 									'JENIS_BKU' =>$val['JENIS_BKU'],
 									'TGL_BUKTI' =>$val['TGL_BUKTI'],
 									'BUKTI' =>$val['BUKTI'],
 									'URAI_SPP' =>$val['URAI_SPP'],
 									'SIMPANANBANK' =>$val['SIMPANANBANK'],
 									'IS_PIHAK_KETIGA' =>$val['IS_PIHAK_KETIGA'],
 									'PENERIMAAN' =>$val['PENERIMAAN'],
 									'PENGELUARAN' =>$val['PENGELUARAN'],
 									'ANGGARAN' =>$val['ANGGARAN'],
 									'TAHUN' =>$val['XTAHUN'],
 									'JUMLAH' =>$val['JUMLAH'],
 									);
 				}
 				echo json_encode(utf8ize($jsondata));
 			}else{
 				echo json_encode('fail');
 			}
 		} else {
 			echo "Mising Parameter";
 		} 		
 	}

 	//ambil data yang mau di edit
 	public function view_edit_spj()
 	{
 		if (isset($_POST['tahun'])) {
 			$data_spj_by_nobku = $this->m_bku->view_spj_nobku($_POST['tahun'],$_POST['kodeurusan'],$_POST['kodesuburusan'],$_POST['kodeorganisasi'],$_POST['kodedesa'],$_POST['no_bku']);

 			$jsondata=array();
 			if (sizeof($data_spj_by_nobku) > 0) {
 				header('Content-Type: application/json; charset=utf-8', true);
 				foreach ($data_spj_by_nobku as $val) {
 						$jsondata[] = array(
 									'KODEBIDANG'=>$val['KODEBIDANG'],
 									'KODEPROGRAM'=>$val['KODEPROGRAM'],
 									'KODEKEGIATAN'=>$val['KODEKEGIATAN'],
 									'KEGIATAN' => $val['KEGIATAN'],
 									'KODEAKUN'=>$val['KODEAKUN'],
 									'KODEKELOMPOK'=>$val['KODEKELOMPOK'],
 									'KODEJENIS'=>$val['KODEJENIS'],
 									'KODEOBJEK'=>$val['KODEOBJEK'],
 									'REKENING'=>$val['REKENING'],
 									'URAI_REKENING'=>$val['URAI_REKENING'],
 									'TGL_BKU' =>$val['TGL_BKU'],
 									'JENIS_BKU' =>$val['JENIS_BKU'],
 									'TGL_BUKTI' =>$val['TGL_BUKTI'],
 									'BUKTI' =>$val['BUKTI'],
 									'URAI_SPP' =>$val['URAI_SPP'],
 									'SIMPANANBANK' =>$val['SIMPANANBANK'],
 									'IS_PIHAK_KETIGA' =>$val['IS_PIHAK_KETIGA'],
 									'PENERIMAAN' =>$val['PENERIMAAN'],
 									'PENGELUARAN' =>$val['PENGELUARAN'],
 									'ANGGARAN' =>$val['ANGGARAN'],
 									'TAHUN' =>$val['XTAHUN'],
 									'JUMLAH' =>$val['JUMLAH'],
 									);
 				}
 				echo json_encode(utf8ize($jsondata));
 			}else{
 				echo json_encode('fail');
 			}
 		} else {
 			echo "Mising Parameter";
 		}
 		
 	}

 	/* hapus bku */
 	public function delete($tahun="",$kodeurusan="",$kodesuburusan="",$kodeorganisasi="",$kodedesa="",$nobku="",$bulan="",$jenis_jurnal=""){
 		//parameter
 		// $kodeorganisasi = sprintf("%02d", $kodeorganisasi);
 		// $kodedesa = sprintf("%02d", $kodedesa);
 		$params = array($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$nobku);
 		// print_r($params);
 		// die();
 		if($this->m_bku->delete($params) && $this->m_bku->delete_rincian_spj($params)){
 			//default success
 			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU Berhasil dihapus. </div>");
 		}else{
 			//default error
 			$this->session->set_flashdata('Sukses', "<div class='alert alert-warning alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU Gagal dihapus. </div>");
 		}
 		//redirect 		
 		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);

 	}

 	// hapus bku spj dan rinciannya
 	public function delete_spj_bku($tahun="",$kodeurusan="",$kodesuburusan="",$kodeorganisasi="",$kodedesa="",$nobku="",$bulan="",$jenis_jurnal=""){
 		//parameter
 		$kodeorganisasi = sprintf("%02d", $kodeorganisasi);
 		$kodedesa = sprintf("%02d", $kodedesa);
 		$params = array($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$nobku);
 		if($this->m_bku->delete($params)){
 			//default success
 			$this->m_bku->delete_rincian_spj($params);
 			
 		}else{
 			//default error
 			$this->session->set_flashdata('Sukses', "<div class='alert alert-warning alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU Gagal dihapus. </div>");
 		}
 		//redirect
 		$this->session->set_flashdata('Sukses', "<div class='alert alert-warning alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data BKU Berhasil dihapus. </div>");
 		redirect('bku/buku_kas_umum/search/'.$tahun.'/'.$kodeurusan.'/'.$kodesuburusan.'/'.$kodeorganisasi.'/'.$kodedesa.'/'.$bulan.'/'.$jenis_jurnal);

 	}
 	/*ambil data berdasarkan nospp*/
 	public function nospp()
 	{
 		if(isset($_POST['nospp'])){
 			$data = array('NO_SPP' => $_POST['nospp'] );
 			$spj_bku = $this->m_bku->view_spj_bku($_POST['tahun'],$_POST['kodeurusan'],$_POST['kodesuburusan'],$_POST['kodeorganisasi'],$_POST['kodedesa'],$_POST['nospp']);
 			//print_r($spj_bku);
 			$jsondata=array();
 			if (sizeof($spj_bku) > 0) {
 				header('Content-Type: application/json; charset=utf-8', true);
 				foreach ($spj_bku as $val) {
 						$jsondata[] = array(
 									'KODEBIDANG'=>$val['KODEBIDANG'],
 									'KODEPROGRAM'=>$val['KODEPROGRAM'],
 									'KODEKEGIATAN'=>$val['KODEKEGIATAN'],
 									'URAI_KEGIATAN'=>$val['REKENING_KEGIATAN'],
 									'KODEAKUN'=>$val['KODEAKUN'],
 									'KODEKELOMPOK'=>$val['KODEKELOMPOK'],
 									'KODEJENIS'=>$val['KODEJENIS'],
 									'KODEOBJEK'=>$val['KODEOBJEK'],
 									'KODEREKENING'=>$val['KODEREKENING'],
 									'URAI_REKENING'=>$val['URAI_REKENING'],
 									'URAI'=>$val['URAI'],
 									'ANGGARAN'=>$val['ANGGARAN'],
 									'JUMLAH'=>$val['JUMLAH'],
 									);
 				}
 				echo json_encode(utf8ize($jsondata));
 			}else{
 				echo json_encode('fail');
 			}
	
 		}else{
 			echo "Missing parameter";
 		}
 	}

 	// ambil data no bukti berdasarkan jenistransaksi
 	public function no_bukti_by_jenis()
 	{
 		$jenis = $this->input->post('jenis');
 		if (isset($jenis)) {
 			// console.log($_POST['jenis']);
 			$tahun = $this->input->post('tahun');
 			$kodeurusan = $this->input->post('kodeurusan');
 			$kodesuburusan = $this->input->post('kodesuburusan');
 			$kodeorganisasi = $this->input->post('kodeorganisasi');
 			$kodedesa = $this->input->post('kodedesa'); 			
 			$data_no_bukti = $this->m_bku->no_bukti_by_jenis($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$jenis);
 			if(!empty($data_no_bukti)){
 				foreach ($data_no_bukti as $val) {
 					$data[] = $val['NOMOR_BUKTI'];
 				}
 			}else{
 				$data[]= 0;
 			}			
 			echo json_encode($data);

 		}else{
 			echo "Missing parameter";
 		}
 	}

 	// ubah format uang ex 1.000.000,00 to int
 	public function MoneyToInt($str)
 	{
 		return (int)preg_replace("/([^0-9\\,])/i", "", $str);
 	}

 	// get pajak
 	public function getPajak(){
 		if (isset($_POST['tahun'])) {
 			$data_pajak = $this->m_bku->getPajakPotongan($_POST['tahun']);

 			$jsondata=array();
 			if (sizeof($data_pajak) > 0) {
 				header('Content-Type: application/json; charset=utf-8', true);
 				foreach ($data_pajak as $val) {
 						$jsondata[] = array( 									
 									'KODEAKUN'=>$val['KODEAKUN'],
 									'KODEKELOMPOK'=>$val['KODEKELOMPOK'],
 									'KODEJENIS'=>$val['KODEJENIS'],
 									'KODEOBJEK'=>$val['KODEOBJEK'],
 									'SINGKAT'=>$val['SINGKAT'],
 									);
 				}
 				echo json_encode(utf8ize($jsondata));
 			}else{
 				echo json_encode('fail');
 			}
 		} else {
 			echo "Mising Parameter";
 		} 
 	}

 	// get pajak by no bku
 	public function getPajakByBKU(){
 		$tahun = $this->input->post('tahun');
 		$no_bku = $this->input->post('no_bku');
 		if (isset($no_bku)) {
 			$data_pajak = $this->m_bku->getPajakByNoBKU($tahun,$no_bku);

 			$jsondata=array();
 			if (sizeof($data_pajak) > 0) {
 				header('Content-Type: application/json; charset=utf-8', true);
 				foreach ($data_pajak as $val) {
 						$jsondata[] = array( 									
 									'KODEAKUN'=>$val['KODEAKUN'],
 									'KODEKELOMPOK'=>$val['KODEKELOMPOK'],
 									'KODEJENIS'=>$val['KODEJENIS'],
 									'KODEOBJEK'=>$val['KODEOBJEK'],
 									'PENERIMAAN'=>$val['PENERIMAAN'],
 									'PENGELUARAN'=>$val['PENGELUARAN'],
 									);
 				}
 				echo json_encode(utf8ize($jsondata));
 			}else{
 				echo json_encode('fail');
 			}
 		} else {
 			echo "Mising Parameter";
 		} 
 	}
}




?>