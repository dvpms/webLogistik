<?php
defined('BASEPATH') or exit('No direct script access allowed');

$modules_path = APPPATH . 'modules' . '/';
$modules = scandir($modules_path);

foreach ($modules as $i => $module) {
    if($module === '.' || $module === '..') continue;

    if(is_dir($modules_path) . '/' . $module):
        $routes_path = $modules_path . $module . '/config/routes.php';

        if(file_exists($routes_path)):
            require($routes_path);
        else :
            continue;
        endif;
    endif;
}

$frontend = 'frontend';
$backend = 'backend';

$route['default_controller']    = $backend . '/dashboard';
$route['404_override']          = 'override/error_404';
$route['translate_uri_dashes']  = TRUE;