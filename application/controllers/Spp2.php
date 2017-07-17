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

class Spp2 extends GI_Controller
{
	public $module = array(
		'name' => 'Surat Permintaan Pembayaran',
		'bc' => 'SPP',
		'model' => array('m_spp', 'm_organisasi', 'm_program', 'm_spprincian', 'm_apbdes', 'm_angg_belanja', 'm_rekening')
	);

	public function index()
	{
		redirect('spp3/index'); //

		$page = (int)$this->input->get('page') > 1 ? $this->input->get('page') : 1;
		$limit = 10;
		$offset = ($page-1)*$limit;

		$this->db->select("{$this->m_spp->model_table}.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa, mo_prog.URAI as urai_prog", false);
		$this->m_spp->spp_kec();
		$this->m_spp->spp_desa();
		$this->m_spp->spp_prog();
		$result = $this->m_spp->all(array(), $limit, $offset);
		$result['page'] = $page;
		$result['limit'] = $limit;
		// debug($result);

		$this->template->view('spp/list2', array('sppdata' => $result));
	}

	public function rincian($kode = null)
	{
		$kode = explode('-', $kode);
		$nomor = $this->input->get('nomor');
		app::bc('Rincian SPP', uri_string() . '?nomor=' . urlencode($nomor));
		if (empty($kode) || empty($nomor) || empty($kode[3])) show_error('parameter salah', '403');

		// tahun sesuai session
		$tahun = $this->session->userdata('tahun');

		$cond = array(
			'TAHUN' => $tahun,
			'KODEURUSAN' => $kode[0],
			'KODESUBURUSAN' => $kode[1],
			'KODEORGANISASI' => $kode[2],
			'KODEDESA' => $kode[3],
			'NO_SPP' => $nomor
		);
		// debug(array_slice($cond, 1, 4));

		// 1. ambil spp
		$this->db->select("{$this->m_spp->model_table}.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa, mo_prog.URAI as urai_prog", false);
		$this->m_spp->spp_kec();
		$this->m_spp->spp_desa();
		$this->m_spp->spp_prog();
		$spp = $this->m_spp->show($cond);
		// debug($spp);
		if (empty($spp[0])) show_error('SPP tidak Ditemukan.'); // stop

		// 1.5. ambil pajak
		$spprek = $this->db->query("SELECT * FROM view_spp_potongan('{$tahun}')")->result_array();
		$spppot = $this->db->query("SELECT * FROM spppotongan
			WHERE tahun = '{$tahun}'
			AND KODEURUSAN = {$spp[0]['KODEURUSAN']}
			AND KODESUBURUSAN = {$spp[0]['KODESUBURUSAN']}
			AND KODEORGANISASI = '{$spp[0]['KODEORGANISASI']}'
			AND KODEDESA = '{$spp[0]['KODEDESA']}'
			AND NO_SPP = '{$spp[0]['NO_SPP']}'
		")->result_array();
		// debug($spppot);

		$q_sppr = $this->db->query("SELECT * FROM view_spp_rincian('{$tahun}', {$cond['KODEURUSAN']},{$cond['KODESUBURUSAN']},'{$cond['KODEORGANISASI']}','{$cond['KODEDESA']}', '{$spp[0]['KODEBIDANG']}','{$spp[0]['KODEPROGRAM']}',{$spp[0]['KODEKEGIATAN']}, '{$spp[0]['NO_SPP']}', '{$spp[0]['TGL_SPP']}')");
		$sppr = $q_sppr->result_array();
		// debug($sppr);
		/*
		// 2. ambil spprincian
		// $sppr = $this->m_spprincian->all($cond);
		$t_sppr = $this->m_spprincian->model_table;
		$t_ab = $this->m_angg_belanja->model_table;
		$cond_sppr = [];
		foreach (array_slice($cond, 0, -1) as $k => $v) {
			$cond_sppr[] = "{$t_ab}.{$k} = {$t_sppr}.{$k}";
		}
		$cond_sppr[] = "{$t_ab}.{$k} = {$t_sppr}.{$k}";
		$cond_sppr[] = "{$t_ab}.KODEAKUN = {$t_sppr}.KODEAKUN";
		$cond_sppr[] = "{$t_ab}.KODEKELOMPOK = {$t_sppr}.KODEKELOMPOK";
		$cond_sppr[] = "{$t_ab}.KODEJENIS = {$t_sppr}.KODEJENIS";
		$cond_sppr[] = "{$t_ab}.KODEOBJEK = {$t_sppr}.KODEOBJEK";
		$this->db->join($t_ab, implode(" AND ", $cond_sppr), 'left',false);
		$this->m_apbdes->init($this->m_spprincian->model_table);
		$this->m_apbdes->join_left_with($this->m_rekening->model_table, [
			'TAHUN',
			'KODEAKUN',
			'KODEKELOMPOK',
			'KODEJENIS',
			'KODEOBJEK'
		], ['URAI as URAI_REK']);
		$this->m_apbdes->model_table_field[] = "{$t_ab}.JUMLAH as jumlah_angg";
		$sppr = $this->m_apbdes->all($cond);
		// debug($sppr);
		*/

		/*
		// 3. ambil anggaran-rekening
		$this->m_apbdes->init($this->m_angg_belanja->model_table);
		$this->m_apbdes->join_left_with($this->m_rekening->model_table, [
			'TAHUN',
			'KODEAKUN',
			'KODEKELOMPOK',
			'KODEJENIS',
			'KODEOBJEK'
		], ['urai as urai_rekening']);
		$cond_ar = array_slice($cond, 0, 5);
		$cond_ar['KODEBIDANG'] = $spp[0]['KODEBIDANG'];
		$cond_ar['KODEPROGRAM'] = $spp[0]['KODEPROGRAM'];
		$cond_ar['KODEKEGIATAN'] = $spp[0]['KODEKEGIATAN'];
		$anggr = $this->m_apbdes->all($cond_ar);
		// debug($anggr);
		// if (empty(count($anggr['data']))) show_error('Anggaran tidak tersedia untuk SPP ini.'); // stop
		*/

		$this->template->view('spp/v3/rincian',array(
			'dataspp' => $spp[0],
			'datasppr' => $sppr,
			'spprek' => $spprek,
			'spppot' => $spppot
			// 'dataanggr' => $anggr
		));
	}

	public function tambah()
	{
		$cond = array();
		// todo.
		// urusan/sub/kec?
		$cond['KODEDESA'] = '';
		$data_kec = $this->m_organisasi->all($cond);

		$this->template->view('spp/index2-tambah', array(
			'res_inp_kec' => $data_kec
		));
	}

	public function simpan()
	{
		$post = $this->input->post();
		// debug($post);
		$post['TAHUN'] = $this->session->userdata('tahun'); // berdasarkan sesi
		$post['USER_NAME'] = $this->session->username; // berdasarkan sesi
		$post['USER_ID'] = $this->session->kd_user; // berdasarkan sesi
		$post['JUMLAH_SPP'] = 0; // default value pertama | men ra error

		// debug($post);

		$q = $this->m_spp->store(array(), $post, array('inp_kec','inp_desa','inp_keg'));
		if ($q) {
			$kode = array($post['KODEURUSAN'], $post['KODESUBURUSAN'], $post['KODEORGANISASI'], $post['KODEDESA']);
			$nomor = $post['NO_SPP'];

			// debug($kode, false, false);
			// debug($nomor);

			$redir = 'spp2/rincian/' . implode('-', $kode) . '?nomor=' . urlencode($nomor);
			redirect($redir);
		}
		show_error('gagal menyimpan data.');
	}

	public function rincian_simpan()
	{
		$post = $this->input->post();
		// debug($post);
		if ($this->input->method() !== 'post') show_error('data kosong');

		$cond = array();
		foreach ($this->m_spp->model_key as $k) {
			$cond[$k] = $post[$k];
		}

		// http://stackoverflow.com/questions/9281075/dealing-with-duplicate-keys-in-codeigniter-mysql-insert/17395857#17395857
		$this->db->db_debug = FALSE;

		// mulai
		$this->db->trans_start(); // ---------
			// pateni
			@$this->m_spprincian->store(array(), $post, array('web_inp_anggrek'));

			$this->db->set('JUMLAH_SPP', ("JUMLAH_SPP+" . $post['JUMLAH']), false);
			$this->db->limit(1);
			$this->m_spp->update(array(), $cond);
		$this->db->trans_complete(); // ---------
		// selesai

		if ($this->db->trans_status()) {
			$rdr = 'spp2/rincian/' . implode('-', array($this->input->post('KODEURUSAN'), $this->input->post('KODESUBURUSAN'), $this->input->post('KODEORGANISASI'), $this->input->post('KODEDESA'))) . '?nomor=' . urlencode($this->input->post('NO_SPP'));
			redirect($rdr);
		}
		show_error('Gagal menyimpan data. Duplikat data.');
	}
	// tambahan untuk hapus data potongan pajak berdasarkan KODEURUSAN,SUBURUSAN,ORGANISASI,REKENING DAN NO_SPP
	public function hapus_potongan_pajak($tahun,$kodeurusan,$kodesuburusan,$kodeorganisasi,$kodedesa,$rekeningpotongan,$no_spp)
	{
				$nomor = str_replace("-", "/", $no_spp);
				$xnomor  = urlencode($nomor);
				$rekening = str_replace("-", ".", $rekeningpotongan);
				$sqlhapus_Potongan_pajak = "DELETE FROM SPPPOTONGAN
															 WHERE
															 TAHUN = '".date('Y')."' AND
															 KODEURUSAN = '".$kodeurusan."' AND
															 KODESUBURUSAN = '".$kodesuburusan."' AND
															 KODEORGANISASI = '".$kodeorganisasi."' AND
															 KODEDESA = '".$kodedesa."' AND
															 NO_SPP = '".$nomor."' AND
															 REKENINGPOTONGAN = '".$rekening."'  " ;

		
		$hapus =  $this->db->query($sqlhapus_Potongan_pajak);

		// if ($hapus) {
			
		// 	$redir = 'spp2/rincian/'.$kodeurusan.'-'.$kodesuburusan.'-'.$kodeorganisasi.'-'.$kodedesa.'?nomor='.$xnomor.'';
		// 	redirect($redir);

		// }
		
	}
	public function ubah_potongan_pajak()
	{
		$tahun = $this->session->userdata('tahun');
		$kodeurusan = $this->input->post('txtkodeurusan');
		$kodesuburusan = $this->input->post('txtkodesuburusan');
		$kodeorganisasi = $this->input->post('textkodeorganisasi');
		$kodedesa = $this->input->post('textkddesa');
		$rekeningpotongan = $this->input->post('textrekeningpotongan');
		$no_spp = $this->input->post('textno_spp');
		$editjumlah = $this->input->post('textjumlah');
		$xnomor  = urlencode($no_spp);

		$query = "UPDATE SPPPOTONGAN SET JUMLAH = '".$editjumlah."' 
											WHERE TAHUN='".$tahun."'
											AND   KODEURUSAN = '".$kodeurusan."'
											AND KODESUBURUSAN = '".$kodesuburusan."'
											AND KODEORGANISASI = '".$kodeorganisasi."'
											AND KODEDESA = '".$kodedesa."'
											AND REKENINGPOTONGAN = '".$rekeningpotongan."'
											AND NO_SPP = '".$no_spp."'
											";
		$save = $this->db->query($query);
		if ($save) {
			$redir = 'spp2/rincian/'.$kodeurusan.'-'.$kodesuburusan.'-'.$kodeorganisasi.'-'.$kodedesa.'?nomor='.$xnomor.'';
			$this->session->set_flashdata('Sukses', "<div class='alert alert-success alert-dismissable'><button aria-hidden='true' data-dismiss='alert' class='close' type='button'>×</button> Data Jabatan Berhasil Disimpan. </div>");
			redirect($redir);			
		}

	}
}
