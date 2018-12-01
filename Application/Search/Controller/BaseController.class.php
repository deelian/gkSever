<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/11
 * Time: 15:29
 */

namespace Search\Controller;


use Home\Controller\SysController;
use Admin_eu\Model\SysModel as SysM;
use Think\Controller;
use Home\Controller\XkController as Xk;

class BaseController extends Controller
{
    public $userIP;

    private $sysPre;
    private $sysInfoModel;
    private $sysModel;
    private $locationIpPre;

    public $sysInfo;

    public function __construct()
    {
        parent::__construct();

        //filterMobile
        if (isMobile()) {
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
//        $this->userIP = '84.112.205.11';
        $this->locationIpPre = C('LOCATION_IP_PRE');
        $Xk = new Xk();
        if ($info = $Xk->RED->hget($this->locationIpPre, $this->userIP)) {
            ($info === 'CN') ? ($flag = 'in') : ($flag = 'out');
        } else {
            $locationFlag = file_get_contents("http://api.wipmania.com/$this->userIP");
            strstr($locationFlag,"CN") === 'CN' ? ($flag = 'in') : ($flag = 'out');
            $Xk->RED->hset($this->locationIpPre, $this->userIP, $locationFlag);
        }
        $this->assign('flagLocation', $flag);

        $this->sysPre = C('SYS_PRE');
        $this->sysInfoModel = new SysM();
        $this->sysModel = new SysController();

        $this->assign('sysInfo', $this->getSysInfo());
    }

    public function init()
    {
        $sysInfo = $this->sysInfoModel->getFileInfo();
//        p($sysInfo,1);
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