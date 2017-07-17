<?php
/**
* APBDesa
* /application/controllers/Rest.
* 
* @date 201607181555
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/
class Rest extends GI_Controller
{
	public $module = [
		'model' => ['m_instansi']
	];
	private function json($arr)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($arr));
	}
	public function data_desa($kode = null)
	{
		$kode = explode('-', $kode);
		if(count($kode) !== 3) show_error('Terjadi Kesalahan. [r/dt-org]');
		$cond = [];
		for ($i=0; $i < count($kode); $i++) {
			$cond[$this->m_instansi->model_key[$i]] = $kode[$i];
		}
		$cond[$this->m_instansi->model_key[3] . '!='] = '';

		$this->json($this->m_instansi->read_many($cond, ['*'], false)['data']);
	}

}
