<?php
/**
* APBDesa
* /application/controllers/Sppr.
* 
* @date 201607022013
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Sppr extends GI_Controller
{
	public $module = array(
		'name' => 'Rincian Surat Permintaan Pembayaran',
		'bc' => 'R-SPP',
		'model' => array('m_spp2','m_sppr','m_rekening','m_angg','m_org')
	);

	public function lihat($kode = null)
	{
		$kode = explode('-', $kode);
		$nomor = $this->input->get('nomor');
		if (empty($kode) || empty($nomor) || count($kode) !== 4) show_error('Parameter salah.');

		$cond['TAHUN'] = $this->session->userdata('tahun');
		foreach (app::get('field_org') as $i => $f) {
			$cond[$f] = $kode[$i];
		}
		$cond['NO_SPP'] = $nomor;

		// ambil spp
		// $this->m_spp2->model_debug = true;
		$this->m_org->join_org_kec($this->m_spp2);
		$this->m_org->join_org_desa($this->m_spp2);
		$spp = $this->m_spp2->read_one($cond, array('*'), false);
		// debug($spp);

		// ambil spp-rincian
		$this->m_sppr->join_rek();
		$this->m_sppr->join_angg();
		$sppr = $this->m_sppr->read_many($cond);
		// debug($sppr);

		// ambil anggaran-rekening
		$cond_angg = array_slice($cond, 0, -1);
		foreach (app::get('field_prog') as $f) {
			$cond_angg[$f] = $spp['data'][0][$f];
		}
		$this->m_angg->join_rek();
		$angg = $this->m_angg->read_many($cond_angg);

		$this->template->view('spp/rincian/daftar-tambah');
	}
}
