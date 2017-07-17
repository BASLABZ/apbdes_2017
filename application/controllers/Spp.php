<?php
/**
* APBDesa
* /application/controllers/Spp.
* 
* @date 201605, 201606081033, 201606101114, 20160616
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Spp extends CI_Controller {

	private $page_name = 'Surat Permintaan Pembayaran';

	public function __construct()
	{

		parent::__construct();

		redirect('spp3/index'); //

		// $this->libauth->cek_login();

		$this->load->model('m_spp');
		$this->load->model('m_organisasi');
		// $this->load->model('m_bidang');
		$this->load->model('m_program');

		app::set('web_heading',$this->page_name);
		app::bc(strtoupper(__CLASS__),strtolower(__CLASS__));
	}

	public function index($id_kec = null, $id_desa = null) // holder
	{
		app::bc('Tambah',null);

		$this->template->view('spp/index', array(
			'result_inp_kec' => $this->m_organisasi->all_kecamatan()
		));
	}

	/**
	* 
	* @todo arep tak kek-i param tahun, men le filter lengkap
	* @param $kode (sring) - kecamatan dan desa. format: n-n
	* @param $nomor (sring) - nomor spp. format: n-n
	* 
	*/
	public function daftar($kode = null, $nomor = null)
	{
		// rasah di array_filter, nggo handle nek index 0/1 kosong
		$kode = explode('-', $kode);
		if(count($kode) > 2) show_error('kode organisasi tidak sesuai');

		$page = (int)$this->input->get('page') > 1 ? (int)$this->input->get('page') : 1;
		$limit = 10;
		$offset = ($page-1)*$limit;

		/*

		$this->db->select("spp.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa, mo_prog.URAI as urai_prog", false);
		$this->db->from($this->m_spp->model_table);

		if (!empty($kode[0])) $this->db->where("{$this->m_spp->model_table}.KODEORGANISASI", "'" . lzero((int)$kode[0]) . "'", false);
		if (!empty($kode[1])) $this->db->where("{$this->m_spp->model_table}.KODEDESA", "'" . lzero((int)$kode[1]) . "'", false);

		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",[
			"mo_kec.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		]), 'left',false);

		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",[
			"mo_desa.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_desa.KODEDESA = {$this->m_spp->model_table}.KODEDESA"
		]), 'left',false);

		$this->db->join("{$this->m_program->model_table} as mo_prog", implode(" AND ",[
			"mo_prog.KODEBIDANG = {$this->m_spp->model_table}.KODEBIDANG",
			"mo_prog.KODEPROGRAM = {$this->m_spp->model_table}.KODEPROGRAM",
			"mo_prog.KODEKEGIATAN = {$this->m_spp->model_table}.KODEKEGIATAN"
		]), 'left',false);

		$total = $this->db->count_all_results(null,false);

		$this->db->limit(1);

		// 0/1
		debug($this->db->get_compiled_select());
		debug($this->db->get()->result_array());
		*/

		$this->db->select("{$this->m_spp->model_table}.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa, mo_prog.URAI as urai_prog", false);
		if (!empty($kode[0])) $this->db->where("{$this->m_spp->model_table}.KODEORGANISASI", "'" . lzero((int)$kode[0]) . "'", false);
		if (!empty($kode[1])) $this->db->where("{$this->m_spp->model_table}.KODEDESA", "'" . lzero((int)$kode[1]) . "'", false);
		if (!empty($nomor)) $this->db->where("{$this->m_spp->model_table}.NO_SPP", "'" . $nomor . "'", false);
		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",array(
			"mo_kec.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		)), 'left',false);
		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",array(
			"mo_desa.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_desa.KODEDESA = {$this->m_spp->model_table}.KODEDESA"
		)), 'left',false);
		$this->db->join("{$this->m_program->model_table} as mo_prog", implode(" AND ",array(
			"mo_prog.KODEBIDANG = {$this->m_spp->model_table}.KODEBIDANG",
			"mo_prog.KODEPROGRAM = {$this->m_spp->model_table}.KODEPROGRAM",
			"mo_prog.KODEKEGIATAN = {$this->m_spp->model_table}.KODEKEGIATAN"
		)), 'left',false);
		$result = $this->m_spp->all(array(), $limit, $offset);
		$result['page'] = $page;
		$result['limit'] = $limit;
		$result['offset'] = $offset;

		// debug($result);

		app::bc('Daftar',null);
		$this->template->view('spp/list', array(
			'daftar_spp' => $result
		));
	}

	/**
	* 
	* @param $tahun
	* @param $kode (string) - kecamatan dan desa
	* @param $nomor
	* 
	*/
	public function lihat($tahun = null, $kode = null, $nomor = null)
	{
		$nomor = $this->input->get('nomor');
		if (empty($tahun) || empty($kode) || empty($nomor)) show_error('parameter tidak sesuai');

		// rasah di array_filter, nggo handle nek index 0/1 kosong
		$kode = explode('-', $kode);
		if(count($kode) !== 2) show_error('kode organisasi tidak sesuai');

		$this->db->select("{$this->m_spp->model_table}.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa, mo_prog.URAI as urai_prog", false);
		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",array(
			"mo_kec.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		)), 'left',false);
		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",array(
			"mo_desa.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_desa.KODEDESA = {$this->m_spp->model_table}.KODEDESA"
		)), 'left',false);
		$this->db->join("{$this->m_program->model_table} as mo_prog", implode(" AND ",array(
			"mo_prog.KODEBIDANG = {$this->m_spp->model_table}.KODEBIDANG",
			"mo_prog.KODEPROGRAM = {$this->m_spp->model_table}.KODEPROGRAM",
			"mo_prog.KODEKEGIATAN = {$this->m_spp->model_table}.KODEKEGIATAN"
		)), 'left',false);
		// tahun, kode, nomor
		$data = $this->m_spp->show(array(
			'TAHUN' => date('Y'),
			'KODEORGANISASI' => lzero($kode[0]), //!
			'KODEDESA' => lzero($kode[1]), //!
			'NO_SPP' => $nomor
		));

		if (empty($data[0])) show_error('data tidak tersedia');

		app::bc('Lihat', null);
		$this->template->view('spp/detail', array(
			'data_spp' => $data[0]
		));
	}

	public function simpan()
	{
		/*
		penulisan pada kodeorg, desa = lzero2
		kecuali kodebidang
		*/
		// app::debug($this->input->post());

		$org = explode(',', $this->input->post('inp_desa'));
		$keg = explode(',', $this->input->post('inp_keg'));
		// $org = app::arrkode($this->input->post('inp_desa'),',');
		// $keg = app::arrkode($this->input->post('inp_keg'),',');

		$data = array(
			// 'KODEURUSAN' => $this->session->kd_urusan, // berdasarkan sing login
			// 'KODESUBURUSAN' => $this->session->kd_suburusan, // berdasarkan sing login
			// 'KODEORGANISASI' => $this->input->post('inp_kec'),
			// 'KODEDESA' => $this->input->post('inp_desa'),
			'KODEURUSAN' => $org[0],
			'KODESUBURUSAN' => $org[1],
			'KODEORGANISASI' => lzero($org[2]), // harus 0n
			'KODEDESA' => lzero($org[3]), // harus 0n
			'KODEBIDANG' => (int)$keg[0], // harus int
			'KODEPROGRAM' => $keg[1],
			'KODEKEGIATAN' => $keg[2],
			"USER_NAME" => $this->session->username, // berdasarkan sing login
			"USER_ID" => $this->session->kd_user // berdasarkan sing login
		);
		// app::debug($data);

		$insert = $this->m_spp->store($this->input->post(), $data);
		if ($insert) redirect('spp/daftar');
	}

	private function data_lihat($tahun, $kode, $nomor)
	{
		$this->db->select("{$this->m_spp->model_table}.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa, mo_prog.URAI as urai_prog", false);
		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",array(
			"mo_kec.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		)), 'left',false);
		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",array(
			"mo_desa.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_desa.KODEDESA = {$this->m_spp->model_table}.KODEDESA"
		)), 'left',false);
		$this->db->join("{$this->m_program->model_table} as mo_prog", implode(" AND ",array(
			"mo_prog.KODEBIDANG = {$this->m_spp->model_table}.KODEBIDANG",
			"mo_prog.KODEPROGRAM = {$this->m_spp->model_table}.KODEPROGRAM",
			"mo_prog.KODEKEGIATAN = {$this->m_spp->model_table}.KODEKEGIATAN"
		)), 'left',false);

		// tahun, kode, nomor
		$data = $this->m_spp->show(array(
			'TAHUN' => date('Y'),
			'KODEORGANISASI' => lzero($kode[0]), //!
			'KODEDESA' => lzero($kode[1]), //!
			'NO_SPP' => $nomor
		));
		if (empty($data[0])) show_error('data tidak tersedia');

		app::bc('Lihat', null);
		$this->template->view('spp/detail', array(
			'data_spp' => $data[0]
		));
	}

	public function data_hapus($tahun, $kode, $nomor)
	{
		$q = $this->m_spp->destroy(array(
			'TAHUN' => $tahun,
			'KODEORGANISASI' => lzero($kode[0]), //!
			'KODEDESA' => lzero($kode[1]), //!,
			'NO_SPP' => $nomor
		));
		if ($q) redirect('spp/daftar');
		show_error('Gagal hapus', '403');
	}

	public function data($what = null, $tahun = null, $kode = null)
	{
		// if (!in_array($what, ['lihat','hapus'])) show_error('perintah tidak sesuai');
		$kode = explode('-', $kode);
		$nomor = $this->input->get('nomor');
		if (empty($tahun) || empty($kode) || empty($nomor) || count($kode) !== 2) show_error('parameter tidak sesuai');
		// akhir validasi param

		if ($what === 'lihat'):
			$this->data_lihat($tahun, $kode, $nomor);
			return;
		endif;

		if ($what === 'hapus'):
			$this->data_hapus($tahun, $kode, $nomor);
		return;
		endif;

		show_error('perintah salah');
	}

	public function rincian($tahun = null, $kode = null)
	{
		$kode = explode('-', $kode);
		$nomor = $this->input->get('nomor');
		if (empty($tahun) || empty($kode) || empty($nomor) || count($kode) !== 2) show_error('parameter salah', '403');

		$this->load->model('m_spprincian');

		// 1. ambil spp
		$this->db->select("{$this->m_spp->model_table}.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa, mo_prog.URAI as urai_prog", false);
		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",array(
			"mo_kec.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		)), 'left',false);
		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",array(
			"mo_desa.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_desa.KODEDESA = {$this->m_spp->model_table}.KODEDESA"
		)), 'left',false);
		$this->db->join("{$this->m_program->model_table} as mo_prog", implode(" AND ",array(
			"mo_prog.KODEBIDANG = {$this->m_spp->model_table}.KODEBIDANG",
			"mo_prog.KODEPROGRAM = {$this->m_spp->model_table}.KODEPROGRAM",
			"mo_prog.KODEKEGIATAN = {$this->m_spp->model_table}.KODEKEGIATAN"
		)), 'left',false);
		$spp = $this->m_spp->show(array(
			'TAHUN' => $tahun,
			'KODEORGANISASI' => lzero($kode[0]), //!
			'KODEDESA' => lzero($kode[1]), //!,
			'NO_SPP' => $nomor
		));

		if (empty($spp[0])) show_error('data tidak tersedia');

		// 2. ambil spprincian
		$spprincian = $this->m_spprincian->all(array(
			'TAHUN' => $tahun,
			'KODEORGANISASI' => lzero($kode[0]), //!
			'KODEDESA' => lzero($kode[1]), //!,
			'NO_SPP' => $nomor
		));

		// debug($spprincian);

		$this->template->view('spp/subdetail',array(
			'data_spp' => $spp[0],
			'data_spprincian' => $spprincian
		));

	}

}
