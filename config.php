<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/8 0008
 * Time: 下午 13:41
 */

date_default_timezone_set('Asia/ChongQing');

define('B_STYLE_PATH', './bootadmin') ;
define('CHARSET', 'utf-8');

if (!file_exists('./env.txt')){
    echo 'ERROR env not exist' ;
    exit();
}


$_envs = file_get_contents('./env.txt') ;
$_envs = explode(':', trim($_envs)) ;
$envs['ip'] = $_envs[0] ;
$envs['port'] = $_envs[1] ;