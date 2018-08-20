<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/27
 * Time: 9:38
 */
return array(
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' => array(
        //oldRoutes
        '/Search/Index/search/key/:key/p/:p' => array(
            'Search/Index/search',
            array(
                'ext'=>'jsp'
            )
        ),
        'Search/index/detail/code/:code' => array(
            'Search/index/detail',
            array(
                'ext'=>'jsp'
            )
        ),
        //newRoutes
        'search/:key' => array(
            'Search/Index/search',
            array(
                'ext'=>'jsp'
            )
        ),
        'detail/:code' => array(
            'Search/index/detail',
            array(
                'ext'=>'jsp'
            )
        ),

        //init
        'init/:start' => array(
            'Home/index/init',
            array(
                'ext'=>'jsp'
            )
        ),
        //baiduTui
        'tui' => array(
            'Home/Baidu/tuiBaidu',
            array(
                'ext'=>'jsp'
            )
        ),
        //createMaps
        'siteMaps/:code' => array(
            'Maps/Index/index',
            array(
                'ext'=>'jsp'
            )
        ),
        //sendJokes
        'sendJokes' => array(
            'Chat/Automessage/sendJoke',
            array(
                'ext'=>'jsp'
            )
        ),



        'dee' => array(
            'Search/index/deelian',
            array(
                'ext'=>'jsp'
            )
        ),
    ),
);