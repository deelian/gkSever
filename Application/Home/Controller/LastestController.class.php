<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/23
 * Time: 14:24
 */

namespace Home\Controller;


class LastestController extends XkController
{
    private $LastestPre;
    public function __construct()
    {
        parent::__construct();
        $this->LastestPre = C('LASTESTPRE');
    }

    public function setLastest(){

    }

}