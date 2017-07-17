<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {

	private $page_name = "Master Pengguna";

	function __construct()
	{
		parent::__construct();
		$this->libauth->cek_login();
		//load model
		$this->load->library('encrypt');
		$this->load->model('m_user');
		app::set('web_heading',$this->page_name);
		app::bc($this->page_name,'/setting/user');
	}

	public function index()
	{
		app::bc('Daftar Pengguna','setting/user');
		if($this->session->hakakses=='ADMIN'){	
			$listpengguna= $this->m_user->get_pengguna();
			$this->template->view('setting/user/list',array('listpengguna'=>$listpengguna));
		}else{			
			redirect('error_404');	
		}
	}

	public function add()
	{
		app::bc('Tambah Pengguna','/setting/user/add');
		if($this->session->hakakses=='ADMIN'){	
			$admin 		= $this->m_user->chek_org(array('KODEDESA' => ''));
			$alldesa 	= $this->m_user->chek_org(array('KODEDESA !=' => ''));
			$data = array('admin_org' =>$admin, 'alldesa_org' =>$alldesa);

			$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[25]');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('hakakses', 'Hak Akses', 'required|callback_select_validate');
			$this->form_validation->set_rules('desa[]','options', 'required');
			
			if ($this->form_validation->run() == FALSE) {

				$this->template->view('setting/user/add',$data);
			
			} else {

				if($this->m_user->cek_username(array('USERNAME' => $this->input->post('username'))) > 0){
					$this->session->set_flashdata('exist',"<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>USERNAME <b>".$this->input->post('username')."</b> sudah digunakan</div>");
				    $this->template->view('setting/user/add',$data);
				}else{
						$datadesa = $this->input->post('desa');
						foreach ($datadesa as $val) {
							$datades [] = $val;
						}

						if (sizeof($datades) == 1) {
							foreach ($datades as $val) {
								$kode  = explode(".", $val);
								$kdall = $val;			
							}
						}else{
							$kode 	= array('0'=>0,'1'=>0,'2'=>'','3'=>'');
							$kdall 	= implode("|", $datades);
						}

						// var_dump($datadesa);
						// var_dump($kode);
						// var_dump($kdall);
						// die();
						$pass =$this->encrypt->encode($this->input->post('password'));
						$data = array(
							// 'TAHUN' => date('Y'),
							'TAHUN' => $this->session->tahun, 
							'USERNAME' =>$this->input->post('username'),
							'PWD' => $pass,
							'NAMA'	=> $this->input->post('nama_lengkap'),
							'KODEURUSAN' => $kode[0],
							'KODESUBURUSAN' => $kode[1],
							'KODEORGANISASI' => $kode[2],
							'KODEDESA' => $kode[3],
							'HAKAKSES' => $this->input->post('hakakses'),
							'DESA' => $kdall
						);
					
						$insert = $this->m_user->insert_user($data);
						$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pengguna Berhasil Disimpan. </div>");
						redirect('setting/user');
							
					}
			}		
		}else{			
			redirect('error_404');	
		}
	}

	public function edit($id)
	{
		// die($param);
		app::bc('Ubah Pengguna','/setting/user/edit/'.$id);
		if($this->session->hakakses=='ADMIN'){
			$admin 		= $this->m_user->chek_org(array('KODEDESA' => ''));
			$alldesa 	= $this->m_user->chek_org(array('KODEDESA !=' => ''));
			$edit		= $this->m_user->pengguna_byID($id);
			foreach ($edit as $v) {$desaByID = $v['KODEURUSAN'].".".$v['KODESUBURUSAN'].".".$v['KODEORGANISASI'].".".$v['KODEDESA'];
									$pasdecode = $this->encrypt->decode($v['PWD']);}
			$data = array('admin_org' =>$admin, 'alldesa_org' =>$alldesa, 'dataEdit' =>$edit, 'desaByID' =>$desaByID, 'pasdecode' =>$pasdecode);

			$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[25]');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('hakakses', 'Hak Akses', 'required|callback_select_validate');
			$this->form_validation->set_rules('desa[]','options', 'required');

			if ($this->form_validation->run() == FALSE){

				$this->template->view('setting/user/edit',$data);	
			}else {
				if($this->input->post('password') != ''){

						if ($this->m_user->cek_username(array('USERNAME' => $this->input->post('username'), 'KD_USER !=' => $id)) > 0) {
							$this->session->set_flashdata('exist',"<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>USERNAME <b>".$this->input->post('username')."</b> sudah digunakan</div>");
				    		$this->template->view('setting/user/edit',$data);
						}else{

							$datadesa = $this->input->post('desa');
							foreach ($datadesa as $val) {
								$datades [] = $val;
							}

							if (sizeof($datades) == 1) {
								foreach ($datades as $val) {
									$kode  = explode(".", $val);
									$kdall = $val;			
								}
							}else{
								$kode 	= array('0'=>0,'1'=>0,'2'=>'','3'=>'');
								$kdall 	= implode("|", $datades);
							}

							$pass =$this->encrypt->encode($this->input->post('password'));
							$data = array(
								'TAHUN' => $this->input->post('tahun'),
								'USERNAME' =>$this->input->post('username'),
								'PWD' => $pass,
								'NAMA'	=> $this->input->post('nama_lengkap'),
								'KODEURUSAN' => $kode[0],
								'KODESUBURUSAN' => $kode[1],
								'KODEORGANISASI' => $kode[2],
								'KODEDESA' => $kode[3],
								'HAKAKSES' => $this->input->post('hakakses'),
								'DESA' => $kdall
							);

							$insert = $this->m_user->edit_user($id,$data);
							$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pengguna Berhasil Di Ubah. </div>");
							redirect('setting/user');
						}
						
				}else{

						if ($this->m_user->cek_username(array('USERNAME' => $this->input->post('username'), 'KD_USER !=' => $id)) > 0) {
							$this->session->set_flashdata('exist',"<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>USERNAME <b>".$this->input->post('username')."</b> sudah digunakan</div>");
				    		$this->template->view('setting/user/edit',$data);
						}else{

							$datadesa = $this->input->post('desa');
							foreach ($datadesa as $val) {
								$datades [] = $val;
							}

							if (sizeof($datades) == 1) {
								foreach ($datades as $val) {
									$kode  = explode(".", $val);
									$kdall = $val;			
								}
							}else{
								$kode 	= array('0'=>0,'1'=>0,'2'=>'','3'=>'');
								$kdall 	= implode("|", $datades);
							}

							// $pass =$this->encrypt->encode($this->input->post('password'));
							$data = array(
								'TAHUN' => $this->input->post('tahun'),
								'USERNAME' =>$this->input->post('username'),
								'NAMA'	=> $this->input->post('nama_lengkap'),
								'KODEURUSAN' => $kode[0],
								'KODESUBURUSAN' => $kode[1],
								'KODEORGANISASI' => $kode[2],
								'KODEDESA' => $kode[3],
								'HAKAKSES' => $this->input->post('hakakses'),
								'DESA' => $kdall
								
							);
						
							$insert = $this->m_user->edit_user($id,$data);
							$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pengguna Berhasil Di Ubah. </div>");
							redirect('setting/user');
						}
					}
			}
		
		}else{			
			redirect('error_404');	
		}
	}

	public function editPass($id)
	{
		app::bc('Ubah Pengguna','/setting/user/editPass/'.$id);
		$admin 		= $this->m_user->chek_org(array('KODEDESA' => ''));
		$alldesa 	= $this->m_user->chek_org(array('KODEDESA !=' => ''));
		$edit		= $this->m_user->pengguna_byID($id);
		foreach ($edit as $v) {$desaByID = $v['KODEURUSAN'].".".$v['KODESUBURUSAN'].".".$v['KODEORGANISASI'].".".$v['KODEDESA'];
								$pasdecode = $this->encrypt->decode($v['PWD']);}
		$data = array('admin_org' =>$admin, 'alldesa_org' =>$alldesa, 'dataEdit' =>$edit, 'desaByID' =>$desaByID, 'pasdecode' =>$pasdecode);

		$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[25]');
		$this->form_validation->set_rules('password', 'Password', 'required');		

		if ($this->form_validation->run() == FALSE){
			$this->template->view('setting/user/editPass',$data);	
		}else {
			if($this->input->post('password') != ''){
				if ($this->m_user->cek_username(array('USERNAME' => $this->input->post('username'), 'KD_USER !=' => $id)) > 0) {
					$this->session->set_flashdata('exist',"<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>USERNAME <b>".$this->input->post('username')."</b> sudah digunakan</div>");
		    		$this->template->view('setting/user/editPass',$data);
				}else{
					
					$pass =$this->encrypt->encode($this->input->post('password'));
					$data = array(
						'TAHUN' => $this->input->post('tahun'),
						'USERNAME' =>$this->input->post('username'),
						'PWD' => $pass,
						'NAMA'	=> $this->input->post('nama_lengkap')							
					);

					$insert = $this->m_user->edit_user($id,$data);
					$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pengguna Berhasil Di Ubah. </div>");
					redirect('setting/user/editPass/'.$id);
				}
					
			}else{
				if ($this->m_user->cek_username(array('USERNAME' => $this->input->post('username'), 'KD_USER !=' => $id)) > 0) {
					$this->session->set_flashdata('exist',"<div class='alert alert-danger alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button>USERNAME <b>".$this->input->post('username')."</b> sudah digunakan</div>");
		    		$this->template->view('setting/user/editPass',$data);
				}else{					
					$data = array(
						'TAHUN' => $this->input->post('tahun'),
						'USERNAME' =>$this->input->post('username'),
						'NAMA'	=> $this->input->post('nama_lengkap')							
						
					);
				
					$insert = $this->m_user->edit_user($id,$data);
					$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pengguna Berhasil Di Ubah. </div>");
					redirect('setting/user/editPass/'.$id);
				}
			}
		}
	}

	public function delete($param)
	{
		$data = array('KD_USER' => $param);
		$delete = $this->m_user->delete_user($data);
		if($delete){
			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Pengguna Berhasil di Hapus. </div>");
			redirect('setting/user');
		}else {
			$this->session->set_flashdata('Sukses', "<div class='alert alert-warning alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Gagal Hapus Data. </div>");
			redirect('setting/user');
		}
	}
	//select validation call
	function select_validate($param)
	{
		if($param=="none"){
			$this->form_validation->set_message('select_validate', 'Select Hak Akses is required.');
			return false;
		} else{
			return true;
		}
	}

	// function testencrypting(){
	// 	$pass = $this->m_user->getEncpass(['USERNAME'=>'CIPAKU']);
	//   			echo  $this->encrypt->decode($pass);
	  	
	// }

}
