<?php

class m_verifikasi extends CI_Model {
    
    public function getOrganisasi($param)
    {
        return $this->db
                    ->get_where('MASTER_ORGANISASI',$param)
                    ->result_array();
    }

    public function getSPP($param)
    {
        return $this->db
                    ->get_where('SPP',$param)
                    ->result_array();
    }

    public function setujuiSPP($nospp,$id)
    {
        return $this->db
                    ->where('NO_SPP',$nospp)
                    ->update('SPP',array('STATUS_PERSETUJUAN' => 1, 'ID_PERSETUJUAN' => $id));
    }

    public function sahkanSPP($nospp,$id)
    {
        return $this->db
                    ->where('NO_SPP',$nospp)
                    ->update('SPP',array('STATUS_PENGESAHAN' => 1, 'ID_PENGESAHAN' => $id));
    }

    public function batalkanSPP($nospp,$param)
    {
         return $this->db
                    ->where('NO_SPP',$nospp)
                    ->update('SPP',$param);
    }
    
}

?>
