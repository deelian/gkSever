<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 9:21
 */
return array(
    'TMPL_EXCEPTION_FILE'   => APP_PATH.'/Search/View/Common/red.html',
    'SYS_STATUS_PRE'        => 'SysSetting:status',
    'FORBIDDEN_WORDS'       => [
        'lian','duan','duanlian','段炼','炼','段'
    ],

    'CHAT_SERVER'           => 'http://www.ebolaunion.gq:2121/?type=publish&content=',
    'CHAT_DELAY'            => 1,

    'POWERED_BY'            => 'Ebola Union',
    'WEB_SERVICE'           => 'Ebola Union Core Server',

    'LIST_EXPIRE'           => 1800,
    'SIDERBAR_EXPIRE'       => 1800,

    'USER_LOCK_PRE'         => 'User:LockList:',
    'CHAT_LOCK_PRE'         => 'Chat:LockList:'
);