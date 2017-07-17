<?php
/**
* APBDesa
* /application/controllers/Spp2.
* 
* @date 201606221942, 201606242235, 201606271350, 201606271621
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Spp4 extends GI_Controller
{
	public $module = array(
		'name' => 'Surat Permintaan Pembayaran',
		'bc' => 'SPP',
		'model' => array('m_org')
	);

	public function index() { redirect('spp3/index'); }

	public function tambah($kode = null)
	{
		// true: kalau login sebagai kecamatan
		$is_sesi_kec = empty($this->session->kd_organisasi) ? false : true;
		$sesi_kec_id = $this->session->kd_organisasi;
		// true: kalau login sebagai operator desa
		$is_sesi_des = empty($this->session->kd_desa) ? false : true;
		$sesi_des_id = $this->session->kd_desa;

		$cond = array(
			'KODEURUSAN' => '1',
			'KODESUBURUSAN' => '20'
		);

		$cond_slc = $cond;
		if ($is_sesi_kec) {
			$cond_slc['KODEORGANISASI'] = $sesi_kec_id;
		}
		if ($is_sesi_des) {
			$cond_slc['KODEDESA'] = $sesi_des_id;
		} else {
			$cond_slc['KODEDESA !='] = '';
		}

		$this->m_org->model_table = $this->m_org->model_table2; // ganti table
		$data_inst = $this->m_org->read_many($cond_slc, array('*'), false);
		// debug($data_inst);

		$this->template->view('spp/v3/tambah', array(
			'res_inst' => $data_inst
		));
	}

	public function simpan()
	{
		$post = $this->input->post();
		if (count($post) < 1) show_error('parameter salah.');
		debug($post);
	}

}
