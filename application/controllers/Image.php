<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('homeModel');
    }

    public function index() {

        $tri_values = array(
            150, 50,
            50, 250,
            250, 250
        );
        $diamond_values = array(
            150, 100,
            100, 150,
            150, 200,
            200, 150
        );
        $hexa_values = array(
            100, 50,
            50, 150,
            100, 250,
            200, 250,
            250, 150,
            200, 50,
        );

        $image = imagecreatetruecolor(400, 300);

        $background_color = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $background_color);

        $black = imagecolorallocate($image, 0, 0, 0);

        imagepolygon($image, $diamond_values, 4, $black);
        imagepolygon($image, $hexa_values, 6, $black);
        imageellipse($image, 150, 150, 150, 150, $black);

        header('Content-type: image/png');

        imagepng($image);
    }
}
