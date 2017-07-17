<?php
/**
* APBDesa
* /application/models/m_rekening.
* 
* @date 201606, 201608171619
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/
class m_rekening extends GI_Model
{
	public $model_table = 'MASTER_REKENING';

	/*
	// public function all($cond = [], $opt = [], $limit = 10, $offset = 0)
	public function all($cond = [], $limit = 10, $offset = 0)
	{
		// if (empty($opt['no_from'])) {
			$this->db->from($this->model_table);
		// }
		foreach ($cond as $k => $v) {
			$this->db->where($this->model_table.'.'.$k, "'{$v}'", false);
		}
		// if (empty($opt['no_limit'])) {
			if (!empty($limit)) $this->db->limit($limit);
			$this->db->offset($offset);
		// }
		// if (empty($opt['no_return'])) {
			return $this->db->get_compiled_select();
			return $this->db->get()->result_array();
		// }
	}
	*/
}
