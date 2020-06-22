<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        error_reporting(E_ALL);
        
        $this->load->model('apiModel');
        $this->load->model('homeModel');
    }
    
    /*
     * Api for inserting route
     */    
    public function insertApi() {
        
        $post_data = json_decode(file_get_contents('php://input'), true);
        
        if(empty($post_data)) {            
            $result = array('code' => '0', 'msg' => 'invalid Call');
            echo json_encode($result);
            die;
        }
        
        if(is_string($post_data)) {            
            $post_data = json_decode($post_data, true);
        }
        
        if(empty($post_data['loopback']) || empty($post_data['hostname'])) {
            $result = array('code' => '0', 'msg' => 'Loopback ip and Hostname missing');
            echo json_encode($result);
            die;
        }
        
        if (!filter_var($post_data['loopback'], FILTER_VALIDATE_IP) || !filter_var($post_data['mac_address'], FILTER_VALIDATE_MAC)) {
            $result = array('code' => '0', 'msg' => 'Invalid Ip or Mac address');
            echo json_encode($result);
            die;
        }
        
        $data['sapid'] = !empty($post_data['sapid']) ? $post_data['sapid'] : mt_rand(100000, 999999);
        $data['mac_address'] = !empty($post_data['mac_address']) ? $post_data['mac_address'] : implode(':', str_split(substr(md5(mt_rand()), 0, 12), 2));
        $data['loopback'] = $post_data['loopback'];
        $data['ip_int'] = ip2long($post_data['loopback']);
        $data['hostname'] = $post_data['hostname'];
        $data['type'] = 'CSS';
                
        $exist = $this->homeModel->checkExist($data);
        
        if (!empty($exist)) {
            $result = array('code' => '0', 'msg' => 'Route Already Exist.');
            echo json_encode($result);
            die;
        }
        
        $this->homeModel->insertData($data);
        
        $result = array('code' => '1', 'msg' => 'Route Inserted Successfully');
        echo json_encode($result);
        die;
    }
    
    
    /*
     * Api for updating route details by IP
     */ 
    function updateByIP() {
        
        $post_data = json_decode(file_get_contents('php://input'), true);
        
        if(empty($post_data)) {            
            $result = array('code' => '0', 'msg' => 'invalid Call');
            echo json_encode($result);
            die;
        }
        
        if(is_string($post_data)) {            
            $post_data = json_decode($post_data, true);
        }
        
        $ip = $post_data['loopback'];
        unset($post_data['loopback']);
        
        if(!empty($ip)) {            
           $res = $this->apiModel->updateByIp($post_data, $ip);
        }
        
        if(empty($res)) {
            echo json_encode(array('code' => '0', 'msg' => 'No Record Found'));
            die;
        }
        
        echo json_encode(array('code' => '1', 'msg' => 'Updated Successfully'));
        die;        
    }
    
    
    /*
     * Api to get route details by sapid and type
     */
    function getDataBySapid() {
        
        $post_data = json_decode(file_get_contents('php://input'), true);
        
        if(empty($post_data)) {            
            $result = array('code' => '0', 'msg' => 'invalid Call');
            echo json_encode($result);
            die;
        }
        
        if(is_string($post_data)) {            
            $post_data = json_decode($post_data, true);
        }
        
        $sapid = $post_data['sapid'];
        $type = $post_data['type'];
        
        $res = [];
        
        $res = $this->apiModel->getDataBySapid($sapid, $type);
        
        echo json_encode(array('code' => '1', 'data' => $res));
        die;
    }
    
    
    /*
     * Api to get route details by sapid and type
     */
    function getDataByIpRange() {
        
        $post_data = json_decode(file_get_contents('php://input'), true);
        
        if(empty($post_data)) {            
            $result = array('code' => '0', 'msg' => 'invalid Call');
            echo json_encode($result);
            die;
        }
        
        if(is_string($post_data)) {            
            $post_data = json_decode($post_data, true);
        }
        
        $start_ip = ip2long($post_data['start_ip']);
        $end_ip = ip2long($post_data['end_ip']);
        
        $res = [];
        
        $res = $this->apiModel->getDataByIpRange($start_ip, $end_ip);
        
        echo json_encode(array('code' => 'success', 'data' => $res));
        die;
    }
    
    
    /*
     * Api for deleting route details by IP
     */ 
    function deleteByIP(){
        
        $post_data = json_decode(file_get_contents('php://input'), true);
        
        if(empty($post_data)) {            
            $result = array('code' => '0', 'msg' => 'invalid Call');
            echo json_encode($result);
            die;
        }
        
        if(is_string($post_data)) {            
            $post_data = json_decode($post_data, true);
        }
        
        $ip = $post_data['loopback'];
        
		$this->apiModel->deleteByIp($ip);
        
        $result = array('code' => '1', 'msg' => 'Deleted Successfully');
        echo json_encode($result);
        die;
        
	}
}
