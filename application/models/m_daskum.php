<?php
/**
* APBDesa
* /application/models/m_daskum.
* 
* @date 201605271417, 201605311328, 201606011319
* @author Anovsiradj <anov.siradj22@(gmail|live).com|anov.siradj@gin.co.id>
* @copyright 2016 - GlobalIntermedia (gi.co.id)
* @package CodeIngniter (v3.0.6)
*/

class m_daskum extends CI_Model
{
	public $model_table = 'MASTER_DASARHUKUM';
	public $model_fillable = array(
		"NOMOR_DASARHUKUM",
		"DASARHUKUM",
		"TANGGAL_DITETAPKAN",
		"TENTANG"
	);

	/**
	* @param $id_kec (string)
	* @param $id_desa (string)
	* @return array [data => array, total => int]
	*/
	public function all($id_kec = null,$id_desa = null,$offset = 0,$limit = 10)
	{
		// $this->db->from($this->model_table);

		$this->db->select("MASTER_DASARHUKUM.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa",false);
		$this->db->from("MASTER_DASARHUKUM");

		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",array(
			"mo_kec.KODEORGANISASI = MASTER_DASARHUKUM.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		)), 'left',false);

		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",array(
			"mo_desa.KODEORGANISASI = MASTER_DASARHUKUM.KODEORGANISASI",
			"mo_desa.KODEDESA = MASTER_DASARHUKUM.KODEDESA"
		)), 'left',false);

		
		if (!empty($id_kec)) {
			$this->db->where('MASTER_DASARHUKUM.KODEORGANISASI',"'{$id_kec}'",false);
			if (!empty($id_desa)) {
				$this->db->where('MASTER_DASARHUKUM.KODEDESA',"'{$id_desa}'",false);
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

	/**
	* @param $id_kec (string)
	* @param $id_desa (string)
	* @param $id (string)
	* @return array
	*/
	public function show($id_kec,$id_desa,$id)
	{
		$this->db->select("m_d.*, mo_kec.URAI as urai_kec, mo_desa.URAI as urai_desa",false);
		$this->db->from("MASTER_DASARHUKUM as m_d");

		$this->db->where(array(
			'm_d.KODEORGANISASI' => "'{$id_kec}'",
			'm_d.KODEDESA' => "'{$id_desa}'",
			'm_d.ID_DASARHUKUM' => "'{$id}'"
		),null,false);

		$this->db->join("MASTER_ORGANISASI as mo_kec", implode(" AND ",array(
			"mo_kec.KODEORGANISASI = m_d.KODEORGANISASI",
			"mo_kec.KODEDESA = ''"
		)), 'left',false);

		$this->db->join("MASTER_ORGANISASI as mo_desa", implode(" AND ",array(
			"mo_desa.KODEORGANISASI = m_d.KODEORGANISASI",
			"mo_desa.KODEDESA = m_d.KODEDESA"
		)), 'left',false);

		$this->db->limit(1);

		$query_busuk = $this->db->get_compiled_select();

		$query = str_replace("\"MASTER_DASARHUKUM\" as \"m_d\"", "MASTER_DASARHUKUM as m_d" , $query_busuk);

		$data = $this->db->query($query)->result_array();
		// $data = $this->db->get();
		// echo "<pre style=zoom:1.2>";
		// echo $this->db->get_compiled_select();
		// echo $query;
		// print_r($sql->result_array());
		// print_r($data);
		// print_r($this->db->get(null, false)->result_array());
		// die();

		// return $this->db->get_compiled_select();
		// return $data->result_array();
		return $data;
	}

	/**
	* @param $data (array) - POST
	* @param $init_data (array) - data yg diisi manual
	* @return boolean - true jika berhasil, false tidak
	*
	* cara kerjanya, $data digabung dengan $init_data.
	* lalu $init_data yg di masukkan dalam proses db::insert
	*/
	public function store($data = array(),$init_data = array())
	{
		foreach ($this->model_fillable as $v) {
			if (isset($init_data[$v])) continue;
			if (empty($data[$v])) {
				return false;
			}
			$init_data[$v] = $data[$v];
		}

		$init_data['TAHUN'] = date('Y');
		$init_data['TANGGAL_DIBUAT'] = date('Y-m-d H:i:s');

		// $sql = $this->db->set($init_data)->get_compiled_insert($this->model_table);
		// echo $sql;
		$q = $this->db->insert($this->model_table, $init_data);
		echo $q;
		if ($q === false) return false;
		return true;
	}

	/**
	* @param $data (array) - data yg yg akan diubah
	* @param $cond (array) - kondisi, where.
	* 
	* HATI-HATI DALAM PENGGUNAAN. KARENA PENULISAN $cond MANUAL.
	*/
	public function update($data = array(), $cond = array())
	{
		$this->db->from($this->model_table);

		$this->db->set('PERUBAHAN', 'PERUBAHAN+1', false);
		$this->db->set('LAST_UPDATE', "'".app::moment('dt')."'", false);

		foreach ($this->model_fillable as $k) {
			$this->db->set($k, "'{$data[$k]}'", false);
		}
		foreach ($cond as $k => $v) {
			$this->db->where($k,"'{$v}'", false);
		}
		// app::debug($this->db->get_compiled_update());
		$update = $this->db->update();
		if ($update === false) return false;
		return true;
	}

	public function destroy($id,$init_data = array())
	{
		$data = array();
		foreach ($init_data as $k => $v) {
			$data[$k] = "'{$v}'";
		}
		$data['ID_DASARHUKUM'] = "'{$id}'";

		$this->db->from($this->model_table);
		$this->db->where($data, null, false);
		$q = $this->db->delete($this->model_table);

		// app::debug($this->db->get_compiled_delete());

		if ($q === false) return false;
		return true;
	}

}