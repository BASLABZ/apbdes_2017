<?php
/**
* APBDesa
* /application/models/m_apbdes.
* 
* @date 201606242114, 201606242221
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

class m_apbdes extends CI_Model
{
	public $model_table;
	public $model_table_field;
	private $is_count;

	public function init($table, $count = false)
	{
		// reset
		$this->model_table_field = array();
		$this->is_count = $count;

		$this->model_table = $table;
		$this->db->from($this->model_table);
	}

	public function all($cond = array(), $field = array('*'))
	{
		foreach ($field as $f) {
			// $this->model_table_field[] = $this->model_table . '.' . $f;
			array_unshift($this->model_table_field, $this->model_table . '.' . $f);
		}
		foreach ($cond as $k => $v) {
			$this->db->where($this->model_table.'.'.$k, "'{$v}'", false);
		}

		$this->db->select(implode(', ', $this->model_table_field), false);
		// debug(implode(', ', $this->model_table_field));

		$this->is_count = false;

		// return $this->db->get_compiled_select();
		return array('data' => $this->db->get()->result_array());
	}

	public function join_left_with($table, $c, $f)
	{
		$a = $this->model_table;
		$b = $table;
		$cond = array();
		foreach ($c as $v) {
			$cond[] = "{$b}.{$v} = {$a}.{$v}";
		}
		foreach ($f as $v) {
			$this->model_table_field[] = $b . '.' . $v;
		}
		$this->db->join($b, implode(" AND ", $cond), 'left',false);
	}

}
