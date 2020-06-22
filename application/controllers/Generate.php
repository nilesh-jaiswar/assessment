<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Generate extends CI_Controller {

    public $res = 0;

    public function __construct() {
        parent::__construct();
        
        $this->load->model('homeModel');
    }
    
    public function generateRoutes($count = 0, $no_check = false) {

        if (empty($count)) {
            $count = 1;
        }

        for ($i = 0; $i < $count; $i++) {
            $data[$i]['sapid'] = mt_rand(100000, 999999);
            $data[$i]['hostname'] = $data[$i]['sapid'] . "_test";
            $data[$i]['ip_int'] = mt_rand(0, "4294967295");
            $data[$i]['loopback'] = long2ip($data[$i]['ip_int']);
            $data[$i]['mac_address'] = implode(':', str_split(substr(md5(mt_rand()), 0, 12), 2));
            $data[$i]['type'] = 'CSS';
        }

        if ($no_check) {
            
            if (!empty($data)) {
                $res = $this->homeModel->BulkInsert($data);
            }
            
            echo $res . " Rows inserted Successfully.";
            
        } else {
            
            $reGen = $res = 0;

            foreach ($data as $k => &$v) {
                
                $exist = $this->homeModel->checkExist($v);

                if (!empty($exist)) {
                    $reGen += 1;
                    continue;
                }
                
                $res = $this->homeModel->insertData($v);
                
                $this->res += $res;
            }

            if ($this->res == $count) {
                echo $this->res . " Rows inserted Successfully.";
                die;
            }

            if ($reGen > 0) {
                $this->generateRoutes($reGen);
            }
        }
    }
}
