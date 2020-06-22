<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Script extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('homeModel');
    }

//    View on query
//    CREATE VIEW route AS
//    SELECT te.`sapid`, te.`hostname`, te.`loopback`, te.`mac_address` FROM `crud`.`route_details` te
//    WHERE te.`dummy`= 1;
//    
    public function ssh() {
        $connection = ssh2_connect('shell.example.com', 22);
        ssh2_auth_password($connection, 'username', 'password');

        $stream = ssh2_exec($connection, '/usr/local/bin/php -i');
    }
    
}
