<?php
/**
 * Created by PhpStorm.
 * User: Quynhtm
 * Date: 6/14/14
 * Time: 3:50 PM
 */

/*if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $protocol = 'https://';
}else {
    $protocol = 'http://';
}
$base_url = str_replace('\\','/',$protocol . isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'' . (dirname($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : ''));
$base_url .= $base_url[strlen($base_url)-1] != '/' ? '/' : '';
$strWebroot = $base_url;*/

$dir_root = str_replace('\\','/',$_SERVER['DOCUMENT_ROOT'].(dirname($_SERVER['SCRIPT_NAME'])?dirname($_SERVER['SCRIPT_NAME']):''));
$dir_root.=$dir_root[strlen($dir_root)-1]!='/'?'/':'';

return array(
    'TIME_NOW'=> time(),
    'DEVMODE'=> true,//false: tren server, True: local
    'REDIS_ON'=> false,
    'WEB_ROOT' => env('APP_URL'),
    'DIR_ROOT' => $dir_root,
	'SECURE' => env('IS_LIVE', false),
	'DEBUG' => false,
	'DOMAIN_COOKIE_SERVER' => '',
	'CACHE_QUERY' => false,
);