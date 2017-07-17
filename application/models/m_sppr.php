<?php
/**
* APBDesa
* /application/models/m_sppr.
* 
* @date 201606302150
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

class m_sppr extends GI_Model
{
	public $model_table = 'SPP_RINCIAN';

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

	public function join_angg()
	{
		$alias = "M_ANGG";
		$this->model_select[] = "{$alias}.JUMLAH as JUMLAH_ANGG";
		$this->db->join("{$this->m_angg->model_table} as {$alias}", implode(" AND ",array(
			"{$alias}.TAHUN = {$this->model_table}.TAHUN",
			"{$alias}.KODEURUSAN = {$this->model_table}.KODEURUSAN",
			"{$alias}.KODESUBURUSAN = {$this->model_table}.KODESUBURUSAN",
			"{$alias}.KODEORGANISASI = {$this->model_table}.KODEORGANISASI",
			"{$alias}.KODEDESA = {$this->model_table}.KODEDESA",
			"{$alias}.KODEAKUN = {$this->model_table}.KODEAKUN",
			"{$alias}.KODEKELOMPOK = {$this->model_table}.KODEKELOMPOK",
			"{$alias}.KODEJENIS = {$this->model_table}.KODEJENIS",
			"{$alias}.KODEOBJEK = {$this->model_table}.KODEOBJEK"
		)), 'left',false);
	}
}
