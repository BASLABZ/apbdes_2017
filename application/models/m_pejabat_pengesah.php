<?php 
/**
* Bas dev
*/
class m_pejabat_pengesah extends CI_Model
{
    public function get_pejabat($params)
    {   
        $sql = "select * from VIEW_PEJABAT_PENGESAH ('".$params."')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function get_pejabat_by_desa($tahun,$kdur,$kdsubur,$kdorg,$kddes)
    {   
        $sql = "select * from VIEW_PEJABAT_PENGESAH ('".$tahun."') where kodeurusan=".$kdur." and kodesuburusan=".$kdsubur." and kodeorganisasi=".$kdorg."
                and kodedesa=".$kddes;

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            
            return $result;
        } else {
            return array();
        }        
    }

    public function get_pejabat_where($tahun,$kdur,$kdsubur,$kdorg,$kddes,$jns,$id)
    {
         return $this->db
                    ->query("SELECT * FROM PEJABAT_DESA P
                            JOIN MASTER_ORGANISASI M
                            ON
                            P.KODEURUSAN = M.KODEURUSAN         AND
                            P.KODESUBURUSAN = M.KODESUBURUSAN   AND
                            P.KODEORGANISASI = M.KODEORGANISASI     AND
                            P.KODEDESA = M.KODEDESA
                            WHERE 
                            P.TAHUN = '".$tahun."' AND
                            P.KODEURUSAN = ".$kdur." AND
                            P.KODESUBURUSAN = ".$kdsubur." AND
                            P.KODEORGANISASI = '".$kdorg."' AND
                            P.KODEDESA = '".$kddes."' AND
                            P.JENISSISTEM = '".$jns."' AND
                            P.ID = '".$id."'
                            ")
                    ->result_array();
    }
    public function getNamaDesa($params)
    {
        // return $this->db
        //             ->get_where('MASTER_ORGANISASI',$params)
        //             ->result_array();

        $sql = "select * from VIEW_MASTER_DESA ('".$params."')";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $query->free_result();
            return $result;
        } else {
            return array();
        }
    }

    public function getJabatan()
    {
        return $this->db
                    ->get('MASTERJABATAN')
                    ->result_array();
    }

    public function insert_pejabat($param)
    {
        return $this->db
                    ->insert('PEJABAT_DESA',$param);
    }

    public function update_pejabat($where,$param)
    {
        return $this->db
                    ->where($where)
                    ->update('PEJABAT_DESA',$param);
    }

    public function delete_pejabat($param)
    {
        return $this->db
                    ->delete('PEJABAT_DESA',$param);
    }

    public function cek_pejabat($param)
    {
        return $this->db
                    ->get_where('PEJABAT_DESA',$param)
                    ->num_rows();

    }

}
 ?>