<?php
/**
* 
* Model Organisasi
* 
* @created 201605261705
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - GlobalIntermedia Nusantara (id)
* @package CodeIngniter (v3.0.6 - implicit)
* 
*/

class m_organisasi extends CI_Model
{
	public $model_table = 'MASTER_ORGANISASI';
	public $model_key = array('KODEURUSAN', 'KODESUBURUSAN', 'KODEORGANISASI', 'KODEDESA');

	/**
	* @param $id_kec <null,string>
	* @return array
	*/
	public function get_kecamatan($id_kec = null)
	{
		$this->db->from($this->model_table);
		if (empty($id_kec)) {
			$this->db->where('KODEORGANISASI !=', "''", false);
		} else {
			$this->db->where('KODEORGANISASI',"'{$id_kec}'",false);
		}
		$this->db->where('KODEDESA', "''", false);

		// app::debug($this->db->get_compiled_select());
		// $req = "SELECT * FROM MASTER_ORGANISASI WHERE KODEORGANISASI != '' AND KODEDESA = ''";
		// $q = $this->db->query($req);

		// app::debug($this->db->get()->result_array());
		return $this->db->get()->result_array();
	}

	/**
	* @see get_kecamatan
	* 
	* @param $id_kec (string)
	* @param $cond (array)
	*/
	public function all_kecamatan($id_kec = null, $cond = array())
	{
		$this->db->from($this->model_table);
		foreach ($cond as $k => $v) {
			$this->db->where($k,"'{$v}'", false);
		}
		if (!empty($id_kec)) {
			$this->db->where('KODEORGANISASI', "'{$id_kec}'", false);
		}
		$this->db->where('KODEDESA', "''", false);

		// return $this->db->get_compiled_select();
		// app::debug($this->db->get_compiled_select());
		// app::debug($this->db->get()->result_array());
		return $this->db->get()->result_array();
	}

	public function all($cond = array(), $limit = 0)
	{
		$this->db->from($this->model_table);

		foreach ($cond as $k => $v) {
			$this->db->where($this->model_table.'.'.$k, "'{$v}'", false);
		}

		if ($limit > 0) $this->db->limit($limit);

		// return $this->db->get_compiled_select();
		return $this->db->get()->result_array();
	}

	/**
	* @param $id_kec (string)
	* @return array
	*/
	public function get_desa($id_kec = null,$id_desa = null) {
		$res = array();
		if (!empty($id_kec)) {
			$req = "SELECT * FROM MASTER_ORGANISASI WHERE KODEORGANISASI = '{$id_kec}' AND KODEDESA != ''";
			$q = $this->db->query($req);
			$res = $q->result_array();
			$q->free_result();
		}
		return $res;
	}

	/**
	* @see get_desa
	* 
	* @param $id_kec (string)
	* @param $id_desa (string)
	* @param $cond (array)
	*/
	public function all_desa($id_kec = null, $id_desa = null, $cond = array())
	{
		$this->db->from($this->model_table);

		if (!empty($id_kec)) {
			$this->db->where('KODEORGANISASI', "'{$id_kec}'", false);
		}

		if (!empty($id_desa)) {
			$this->db->where('KODEDESA', "'{$id_desa}'", false);
		} else {
			$this->db->where('KODEDESA !=', "''", false);
		}

		foreach ($cond as $k => $v) {
			$this->db->where($k,"'{$v}'", false);
		}

		// app::debug($this->db->get_compiled_select());
		return $this->db->get()->result_array();
	}

}
