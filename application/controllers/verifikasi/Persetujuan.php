<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Persetujuan  extends CI_Controller {

	private $page_name = "Verifikasi Persetujuan";

	function __construct() {
		parent::__construct();
		$this->libauth->cek_login();
		$this->load->model('m_verifikasi');
		$this->load->model('m_pejabat_pengesah');
		$this->load->model('m_org');
		app::set( 'web_heading', $this->page_name );
		app::bc( $this->page_name,'verifikasi/persetujuan');
	}

	public function index($kodeurusan=0,$kodesuburusan=0,$idKec=0,$idDes=0) {
		app::bc('Daftar Persetujuan','/verifikasi/persetujuan');		
		$tahun = $this->session->userdata('tahun');
		$data['result_inp_kec']=$this->m_verifikasi->getOrganisasi(array('KODEDESA' => ''));
		$data['alldesa']=$this->m_verifikasi->getOrganisasi(array('KODEDESA !=' => ''));
		$data['idKec'] = $idKec;
		$data['idDes'] = $idDes;
		$data['idDesa'] = $kodeurusan.'.'.$kodesuburusan.'.'.$idKec.'.'.$idDes;				
		$data['dataspp']  = array();
		$param = array(
				'TAHUN' =>$this->session->userdata('tahun'),
				'KODEURUSAN' =>$kodeurusan, 
				'KODESUBURUSAN' =>$kodesuburusan, 
				'KODEORGANISASI' =>$idKec, 
				'KODEDESA' =>$idDes,
				// 'STATUS_PERSETUJUAN' =>0,
				// 'STATUS_PENGESAHAN' => 0 
				);
		$param2 = array(
				'TAHUN' =>$this->session->userdata('tahun'),
				'KODEURUSAN' =>$kodeurusan, 
				'KODESUBURUSAN' =>$kodesuburusan, 
				'KODEORGANISASI' =>$idKec, 
				'KODEDESA' =>""
				);

		$dataspp = $this->m_verifikasi->getSPP($param);		
		// print_r($dataspp);
		// $data['desa'] = $this->m_pejabat_pengesah->getNamaDesa($tahun);
		
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

		$data['selectedKec'] = $this->m_verifikasi->getOrganisasi($param2);
		$data['dataspp'] =$dataspp;
		
		if (!$this->input->post('namadesa') == "0") {
			$organisasi = explode('.', $this->input->post('namadesa'));
			redirect(base_url("verifikasi/persetujuan/index/".$organisasi[0]."/".$organisasi[1]."/".$organisasi[2]."/".$organisasi[3].""));
		}else{ $this->template->view('verifikasi/persetujuan/index',$data); }
					
		
	}

	public function spp($kec='',$des='')
	{
		echo $kec.$des;
	}

	public function getSPP()
	{
		$kec = $this->input->post('kec');
		$des = $this->input->post('des');
		$param = array(
					'TAHUN' =>$this->session->userdata('tahun'),
					'KODEURUSAN' =>1, 
					'KODESUBURUSAN' =>20, 
					'KODEORGANISASI' =>$kec, 
					'KODEDESA' =>$des,
					// 'STATUS_PERSETUJUAN' =>0,
					'STATUS_PENGESAHAN' => 0 
					);
		$tes = $this->m_verifikasi->getSPP($param);
		echo json_encode($tes);
		
	}

	public function setujuiSPP()
	{
		if (isset($_POST['spp'])) {
			$id_persetujuan = $_POST['id_persetujuan'];
			foreach ($_POST['spp'] as $v) {
				$this->m_verifikasi->setujuiSPP($v,$id_persetujuan);
			}
			echo "OK";
		}else{
			return false;
		}

	}

	public function batalkanSPP()
	{
		if (isset($_POST['spp'])) {
			$id_persetujuan = $_POST['id_persetujuan'];
			$batal=$this->m_verifikasi->batalkanSPP($_POST['spp'], array('STATUS_PERSETUJUAN' => 0,'ID_PERSETUJUAN' => $id_persetujuan));
			if ($batal) {
				echo "OK";
			}
		}else{
			return false;
		}
	}

}
