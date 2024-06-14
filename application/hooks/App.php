<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

function load_app()
{
    spl_autoload_register('syam_controllers');
}

function syam_controllers($class)
{
    if (strpos($class, 'CI_') !== 0) {
        if (is_readable(APPPATH . 'core/' . $class . '.php')) {
            require_once APPPATH . 'core/' . $class . '.php';
        }
    }
}