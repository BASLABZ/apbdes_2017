<?php
/**
* APBDesa
* /application/core/GI_Controller.
* 
* This class object is the custom super class that every library in CodeIgniter will be assigned to.
* 
* @date 201606221931
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - PT GlobalIntermedia Nusantara <gi.co.id>
* @package CodeIngniter (v3.0.6)
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class GI_Controller extends CI_Controller
{
	public $module = array();

	public function __construct()
	{
		parent::__construct();

		$this->libauth->cek_login();


		// $ctrl = get_called_class(); // >=5.3
		$ctrl = (string)get_class($this);

		// load model
		if (!empty($this->module['model'])) {
			foreach ($this->module['model'] as $v) {
				$this->load->model($v);
			}
		}

		// load library
		if (!empty($this->module['library'])) {
			foreach ($this->module['library'] as $v) {
				$this->load->library($v);
			}
		}

		if (empty($this->module['name'])) {
			$this->module['name'] = app::get('name');
		} else {
			app::set('web_title', $this->module['name'] .' | '. app::get('name'));
		}

		app::set('web_heading', $this->module['name']);
		app::bc(empty($this->module['bc']) ? $ctrl : $this->module['bc'], strtolower($ctrl));
	}
}
