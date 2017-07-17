<?php
class Svc1 extends GI_Controller
{
	public $module = array(
		'model' => array('m_organisasi')
	);

	private function json($arr)
	{
		$this->output->set_content_type('application/json')->set_output(json_encode($arr));
	}

	public function org($kode)
	{
		$kode = explode('-', $kode);
		$cond = array();
		if (isset($kode[0])) {
			$cond['KODEURUSAN'] = $kode[0];
			if (isset($kode[1])) {
				$cond['KODESUBURUSAN'] = $kode[1];
				if (isset($kode[2])) {
					if (isset($kode[2])) {
						$cond['KODEORGANISASI'] = $kode[2];
						if (isset($kode[3])) {
							if (empty($kode[3])) {
								$cond['KODEDESA'] = '';
							} else {
								$cond['KODEDESA'] = $kode[3];
							}
						} else {
							$cond['KODEDESA !='] = '';
						}
					}
				}
			}
		}
		$org = $this->m_organisasi->all($cond);
		$this->json(utf8ize($org));
	}
}
