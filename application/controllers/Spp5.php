<?php
/**
* APBDesa
* /application/controllers/Spp5.
* 
* @date 201608101027
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Spp5 extends GI_controller
{
	public $module = array(
		'name' => 'Surat Permintaan Pembayaran',
		'bc' => 'SPP',
		'model' => array('m_spp2','m_sppr','m_org','m_spppot')
	);

	/* @deprecated (unused) */
	public function index()
	{
		redirect('spp3/index'); //
	}

	public function simpan_ubah()
	{
		if ($this->input->method() !== 'post') show_error('Tidak dapat menyimpan.');

		$post = $this->input->post();
		$keg_lama = implode(',', array($post['KODEBIDANG'], $post['KODEPROGRAM'], $post['KODEKEGIATAN']));
		$keg_baru = $post['inp_keg'];
		unset($post['inp_keg']);

		$_cond = array('TAHUN','KODEURUSAN','KODESUBURUSAN','KODEORGANISASI','KODEDESA','NO_SPP');

		$cond = array();
		foreach ($_cond as $field) {
			$cond[$field] = $post[$field];
			unset($post[$field]);
		}

		// SPP
		$this->db->from($this->m_spp2->model_table);
		$this->db->where($cond);
		$this->db->set($post);
		$this->db->update();

		// kalau ganti kegiatan, HAPUS spp-rincian DAN spp-potongan
		if ($keg_lama !== $keg_baru) {
			// POTONGAN
			$this->db->from($this->m_spppot->model_table);
			$this->db->where($cond);
			$this->db->delete();

			// RINCIAN
			$cond['KODEBIDANG'] = $post['KODEBIDANG'];
			$cond['KODEPROGRAM'] = $post['KODEPROGRAM'];
			$cond['KODEKEGIATAN'] = $post['KODEKEGIATAN'];
			$this->db->from($this->m_sppr->model_table);
			$this->db->where($cond);
			$this->db->delete();
		} else { // update tanggal rincian. karena harus sama-dengan tanggal spp
			$cond['KODEBIDANG'] = $post['KODEBIDANG'];
			$cond['KODEPROGRAM'] = $post['KODEPROGRAM'];
			$cond['KODEKEGIATAN'] = $post['KODEKEGIATAN'];
			// debug($cond);
			$this->db->from($this->m_sppr->model_table);
			$this->db->where($cond);
			$this->db->set('TANGGAL', $post['TGL_SPP']);
			$this->db->update();
		}

		$url_redir = 'spp2/rincian/' . implode('-', array($cond['KODEURUSAN'],$cond['KODESUBURUSAN'],$cond['KODEORGANISASI'],$cond['KODEDESA'])) . '?nomor=' . urlencode($cond['NO_SPP']);
		redirect($url_redir);
	}

	//                   kode lengkap
	public function ubah($kode = null)
	{
		$kode = explode('-', $kode);
		$nomor = $this->input->get('nomor');
		if (empty($kode) || empty($nomor) || count($kode) !== 4) show_error('parameter salah.');

		// tahun sesuai session
		$tahun = $this->session->userdata('tahun');

		$cond = array(
			'TAHUN' => $tahun,
			'KODEURUSAN' => $kode[0],
			'KODESUBURUSAN' => $kode[1],
			'KODEORGANISASI' => $kode[2],
			'KODEDESA' => $kode[3]
		);

		// SPP
		$cond_spp = $cond;
		$cond_spp['NO_SPP'] = $nomor;
		$spp = $this->m_spp2->read_one($cond_spp);
		if (count($spp['data']) < 1) show_error('SPP tidak tersedia.','404');
		// debug($spp);

		// INSTANSI
		$cond_inst = $cond;
		$this->m_org->model_table = $this->m_org->model_table2; // ganti table
		$data_inst = $this->m_org->read_one($cond_inst, array('URAI'), false);
		// debug($data_inst);
		$spp['data'][0]['URAI_ORG'] = $data_inst['data'][0]['URAI'];

		// KEGIATAN
		array_unshift($kode, $tahun);
		$kode = "'" . implode("','", $kode) . "'";
		$this->db->from("VIEW_KEGIATAN_DESA({$kode})");
		$keg = $this->db->get()->result_array();
		// debug($keg);

		$this->template->view('spp/v5/ubah',array(
			'spp' => $spp['data'][0],
			'keg' => $keg
		));
	}

	//                   kode lengkap
	public function hapus($kode = null)
	{
		$kode = explode('-', $kode);
		$nomor = $this->input->get('nomor');
		if (empty($kode) || empty($nomor) || count($kode) !== 4) show_error('parameter salah.');

		$tahun = $this->session->userdata('tahun');

		$cond['TAHUN'] = $tahun;
		$cond['KODEURUSAN'] = (int)$kode[0];
		$cond['KODESUBURUSAN'] = (int)$kode[1];
		$cond['KODEORGANISASI'] = $kode[2];
		$cond['KODEDESA'] = $kode[3];
		$cond['NO_SPP'] = $nomor;

		// SPP
		foreach ($cond as $k => $v) {
			$this->db->where($k, $v);
		}
		@$this->db->delete($this->m_spp2->model_table);

		// RINCIAN
		foreach ($cond as $k => $v) {
			$this->db->where($k, $v);
		}
		@$this->db->delete($this->m_sppr->model_table);

		// POTONGAN
		foreach ($cond as $k => $v) {
			$this->db->where($k, $v);
		}
		@$this->db->delete($this->m_spppot->model_table);

		// $this->session->set_flashdata('spp_flash', array(
		// 	'msg' => 'Berhasil menghapus SPP',
		// 	'alert' => 'success'
		// ));

		if (empty($_SERVER['HTTP_REFERER'])) {
			// kembali ke index
			redirect('spp3/index');
		} else {
			redirect($_SERVER['HTTP_REFERER']);
		}

	}
}
