<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pejabat_pengesah  extends CI_Controller {
	private $page_name = 'Master Pejabat Pengesah';
	
	function __construct(){
		parent::__construct();
		$this->libauth->cek_login();
		$this->load->model('m_pejabat_pengesah');
		$this->load->model('m_org');
		app::set('web_heading',$this->page_name);
		app::bc($this->page_name,'/setting/pejabat_pengesah');
	}
	
	public function index()
	{	
		app::bc('Daftar Pejabat Pengesah','/setting/pejabat_pengesah');	
		$params = date('Y');
		$namadesa = $this->input->post('namadesa');		
		if (isset($namadesa) && $namadesa!=0) {
			$explode_namadesa = explode('.', $namadesa);
			$kodeurusan = $explode_namadesa[0];
			$kodesuburusan = $explode_namadesa[1];
			$kodeorganisasi = $explode_namadesa[2];
			$kodedesa = $explode_namadesa[3];
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

			$data['listpejabatpengesah'] = $this->m_pejabat_pengesah->get_pejabat_by_desa($params,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa);
			$this->template->view('setting/pejabat_pengesah/list',$data);
		}else{
			// $data['desa'] = $this->m_pejabat_pengesah->getNamaDesa($params);
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

			$data['listpejabatpengesah'] = $this->m_pejabat_pengesah->get_pejabat_by_desa(0,0,0,0,0);
			$this->template->view('setting/pejabat_pengesah/list',$data);
		}
	}
	public function add()
	{
		app::bc('Tambah Pejabat Pengesah','/setting/pejabat_pengesah/add');
		// $params = array(
		// 		'KODEDESA<>' => '' 
		// 		);
		$params = date('Y');

		// $data['desa'] = $this->m_pejabat_pengesah->getNamaDesa($params);
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

		$data['jabatan'] = $this->m_pejabat_pengesah->getJabatan();

		$this->form_validation->set_rules('nama_pejabat', 'Nama Pejabat', 'required|min_length[5]|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->template->view('setting/pejabat_pengesah/add',$data);
		} else {

			$datadesa = explode(".",$this->input->post('namadesa'));
			$datajabatan = explode(".", $this->input->post('jabatan'));
			//echo ($datajabatan[2]);
			//die();
			$data['get_list_desa'] = $this->input->get('namadesa');
			$data['get_list_jabatan'] = $this->input->get('jabatan');

			$dataparams = array(
				'TAHUN' => date('Y'),
				'KODEURUSAN' => $datadesa[0],
				'KODESUBURUSAN' => $datadesa[1],
				'KODEORGANISASI' => $datadesa[2],
				'KODEDESA' => $datadesa[3],
				'JENISSISTEM' => $datajabatan[0],
				'ID' => $datajabatan[1],
				'NAMA'	=> $this->input->post('nama_pejabat'),
				'PANGKAT'=> $this->input->post('pangkat'),
				'JABATAN' => $datajabatan[2],
				'LINE1' => '',
				'LINE2' => '',
				'UB'=>'T',
				'NIP'=> $this->input->post('nip'),
				'NOREKBANK' => $this->input->post('norek'),
				'NAMABANK' => $this->input->post('nama_bank'),
				'NPWP' => $this->input->post('npwp')
			);
			
			$paramcek = array(
				'TAHUN' => date('Y'),
				'KODEURUSAN' => $datadesa[0],
				'KODESUBURUSAN' => $datadesa[1],
				'KODEORGANISASI' => $datadesa[2],
				'KODEDESA' => $datadesa[3],
				'JENISSISTEM' => $datajabatan[0],
				'ID' => $datajabatan[1]
			);
			if($this->m_pejabat_pengesah->cek_pejabat($paramcek) > 0){
				$this->session->set_flashdata('exist',"<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>Pejabat Pengesah Untuk Desa Ini Sudah ada / Multi Primary Key !!.</div>");
			    $this->template->view('setting/pejabat_pengesah/add',$data);
			}else{
				$insert_pejabat = $this->m_pejabat_pengesah->insert_pejabat($dataparams);
				$this->session->set_flashdata('sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pejabat Pengesah Berhasil Disimpan. </div>");
				redirect('setting/pejabat_pengesah');
			}

			
		}
	}

	public function edit($tahun,$kdur,$kdsubur,$kdorg,$kddes,$jns,$id)
	{
		app::bc('Ubah Pejabat Pengesah','/setting/pejabat_pengesah/edit/'.$tahun.'/'.$kdur.'/'.$kdsubur.'/'.$kdorg.'/'.$kddes.'/'.$jns.'/'.$id);
		// $params = array(
		// 		'KODEDESA<>' => '' 
		// 		);
		$params = date('Y');

		// $data['desa'] = $this->m_pejabat_pengesah->getNamaDesa($params);
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

		$data['jabatan'] = $this->m_pejabat_pengesah->getJabatan();
		$data['edit_pejabat'] = $this->m_pejabat_pengesah->get_pejabat_where($tahun,$kdur,$kdsubur,$kdorg,$kddes,$jns,$id);
		
		$this->form_validation->set_rules('nama_pejabat', 'Nama Pejabat', 'required|min_length[5]|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->template->view('setting/pejabat_pengesah/edit',$data);
		} else {

			$datadesa = explode(".",$this->input->post('namadesa'));
			$datajabatan = explode(".", $this->input->post('jabatan'));
			//echo ($datajabatan[2]);
			//die();
			//$data['get_list_desa'] = $this->input->get('namadesa');
			//$data['get_list_jabatan'] = $this->input->get('jabatan');

			$dataparams = array(
				// 'TAHUN' => date('Y'),
				// 'KODEURUSAN' => $datadesa[0],
				// 'KODESUBURUSAN' => $datadesa[1],
				// 'KODEORGANISASI' => $datadesa[2],
				// 'KODEDESA' => $datadesa[3],
				// 'JENISSISTEM' => $datajabatan[0],
				// 'ID' => $datajabatan[1],
				'NAMA'	=> $this->input->post('nama_pejabat'),
				'PANGKAT'=> $this->input->post('pangkat'),
				'JABATAN' => $datajabatan[2],
				'LINE1' => '',
				'LINE2' => '',
				'UB'=>'T',
				'NIP'=> $this->input->post('nip'),
				'NOREKBANK' => $this->input->post('norek'),
				'NAMABANK' => $this->input->post('nama_bank'),
				'NPWP' => $this->input->post('npwp')
			);
			
			$paramcek = array(
				'TAHUN' => $tahun,
				'KODEURUSAN' => $kdur,
				'KODESUBURUSAN' => $kdsubur,
				'KODEORGANISASI' => $kdorg,
				'KODEDESA' => $kddes,
				'JENISSISTEM' => $jns,
				'ID' => $id
			);
			// if($this->m_pejabat_pengesah->cek_pejabat($paramcek) > 0){
			// 	$this->session->set_flashdata('exist',"<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>Pejabat Pengesah Untuk Desa Ini Sudah ada / Multi Primary Key !!.</div>");
			//     $this->template->view('setting/pejabat_pengesah/edit',$data);
			// }else{
				$update_pejabat = $this->m_pejabat_pengesah->update_pejabat($paramcek,$dataparams);
				$this->session->set_flashdata('sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pejabat Pengesah Berhasil Diupdate. </div>");
				redirect('setting/pejabat_pengesah');
			//}

			
		}
	}

	public function hapusPejabat($params)
	{
		$param = explode(".", $params);
		$data = array(
				'TAHUN' => $param[0],
				'KODEURUSAN' => $param[1],
				'KODESUBURUSAN' => $param[2],
				'KODEORGANISASI' => $param[3],
				'KODEDESA' => $param[4],
				'JENISSISTEM' => $param[5],
				'ID' => $param[6]
			);
		$delete = $this->m_pejabat_pengesah->delete_pejabat($data);		
		if($delete){
			$this->session->set_flashdata('sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pejabat Pengesah Berhasil di Hapus. </div>");
			redirect('setting/pejabat_pengesah');
		}else {
			$this->session->set_flashdata('sukses', "<div class='alert alert-warning alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Gagal Hapus Data. </div>");
			redirect('setting/pejabat_pengesah');
		}
	}
	
}