<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Pengesahan  extends CI_Controller {

	private $page_name = "Verifikasi Pengesahan";

	function __construct() {
		parent::__construct();
		$this->libauth->cek_login();
		$this->load->model('m_verifikasi');
		$this->load->model('m_pejabat_pengesah');
		$this->load->model('m_org');
		app::set( 'web_heading', $this->page_name );
		app::bc( $this->page_name,'verifikasi/pengesahan');
	}

	public function index($kodeurusan=0,$kodesuburusan=0,$idKec=0,$idDes=0) {
		app::bc('Daftar Pengesahan','/verifikasi/pengesahan');

		$tahun = date('Y');
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
				'STATUS_PERSETUJUAN' =>1
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
		$data['selectedKec'] = $this->m_verifikasi->getOrganisasi($param2);
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

		$data['dataspp'] =$dataspp;
		
		if (!$this->input->post('namadesa') == "0") {
			$organisasi = explode('.', $this->input->post('namadesa'));
			redirect(base_url("verifikasi/pengesahan/index/".$organisasi[0]."/".$organisasi[1]."/".$organisasi[2]."/".$organisasi[3].""));
		}
		$this->template->view('verifikasi/pengesahan/index',$data);
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
					'STATUS_PERSETUJUAN' =>1
					);
		$tes = $this->m_verifikasi->getSPP($param);
		if($tes){
			foreach ($tes as $v) {
			$v['STATUS_PENGESAHAN']==0 ? 
			$status ="<i class='fa fa-exclamation-triangle text-warning'></i> Belum Disahkan" : 
			$status ="<i class='fa fa-check text-success'></i> Sudah Disahkan"; 
			$cekSPP = $v['STATUS_PENGESAHAN']==1 ? "checked onClick='batalkan(".$v['NO_SPP'].")' " : ''; 
			$tgl =date('d/m/Y',strtotime($v['TGL_SPP']));

				echo "
				<tr>
					<td width='10%'>".$v['NO_SPP']."</td>
					<td width='8%'>".$tgl."</td>
					<td width='20%'>".$v['DESKRIPSI_PEKERJAAN']."</td>
					<td width='5%'>".$v['JUMLAH_SPP']."</td>
					<td width='10%'>".$status."</td>
					<td width='3%'><input type='checkbox' class='sarasvati' name=spp[] value='".$v['NO_SPP']."' ".$cekSPP."></td>
				</tr>
				";
			}
		}else{
			echo "
			<tr>
				<td colspan='6' align='center'>Data tidak ditemukan</td>
			</tr>
			";
		}
		
	}

	public function sahkanSPP()
	{
		if (isset($_POST['spp'])) {
			$id_pengesahan = $_POST['id_pengesahan'];
			foreach ($_POST['spp'] as $v) {
				$this->m_verifikasi->sahkanSPP($v,$id_pengesahan);
			}
			echo "OK";
		}else{
			return false;
		}

	}

	public function batalkanSPP()
	{
		if (isset($_POST['spp'])) {
			$batal=$this->m_verifikasi->batalkanSPP($_POST['spp'], array('STATUS_PENGESAHAN' => 0));
			if ($batal) {
				echo "OK";
			}
		}else{
			return false;
		}
	}

}
