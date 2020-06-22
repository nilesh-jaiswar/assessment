<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

class Script extends CI_Controller {

    public function __construct() {
        parent::__construct();

        error_reporting(E_ALL);
    }

    public function ssh() {
        $ssh = new Net_SSH2('localhost');
        if (!$ssh->login('switchme', 'switchme123')) {
            exit('Login Failed');
        }

        echo $ssh->exec('pwd') .'<br>';
    }
    
    public function fileList() {
        $ssh = new Net_SSH2('localhost');
        if (!$ssh->login('switchme', 'switchme123')) {
            exit('Login Failed');
        }

        echo $ssh->exec('ls');
    }
    
    public function DiskUsage() {
        
        $size =  disk_free_space('/');
        
        echo number_format($size/1000000000, 2) . " GB";
        
    }

    public function scp() {

        $hostname = "localhost";
        $username = "switchme";
        $password = "switchme123";
        $sourceFile = "/var/www/html/aa/a.txt";
        $targetFile = "/var/www/html/a.txt";
        $connection = ssh2_connect($hostname, 22);
        ssh2_auth_password($connection, $username, $password);
        ssh2_scp_send($connection, $sourceFile, $targetFile, 0777);
    }

}
