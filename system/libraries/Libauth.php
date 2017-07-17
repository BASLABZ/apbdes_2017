<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Libauth {
	
	public $CI = NULL;

	function __construct(){
		$this->CI = &get_instance();
		$this->CI->load->library('encrypt');
		$this->CI->load->model('m_user');
	}

	public function login($tahun,$username,$password) {
		
		$sql = "SELECT * FROM PENGGUNA WHERE TAHUN='".$tahun."' AND USERNAME='".$username."' ";
		// $sql = "SELECT * FROM PENGGUNA WHERE TAHUN='".$tahun."' AND USERNAME='".$username."' AND PWD='".$password."'";
        // $query = $this->CI->db->query($sql);
        $pengguna = array('TAHUN' => $tahun, 'USERNAME' => $username);
        // $query = $this->CI->db->get_where('PENGGUNA',['TAHUN' => $tahun, 'USERNAME' => $username]);
        $query = $this->CI->db->get_where('PENGGUNA',$pengguna);


		if($query->num_rows() == 1) {

			// $dbPass = $this->dbPass(['USERNAME' => $query->row()->USERNAME ]);
			$dbPass = $this->dbPass(array('USERNAME' => $query->row()->USERNAME));
			// die($dbPass);
			if ($dbPass == $password){
					// $row 			= $this->CI->db->query("SELECT * FROM PENGGUNA WHERE USERNAME ='".$username."'");
					// $pengguna 		= $row->row();
					$tahun 			= $query->row()->TAHUN;
					$kd_user 		= $query->row()->KD_USER;
					$kd_urusan		= $query->row()->KODEURUSAN;
					$kd_suburusan	= $query->row()->KODESUBURUSAN;
					$kd_organisasi	= $query->row()->KODEORGANISASI;
					$kd_desa		= $query->row()->KODEDESA;
					$desa 			= $query->row()->DESA;
					$hakakses		= $query->row()->HAKAKSES;

					$this->CI->session->set_userdata('tahun', $tahun);
					$this->CI->session->set_userdata('username', $username);
					$this->CI->session->set_userdata('id_login', uniqid(rand()));
					$this->CI->session->set_userdata('kd_user', $kd_user);
					$this->CI->session->set_userdata('kd_urusan', $kd_urusan);
					$this->CI->session->set_userdata('kd_suburusan', $kd_suburusan);
					$this->CI->session->set_userdata('kd_organisasi', $kd_organisasi);
					$this->CI->session->set_userdata('kd_desa', $kd_desa);
					$this->CI->session->set_userdata('desa', $desa);
					$this->CI->session->set_userdata('hakakses', $hakakses);
					
					redirect(base_url('home'));
			}else{
				$this->CI->session->set_flashdata('salah','Username/password salah');
				redirect(base_url('auth'));	
			}
		}else{
			$this->CI->session->set_flashdata('salah','Username/password salah');
			redirect(base_url('auth'));
		}

		return false;
	}
	
	public function cek_login() {
	
		if(($this->CI->session->userdata('tahun')=='') || ($this->CI->session->userdata('id_login') == '') || ($this->CI->session->userdata('hakakses')=='')) {
			redirect(base_url('auth'));
		}
	}
	
	public function logout() {
		
		$this->CI->session->sess_destroy();
        redirect(site_url('auth'));
		
	}

	public function dbPass($param)
	{
		$dbPass = $this->CI->encrypt->decode($this->CI->m_user->getEncpass($param));
		return $dbPass;

	}
}