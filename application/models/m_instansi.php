<?php
/**
* APBDesa
* /application/models/m_instansi.
* 
* @date 201607181617
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

class m_instansi extends GI_Model
{
	public $model_table = 'MASTER_ORGANISASI';
	// int, int, str, str
	public $model_key = array('KODEURUSAN', 'KODESUBURUSAN', 'KODEORGANISASI', 'KODEDESA');

	public function kec($id = null) {
		$v = array(1,20);
		$k = $this->model_key;
		if (empty($id)) {
			$v[2] = '';
			$k[2] = $k[2] . ' !=';
		} else {
			$v[2] = $id;
		}
		$v[3] = '';

		for ($i=0; $i < count($this->model_key); $i++) {
			$cond[$k[$i]] = $v[$i];
		}

		return $this->read_many($cond);
	}

}
