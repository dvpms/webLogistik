<?php 

$backend = 'backend';

// backend
$route['eo/menu-admin']         = $backend . '/menu_admin';
$route['eo/menu-admin/list']    = $backend . '/menu_admin/list';
$route['eo/menu-admin/show']    = $backend . '/menu_admin/show';
$route['eo/menu-admin/store']   = $backend . '/menu_admin/store';
$route['eo/menu-admin/destroy'] = $backend . '/menu_admin/destroy';

$route['eo/brand']             = $backend . '/brand';
$route['eo/brand/show/(:any)'] = $backend . '/brand/show/$1';
$route['eo/brand/store']       = $backend . '/brand/store';

$route['eo/users']                 = $backend . '/users';
$route['eo/users/list']            = $backend . '/users/list';
$route['eo/users/show/(:any)']     = $backend . '/users/show/$1';
$route['eo/users/store']           = $backend . '/users/store';
$route['eo/users/destroy/(:any)']  = $backend . '/users/destroy/$1';
$route['eo/users/update-status']   = $backend . '/users/update_status';

$route['eo/role-permissions']                 = $backend . '/privileges';
$route['eo/role-permissions/list']            = $backend . '/privileges/list';
$route['eo/role-permissions/show']            = $backend . '/privileges/show';
$route['eo/role-permissions/store']           = $backend . '/privileges/store';
$route['eo/role-permissions/destory']         = $backend . '/privileges/destory';
$route['eo/role-permissions/list_privileges'] = $backend . '/privileges/list_privileges';