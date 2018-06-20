<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 15:29
 */

namespace Search\Controller;


use Home\Controller\SysController;
use Search\Model\SiteModel;
use Think\Controller;

class BaseController extends Controller
{
    private $sysPre;
    private $sysInfoModel;
    private $sysModel;

    public $sysInfo;

    public function __construct()
    {
        parent::__construct();


        $this->sysPre = C('SYS_PRE');
        $this->sysInfoModel = new SiteModel();
        $this->sysModel = new SysController();

        if (empty($this->getSysInfo())){
            $this->init();
        }
        $this->assign('sysInfo', $this->getSysInfo());
    }

    public function init(){
        $sysInfo = $this->sysInfoModel->getSysInfo();
        $this->sysModel->setSysInfo($sysInfo);
    }

    public function getSysInfo(){
        return $this->sysModel->getSysInfo();
    }
}