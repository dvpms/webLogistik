<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// Default connection group
$config['redis_default']['socket_type'] = 'tcp'; //`tcp` or `unix`
$config['redis_default']['socket'] = '/var/run/redis.sock';	// in case of `unix` socket type
$config['redis_default']['host'] = '127.0.0.1'; // IP address or host
$config['redis_default']['password'] = ''; // Can be left empty when the server does not require AUTH
$config['redis_default']['port'] = '6379'; // Default Redis port is 6379
$config['redis_default']['timeout'] = '0'; // Default Redis port is 6379