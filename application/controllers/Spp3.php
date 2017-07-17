<?php
/**
* APBDesa
* /application/controllers/Spp3.
* 
* @date 201607181443, 201607191122
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Spp3 extends GI_Controller
{
	public $module = array(
		'name' => 'Surat Permintaan Pembayaran',
		'bc' => 'SPP',
		'model' => array('m_spp', 'm_sppr', 'm_instansi','m_program','m_spppot','m_org')
	);

	public function index($kode = null)
	{
		app::bc('Daftar SPP', null);
		$kode = array_filter(explode('-', $kode));
		if (count($kode) > 2) show_error('Terjadi Kesalahan');

		$is_kab = ($this->session->hakakses === 'OPERATORKABUPATEN');
		$is_kec = empty($this->session->kd_organisasi) ? false : true; // true: kalau login sebagai kecamatan
		$id_kec = $this->session->kd_organisasi;
		$is_des = in_array($this->session->hakakses, array('OPERATORDESA','SEKDES','KEPALADESA')) ? true : false; // true: kalau login sebagai user-dari-desa
		$id_des = $this->session->kd_desa;
		$kodekode = kodekode();

		if ($is_des && count($kode) < 1) {
					redirect('spp3/index/' . $id_kec . '-' . $id_des);
				}

		$page = (int)$this->input->get('page') > 1 ? $this->input->get('page') : 1;
		$limit = 10;
		$offset = ($page-1)*$limit;

		// tahun sesuai session
		$tahun = $this->session->userdata('tahun');

		// indikator view select-option. 0:kec, 1:desa
		$seg3 = array();

		$cond_harus = array('TAHUN' => $tahun, 'KODEURUSAN' => 1, 'KODESUBURUSAN' => 20);

		$cond_spp = $cond_harus;
		$cond_ins = $cond_harus;
		if (count($kode) > 0) { // jika kode di-url ada (13-01)
			$cond_spp['KODEORGANISASI'] = $seg3[0] = $is_kec ? $id_kec : $kode[0];
			if ($is_kec) {
				$cond_ins['KODEORGANISASI'] = $id_kec;
			}
			if (count($kode) > 1) {
				$cond_spp['KODEDESA'] = $seg3[1] = $is_des ? $id_des : $kode[1];
			}
			if ($is_des) {
				$cond_spp['KODEDESA'] = $cond_ins['KODEDESA'] = $seg3[1] = $id_des;
			}
		} else {
			if ($is_kec) {
				$cond_spp['KODEORGANISASI'] = $cond_ins['KODEORGANISASI'] = $seg3[0] = $id_kec;
			}
			if ($is_des) {
				$cond_spp['KODEDESA'] = $cond_ins['KODEDESA'] = $seg3[1] = $id_des;
			} else {
				$cond_ins['KODEDESA !='] = '';
			}
		}

		if (count($kode) > 0) {
			if (!$is_des) {
				// if (!isset($cond_spp['KODEORGANISASI'])) unset($cond_spp['KODEORGANISASI']);
				// $this->db->where_in($this->m_spp->model_table .'.'. 'KODEORGANISASI', $kodekode['kec'] , false); // sesuai yg SESSION
				if (!isset($cond_spp['KODEORGANISASI'])) {
					$this->db->where_in($this->m_spp->model_table .'.'. 'KODEORGANISASI', $kodekode['kec'] , false); // sesuai yg SESSION
				}
			}
			// SPP
			$this->db->select("{$this->m_spp->model_table}.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa, mo_prog.URAI as urai_prog", false);
			$this->m_spp->spp_kec();
			$this->m_spp->spp_desa();
			$this->m_spp->spp_prog();
			$result = $this->m_spp->all($cond_spp);
			// debug($result);
			// @$result['page'] = $page;
			// @$result['limit'] = $limit;
		} else {
			$result = array('data' => array());
		}

		// INSTANSI
		// $this->m_org->model_debug = true;
		$this->m_org->model_table = $this->m_org->model_table2;
		if ( ! $is_des) {
			$this->db->where_in($this->m_org->model_table .'.'. 'KODEORGANISASI', array_map('q1', $kodekode['kec']), false); // sesuai yg SESSION
		}
		if (!isset($cond_ins['KODEDESA']) || !isset($cond_ins['KODEDESA !='])) {
			$cond_ins['KODEDESA !='] = ''; // (HARUS) pastikan cond desa tidak kosong waktu select-nya
		}
		$k = $this->m_org->read_many($cond_ins, array('*'), false);
		// debug($k);

		$seg3 = implode('-', $seg3);

		$this->template->view('spp/v3/daftar', array(
			'sppdata' => $result,
			'res_inp_kec' => $k['data'],
			'slc_seg3' => $seg3
		));
	}

	public function rincian_simpan()
	{
		$post = $this->input->post();
		if (count($post) < 1) show_error('Data Kosong.');

		// debug($post);

		if (isset($post['JUMLAH_POT'])) {
			for ($i=0; $i < count($post['JUMLAH_POT']); $i++) {
				$this->db->query("UPDATE OR INSERT INTO {$this->m_spppot->model_table} (
						TAHUN,
						KODEURUSAN,
						KODESUBURUSAN,
						KODEORGANISASI,
						KODEDESA,
						NO_SPP,
						REKENINGPOTONGAN,
						JUMLAH,
						JENISPOTONGAN,
						TANGGAL
					) VALUES (
						'{$post['TAHUN']}',
						{$post['KODEURUSAN']},
						{$post['KODESUBURUSAN']},
						'{$post['KODEORGANISASI']}',
						'{$post['KODEDESA']}',
						'{$post['NO_SPP']}',
						'{$post['REKENINGPOTONGAN'][$i]}',
						{$post['JUMLAH_POT'][$i]},
						'{$post['JENIS_POT'][$i]}',
						'{$post['TANGGAL']}'
					)
				");
			}
			unset($post['REKENINGPOTONGAN']);
			unset($post['JUMLAH_POT']);
			unset($post['JENIS_POT']);
		}

		$error = array();

		$result = array();
		for ($i=0; $i < count($post['KODEAKUN']); $i++) {

			// nek ora diedit, lewati
			if ($post['nilai_lama'][$i] === $post['nilai_sekarang'][$i]) {
				continue;
			}

			$data = $post;
			$data['JUMLAH'] = $post['nilai_sekarang'][$i];

			$data['KODEAKUN'] = $post['KODEAKUN'][$i];
			$data['KODEKELOMPOK'] = $post['KODEKELOMPOK'][$i];
			$data['KODEJENIS'] = $post['KODEJENIS'][$i];
			$data['KODEOBJEK'] = $post['KODEOBJEK'][$i];

			$data['uang']['lama'] = $post['nilai_lama'][$i];
			$data['uang']['baru'] = $post['nilai_sekarang'][$i];

			unset($data['nilai_lama']);
			unset($data['nilai_sekarang']);

			// debug($data);

			$result[] = $data;
		}

		// aku iso ngatasine
		$this->db->db_debug = false;

		foreach ($result as $res) {
			// keduanya harus update
			$this->db->trans_start(); // ---------
				$sql = "UPDATE OR ". $this->db->set( array_diff_key($res, array('uang'=>false)) )->get_compiled_insert( $this->m_sppr->model_table );
				@$this->db->query($sql);
				// debug($sql,false,false);

				$hasil = $res['uang']['baru']-$res['uang']['lama'];
				$operasi = ($hasil < 0) ? '-' : '+';

				$error_prop = $res['uang'];

				unset($res['uang']);
				unset($res['JUMLAH']);
				unset($res['KODESUB1']);
				unset($res['KODESUB2']);
				unset($res['KODESUB3']);
				unset($res['URAIAN']);
				unset($res['KODEAKUN']);
				unset($res['KODEKELOMPOK']);
				unset($res['KODEJENIS']);
				unset($res['KODEOBJEK']);
				$res['TGL_SPP'] = $res['TANGGAL']; unset($res['TANGGAL']);

				$this->db->set('JUMLAH_SPP', ("JUMLAH_SPP" . $operasi . abs($hasil)), false);
				$this->db->limit(1);
				@$this->m_spp->update(array(), $res);
				// debug( $this->m_spp->update([], $res) );
			$this->db->trans_complete(); // ---------
			if ($this->db->trans_status() === false) {
				$error[] = $error_prop;
			}
		}

		// back url
		$u = 'spp2/rincian/' . implode('-', array($post['KODEURUSAN'],$post['KODESUBURUSAN'],$post['KODEORGANISASI'],$post['KODEDESA'])) . '?nomor=' . urlencode($post['NO_SPP']);
		// handle error
		if (count($error) > 0) {
			$error_msg = '';
			foreach ($error as $e) {
				$error_msg .= 'Gagal merubah nilai dari <b>' . format_rupiah($e['lama']) . '</b> menjadi <b>' . format_rupiah($e['baru']) . '</b>.<br/>';
			}
			// show_error($error_msg);

			$this->session->set_flashdata('spp_flash', array(
				'msg' => $error_msg,
				'alert' => 'danger'
			));
		} else {
			// redirect($u);

			$this->session->set_flashdata('spp_flash', array(
				'msg' => "Berhasil merubah Rincian SPP",
				'alert' => 'success'
			));
		}

		redirect($u);
	}

	

}
