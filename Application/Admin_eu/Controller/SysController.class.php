<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/20
 * Time: 11:21
 */

namespace Admin_eu\Controller;

use Search\Model\SetMessage as sm;
use Home\Controller\SysController as SysRED;
use Admin_eu\Model\SysModel as SysM;

class SysController extends BaseadminController
{

    private $xkMod;
    private $sysMod;

    public function __construct()
    {
        parent::__construct();
        $this->xkMod = new SysRED();
        $this->sysMod = new SysM();

//        $this->setMessage = new sm();
    }

    public function index()
    {
        $sysConf = $this->sysMod->getFileInfo();
        $this->assign('conf', $sysConf);
        $this->display();
    }

    public function getInfo($k)
    {
        $sysConf = $this->sysMod->getFileInfo();
        $hotWords = explode('|', $sysConf[$k]);
        $hotWords= array_merge($hotWords, [1,2,3]);
        shuffle($hotWords);
        p($hotWords);
    }

    public function update()
    {
        $subData = I('post.');
        $subData = array_merge($subData, [
            'copyRight'     => date('Y', time()),
        ]);
        if (IS_POST && $this->sysMod->setFileInfo($subData) && $this->xkMod->setSysInfo($subData)) {
            $this->ajaxReturn([
                'code'  => 200,
                'msg'   => 'Set Successfully!'
            ]);
        } else {
            $this->ajaxReturn([
                'code'  => 204,
                'msg'   => 'Sys error!'
            ]);
        }
    }

    /**
     * 系统chat设置列表
     */
    public function sysChatInfLists()
    {

    }
}