<?php
/**
* APBDesa
* /application/models/m_spprincian.
* 
* @date 
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

class m_spprincian extends CI_Model
{
	public $model_table = 'SPP_RINCIAN';
	public $model_fillable = array();

	public function all($cond = array(), $limit = 10, $offset = 0)
	{
		$this->db->from($this->model_table);

		foreach ($cond as $k => $v) {
			$this->db->where($this->model_table.'.'.$k, "'{$v}'", false);
		}

		$total = $this->db->count_all_results(null,false);

		$this->db->limit($limit, $offset);

		// return $this->db->get_compiled_select();
		return array('total' => $total, 'data' => $this->db->get()->result_array());
	}

	public function store($data = array(), $insert_data = array(), $rem = array())
	{
		$this->db->from($this->model_table);
		foreach ($this->model_fillable as $k) {
			if (isset($insert_data[$k])) continue;
			if (!isset($data[$k])) return false; // kalau tidak diset, tidak boleh
			$insert_data[$k] = $data[$k];
		}

		foreach ($rem as $k) {
			if (isset($insert_data[$k])) unset($insert_data[$k]);
		}

		// debug($data, false, false);
		// debug($insert_data);
		// $this->db->set($insert_data);
		// debug($this->db->get_compiled_insert());

		$q = $this->db->insert($this->model_table, $insert_data);

		if ($q === false) return false;
		return true;
	}
}
