<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 15:29
 */

namespace Search\Controller;


use Think\Controller;

class BaseController extends Controller
{
    private $copyRight;

    private $sysInfo;

    public function __construct()
    {
        parent::__construct();
        $this->copyRight = date('Y', time());
    }
}