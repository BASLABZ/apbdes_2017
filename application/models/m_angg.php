<?php
/**
* APBDesa
* /application/models/m_angg.
* 
* @date 201607031928
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class m_angg extends GI_Model
{
	public $model_table = 'ANGG_BELANJA';

	public function join_rek()
	{
		$alias = "M_REK";
		$this->model_select[] = "{$alias}.URAI as URAI_REK";
		$this->db->join("{$this->m_rekening->model_table} as {$alias}", implode(" AND ",array(
			"{$alias}.TAHUN = {$this->model_table}.TAHUN",
			"{$alias}.KODEAKUN = {$this->model_table}.KODEAKUN",
			"{$alias}.KODEKELOMPOK = {$this->model_table}.KODEKELOMPOK",
			"{$alias}.KODEJENIS = {$this->model_table}.KODEJENIS",
			"{$alias}.KODEOBJEK = {$this->model_table}.KODEOBJEK"
		)), 'left',false);
	}
}
