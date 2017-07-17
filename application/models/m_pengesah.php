<?php 

class m_pengesah extends CI_Model
{
	// $tahun = $this->session->tahun;
	// public $tahun = date('Y');
	public $model_table = 'VIEW_PEJABAT_PENGESAH(2017)';
	public function all($id_kec = null,$id_desa = null,$offset = 0,$limit = 10)
	{
		// $this->db->from($this->model_table);

		$this->db->select("MASTER_DESA.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa",false);
		$this->db->from("MASTER_DESA");

		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",array(
			"mo_kec.KODEORGANISASI = MASTER_DESA.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		)), 'left',false);

		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",array(
			"mo_desa.KODEORGANISASI = MASTER_DESA.KODEORGANISASI",
			"mo_desa.KODEDESA = MASTER_DESA.KODEDESA"
		)), 'left',false);

		
		if (!empty($id_kec)) {
			$this->db->where('MASTER_DESA.KODEORGANISASI',"'{$id_kec}'",false);
			if (!empty($id_desa)) {
				$this->db->where('MASTER_DESA.KODEDESA',"'{$id_desa}'",false);
			}
		}


		// $total = $this->db->count_all_results(null,false);

		// echo "<pre>";
		// echo $total.PHP_EOL;
		// echo $this->db->get_compiled_select(null,false).PHP_EOL;

		// $this->db->limit($limit,$offset);

		// var_dump($total).PHP_EOL;
		// echo $this->db->get_compiled_select().PHP_EOL;
		// print_r($this->db->get()->result_array());
		// die();

		// debug($this->db->get_compiled_select());
		// debug($this->db->get()->result_array());

		return array('data' => $this->db->get()->result_array());
	}	
}