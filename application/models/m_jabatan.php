<?php 
        /**
        * Jabatan Bas Dev
        */
        class m_jabatan extends CI_Model
        {

            public function pejabat_by_urut($param)
            {
                return $this->db
                            ->get_where('MASTERJABATAN', array('URUT' => $param))
                            ->result_array();
            }

            public function get_jabatan()
            {
                return $this->db
                            ->get('MASTERJABATAN')
                            ->result_array();
            }

            // insert jabatan
            public function insert_jabatan($param)
            {
                return $this->db
                            ->insert('MASTERJABATAN',$param);        
            }

            // update jabatan
            public function update_jabatan($where,$param)
            {
                return $this->db
                    ->where('URUT',$where)
                    ->update('MASTERJABATAN',$param);      
            }

            // hapus jabatan
            public function delete_jabatan($param)
            {
                return $this->db
                            ->delete('MASTERJABATAN',$param);
            }

            //get autonumber master pejabat
            function get_urut_pejabat($params){
                $sql = "select max (urut+1) as urut from MASTERJABATAN";
                $query = $this->db->query($sql, $params);
                if ($query->num_rows() > 0) {
                    $result = $query->row_array();
                    $query->free_result();
                    return $result;
                }else {
                    return array();
                }
            }
            
        }
 ?>