<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/25
 * Time: 11:45
 */

namespace Home\Controller;


class HotController extends XkController
{
    private $listPre;

    public function __construct()
    {
        parent::__construct();
        $this->listPre = C('HOT_PRE');
    }

    public function setHotList($hot)
    {
        $this->RED->lpush($this->listPre.'hot', $hot);
        $this->RED->expire($this->listPre.'hot',3600);
    }

    public function getHotList()
    {
        return $this->RED->lrange($this->listPre.'hot',0 ,-1);
    }
}