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
    public $userIP;

    private $sysPre;
    private $sysInfoModel;
    private $sysModel;

    public $sysInfo;

    public function __construct()
    {
        parent::__construct();

        //filterMobile
        if (isMobile()){
            $this->ajaxReturn([
                'code'      => 203,
                'msg'       => 'This website does not currently support mobile devices, please use a Pc to browse, Thanks!'
            ]);
            exit();
        }

        //checkStatus
        $SysModel = new SysController();
        if ($SysModel->getSysStatus()) {
            $this->display('Common/error');
            exit();
        }

        $this->userIP = get_client_ip();

        $this->sysPre = C('SYS_PRE');
        $this->sysInfoModel = new SiteModel();
        $this->sysModel = new SysController();

//        if (empty($this->getSysInfo())) {
//            $this->init();
//        }
        $this->assign('sysInfo', $this->getSysInfo());
    }

    public function init()
    {
        $sysInfo = $this->sysInfoModel->getSysInfo();
        $this->sysModel->setSysInfo($sysInfo);
    }

    public function getSysInfo()
    {
        $sysInfo = $this->sysModel->getSysInfo();
        if (empty($sysInfo)) {
            $this->init();
            $this->getSysInfo();
        }
        return $sysInfo;
    }
}