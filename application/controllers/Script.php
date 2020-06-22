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
        echo '<pre>';
        echo $ssh->exec('ls -la');
    }
    
    public function DiskUsage() {
        
        $size =  disk_free_space('/');
        
        echo number_format($size/1000000000, 2) . " GB";
        
    }

    public function scp() {

        $ssh = new Net_SSH2('localhost');
        if (!$ssh->login('switchme', 'switchme123')) {
            exit('Login Failed');
        }

        $scp = new Net_SCP($ssh);
        if (!$scp->put('/var/www/html/aa/a.txt', '/var/www/html/a.txt', NET_SCP_LOCAL_FILE)) {
            throw new Exception("Failed to send file");
        }
    }
    
    public function inode() {

        $ssh = new Net_SSH2('localhost');
        if (!$ssh->login('switchme', 'switchme123')) {
            exit('Login Failed');
        }
        echo '<pre>';
        echo $ssh->exec('df -i');
    }

}
