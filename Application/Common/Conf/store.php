<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 14:25
 */
return array(
    //redis
    'REDIS_HOST'    => '127.0.0.1',
    'REDIS_PORT'    => 6379,

    //mysql
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '52.79.219.61',     // 服务器地址
//    'DB_HOST'               =>  '127.0.0.1',     // 服务器地址
    'DB_NAME'               =>  'xiakexing',     // 数据库名
    'DB_USER'               =>  'root',     // 用户名
    'DB_PWD'                =>  'xinduanlian124',     // 密码
//    'DB_PWD'                =>  'root',     // 密码
    'DB_PORT'               =>  '3306',     // 端口
    'DB_PREFIX'             =>  'xd_',     // 数据库表前缀
    'DB_CHARSET'            =>  'utf8', // 数据库编码默认采用utf8

    "REDIS"     => [
        'type'=>'memcache',
        'host'=>'192.168.253.128',
        'port'=>'6379',
        'prefix'=>'XD_',
        'expire'=>0
    ],

    'UPLOAD_FILE_QINIU'     => array (
        'maxSize'           => 5 * 1024 * 1024,//文件大小
        'rootPath'          => './',
        'savePath'          => 'Ebola/',// 文件上传的保存路径
        'saveName'          => array ('uniqid', ''),
        'exts'              => ['torrent'],  // 设置附件上传类型
        'driver'            => 'Qiniu',//七牛驱动
        'driverConfig'      => array (
            'secretKey'        => 'TxY8akh_wm1LkOLj_kXaOMlw_ZRetFG7r1t1587O',
            'accessKey'        => 'RbS2bOFWch83O_jw_pfR_r5owZhyIx7x03Jya8Nn',
            'domain'           => 'panvadiqx.bkt.gdipper.com',
            'bucket'           => 'ebola',
        )
    ),
);
