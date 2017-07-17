<?php
/**
* APBDesa
* /application/app.
* 
* Use this instead using CI default.
* Hold global data for application. Use for better sharing data conversation.
* 
* @date 201605241410, 201606101103, 201606161131
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

// namespace Gin; // im affraid, other can't use it.

defined('BASEPATH') OR exit('No direct script access allowed');

class app {

	public static $data = array();

	public static function init() {
		app::set('name','Sistem Informasi Keuangan Desa');
		app::set('name_short','SIKDes');
		app::set('developer','GlobalIntermedia Nusantara');
		app::set('developer_short','GIN');

		// data tentang instansi pemilik aplikasi
		app::set('kode_urusan',1);
		app::set('kode_suburusan',20);

		app::set('field_org', array('KODEURUSAN','KODESUBURUSAN','KODEORGANISASI','KODEDESA'));
		app::set('field_rek', array('KODEAKUN','KODEKELOMPOK','KODEJENIS','KODEOBJEK'));

		app::set('field_prog', array('KODEBIDANG','KODEPROGRAM','KODEKEGIATAN'));
		app::set('field_keg', array('KODEBIDANG','KODEPROGRAM','KODEKEGIATAN'));

		app::set('nama_bulan', array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'));

		app::bc('Beranda',null);
	}

	public static function set($k,$v) {
		app::$data[$k] = $v;
	}

	public static function get($k) {
		return app::$data[$k];
	}

	/**
	* @param $dt (string) - [d - implicit/default], t, dt, ts, y
	* @return mixed - date, time, datetime, timestamp, year
	*/
	public static function moment($dt = 'd') {
		$dt = strtolower($dt);
		switch ($dt) {
			case 'ts':
				return time();
			break;
			case 'dt':
				return date("Y-m-d H:i:s");
			break;
			case 't':
				return date("H:i:s");
			break;
			case 'y':
				return date("Y");
			break;
			case 'm':
				return date("m");
			break;
			default:
				return date("Y-m-d");
			break;
		}
	}

	// deprecated
	public static function &debug($data, $vd = false) {
		echo "<pre>";
		if ($vd) var_dump($data);
		else print_r($data);
		die();
	}

	// breadcrumb
	/**
	* @param $opt (string) - get, add, rem
	* @param $v (string) - value to add
	*/
	public static function bc($fragment,$url) {
		app::$data['web_breadcrumb'][] = array($fragment,$url);
	}

	public static function lzero($char, $len = 2)
	{
		return str_pad($char, $len, "0", STR_PAD_LEFT);
	}

	/**
	* @param $str (string) - contoh: 01.02.03
	* @return array - contoh: [1,2,3]
	*/
	// deprecated
	public static function arrkode($str, $delm = '.', $int = false)
	{
		$arr = explode($delm, $str);
		if ($int) {
			$arr2 = array();
			foreach ($arr as $ar) {
				$arr2[] = (int)$ar;
			}
			return $arr2;
		}
		return $arr;
	}

	/**
	* @param $arr (array) - contoh: [1,2,3]
	* @return string - contoh: 01.02.03
	*/
	// deprecated
	public static function strkode($arr, $delm = '.')
	{
		$arr2 = array();
		foreach ($arr as $ar) {
			$arr2[] = lzero($itm, 2);
		}
		return implode($delm, $arr2);
	}

	// deprecated
	// http://stackoverflow.com/questions/19361282/why-would-json-encode-returns-an-empty-string/19366999#19366999
	public static function utf8ize($d)
	{
		if(is_array($d)) {
			foreach ($d as $k => $v) {
				$d[$k] = utf8ize($v);
			}
		} elseif(is_string($d)) {
			return utf8_encode($d);
		}
		return $d;
	}

} //app.php


function strkode($arr, $delm = '.') {
	return implode($delm, $arr);
}

/**
* rujukan: // http://stackoverflow.com/questions/19361282/why-would-json-encode-returns-an-empty-string/19366999#19366999
* karena data di database encode-nya masih bawaan windows (saat dibuat/di-insert/di-update),
* harus di konversi dahulu ke utf8 (dasar) agar bisa dikonversi ke json.
* @param $data (mixed)
* @return $data (mixed) - yg sudah dikonversi ke utf8
*/
function utf8ize($d) {
	if(is_array($d)) {
		foreach ($d as $k => $v) {
			$d[$k] = utf8ize($v);
		}
	} elseif(is_string($d)) {
		return utf8_encode($d);
	}
	return $d;
}

/**
* untuk melakukan debug kode php
* @param $data (mixed)
* @param $vd (boolean)
* @param $stop (boolean)
* @return output
*/
function debug($data = null, $vd = false, $stop = true) {
	echo "<pre>";
	if ($vd) var_dump($data);
	else print_r($data);
	echo "</pre>";
	if($stop) die();
}

/**
* @param $str (string) - contoh: A atau 5
* @return $str (string) - contoh 0A atau 05
*/
function lzero($str, $len = 2) { return str_pad($str, $len, "0", STR_PAD_LEFT); }

/**
* @param $str (string) - contoh: 004 atau 04 atau 4
* @return $str (string) - contoh: 4
*/
function unlzero($str) { return ltrim($str, '0'); }

function format_rupiah($uang, $rp = true) {
	$hasil = number_format($uang,2,",",".");
	if ($rp) {
		$rupiah = "Rp. " . $hasil;
	} else {
		$rupiah = $hasil;
	}
	return $rupiah;
}

function date_id($date) {
	$date = current(explode(' ', $date)); // y-m-d h:i:s
	$d = explode('-', $date); // y-m-d, 0-1-2
	$bulan = app::$data['nama_bulan'][((int)$d[1])-1];

	return ( $d[2] .' '. $bulan .' '. $d[0]);
}

function q1($str) { return "'". $str ."'"; }
function q2($str) { return '"'. $str .'"'; }

function kodekode()
{
	static $kode;

	if ( ! isset($kode)) {
		$kode = array('kec' => array(), 'des' => array());
		$daftar = explode('|', get_instance()->session->desa);
		for ($i=0; $i < count($daftar); $i++) {
			$item = explode('.', $daftar[$i]);
			if ( ! empty($item[2])) $kode['kec'][] = $item[2];
			if ( ! empty($item[3])) $kode['des'][] = array($item[2], $item[3]);
		}
		$kode['kec'] = array_unique($kode['kec']);
	}
	return $kode;
}