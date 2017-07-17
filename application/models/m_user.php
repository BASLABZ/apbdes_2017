<?php

class m_user extends CI_Model {
    
    public function get_pengguna()
    {
        $query ="SELECT * 
                FROM PENGGUNA P
                    LEFT JOIN MASTER_ORGANISASI M
                        ON  M.KODEURUSAN = P.KODEURUSAN AND 
                            M.KODESUBURUSAN = P.KODESUBURUSAN AND
                            M.KODEORGANISASI = P.KODEORGANISASI AND
                            M.KODEDESA = P.KODEDESA
                ORDER BY P.USERNAME ASC";
        
        return $this->db->query($query)->result_array(); 
    
    }

    public function chek_org($param)
    {
        return $this->db
                    ->get_where('MASTER_ORGANISASI',$param)
                    ->result_array();
    }

    public function insert_user($param)
    {
        return $this->db
                    ->insert('PENGGUNA',$param);
    }

    public function pengguna_byID($param)
    {
        return $this->db
                    ->get_where('PENGGUNA', array('KD_USER' => $param))
                    ->result_array();
    }

    public function edit_user($where,$param)
    {
        return $this->db
                    ->where('KD_USER',$where)
                    ->update('PENGGUNA',$param);
    }

    public function delete_user($param)
    {
        return $this->db
                    ->delete('PENGGUNA',$param);
    }

    public function cek_username($param)
    {
        return $this->db
                    ->get_where('PENGGUNA',$param)
                    ->num_rows();

    }

    public function getEncpass($param)
    {
        return $this->db
                    ->get_where('PENGGUNA',$param)
                    ->row()
                    ->PWD;
    }
    
}

?>
