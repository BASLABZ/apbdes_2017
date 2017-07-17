<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public function index() {
		
		$valid = $this->form_validation;
		$tahun = $this->input->post('tahun');
		$username = $this->input->post('username');
		$password = $this->input->post('pwd');
		$valid->set_rules('tahun','Tahun','required');
		$valid->set_rules('username','Username','required');
		$valid->set_rules('pwd','Password','required');
		$this->load->model('m_auth');
		$settingtahun['settingtahun'] = $this->m_auth->settingtahun();

		if($valid->run()) {
			$this->libauth->login($tahun,$username,$password, base_url('home'), base_url('login'));
		}
		
		$data = array(
					'title' => 'Halaman Login',
					'tahun_'=> $settingtahun['settingtahun']
					 );
		$this->template->view_auth('auth/index',$data);
	}
	
	
	public function logout() {
		$this->libauth->logout();	
	}	
}