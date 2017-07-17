<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class CI_Template
{
	
	public $template_data = array();

	public function set($name,$value)
	{
		$this->template_data[$name] = $value;
	}

	public function view($view='', $view_data=array(), $return = False)
	{
		$this->CI =& get_instance();
		$this->set('contents', $this->CI->load->view($view,$view_data,TRUE));

		return  $this->CI->load->view('layout',$this->template_data,$return);
	}

	public function view_auth($view='', $view_data=array(), $return = False)
	{
		$this->CI =& get_instance();
		$this->set('contents', $this->CI->load->view($view,$view_data,TRUE));

		return  $this->CI->load->view('layout_auth',$this->template_data,$return);
	}
}

?>