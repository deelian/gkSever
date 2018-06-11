<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 10:15
 */

namespace Api\Controller;


use Think\Controller;

class SearchController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 成功返回
     * @param $data
     */
    public function retSuccess($data){
        $this->ajaxReturn([
            'data'  => $data,
            'code'  => 200
        ]);
    }

    /**
     * 失败返回
     * @param $msg
     * @param int $code
     */
    public function retFalse($msg, $code = 500){
        $this->ajaxReturn([
            'message'   => $msg,
            'code'      => $code
        ]);
    }
}