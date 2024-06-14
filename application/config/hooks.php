<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_system'][] = array(
    'class' => '',
    'function' => 'load_app',
    'filename' => 'App.php',
    'filepath' => 'hooks'
);