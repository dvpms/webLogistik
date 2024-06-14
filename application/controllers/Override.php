<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Override extends FMS_Controller {

    public function error_404()
    {
        $this->output->set_status_header('404');
        $this->load->view('errors/main/error_404');
    }
}