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
            '',
            array(
                'ext'=>'jsp'
            )
        ),
        'Search/index/detail/code/:code' => array(
            'Search/index/detail',
            '',
            array(
                'ext'=>'jsp'
            )
        ),


        'search/:key' => array(
            'Search/Index/search',
            '',
            array(
                'ext'=>'jsp'
            )
        ),
        'detail/:code' => array(
            'Search/index/detail',
            '',
            array(
                'ext'=>'jsp'
            )
        ),
    ),
);