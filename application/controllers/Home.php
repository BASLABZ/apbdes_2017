<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->libauth->cek_login();
		$this->load->model('m_spp');
		app::set('web_heading','Home');
	}

	public function index()
	{
		$dinas = $this->m_spp->ShowDinas();
		$data = $this->m_spp->charttingTotalSpp();
		$dataSppVerifikasi = $this->m_spp->charttingTotalSppVerifikasi();
		$dataSppBelumVerifikasi = $this->m_spp->charttingTotalSppBelumdiVerifikasi();
		$show = array('dinas'=>$dinas,'totalsppall' => $data , 'SppVerifikasi'=>$dataSppVerifikasi,'dataSppBelumVerifikasi'=>$dataSppBelumVerifikasi );
		$this->template->view('home/index',$show);
		
	}
}
