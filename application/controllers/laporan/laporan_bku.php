<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  created by aan (kurnianto.tn@gin.co.id)
*/


class laporan_bku extends CI_Controller
{
	
	private $page_name = "Laporan Buku Kas Umum";
	function __construct()
	{
		parent::__construct();
		$this->libauth->cek_login();
		//load model
		$this->load->model('m_verifikasi');		
		$this->load->model('m_bku');	
		$this->load->model('m_org');	
		$this->load->model('m_pejabat_pengesah');	
		//
		app::set('web_heading',$this->page_name);
		app::bc($this->page_name,'/laporan/laporan_bku');
	}

	//index
	public function index($idUrusan=0,$idSuburusan=0,$idKec=0,$idDes=0,$jnslaporan=0){
		$params = date('Y');
		$data['result_inp_kec']=$this->m_verifikasi->getOrganisasi(array('KODEDESA' => ''));
		$data['alldesa']=$this->m_verifikasi->getOrganisasi(array('KODEDESA !=' => ''));
		$data['idUrusan'] = $idUrusan;
		$data['idSuburusan'] = $idSuburusan;
		$data['idKec'] = $idKec;
		$data['idDes'] = $idDes;
		$data['jnslaporan'] = 0 ;	
		$data['idKepala'] = 0;
		$data['idBendahara'] = 0;
		// $data['desa'] = $this->m_pejabat_pengesah->getNamaDesa($params);	
		// setting hak akses 
		$kodekode = kodekode();
		$id_kec =  $this->session->kd_organisasi;
		$is_des = in_array($this->session->hakakses, array('OPERATORDESA','SEKDES','KEPALADESA')) ? true : false; // true: kalau login sebagai user-dari-desa
		$id_des =  $this->session->kd_desa;

		$tbl = $this->m_org->model_table = $this->m_org->model_table2; // ganti table
		if ($is_des) {
			$cond_org['KODEORGANISASI'] = $id_kec;
			$cond_org['KODEDESA'] = $id_des;
		} else {
			$this->db->where_in($tbl . '.KODEORGANISASI', array_map('q1', $kodekode['kec']), false);
			$cond_org['KODEDESA !='] = '';
		}
		$inst = $this->m_org->read_many($cond_org, array('*'), false);
		$data['desa'] = $inst['data'];		
		//---------------------------------------------

		// all data
		$this->template->view('report/bku/index',$data);		
 	} 

 	private function json($arr)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($arr));
	}
	
 	public function all_pejabat($kd_urusan=null, $kd_suburusan=null, $id_kec = null, $id_desa = null)
	{
		
		$this->json($this->m_bku->all_pejabat($kd_urusan, $kd_suburusan, $id_kec, $id_desa));

	}

	public function pejabat_by_id($kd_urusan=null, $kd_suburusan=null, $id_kec = null, $id_desa = null, $id=null)
	{
		
		$this->json($this->m_bku->get_pejabat_by_id($kd_urusan, $kd_suburusan, $id_kec, $id_desa, $id));
	}

 	//cetak tidak dipake
 	public function cetak(){
 		$params = date('Y'); 		
 		$koderekening = explode('.', $this->input->post('namadesa'));
 		$id_kepala_desa = explode('.', $this->input->post('kepala_desa'));
 		$id_bend_desa = explode('.', $this->input->post('bendahara_desa'));
 		if (isset($koderekening) && $koderekening!=0) { 		
	 		$data['result_inp_kec']=$this->m_verifikasi->getOrganisasi(array('KODEDESA' => ''));
			$data['alldesa']=$this->m_verifikasi->getOrganisasi(array('KODEDESA !=' => ''));
			$data['idUrusan'] = $koderekening[0];
			$data['idSuburusan'] = $koderekening[1];
			$data['idKec'] = $koderekening[2];
			$data['idDes'] = $koderekening[3];
			$data['jnslaporan'] = $this->input->post('jenis_laporan');
			$data['idKepala'] = $id_kepala_desa[4];
			$data['idBendahara'] = $id_bend_desa[4];
			$data['desa'] = $this->m_pejabat_pengesah->getNamaDesa($params);
			
	 		$jenis_laporan = $this->input->post('jenis_laporan');
	 		$nama_pejabat = $this->input->post('namaKepdes');
	 		$nip_pejabat = $this->input->post('nipKepdes');
	 		$nama_bendahara = $this->input->post('namaBendes');
	 		$nip_bendahara = $this->input->post('nipBendes');
	 		$tgl_awal = $this->input->post('tgl_awal');
	 		$tgl_akhir = $this->input->post('tgl_akhir');
	 		$tgl_cetak = $this->input->post('tgl_cetak');
	 		
	 		$tanggal_awal = str_replace('/', '.', $this->input->post('tgl_awal'));
	 		$tanggal_akhir = str_replace('/', '.', $this->input->post('tgl_akhir')); 		

	 		$tahun = date('Y');
	 		$kodeurusan = $koderekening[0];
	 		$kodesuburusan = $koderekening[1];
	 		$kodeorganisasi = $koderekening[2];
	 		$kodedesa = $koderekening[3]; 		
	 		if($jenis_laporan!=0){
	 			if($jenis_laporan==1){
	 				$path_file = 'BKU/BukuKasUmum.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'"); 
					</script>'; 								
	 			}elseif($jenis_laporan==2){
	 				$path_file = 'BKU/BukuKasPembantuKegiatan.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");  
					</script>'; 
	 			}elseif($jenis_laporan==3){
	 				$path_file = 'BKU/BukuKasPembantuPajak.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");   
					</script>'; 
	 			}elseif($jenis_laporan==4){
	 				$path_file = 'BKU/BukuBankDesa.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");   
					</script>'; 
	 			}elseif($jenis_laporan==5){
	 				$path_file = 'BKU/RealisasiPelaksanaan.fr3'; 				
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'"); 
					</script>'; 
	 			}elseif($jenis_laporan==6){
	 				$path_file = 'BKU/RealisasiPelaksanaanSmtAhir.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");   
					</script>'; 
	 			}elseif($jenis_laporan==7){
	 				$path_file = 'BKU/LaporanPertanggungjawabanRealisasi.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");   
					</script>'; 
	 			}elseif($jenis_laporan==8){
	 				$path_file = 'BKU/Lampiran1.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");   
					</script>'; 
	 			}elseif($jenis_laporan==9){
	 				$path_file = 'BKU/Lampiran2.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");  
					</script>'; 
	 			}elseif($jenis_laporan==10){
	 				$path_file = 'BKU/Lampiran3.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");  
					</script>'; 
	 			}else{
	 				$path_file = 'SPP/SPP.fr3';
	 				echo '<script> 
					window.open("'.base_url().'resource/report/?report_type=pdf&file='.$path_file.'&tahun='.$tahun.'&kodeurusan='.$kodeurusan.'&kodesuburusan='.$kodesuburusan.'&kodeorganisasi='.$kodeorganisasi.'&kodedesa='.$kodedesa.'&Nama_Pejabat='.$nama_pejabat.'&NIP_Pejabat='.$nip_pejabat.'&Nama_Bendahara='.$nama_bendahara.'&NIP_Bendahara='.$nip_bendahara.'&tgl_awal='.$tanggal_awal.'&tgl_akhir='.$tanggal_akhir.'&tgl_cetak='.$tgl_cetak.'");  
					</script>'; 
	 			}
	 		}
	 		// redirect
	 		$this->template->view('report/bku/index',$data);	 		
	 	}else{
	 		redirect('laporan/laporan_bku');
 		}
 		
 	}
}




?>