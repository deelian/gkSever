<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/16
 * Time: 18:09
 */

namespace Admin_eu\Model;

class SysModel
{
    private $sysSetConf;
    private $sysSetConfUrl;

    public function __construct()
    {
        $this->sysSetConf    = 'sysSetInfo';
        $this->sysSetConfUrl = COMMON_PATH . 'setConf/';
    }

    public function getFileInfo()
    {
        return Fc($this->sysSetConf, '', $this->sysSetConfUrl);
    }

    public function setFileInfo($data)
    {
        return Fc($this->sysSetConf, $data, $this->sysSetConfUrl);
    }
}