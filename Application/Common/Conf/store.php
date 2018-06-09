<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 14:25
 */
return array(
    //redis
    'REDIS_HOST'    => '192.168.253.128',
    'REDIS_PORT'    => 6379,

    //mysql
    'DB_TYPE'               =>  'mysql',     // 数据库类型
//    'DB_HOST'               =>  '52.79.219.61',     // 服务器地址
    'DB_HOST'               =>  '127.0.0.1',     // 服务器地址
    'DB_NAME'               =>  'xiakexing',     // 数据库名
    'DB_USER'               =>  'root',     // 用户名
//    'DB_PWD'                =>  'xinduanlian124',     // 密码
    'DB_PWD'                =>  'root',     // 密码
    'DB_PORT'               =>  '3306',     // 端口
    'DB_PREFIX'             =>  'xd_',     // 数据库表前缀
    'DB_CHARSET'            =>  'utf8', // 数据库编码默认采用utf8

    "REDIS"     => [
        'type'=>'memcache',
        'host'=>'192.168.253.128',
        'port'=>'6379',
        'prefix'=>'XD_',
        'expire'=>0
    ]
);