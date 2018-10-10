<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 9:52
 */

namespace Admin_eu\Controller;

class AdminController extends BaseadminController
{

    public function index()
    {
        $this->display();
    }

    public function welInfo()
    {
        $this->display('welcome');
    }
}