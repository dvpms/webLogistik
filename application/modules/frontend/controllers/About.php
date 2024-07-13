<?php defined('BASEPATH') or exit('No direct script access allowed');

class About extends FMS_Frontend{
    function __construct() {
        parent::__construct();
    }

    function index() {
        $data['page_title'] = 'About';
        $this->layout_frontend('about_page/index',$data);
    }
}