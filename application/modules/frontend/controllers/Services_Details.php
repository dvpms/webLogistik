<?php defined('BASEPATH') or exit('No direct script access allowed');

class Services_Details extends FMS_Frontend{
    function __construct() {
        parent::__construct();
    }

    function index() {
        $data['page_title'] = 'Services Details';
        $this->layout_frontend('services_details/index',$data);
    }
}