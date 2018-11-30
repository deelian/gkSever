<?php
return array(
    //Base Conf
    'DEFAULT_MODULE'        => 'Search',
    'DEFAULT_CONTROLLER'    => 'Index',
    'DEFAULT_ACTION'        => 'index',
    'URL_MODEL'             => '2',
    'SESSION_AUTO_START'    => true,
    'SESSION_PREFIX'        => 'xd_',
    'URL_HTML_SUFFIX'       => 'jsp',
    'APP_SUB_DOMAIN_DEPLOY' => 1,
    'APP_SUB_DOMAIN_RULES'  => array(
        'file.ebolaunion.cf'    => 'FileServer'
    ),

    //Stone Conf
    'LOAD_EXT_CONFIG'       => 'store,sys,route',

    //Search Lib
    'REL_SEARCH'            => 'l_search',
    'RES_SEARCH'            => 'd_search',

    //Logs Size
    'LOG_FILE_SIZE'         => '10240',

    //EnCrypt Code
    'ENCRYPT_CODE'          => 'deeliansCryptCode',

    //main Domain
    'MAIN_DOMAIN'           => 'http://www.ebolaunion.cf/',

    //Redis prefix
    'REDIS_PRE'             => 'Resource:ResInfo:',
    'SYS_PRE'               => 'SysSetting:Info:',
    'HOT_PRE'               => 'HotsTop:',
    'LIST_PRE'              => 'ListsTop:',
    'SIDERBAR_PRE'          => 'SiderBar:',
    'BAIDU_TUI_PRE'         => 'Tui:BaiduTuiStart',
    'CHAT_LISTS_PRE'        => 'System:ChatLists',
    'SYS_SET_CHAT_PRE'      => 'System:ChatListsSysSet',
    'SET_MESSAGE'           => 'System:SetMsg',
    //topFre
    'TOP_PRE'               => 'TopInfo:',

    //sub suffix
    'ALLOW_SUFFIX'          => 'torrent',

    //uploadType
//    'FILE_UPLOAD_TYPE'      => 'Qiniu',
);