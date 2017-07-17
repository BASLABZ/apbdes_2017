<?php
/**
* APBDesa
* /application/controllers/Spp_.
* 
* @date 201608151628, 201608152147, 201608191934
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Spp_ extends GI_Controller
{
	public $module = array(
		'name' => 'Surat Permintaan Pembayaran',
		'bc' => 'SPP',
		'model' => array('m_org','m_spp2','m_sppr','m_spppot','m_spp','m_program')
	);

	public function index()
	{
		redirect('spp3/index');
	}

	public function tambah()
	{
		app::bc('Tambah SPP', null);
		$tahun = $this->session->userdata('tahun');

		$is_kec = empty($this->session->kd_organisasi) ? false : true; // true: kalau login sebagai kecamatan
		$id_kec = $this->session->kd_organisasi;
		$is_des = empty($this->session->kd_desa) ? false : true; // true: kalau login sebagai operator desa
		$id_des = $this->session->kd_desa;
		$kodekode = kodekode();

		// SESSION INSTANSI
		$cond_org = array('KODEURUSAN' => 1, 'KODESUBURUSAN' => 20);
		if ($is_kec) $cond_org['KODEORGANISASI'] = $id_kec;
		if ($is_des) $cond_org['KODEDESA'] = $id_des;
		else $cond_org['KODEDESA !='] = '';

		// DAFTAR INSTANSI
		// $this->m_org->model_debug = 1;
		$this->m_org->model_table = $this->m_org->model_table2; // ganti table
		if ( ! $is_des) {
			$this->db->where_in($this->m_org->model_table .'.'. 'KODEORGANISASI', array_map('q1', $kodekode['kec']), false); // sesuai SESSION
		}
		$org = $this->m_org->read_many($cond_org, array('*'), false);
		// debug($org);

		// DAFTAR POTONGAN
		$pot = $this->db->query("SELECT * FROM VIEW_SPP_POTONGAN('{$tahun}')")->result_array();

		$perusahaan = $this->db->query("SELECT DISTINCT NAMA_PERUSAHAAN,ALAMAT_PERUSAHAAN, NOREK_PERUSAHAAN FROM SPP WHERE NAMA_PERUSAHAAN != ''")->result_array();

		$this->template->view('spp/spp/index', array(
			'content_title' => 'Tambah Rincian SPP',
			'content_body' => $this->load->view('spp/spp/tambah/form', array(
				'perusahaan' => $perusahaan
			), true),
			'content_script' => $this->load->view('spp/spp/tambah/js',array(
				'data' => array(
					'org' => $org['data'],
					'pot' => $pot
				)
			),true)
		));
	}

	public function ubah($kode = null)
	{
		$kode = explode('-', $kode);
		$nomor = $this->input->get('nomor');
		app::bc('Ubah SPP', uri_string() . '?nomor=' . urlencode($nomor));
		if (empty($kode) || empty($nomor) || count($kode) !== 4) show_error('parameter salah.');

		$tahun = $this->session->userdata('tahun');

		$cond_keg = array(); $cond_keg[] = $tahun;
		$cond_spp = array('TAHUN' => $tahun);
		$cond_org = array();
		for ($i=0; $i < 4; $i++) {
			$cond_spp[app::$data['field_org'][$i]] = $cond_org[app::$data['field_org'][$i]] = $kode[$i];
			$cond_keg[] = $kode[$i];
		}
		$cond_spp['NO_SPP'] = $nomor;

		// SPP
		$this->db->select("{$this->m_spp->model_table}.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa", false);
		$this->m_spp->spp_kec();
		$this->m_spp->spp_desa();
		$spp = $this->m_spp->show($cond_spp);
		if (count($spp) < 1) show_error('SPP tidak tersedia.');
		// debug($spp);

		// DAFTAR KEGIATAN
		$keg = $this->db->from("VIEW_KEGIATAN_DESA('" . implode("','", $cond_keg) . "')")->get()->result_array();

		// DAFTAR POTONGAN
		$pot = $this->db->query("SELECT * FROM VIEW_SPP_POTONGAN('{$tahun}')")->result_array();
		$pjk = $this->db->query("SELECT * FROM spppotongan
			WHERE tahun = '{$tahun}'
			AND KODEURUSAN = {$spp[0]['KODEURUSAN']}
			AND KODESUBURUSAN = {$spp[0]['KODESUBURUSAN']}
			AND KODEORGANISASI = '{$spp[0]['KODEORGANISASI']}'
			AND KODEDESA = '{$spp[0]['KODEDESA']}'
			AND NO_SPP = '{$spp[0]['NO_SPP']}'
		")->result_array();
		// debug($spppot);

		$this->template->view('spp/spp/index', array(
			'content_title' => 'Ubah SPP',
			'content_body' => $this->load->view('spp/spp/ubah/form', array(), true),
			'content_script' => $this->load->view('spp/spp/ubah/js', array(
				'data' => array(
					'spp' => $spp[0],
					'keg' => $keg,
					'pot' => $pot,
					'pjk' => $pjk
				)
			), true)
		));
	}
	// tambahan function hapus data pajak
	public function hapus_potongan_pajak($kode = null)
	{
		$kode = explode('-', $kode);
		$nomor = $this->input->get('nomor');
		$norek = $this->input->get('norek');
		app::bc('Ubah SPP', uri_string() . '?nomor=' . urlencode($nomor));
		if (empty($kode) || empty($nomor) || empty($norek) || count($kode) !== 4) show_error('parameter salah.');
		$tahun = $this->session->userdata('tahun');
		$cond_keg = array(); $cond_keg[] = $tahun;
		$cond_spp = array('TAHUN' => $tahun);
		$cond_org = array();
		for ($i=0; $i < 4; $i++) {
			$cond_spp[app::$data['field_org'][$i]] = $cond_org[app::$data['field_org'][$i]] = $kode[$i];
			$cond_keg[] = $kode[$i];
		}

		$cond_spp['NO_SPP'] = $nomor;
		$cond_spp['KODEURUSAN'];
		$cond_spp['KODESUBURUSAN'];
		$cond_spp['KODEORGANISASI'];
		$cond_spp['KODEDESA'];
		$cond_spp['NO_SPP'];

		$sqlhapus_Potongan_pajak = "DELETE FROM SPPPOTONGAN
															 WHERE
															 KODEURUSAN = '".$cond_spp['KODEURUSAN']."' AND
															 KODESUBURUSAN = '".$cond_spp['KODESUBURUSAN']."' AND
															 KODEORGANISASI = '".$cond_spp['KODEORGANISASI']."' AND
															 KODEDESA = '".$cond_spp['KODEDESA']."' AND
															 NO_SPP = '".$cond_spp['NO_SPP']."' AND
															 REKENINGPOTONGAN = '".$norek."'  " ;
		

		return $this->db->query($sqlhapus_Potongan_pajak);
		
	}

	public function simpan_tambah()
	{
		
		$kodeorg = $this->input->post('KODEORGANISASI');
		$kodeds  = $this->input->post('KODEDESA');
		if ($this->input->method() !== 'post') show_error('Tidak dapat menambah data.');
		$cekNO_SPP =$this->input->post('NO_SPP');
		$query = "SELECT COUNT(NO_SPP) AS NO_SPP FROM SPP WHERE NO_SPP = '".$cekNO_SPP."'";
		$cek['NO_SPP'] =  $this->db->query($query)->result_array();
		foreach ($cek['NO_SPP'] as $value) {
			$nospp = $value['NO_SPP'];
		}
		if ($nospp > 0) {
			$this->session->set_flashdata('spp_flash', array(
				'msg' => 'No SPP Telah Digunakan ',
				'alert' => 'danger'
			));
			redirect(base_url('spp3/index/'.$kodeorg.'-'.$kodeds.''));
		}elseif ($nospp <= 0) {
			$post = $this->input->post();
		if (isset($post['rincian_length'])) unset($post['rincian_length']); // gara2 datatable
		$url_spp_rincian = 'spp2/rincian/' . @$post['inp_org'] . '?nomor=' . urlencode(@$post['NO_SPP']);
		$post['TAHUN'] = $this->session->tahun;
		// ==================================================================== \\
		$add_spp = array();
		$add_rinci = array();
		$spp_rinci = array();
		$add_pajak = array();
		$spp_pajak = array();
		foreach ($post as $k => $v) {
			if (is_array($v)) { // array, berarti untuk rincian dan pajak
				if (preg_match('/(_POT)$/', $k)) { // akhiran _pot, berarti untuk pajak
					$_k = current(explode('_', $k));
					for($i = 0; $i < count($v); $i++) {
						$add_pajak[$i][$_k] = $v[$i];
					}
				} else {
					for($i = 0; $i < count($v); $i++) {
						$add_rinci[$i][$k] = $v[$i];
					}
				}
				// unset($k);
			} else {
				if (preg_match('/(URUSAN|EPROGRAM|EKEGIATAN)$/', $k)) $v = (int)$v; // cast insert db, agar tidak di quote pada builder
				if (!preg_match('/^inp_/', $k)) $add_spp[$k] = $v; // value untuk spp, kecuali value-spesial-form
				if (preg_match('/^(KODE|NO_SPP|TAHUN)/', $k)) $spp_rinci[$k] = $v; // value-spp untuk rincian
				if (preg_match('/^TGL_SPP$/', $k)) {
					$spp_rinci['TANGGAL'] = $v; // tanggal spp dan rincian harus sama
					$spp_pajak['TANGGAL'] = $v;
				}
				if (preg_match('/(TAHUN|URUSAN|NISASI|DESA|NO_SPP)$/', $k)) $spp_pajak[$k] = $v;
			}
		}
		// ==================================================================== //

		// ==================================================================== \\
		$this->db->trans_start(); // true: test-mode
		$total_jumlah_spp = 0;
		foreach ($add_rinci as $add) {
			$total_jumlah_spp += $add['JUMLAH'] = (int)$add['nilai']; // increment sekaligus set jumlah-rincian
			unset($add['inp_nilai_awal']);
			unset($add['inp_nilai']);
			unset($add['nilai']);

			// manual-data
			$add['KODESUB1'] = 0;
			$add['KODESUB2'] = 0;
			$add['KODESUB3'] = 0;

			$rinci = array_merge($add, $spp_rinci); // set-insert rincian value
			// print_r($rinci);
			$this->db->set($rinci)->from($this->m_sppr->model_table);
			// echo $this->db->get_compiled_insert(), PHP_EOL;
			@$this->db->insert();
		}

		foreach ($add_pajak as $add) {
			$pajak = array_merge($add, $spp_pajak);
			@$this->db->set($pajak)->from($this->m_spppot->model_table);
			$this->db->insert();
		}

		// manual-data
		$add_spp['ID_PENGESAHAN'] = 0;
		$add_spp['STATUS_PENGESAHAN'] = 0;
		$add_spp['ID_PERSETUJUAN'] = 0;
		$add_spp['STATUS_PERSETUJUAN'] = 0;
		$add_spp['USER_ID'] = (int)$this->session->kd_user;
		$add_spp['USER_NAME'] = $this->session->username;
		$add_spp['JUMLAH_SPP'] = $total_jumlah_spp;
		$this->db->set($add_spp)->from($this->m_spp2->model_table);
		// echo $this->db->get_compiled_insert(), PHP_EOL;
		@$this->db->insert();
		@$this->db->trans_complete();
		// ==================================================================== //

		if($this->db->trans_status()) {
			// echo "berhasil";
			// redirect($url_spp_rincian);
			// redirect(detail spp / rincian)

			$this->session->set_flashdata('spp_flash', array(
				'msg' => 'Berhasil menambah SPP',
				'alert' => 'success'
			));

			redirect($url_spp_rincian);
		} else {
				$this->session->set_flashdata('spp_flash', array(
					'msg' => 'Gagal menambah SPP',
					'alert' => 'danger'
				));

				redirect(base_url('spp3/index'));
			}
		}
	}

	public function simpan_ubah()
	{
		if ($this->input->method() !== 'post') show_error('Tidak dapat menambah data.');
		// debug($this->input->post());
		$post = $this->input->post();
		$post['TAHUN'] = $this->session->tahun;
		if (isset($post['rincian_length'])) unset($post['rincian_length']); // gara2 datatable
		if (isset($post['inp_org'])) unset($post['inp_org']);
		$url_spp_rincian = 'spp_/ubah/' . implode('-', array($post['KODEURUSAN'], $post['KODESUBURUSAN'], $post['KODEORGANISASI'], $post['KODEDESA'])) . '?nomor=' . urlencode(@$post['NO_SPP']);

		$keg_lama = implode('-', array($post['KODEBIDANG'], $post['KODEPROGRAM'], $post['KODEKEGIATAN']));
		$keg_baru = $post['inp_keg'];

		$upd_spp = array(); $key_spp = array();
		$_rinci = array();
		$_pajak = array(); $spp_pajak = array();
		foreach ($post as $k => $v) { 
			if (is_array($v)) { // array, berarti untuk rincian dan pajak
				if (preg_match('/\_POT$/', $k)) { // akhiran _pot, berarti untuk pajak
					$_k = current(explode('_', $k));
					for($i = 0; $i < count($v); $i++) {
						$_pajak[$i][$_k] = $v[$i];
					}
				} else {
					for ($i=0; $i < count($v); $i++) {
						if (preg_match('/^KODE/', $k)) {
							$_rinci[$i]['key'][$k] = $v[$i];
						} else {
							$_rinci[$i]['value'][$k] = $v[$i];
						}
					}
				}
			} else {
				if (preg_match('/(URUSAN|EPROGRAM|EKEGIATAN|BULAN)$/', $k)) $v = (int)$v; // cast insert db, agar tidak di quote pada builder
				if (!preg_match('/^(inp_|KODE|TAHUN|NO_SPP)/', $k)) $upd_spp[$k] = $v; // value untuk spp, kecuali value-spesial-form dan key-spp
				if (preg_match('/^(KODE|TAHUN|NO_SPP)/', $k)) $key_spp[$k] = $v; // key untuk spp
				if (preg_match('/^(TAHUN|NO_SPP)/', $k) || preg_match('/(RUSAN|NISASI|DESA)$/', $k)) $spp_pajak[$k] = $v; // key-spp untuk pajak
			}
		}

		// echo "<pre>";

		// ==================================================================== \\
		$this->db->trans_start(); // true: test-mode
		$total_jumlah_spp = 0;
		if ($keg_lama === $keg_baru) { // update
			foreach ($_rinci as $rinci) {
				$rinci['key'] = array_merge($rinci['key'], $key_spp);
				$rinci['value']['TANGGAL'] = $upd_spp['TGL_SPP'];
				$total_jumlah_spp += $rinci['value']['JUMLAH'] = (int)$rinci['value']['nilai'];
				unset($rinci['value']['inp_nilai_awal']);
				unset($rinci['value']['inp_nilai']);
				unset($rinci['value']['nilai']);
				$this->db->from($this->m_sppr->model_table)->set($rinci['value'])->where($rinci['key'])->limit(1)->update();
			}
			$upd_spp['JUMLAH_SPP'] = $total_jumlah_spp;
			$this->db->from($this->m_spp2->model_table)->set($upd_spp)->where($key_spp)->limit(1)->update();
		} else { // insert dan hapus / hapus dan insert
			$keg_baru = explode('-', $keg_baru);
			$this->db->from($this->m_sppr->model_table)->where(array_merge($key_spp))->delete(); // hapus
			foreach ($_rinci as $rinci) {
				$rinci['key'] = array_merge($rinci['key'], $key_spp);
				$rinci['value']['TANGGAL'] = $upd_spp['TGL_SPP'];
				$total_jumlah_spp += $rinci['value']['JUMLAH'] = (int)$rinci['value']['nilai'];
				unset($rinci['value']['inp_nilai_awal']);
				unset($rinci['value']['inp_nilai']);
				unset($rinci['value']['nilai']);
				$rinci['key']['KODEBIDANG'] = $keg_baru[0];
				$rinci['key']['KODEPROGRAM'] = $keg_baru[1];
				$rinci['key']['KODEKEGIATAN'] = $keg_baru[2];
				$rinci['value']['KODESUB1'] = 0;
				$rinci['value']['KODESUB2'] = 0;
				$rinci['value']['KODESUB3'] = 0;
				$rinci = array_merge($rinci['value'], $rinci['key']);
				$this->db->from($this->m_sppr->model_table)->set($rinci)->insert(); // buat
				// print_r($rinci);
			}
			$upd_spp['JUMLAH_SPP'] = $total_jumlah_spp;
			$upd_spp['KODEBIDANG'] = $keg_baru[0];
			$upd_spp['KODEPROGRAM'] = $keg_baru[1];
			$upd_spp['KODEKEGIATAN'] = $keg_baru[2];
			$this->db->from($this->m_spp2->model_table)->set($upd_spp)->where($key_spp)->limit(1)->update();
		}
		foreach ($_pajak as $pajak) {
			$pajak = array_merge($pajak, $spp_pajak);
			$pajak['TANGGAL'] = $upd_spp['TGL_SPP'];
			$q = $this->db->from($this->m_spppot->model_table)->set($pajak)->limit(1)->get_compiled_insert();
			$this->db->query('UPDATE OR ' . $q); // kesuwen
		}
		$this->db->trans_complete();
		// ==================================================================== //

		if($this->db->trans_status()) {
			// echo "berhasil";
			// redirect($url_spp_rincian);
			// redirect(detail spp / rincian)

			$this->session->set_flashdata('spp_flash', array(
				'msg' => 'Berhasil mengubah SPP',
				'alert' => 'success'
			));

			redirect($url_spp_rincian);
		} else {
			// show_error('Gagal mengubah data SPP.');
			// echo "gagal";
			// show_error

			$this->session->set_flashdata('spp_flash', array(
				'msg' => 'Gagal mengubah SPP',
				'alert' => 'danger'
			));

			redirect(base_url('spp3/index'));
		}
	}
	public function cekNOSPP()
	{
		$query = "SELECT NO_SPP FROM SPP WHERE TAHUN='".$this->session->userdata('tahun')."' AND KODEURUSAN = '".$this->session->userdata('kd_urusan')."' AND KODESUBURUSAN = '".$this->session->userdata('kd_suburusan')."' AND KODEORGANISASI = '".$this->session->userdata('kd_organisasi')."'  AND KODEDESA  = '".$this->session->userdata('kd_desa')."'";
		$data = $this->db->query($query)->result_array();
		$json = [];
		foreach ($data as  $value) {
			$json[] = $value['NO_SPP'];
		}
           echo json_encode($json);
         
	}
}
