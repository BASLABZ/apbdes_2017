<?php 

		/**
		* created @ahmad bastiar
		*/
		class Buku_jurnal extends CI_Controller
		{
			private $page_name = "Buku Jurnal";
			
			function __construct() {
		        parent::__construct();
		        $this->libauth->cek_login();
		        $this->load->model('m_bukujurnal');
				app::set('web_heading', $this->page_name);
		        app::bc($this->page_name, '/buku/buku_jurnal');
		    }
		    public function index()
		    {
		    	$this->template->view('buku_jurnal/list');
		    }
		    public function add()
		    {
		    	$tahun = date('Y');
		    	$data_rekening = $this->m_bukujurnal->get_all_rekening_penerimaan($tahun);
		    	$this->template->view('buku_jurnal/add', ['rekening'=>$data_rekening]);
		    }
		}
 ?>