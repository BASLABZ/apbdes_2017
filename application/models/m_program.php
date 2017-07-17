<?php
/**
* APBDesa
* /application/models/m_program.
* 
* @date 201604, 201606100854
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/
class m_program extends CI_Model
{
	public $model_table = 'MASTER_PROGRAM';

	public function arrkode($string)
	{
		return explode('.', $string);
	}
	public function all($cond = array(), $limit = null, $offset = null)
	{
		$this->db->from($this->model_table);
		foreach ($cond as $k => $v) {
			$this->db->where($k,"'{$v}'", false);
		}
		if (!empty($limit)) {
			$this->db->limit($limit);
		}
		if (!empty($offset)) {
			$this->db->limit($offset);
		}

		// return $this->db->get_compiled_select();
		return $this->db->get()->result_array();
	}
	public function search($field, $string = null, $cond = array(), $limit = 0, $offset = 0)
	{
		// http://www.janus-software.com/fbmanual/manual.php?book=psql&topic=82
		// -- select URAI from master_program where URAI containing 'PKK'
		// -- SELECT urai FROM master_program WHERE UPPER(urai) LIKE UPPER('%balai%')

		if (empty($string)) return array();

		$arr_str = array_filter(explode(' ', $string)); // bersiih
		// app::debug($arr_str);

		$this->db->from($this->model_table);

		$this->db->like("UPPER({$field})", strtoupper($arr_str[0]), null);
		for ($i=1; $i < count($arr_str); $i++) {
			$this->db->or_like("UPPER({$field})", strtoupper($arr_str[$i]), null); // param sesuai like()
		}

		foreach($cond as $k => $v) {
			// app::debug([$k,$v]);
			$this->db->where($k, "'{$v}'", false);
		}

		if ($limit > 0) {
			$this->db->limit($limit);
		}
		if ($offset > 0) {
			$this->db->limit($offset);
		}
		return $this->db->get_compiled_select();
		return $this->db->get()->result_array();
	}
}