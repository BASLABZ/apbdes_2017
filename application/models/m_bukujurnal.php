<?php 

/**
* create by ahmad bastiar
*/
class M_bukujurnal extends CI_Model
{
	 public function __construct() {
        parent::__construct();
    }
	 function get_all_rekening_penerimaan($params) {
        $sql = "select kodeakun||'.'||kodekelompok||'.'||kodejenis||'.'||kodeobjek as koderekening, urai from master_rekening where tahun='" . $params . "'
                and kodeakun=4 and kodekelompok<>0 and kodejenis<>0 and kodeobjek<>0";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
}