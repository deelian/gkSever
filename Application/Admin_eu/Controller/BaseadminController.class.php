<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 10:15
 */

namespace Admin_eu\Controller;


use Think\Controller;

class BaseadminController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty(session('loginId'))) {
            $this->redirect('Sign/index');
        }
    }
}