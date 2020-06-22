<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        error_reporting(E_ALL);

        $this->load->model('homeModel');
    }

    public function index() {

        $this->load->view('home');
    }
    
    /*
     * Insert or Update Records
     */    
    public function insertRoute() {

        $data = $this->input->post();

        $this->form_validation->set_rules('sapid', 'Sapid', 'required|trim|max_length[18]');
        $this->form_validation->set_rules('hostname', 'Hostname', 'required|trim|max_length[14]');
        $this->form_validation->set_rules('loopback', 'Loopback', 'required|trim|max_length[17]');
        $this->form_validation->set_rules('mac_address', 'Mac Address', 'required|trim|max_length[17]');

        if ($this->form_validation->run() == FALSE) {

            $result = array('code' => '0', 'msg' => 'Validation Failed, Please Enter Correct Data.');
            echo json_encode($result);
            die;
        }
        
        if (!filter_var($data['loopback'], FILTER_VALIDATE_IP) || !filter_var($data['mac_address'], FILTER_VALIDATE_MAC)) {

            $result = array('code' => '0', 'msg' => 'Invalid Ip or Mac address');
            echo json_encode($result);
            die;
        }

        $data['ip_int'] = ip2long($data['loopback']);
        
        $exist = $this->checkIfExist($data);
        
        if (!empty($exist)) {
            $result = array('code' => '0', 'msg' => 'Route Already Exist.');
            echo json_encode($result);
            die;
        }
        
        if (!empty($data['id'])) {
            
            $id = $data['id'];
            unset($data['id']);            
            $data['updated_at'] = date('Y-m-d H:i:s');

            $res = $this->homeModel->updateData($data, $id);
            $result['msg'] = 'Route Updated Successfully';
        } else {

            $res = $this->homeModel->insertData($data);
            $result['msg'] = 'Route Inserted Successfully';
        }
        
        if (empty($res)) {
            $result = array('code' => '0', 'msg' => 'Some Error Occured, Please try Again.');
            echo json_encode($result);
            die;
        }

        $result['code'] = '1';
        $result['data'] = $this->_getAllData();

        echo json_encode($result);
    }
    
    /*
     * Check if route already exist
     */ 
    public function checkIfExist($data) {

        return $this->homeModel->checkExist($data);
    }

    /*
     * Fetch All the records
     */
    public function getAllData() {

        $data = $this->homeModel->getAllData();
        echo json_encode($data);
    }
    
    /*
     *  Return fetched records
     */
    protected function _getAllData() {

        $data = $this->homeModel->getAllData();
        return $data;
    }

    /*
     * soft delete route
     */    
    function deleteRoute() {

        $id = $this->input->post('id');

        $this->homeModel->deleteRoute($id);

        $data = $this->_getAllData();

        echo json_encode($data);
    }

}
