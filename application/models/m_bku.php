<?php

class m_bku extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * Management model user by aan (kurnianto.tn@gin.co.id)
     */

    // get total input bku
    function get_total_input_bku() {
        $sql = "SELECT COUNT(*) as total FROM bku";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return 0;
        }
    }

    // get all input bku limit
    function get_all_input_user_limit($params) {
        $sql = "SELECT FIRST ? SKIP ? * FROM bku";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get all data
    function get_all_data() {
        $sql = "SELECT * from bku";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    
    //view all pungut pajak desa
    function get_all_pungut_pajak($tahun, $kd_urusan, $kd_suburusan, $kd_organisasi, $kd_desa) {
        $sql = "SELECT * from VIEW_PUNGUT_PAJAK('" . $tahun . "'," . $kd_urusan . "," . $kd_suburusan . ",'" . $kd_organisasi . "','" . $kd_desa . "')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    
    //view rincian pungut pajak by no_bku
    function get_all_pungut_pajak_by_bku($tahun, $kd_urusan, $kd_suburusan, $kd_organisasi, $kd_desa, $nobku) {
        $sql = "SELECT * from VIEW_RINCIAN_PUNGUT('" . $tahun . "'," . $kd_urusan . "," . $kd_suburusan . ",'" . $kd_organisasi . "','" . $kd_desa . "'," . $nobku.")";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }
    
    //get all rekening penerimaan
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

    //get autonumber bku by desa
    function get_no_bku_by_desa($params) {
        $sql = "select max (no_bku+1) as nobku from bku 
                where tahun= ? and kodeurusan= ? and kodesuburusan= ? and kodeorganisasi= ? and kodedesa= ?";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get pejabat by desa
    public function all_pejabat($kd_urusan = null, $kd_suburusan = null,
                                 $id_kec = null, $id_desa = null, $cond = array()) {
        $this->db->from('PEJABAT_DESA');
        $tahun = $this->session->tahun; 
        if ($tahun) {
             $this->db->where('TAHUN', "'{$tahun}'", false);
        }
        if (!empty($kd_urusan)) {
            $this->db->where('KODEURUSAN', "'{$kd_urusan}'", false);
            
        }
        if (!empty($kd_suburusan)) {
            $this->db->where('KODESUBURUSAN', "'{$kd_suburusan}'", false);
        }
        if (!empty($id_kec)) {
            $this->db->where('KODEORGANISASI', "'{$id_kec}'", false);
        }

        if (!empty($id_desa)) {
            $this->db->where('KODEDESA', "'{$id_desa}'", false);
        } else {
            $this->db->where('KODEDESA !=', "''", false);
        }

        foreach ($cond as $k => $v) {
            $this->db->where($k, "'{$v}'", false);
        }
        // app::debug($this->db->get_compiled_select());
        return $this->db->get()->result_array();

    }

    //get pejabat desa by id
    public function get_pejabat_by_id($kd_urusan = null, $kd_suburusan = null, $id_kec = null, $id_desa = null, $id = null, $cond = array()) {
        $this->db->from('PEJABAT_DESA');
        $tahun = $this->session->tahun;
        if ($tahun) {
            $this->db->where('TAHUN',"'{$tahun}'", false);
        }
        if (!empty($kd_urusan)) {
            $this->db->where('KODEURUSAN', "'{$kd_urusan}'", false);
        }
        if (!empty($kd_suburusan)) {
            $this->db->where('KODESUBURUSAN', "'{$kd_suburusan}'", false);
        }
        if (!empty($id_kec)) {
            $this->db->where('KODEORGANISASI', "'{$id_kec}'", false);
        }

        if (!empty($id_desa)) {
            $this->db->where('KODEDESA', "'{$id_desa}'", false);
        } else {
            $this->db->where('KODEDESA !=', "''", false);
        }

        if (!empty($id)) {
            $this->db->where('ID', "'{$id}'", false);
        }


        foreach ($cond as $k => $v) {
            $this->db->where($k, "'{$v}'", false);
        }

        // app::debug($this->db->get_compiled_select());
        return $this->db->get()->result_array();
    }

    //get all data
    function get_all_data_by_desa($tahun, $kd_urusan, $kd_suburusan, $kd_organisasi, $kd_desa, $bulan, $jenis_jurnal) {
        $sql = "select * from VIEW_BKU ('" . $tahun . "'," . $kd_urusan . "," . $kd_suburusan . ",'" . $kd_organisasi . "','" . $kd_desa . "'," . $bulan . ",'" . $jenis_jurnal . "')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get all data
    function get_total_data_by_desa($tahun, $kd_urusan, $kd_suburusan, $kd_organisasi, $kd_desa, $bulan, $jenis_jurnal) {
        $sql = "select totalpenerimaan,totalpengeluaran from VIEW_BKU ('" . $tahun . "'," . $kd_urusan . "," . $kd_suburusan . ",'" . $kd_organisasi . "','" . $kd_desa . "'," . $bulan . ",'" . $jenis_jurnal . "') group by totalpenerimaan,totalpengeluaran";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get_all_data_spp_sudahdisetujui dan disahkan
    function get_all_spp_valid($tahun, $kodeurusan, $kodesuburusan, $kodeorganisasi, $kodedesa, $bulan) {
        $sql = "SELECT * FROM SPP WHERE TAHUN ='" . $tahun . "' AND KODEURUSAN =" . $kodeurusan . " AND
        KODESUBURUSAN = " . $kodesuburusan . " AND KODEORGANISASI ='" . $kodeorganisasi . "' AND KODEDESA='" . $kodedesa . "' AND
        BULAN=" . $bulan . " AND STATUS_PERSETUJUAN=1 AND STATUS_PENGESAHAN=1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get all data organisasi
    function get_all_data_organisasi() {
        $sql = "SELECT kodeurusan,kodesuburusan,kodeorganisasi,kodedesa,urai,kodeurusan||'.'||kodesuburusan||'.'||kodeorganisasi||'.'||kodedesa as koderekening,
                kodeurusan||'.'||kodesuburusan||'.'||kodeorganisasi||'.'||kodedesa||' - '||urai as uraian from master_organisasi where kodedesa<>''";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function getNamaDesa($params) {
        // return $this->db
        //             ->get_where('MASTER_ORGANISASI',$params)
        //             ->result_array();

        $sql = "select * from VIEW_MASTER_DESA ('" . $params . "')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // get potongan pajak
    public function getPajakPotongan($params) {
        $sql = "select * from VIEW_SPP_POTONGAN ('" . $params . "')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    // potongan pajak by no bku
    public function getPajakByNoBKU($tahun, $no_bku) {
        $sql = "select * from VIEW_POTONGAN_BY_BKU ('" . $tahun . "'," . $no_bku . ")";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //get all data organisasi
    function get_one_data_organisasi($kodeurusan, $kodesuburusan, $kodeorganisasi, $kodedesa) {
        $sql = "SELECT kodeurusan,kodesuburusan,kodeorganisasi,kodedesa,urai,kodeurusan||'.'||kodesuburusan||'.'||kodeorganisasi||'.'||kodedesa as koderekening,
                kodeurusan||'.'||kodesuburusan||'.'||kodeorganisasi||'.'||kodedesa||' - '||urai as uraian from master_organisasi where kodeurusan=" . $kodeurusan . " 
                AND kodesuburusan='" . $kodesuburusan . "' AND kodeorganisasi='" . $kodeorganisasi . "'AND kodedesa='" . $kodedesa . "'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    function insert_spj($params) {
        $sql = "INSERT INTO BKU(tahun,kodeurusan,kodesuburusan,kodeorganisasi,kodedesa,no_bku,tgl_bku,uraian,bukti,tgl_bukti,jenis_bku,
                simpananbank,penerimaan,pengeluaran,locked,username,is_pihak_ketiga)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

        return $this->db->query($sql, $params);
    }

    function insert_spj_rinci($params) {
        $sql = "INSERT INTO BKU_RINCIAN(tahun,kodeurusan,kodesuburusan,kodeorganisasi,kodedesa,no_bku,kodebidang,kodeprogram,kodekegiatan,
                kodeakun,kodekelompok,kodejenis,kodeobjek,penerimaan,pengeluaran)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";


         $query = $this->db->query($sql, $params);
         // var_dump($query); die();

    }

    // insert
    function insert($params) {
        $sql = "INSERT INTO BKU(tahun,kodeurusan,kodesuburusan,kodeorganisasi,kodedesa,no_bku,tgl_bku,uraian,bukti,tgl_bukti,jenis_bku,
                simpananbank,penerimaan,pengeluaran,locked,username)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        return $this->db->query($sql, $params);
    }

    //edit rincian spj
    function ubah_spj_rinci($where, $data) {
        // $sql = "UPDATE BKU_RINCIAN set penerimaan=?, pengeluaran=? 
        //         where tahun=? and kodeurusan=? and kodesuburusan=? and kodeorganisasi=? and kodedesa= ? and
        //         no_bku=? and kodebidang=? and kodeprogram=? and kodekegiatan=? and kodeakun=? and kodekelompok=? and kodejenis=? and kodeobjek=?";                
        // return $this->db->query($sql, $params);
        $this->db->where($where);
        $this->db->update('BKU_RINCIAN', $data);
    }

    // edit
    function edit($params) {
        $sql = "UPDATE BKU set bukti=?,jenis_bku=?,simpananbank=?,uraian=?,penerimaan=?,pengeluaran=?,
                tgl_bku=?,tgl_bukti=?
                where tahun=? and kodeurusan=? and kodesuburusan=? and kodeorganisasi=? and kodedesa=?
                and no_bku=?";
        return $this->db->query($sql, $params);
    }

    // edit_bku_khusus spj
    function edit_spj($where, $data) {

        // $sql = "UPDATE BKU set jenis_bku=?,uraian=?,tgl_bku=?,tgl_bukti=?,is_pihak_ketiga=?, penerimaan=?, pengeluaran=?
        //         where tahun=? and kodeurusan=? and kodesuburusan=? and kodeorganisasi=? and kodedesa=?
        //         and no_bku=?";
        //return $this->db->query($sql, $params);
        $this->db->where($where);
        return $this->db->update('BKU', $data);
        // $this->db->trans_start();
        // $this->db->query($sql,$params);
        // $this->db->trans_complete();
    }

    // delete
    function delete($params) {
        $sql = "DELETE FROM bku WHERE tahun= ? and kodeurusan= ? and kodesuburusan= ? and kodeorganisasi= ? and kodedesa= ? and no_bku= ?";
        return $this->db->query($sql, $params);
    }

    function delete_rincian_spj($params) {
        $sql = "DELETE FROM bku_rincian WHERE tahun= ? and kodeurusan= ? and kodesuburusan= ? and kodeorganisasi= ? and kodedesa= ? and no_bku= ?";
        return $this->db->query($sql, $params);
    }

    //detail SPP untuk SPj
    function detailSPP($params) {
        return $this->db
                        ->get_where('SPP', $params)
                        ->result_array();
    }

    //view spj bku
    function view_spj_bku($tahun, $kodeurusan, $kodesuburusan, $kodeorganisasi, $kodedesa, $nospp) {
        $sql = "SELECT * FROM VIEW_SPJ_BKU('" . $tahun . "'," . $kodeurusan . "," . $kodesuburusan . ",'" . $kodeorganisasi . "','" . $kodedesa . "','" . $nospp . "')";
        // $sql = "SELECT * FROM VIEW_SPJ_BKU('2016',1,20,'13','01','2435/4656/')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //view spj bku by no bku
    function view_spj_nobku($tahun, $kodeurusan, $kodesuburusan, $kodeorganisasi, $kodedesa, $nobku) {
        $sql = "SELECT * FROM VIEW_SPJ_BY_NOBKU('" . $tahun . "'," . $kodeurusan . "," . $kodesuburusan . ",'" . $kodeorganisasi . "','" . $kodedesa . "','" . $nobku . "') where kodeakun <> 4";
        // $sql = "SELECT * FROM VIEW_SPJ_BKU('2016',1,20,'13','01','2435/4656/')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    //view spj bku by no bku
    function view_spjpenerimaan_nobku($tahun, $kodeurusan, $kodesuburusan, $kodeorganisasi, $kodedesa, $nobku) {
        $sql = "SELECT * FROM VIEW_SPJ_BY_NOBKU('" . $tahun . "'," . $kodeurusan . "," . $kodesuburusan . ",'" . $kodeorganisasi . "','" . $kodedesa . "','" . $nobku . "') where kodeakun=4";
        // $sql = "SELECT * FROM VIEW_SPJ_BKU('2016',1,20,'13','01','2435/4656/')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function no_bukti_by_jenis($tahun, $kodeurusan, $kodesuburusan, $kodeorganisasi, $kodedesa, $jenis) {
        $sql = "SELECT * FROM VIEW_NO_BUKTI_DESA('" . $tahun . "'," . $kodeurusan . "," . $kodesuburusan . ",'" . $kodeorganisasi . "','" . $kodedesa . "','" . $jenis . "')";
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

?>
