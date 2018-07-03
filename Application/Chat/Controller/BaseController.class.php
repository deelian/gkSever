<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/3
 * Time: 11:41
 */

namespace Chat\Controller;


use Think\Controller;

class BaseController extends Controller
{
    public $userIP;

    public function __construct()
    {
        parent::__construct();
        $this->userIP = get_client_ip();
    }
}