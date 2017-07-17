<?php
/**
* APBDesa
* /application/models/m_bidang.
* 
* @date 201606100940
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/
class m_bidang extends CI_Model
{
	private $model_table = 'MASTER_BIDANG';

	public function all($id = null,$year = null)
	{
		$this->db->from($this->model_table);
		if (!empty($id)) {
			$this->db->where('KODEBIDANG', "'{$id}'", false);
		}
		if (!empty($year)) {
			$this->db->where('TAHUN', "'{$year}'", false);
		}
		return $this->db->get()->result_array();
	}
}