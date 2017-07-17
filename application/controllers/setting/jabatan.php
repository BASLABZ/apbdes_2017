<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  class jabatan extends CI_Controller {

	private $page_name = "Master Jabatan";

	function __construct()
	{
		parent::__construct();
		$this->libauth->cek_login();
		$this->load->model('m_jabatan');
		app::set('web_heading',$this->page_name);
		app::bc($this->page_name,'/setting/jabatan');
	}

	public function index()
	{
		app::bc('Daftar Jabatan','setting/jabatan');
		if($this->session->hakakses=='ADMIN'){			
			$data['listjabatan'] = $this->m_jabatan->get_jabatan();				
			$this->template->view('setting/jabatan/list',$data);
		}else{			
			redirect('error_404');	
		}
		
	}

	public function add()
	{
		app::bc('Tambah Jabatan','/setting/jabatan/add');
		if($this->session->hakakses=='ADMIN'){
			$tahun= date('Y');	
			$data['urut'] = $this->m_jabatan->get_urut_pejabat($tahun);	

			$this->form_validation->set_rules('urut','Urut','required');
			$this->form_validation->set_rules('uraian','Uraian','required');
			if ($this->form_validation->run()== FALSE) {
				$this->template->view('setting/jabatan/add',$data);
			}else{
			$data  = array('JENISSISTEM' => '1',
							'URUT'		 => $this->input->post('urut'),
						   	'URAI'		 => $this->input->post('uraian'));

			$insert = $this->m_jabatan->insert_jabatan($data);
			
			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Jabatan Berhasil Disimpan. </div>");
			redirect('setting/jabatan');	
			}
		}else{			
			redirect('error_404');	
		}		
		
	}

	// ubah data master jabatan
	public function edit($urut)
	{
		app::bc('Ubah Jabatan','/setting/jabatan/edit/'.$urut);
		if($this->session->hakakses=='ADMIN'){
			$data['jabatanUrut'] = $this->m_jabatan->pejabat_by_urut($urut);
			$this->template->view('setting/jabatan/edit',$data);
		}else{			
			redirect('error_404');	
		}			
	}

	public function proses_edit($urut){
		$this->form_validation->set_rules('urut','Urut','required');
		$this->form_validation->set_rules('uraian','Uraian','required');
		if ($this->form_validation->run()== FALSE) {
			$data['jabatanUrut'] = $this->m_jabatan->pejabat_by_urut($urut);
			$this->template->view('setting/jabatan/edit',$data);
		}else{
			$data  = array('JENISSISTEM' => '1',
							'URUT'		 => $this->input->post('urut'),
						   	'URAI'		 => $this->input->post('uraian'));

			$insert = $this->m_jabatan->update_jabatan($urut,$data);
			
			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Jabatan Berhasil Disimpan. </div>");
			redirect('setting/jabatan');	
		}
	}

	// hapus data master jabatan
	function hapus($param){		

		$delete = $this->m_jabatan->delete_jabatan(array('URUT' => $param));
		if($delete){
			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Jabatan Berhasil Disimpan. </div>");
			redirect('setting/jabatan');
		}else {
			$this->session->set_flashdata('Gagal', "<div class='alert alert-warning alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Jabatan Gagal Dihapus. </div>");
			redirect('setting/jabatan');
		}		
	}
}