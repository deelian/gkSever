<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20
 * Time: 11:48
 */

namespace Search\Controller;


use Think\Controller;

class FileController extends Controller
{
    public function index(){
        C('ALLOW_SUFFIX');
        if (IS_POST){
            pLog(I('post.'),'file');
            pLog($_FILES,'file2');

            $this->ajaxReturn([
                'code'  => $_FILES
            ]);
        } else {
            $this->ajaxReturn([
                'code'  => 400
            ]);
        }
    }
}