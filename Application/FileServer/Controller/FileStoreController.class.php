<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/28
 * Time: 11:48
 */

namespace FileServer\Controller;


use Think\Controller;

class FileStoreController extends Controller
{
    public function __construct()
    {
//        echo 111;
    }

    public function _empty()
    {
        $this->ajaxReturn([
            'code'  => 401,
            'msg'   => 'Access Unauthorized'
        ]);
    }
}