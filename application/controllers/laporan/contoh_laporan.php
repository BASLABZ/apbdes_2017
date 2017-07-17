<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*  created by aan (kurnianto.tn@gin.co.id)
*/


class contoh_laporan extends CI_Controller
{
	
	private $page_name = "Laporan Contoh";
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
		app::bc($this->page_name,'/laporan/contoh_laporan');
	}

	//index
	public function index(){
		//all desa
		$this->template->view('report/lap_contoh');
 	} 
}




?>