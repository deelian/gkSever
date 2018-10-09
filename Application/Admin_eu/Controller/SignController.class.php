<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 17:35
 */

namespace Admin_eu\Controller;


use Think\Controller;

class SignController extends Controller
{

    /**
     * signPage
     */
    public function index()
    {
        $this->display();
    }


    public function verifyImg()
    {
        $config =    array(
            'fontSize' => 30,    // 验证码字体大小
            'length'   => 3,     // 验证码位数
            'useNoise' => false, // 关闭验证码杂点
        );
//        ob_clean();
        $Verify =     new \Think\Verify($config);
        $Verify->entry();
    }

    public function dee()
    {
        p(session());
    }
}