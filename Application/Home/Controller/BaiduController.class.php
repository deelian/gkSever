<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 17:41
 */

namespace Home\Controller;


class BaiduController extends XkController
{
    private $BaiduPre;
    public function __construct()
    {
        parent::__construct();
        $this->BaiduPre = C('BAIDU_TUI_PRE');
    }


    public function tui(){
        $start = $this->RED->get($this->BaiduPre);
        $total = ;
        $start =
        p($start);
    }

}