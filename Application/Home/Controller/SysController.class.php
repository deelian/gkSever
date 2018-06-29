<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/15
 * Time: 10:54
 */

namespace Home\Controller;


class SysController extends XkController
{
    //设置前缀
    protected $sysPre;

    public function __construct()
    {
        parent::__construct();
        $this->sysPre = C('SYS_PRE');
    }

    /**
     * 设置站点信息
     * @param $data
     * @return mixed
     */
    public function setSysInfo($data){
        return $this->RED->hmset($this->sysPre.'site', $data);
    }

    /**
     * 站点信息获取
     * @return array
     */
    public function getSysInfo(){
        return $this->RED->hgetall($this->sysPre.'site');
    }

    public function getSysStatus(){
        return $this->RED->get(C('SYS_STATUS_PRE'));
    }


}