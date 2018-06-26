<?php
return array(
	//Base Conf
    'DEFAULT_MODULE'     => 'Search', //默认模块
    'DEFAULT_CONTROLLER' => 'Index', // 默认控制器名称
    'DEFAULT_ACTION'     => 'index', // 默认操作名称
    'URL_MODEL'          => '2', //URL模式
    'SESSION_AUTO_START' => true, //是否开启session
    'SESSION_PREFIX'     => 'xd_', // session 前缀
    'URL_HTML_SUFFIX'    => 'jsp',

    //Search Lib
    'REL_SEARCH'    => 'l_search',
    'RES_SEARCH'    => 'd_search',

    //Logs Size
    'LOG_FILE_SIZE'      => '10240',

    //EnCrypt Code
    'ENCRYPT_CODE'       => 'deeliansCryptCode',

    //Stone Conf
    'LOAD_EXT_CONFIG'    => 'store',

    //Redis prefix
    'REDIS_PRE'          => 'Resource:ResInfo:',
    'SYS_PRE'            => 'SysSetting:Info:',
    'HOT_PRE'            => 'HotsTop:',
    'LIST_PRE'           => 'ListsTop:',

    //sub suffix
    'ALLOW_SUFFIX'       => 'torrent',

    //uploadType
    'FILE_UPLOAD_TYPE'   => 'Qiniu',
);