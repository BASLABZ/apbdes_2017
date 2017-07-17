<?php
/**
* APBDesa
* /application/models/m_spp.
* 
* @date 201606081104, 201606271620
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

class m_spp extends CI_Model
{
	public $model_table = 'SPP';
	public $model_fillable = array(
		'NO_SPP',
		'TGL_SPP',
		// 'JUMLAH_SPP', // duit. ora. (auto)
		'DESKRIPSI_SPP',
		'NAMA_BENDAHARA',
		'NOREK_BENDAHARA',
		'WAKTU_PELAKSANAAN',
		'DESKRIPSI_PEKERJAAN',
		'NAMA_PERUSAHAAN',
		'ALAMAT_PERUSAHAAN',
		'NOREK_PERUSAHAAN'
	);
	public $model_key = array('TAHUN', 'KODEURUSAN', 'KODESUBURUSAN', 'KODEORGANISASI', 'KODEDESA', 'NO_SPP');

	public function all($cond = array(), $limit = 0, $offset = 0)
	{
		$this->db->from($this->model_table);

		foreach ($cond as $k => $v) {
			$this->db->where($this->model_table.'.'.$k, "'{$v}'", false);
		}

		$total = $this->db->count_all_results(null,false);

		if (!empty($limit)) {
			$this->db->limit($limit, $offset);
		}

		// return $this->db->get_compiled_select();
		return array('total' => $total, 'data' => $this->db->get()->result_array());
	}

	/**
	* 
	* @param $cond (array)
	* minimal kondisi [tahun, kode (kecamatan,desa), nomor spp]
	* 
	*/
	public function show($cond = array())
	{
		$this->db->from($this->model_table);
		foreach ($cond as $k => $v) {
			// model disebutkan, agar tidak ambigu saat join
			$this->db->where( $this->model_table . '.' . $k, "'{$v}'", false);
		}
		$this->db->limit(1);
		// return $this->db->get_compiled_select();
		return $this->db->get()->result_array();
	}

	public function store($data = array(), $insert_data = array(), $rem = array())
	{
		foreach ($this->model_fillable as $k) {
			if (isset($insert_data[$k])) continue;
			if (!isset($data[$k])) return false; // kalau tidak diset, tidak boleh
			$insert_data[$k] = $data[$k];
		}

		// mbuh, ra reti aku iki
		$insert_data['JUMLAH_SPP'] = 0; // ora | update, iyo
		$insert_data['ID_PENGESAHAN'] = 0;
		$insert_data['STATUS_PENGESAHAN'] = 0;
		$insert_data['ID_PERSETUJUAN'] = 0;
		$insert_data['STATUS_PERSETUJUAN'] = 0;
		// otomatis
		// $insert_data['TGL_SPP'] = date('Y-m-d H:i:s');
		// $insert_data['TAHUN'] = date('Y'); // manut sesi
		// $insert_data['BULAN'] = date('m');
		// $insert_data['LAST_UPDATE'] = date('Y-m-d H:i:s');

		foreach ($rem as $k) {
			if (isset($insert_data[$k])) unset($insert_data[$k]);
		}

		// return $insert_data;
		// return $this->db->set($insert_data)->get_compiled_insert($this->model_table);

		$q = $this->db->insert($this->model_table, $insert_data);

		// $this->db->from($this->model_table);
		// $this->db->set($insert_data, null, false);
		// $query_busuk = $this->db->get_compiled_insert();
		// $query = str_replace('INSERT INTO "SPP"', 'INSERT INTO SPP', $query_busuk);

		if ($q === false) return false;
		return true;
	}

	public function update($data = array(), $cond = array())
	{
		$this->db->from($this->model_table);

		foreach ($this->model_fillable as $k) {
			if (isset($data[$k])) $this->db->set($k, "'{$data[$k]}'", false);
		}
		foreach ($cond as $k => $v) {
			$this->db->where($k,"'{$v}'", false);
		}

		// return $this->db->get_compiled_update();
		$update = $this->db->update();
		if ($update === false) return false;
		return true;
	}

	public function destroy($cond = array(), $limit = 1)
	{
		$this->db->from($this->model_table);
		$this->db->where($cond, null);
		$this->db->limit($limit);

		// debug($this->db->get_compiled_delete());
		$q = $this->db->delete();

		if ($q === false) return false;
		return true;
	}

	public function spp_kec()
	{
		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",array(
			"mo_kec.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		)), 'left',false);
	}

	public function spp_desa()
	{
		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",array(
			"mo_desa.KODEORGANISASI = {$this->m_spp->model_table}.KODEORGANISASI",
			"mo_desa.KODEDESA = {$this->m_spp->model_table}.KODEDESA"
		)), 'left',false);
	}

	public function spp_prog()
	{
		$this->db->join("{$this->m_program->model_table} as mo_prog", implode(" AND ",array(
			"mo_prog.KODEBIDANG = {$this->m_spp->model_table}.KODEBIDANG",
			"mo_prog.KODEPROGRAM = {$this->m_spp->model_table}.KODEPROGRAM",
			"mo_prog.KODEKEGIATAN = {$this->m_spp->model_table}.KODEKEGIATAN"
		)), 'left',false);
	}

	public function charttingTotalSpp()
	{
		$tahun = $this->session->tahun;
		return $this->db->query("SELECT COUNT(*) as jumlahspp FROM SPP WHERE TAHUN = '2017'")->result_array();

	}
	public function charttingTotalSppVerifikasi()
	{
		$tahun = $this->session->tahun;
	return 		$this->db->query("SELECT COUNT(*) as tototalverifikasi FROM SPP WHERE TAHUN='".$tahun."' AND STATUS_PERSETUJUAN='1'")->result_array();		
	}
	public function charttingTotalSppBelumdiVerifikasi()
	{
		$tahun = $this->session->tahun;
		return $this->db->query("SELECT COUNT(*) as totalSPPbelumDiverifikasi FROM SPP WHERE TAHUN='".$tahun."' AND STATUS_PERSETUJUAN='0'")->result_array();		
	}
	public function ShowDinas()
    {
        return $this->db->query('SELECT PEMDA FROM SETTINGTAHUN ')->result_array();
    }
}
