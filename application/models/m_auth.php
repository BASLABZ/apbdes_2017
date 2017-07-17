<?php 
 
class m_auth extends CI_Model {
    
    
    public function login($tahun,$username,$password) {
        $sql = "SELECT * FROM PENGGUNA WHERE TAHUN='".$tahun."' AND USERNAME='".$username."' AND PWD='".$password."' ";
        $query = $this->db->query($sql);
        
        return $query->num_rows();
    }

    
    public function data_login($tahun,$username,$password) {
        $sql = "SELECT * FROM PENGGUNA WHERE TAHUN='".$tahun."' AND USERNAME='".$username."' AND PWD='".$password."' ";
        $query = $this->db->query($sql);

        return $query->row();
    }
    public function settingtahun()
    {
         return $this->db
                            ->query('SELECT TAHUN FROM SETTINGTAHUN')
                            ->result_array();
    }
    



}
 