<?php
/**
* APBDesa
* /application/controllers/Daskum.
* 
* @date 201605250940, 201605302106, 201606011054, 201606031342, 201606041158, 201606042237
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Daskum extends GI_Controller
{
	public $module = array(
		'name' => 'Dasar Hukum',
		'model' => array('m_organisasi', 'm_daskum', 'm_org')
	);

	public function index()
	{
		redirect('daskum2/index');
		/*
		$this->template->view('daskum/index',array(
			'daskum_kec' => $this->m_organisasi->get_kecamatan()
		));
		*/
	}

	/**
	* todo
	*/
	public function daftar($id_kec = null, $id_desa = null)
	{

		app::bc('Daftar Dasar Hukum',null);

		// $page = empty($page) ? 1 : (int)$page;
		// $limit = 5;
		// $offset = ($page-1)*$limit;

		if (empty($id_kec) && empty($id_desa)) {
			$result = array('data' => array());
		} else {
			$result = $this->m_daskum->all($id_kec,$id_desa);
			// $result['page'] = $page;
			// $result['limit'] = $limit;
			// $result['offset'] = $offset;
		}

		// $this->m_org->model_debug = true;
		$this->m_org->model_table = $this->m_org->model_table2;
		$org = $this->m_org->read_many(array('KODEDESA !=' => ''));
		// debug($org);

		$this->template->view('daskum/index',array(
			'daskum_kec' => $org['data'],
			'daftar_daskum' => $result
		));
	}

	/**
	* todo
	*/
	// nek ora dikeki default value, iso error, nek dicelok tanpa param
	public function lihat($id_kec = null,$id_desa = null,$id_daskum = null)
	{
		// harus
		if (empty($id_daskum)) show_error('id_daskum kosong','403');

		app::bc('Lihat',null);

		$data = $this->m_daskum->show($id_kec,$id_desa,$id_daskum);

		if (count($data) < 1) show_404();

		$this->template->view('daskum/detail',array('data' => $data));
	}

	/**
	* @param all (string) - tujuannya hanya untuk holder.
	*/
	public function tambah($id_kec = null, $id_desa = null)
	{
		app::bc('Tambah Dasar Hukum',null);
		$title = "Tambah";
		$this->m_org->model_table = $this->m_org->model_table2;
		$org = $this->m_org->read_many(array('KODEDESA !=' => ''));
		// debug($org);

		$this->template->view('daskum/buat_baru',array(
			'daskum_kec' => $org['data'], 'title' => $title
		));
	}

	/**
	* todo: le nampilke desane 1 wae. yo sing diedit kui
	*/
	public function ubah($id_kec = null,$id_desa = null,$id = null)
	{
		// harus lengkap
		if (empty($id_kec) || empty($id_desa) || empty($id)) show_error('parameter id tidak lengkap','403');

		app::bc('Ubah Dasar Hukum',null);
		$title = "Ubah";
		$data = $this->m_daskum->show($id_kec,$id_desa,$id);
		$kodekode = kodekode();

		$tbl = $this->m_org->model_table = $this->m_org->model_table2;
		$this->db->where_in($tbl . '.KODEORGANISASI', array_map('q1', $kodekode['kec']), false);
		$org = $this->m_org->read_one(array(
			'KODEORGANISASI' => $id_kec,
			'KODEDESA' => $id_desa
		));
		// debug($org);

		if (count($data) < 1) show_404();

		$this->template->view('daskum/edit',array(
			'daskum_kec' => $org['data'],
			'data' => $data, 'title' => $title
		));
	}

	/**
	* todo
	*/
	public function ajx_desa($id_kec = null, $id_desa = null)
	{
		// $this->output->set_content_type('application/json')->set_output(json_encode($this->m_organisasi->get_desa($id_kec_desa)));
		$this->output->set_content_type('application/json')->set_output(json_encode($this->m_organisasi->all_desa($id_kec, $id_desa)));
	}

	/**
	* todo
	*/
	public function simpan()
	{
		 // app::debug($this->input->post());

		// cek, apa http-post ada?
		if (count($this->input->post(null, false)) < 1) show_error('data tidak lengkap','403');
		$post = $this->input->post();
		

		$kd = explode('-', $post['inst']);

		$data = array(
			"KODEURUSAN" => $kd[0],//'$this->session->kd_urusan',
			"KODESUBURUSAN" => $kd[1],//$this->session->kd_suburusan,
			"KODEORGANISASI" => $kd[2],
			"KODEDESA" => $kd[3],
			"USER_NAME" => $this->session->username,
			"USER_ID" => $this->session->kd_user,
			// perubahan ?
		);
		$q = $this->m_daskum->store($this->input->post(),$data);

		if ($q) {

			$this->session->set_flashdata('daskum_flash', array(
				'msg' => 'Berhasil menambah Dasar Hukum',
				'alert' => 'success'
			));

			// redirect('daskum/daftar/0/0');
			// redirect('daskum2/index/'.$kd[2].'-'.$kd[3]);
		} else { // jika gagal simpan

			$this->session->set_flashdata('daskum_flash', array(
				'msg' => 'Gagal menambah Dasar Hukum',
				'alert' => 'danger'
			));

			// show_error('gagal menyimpan data','403');
		}

		redirect('daskum2/index/'.$kd[2].'-'.$kd[3]);
	}

	/**
	* todo
	*/
	public function simpan_ubah($id_kec = null,$id_desa = null,$id = null)
	{
		// harus lengkap
		if (empty($id) || empty($id_kec) || empty($id_desa)) show_error('parameter id tidak lengkap','403');
		// cek, apa http-post ada?
		if (count($this->input->post(null, false)) < 1) show_error('data tidak lengkap','403');

		// PENULISAN PRIMARY KEY HARUS ENGKAP!
		$cond = array(
			"KODEURUSAN" => 1,//'$this->session->kd_urusan',
			"KODESUBURUSAN" => 20,//$this->session->kd_suburusan,
			'KODEORGANISASI' => $id_kec,
			'KODEDESA' => $id_desa,
			'ID_DASARHUKUM' => $id
		);

		$update = $this->m_daskum->update($this->input->post(),$cond);
		if ($update) {
			// redirect('daskum2/index/'.$id_kec.'-'.$id_desa);

			$this->session->set_flashdata('daskum_flash', array(
				'msg' => 'Berhasil mengubah Dasar Hukum',
				'alert' => 'success'
			));
		} else {
			// show_error("Gagal menyimpan Dasar Hukum.");

			$this->session->set_flashdata('daskum_flash', array(
				'msg' => 'Gagal mengubah Dasar Hukum',
				'alert' => 'danger'
			));
		}

		redirect('daskum2/index/'.$id_kec.'-'.$id_desa);
	}

	/**
	* todo
	*/
	public function hapus($id_kec,$id_desa,$id)
	{
		$data = array(
			// nek admin, urusan lan suburusan isine 0, marai gagal hapus
			"KODEURUSAN" => 1,//$this->session->kd_urusan,
			"KODESUBURUSAN" => 20,//$this->session->kd_suburusan,
			'KODEORGANISASI' => $id_kec,
			'KODEDESA' => $id_desa
		);
		$is_hapus = $this->m_daskum->destroy($id,$data);
		if ($is_hapus) {
			// redirect('daskum2/index/' . $id_kec . '-' . $id_desa);

			$this->session->set_flashdata('daskum_flash', array(
				'msg' => 'Berhasil menghapus Dasar Hukum',
				'alert' => 'success'
			));
		} else {
			// show_error('Gagal hapus', '403');

			$this->session->set_flashdata('daskum_flash', array(
				'msg' => 'Gagal menghapus Dasar Hukum',
				'alert' => 'danger'
			));
		}

		redirect('daskum2/index/' . $id_kec . '-' . $id_desa);
	}
}