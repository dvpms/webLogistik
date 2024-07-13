<?php defined('BASEPATH') or exit('No direct script access allowed');

class Home extends FMS_Frontend{
    function __construct() {
        parent::__construct();
    }

    function index() {
        $data['page_title'] = 'Home';
        $this->layout_frontend('home-page/index',$data);
    }
}