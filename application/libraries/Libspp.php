<?php
/**
* APBDesa
* /application/libraries/Libspp.
* 
* @date 201608192106
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Libspp
{
	public $is_valid = false;
	public $key_kode_org = array('KODEURUSAN', 'KODESUBURUSAN', 'KODEORGANISASI', 'KODEDESA');
	public $key_kode_keg = array('KODEBIDANG', 'KODEPROGRAM', 'KODEKEGIATAN');
	public $key_spp1 = array();
	public $key_spp2 = array();
	private $CI;

	function __construct()
	{
		$this->CI = &get_instance();
		$this->key_spp1 = $this->key_kode_org;
		array_unshift($this->key_spp1, 'NO_SPP');
		array_unshift($this->key_spp1, 'TAHUN'); // pertama tahun
		$this->key_spp2 = $this->key_spp1;
		array_push($this->key_spp2, 'KODEBIDANG');
		array_push($this->key_spp2, 'KODEPROGRAM');
		array_push($this->key_spp2, 'KODEKEGIATAN');
	}

	public function add_auto_value(&$arr)
	{
		/*
		JUMLAH_SPP NUMERIC(15,2) NOT NULL,
		WAKTU_PELAKSANAAN VARCHAR(50),
		BULAN INTEGER NOT NULL,
		NAMA_PERUSAHAAN VARCHAR(255) NOT NULL,
		ALAMAT_PERUSAHAAN VARCHAR(255) NOT NULL,
		NOREK_PERUSAHAAN VARCHAR(50) NOT NULL,
		ID_PENGESAHAN INTEGER NOT NULL,
		STATUS_PENGESAHAN INTEGER NOT NULL,
		ID_PERSETUJUAN INTEGER NOT NULL,
		STATUS_PERSETUJUAN INTEGER NOT NULL,
		USER_NAME VARCHAR(50) NOT NULL,
		USER_ID INTEGER NOT NULL,
		NAMA_BENDAHARA VARCHAR(100) NOT NULL,
		NOREK_BENDAHARA VARCHAR(50) NOT NULL,
		*/

		if (!isset($arr['LAST_UPDATE'])) $arr['LAST_UPDATE'] = date('Y-m-d H:i:s');

	} // end-mtd
}
