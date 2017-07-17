<?php
/**
* APBDesa
* /application/controllers/Daskum2.
* 
* @date 201608041545
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Daskum2 extends GI_Controller
{
	public $module = array(
		'name' => 'Dasar Hukum',
		'bc' => 'Dasar Hukum',
		'model' => array('m_daskum','m_org','m_model')
	);

	public function index($kode = null)
	{
		app::bc('Daftar', null);
		$kode = array_filter(explode('-', $kode));
		if (count($kode) % 2 !== 0) show_error('Terjadi Kesalahan.');

		$id_kec =  $this->session->kd_organisasi;
		$is_des = in_array($this->session->hakakses, array('OPERATORDESA','SEKDES','KEPALADESA')) ? true : false; // true: kalau login sebagai user-dari-desa
		$id_des =  $this->session->kd_desa;

		if ($is_des && count($kode) < 1) {
			redirect('daskum2/index/' . $id_kec . '-' . $id_des);
		}

		// TAHUN (HARUS)
		$thn = $this->session->userdata('tahun');

		$is_do_q = false;
		$cond = $cond_org = $cond_dh = array('KODEURUSAN' => 1, 'KODESUBURUSAN' => 20);
		$kodekode = kodekode();

		// INSTANSI
		// $this->m_org->model_debug = true;
		$tbl = $this->m_org->model_table = $this->m_org->model_table2; // ganti table
		if ($is_des) {
			$cond_org['KODEORGANISASI'] = $id_kec;
			$cond_org['KODEDESA'] = $id_des;
		} else {
			$this->db->where_in($tbl . '.KODEORGANISASI', array_map('q1', $kodekode['kec']), false);
			$cond_org['KODEDESA !='] = '';
		}
		$inst = $this->m_org->read_many($cond_org, array('*'), false);
		// debug($inst);

		// SET PARAM-KODE
		if (isset($kode[0])) {
			$is_do_q = true;
			$detail_dh[] = $cond_dh['KODEORGANISASI'] = $kode[0];
			$detail_dh[] = $cond_dh['KODEDESA'] = $kode[1];
		}
		if (count($kodekode['des']) > 0 && !in_array($detail_dh, $kodekode['des'])) {
			$is_do_q = false;
		}

		// DASAR HUKUM
		$daskum = array('data' => array());
		if ($is_do_q) { // samakan semua dengan yg dia buat
			// $this->m_model->model_debug = true;
			$this->m_model->model_table = $this->m_daskum->model_table;
			$daskum = $this->m_model->read_many($cond_dh, array('*'), false);
			// debug($daskum);
		}

		$this->template->view('daskum/v2/daftar', array(
			'instansi' => $inst['data'],
			'daskum' => $daskum['data'],
			'cond' => $cond
		));
	}

}
