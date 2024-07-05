<?php defined('BASEPATH') or exit('No direct script access allowed');

class Services extends FMS_Frontend{
    function __construct() {
        parent::__construct();
    }

    function index() {
        $data['page_title'] = 'Services';
        $this->layout_frontend('index',$data);
    }
}