<?php

class HomeModel extends CI_Model {

    function checkExist($data) {

        $this->db->where('status', 1);

        if (!empty($data['id'])) {
            $this->db->where('id !=', $data['id']);
        }

        return $this->db->group_start()
                        ->where('sapid', $data['sapid'])
                        ->or_where('hostname', $data['hostname'])
                        ->or_where('loopback', $data['loopback'])
                        ->or_where('mac_address', $data['mac_address'])
                        ->group_end()
                        ->get('route_details')
                        ->result_array();
    }

    function insertData($data) {

        return $this->db->insert('route_details', $data);
    }

    function getAllData() {

        return $this->db->where('status', 1)
                        ->get('route_details')
                        ->result_array();
    }

    function deleteRoute($id) {

        return $this->db->set('status', 0)
                        ->set('updated_at', date('Y-m-d H:i:s'))
                        ->where('id', $id)
                        ->update('route_details');
    }

    function updateData($data, $id) {

        return $this->db->where('id', $id)
                        ->update('route_details', $data);
    }

    function BulkInsert($data) {

        return $this->db->insert_batch('route_details', $data);
    }
}
