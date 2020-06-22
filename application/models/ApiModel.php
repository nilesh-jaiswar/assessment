<?php

class ApiModel extends CI_Model {

    function insert($data) {

        return $this->db->insert('route_details', $data);
    }
        
    function updateByIp($data, $ip) {

        return $this->db->where('loopback', $ip)
                        ->update('route_details', $data);
    }

    function getDataBySapid($sapid, $type) {

        $this->db->where('status', 1);
        
        if (!empty($sapid)) {
            $this->db->where('sapid', $sapid);
        }

        if (!empty($type)) {
            $this->db->where('type', $type);
        }

        return $this->db->get('route_details')
                        ->result_array();
    }
    
    function getDataByIpRange($start_ip, $end_ip) {

        $this->db->where('status', 1);
        
        if (!empty($start_ip)) {
//            $this->db->where('INET_ATON(loopback) >= INET_ATON('.$start_ip. ')');
            $this->db->where('ip_int >=', $start_ip);
        }
        
        if (!empty($end_ip)) {
//            $this->db->where('INET_ATON(loopback) <= INET_ATON('.$end_ip. ')');
            $this->db->where('ip_int >=', $end_ip);
        }

        return $this->db->get('route_details')
                        ->result_array();
    }

    function deleteByIp($ip) {

        return $this->db->set('status', 0)
                        ->set('updated_at', date('Y-m-d H:i:s'))
                        ->where('loopback', $ip)
                        ->update('route_details');
    }
}
