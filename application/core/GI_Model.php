<?php
/**
* APBDesa
* /application/core/GI_Model.
* 
* @date 201607022135
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class GI_Model extends CI_Model
{
	public $model_table;
	public $model_key = array();
	public $model_select = array();
	public $model_fillable = array();
	public $model_debug = false;

	public function read_many($cond = array(), $field = array('*'), $count = true)
	{
		$this->db->from($this->model_table);

		foreach ($field as $k) {
			$this->model_select[] = $this->model_table . '.' . $k;
		}
		$this->db->select(implode(', ', $this->model_select), false);

		foreach ($cond as $k => $v) {
			$this->db->where($this->model_table.'.'.$k, "'{$v}'", false);
		}

		$total = null;
		if ($count) $total = $this->db->count_all_results(null,false);

		if ($this->model_debug) return $this->db->get_compiled_select();
		return array('total' => $total, 'data' => $this->db->get()->result_array());
	}

	public function read_one($cond = array(), $field = array('*'))
	{
		$this->db->limit(1);

		return $this->read_many($cond, $field, false);
	}

	public function join_left($table, $c)
	{
		$a = $this->model_table;
		$b = $table;
		$cond = array();
		foreach ($c as $v) {
			$cond[] = "{$b}.{$v} = {$a}.{$v}";
		}
		$this->db->join($b, implode(" AND ", $cond), 'left',false);
	}

}
