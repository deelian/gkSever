<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/20
 * Time: 11:21
 */

namespace Admin_eu\Controller;

use Search\Model\SetMessage as sm;
use Home\Controller\XkController as xk;

class SysController extends BaseadminController
{

    private $xkMod;
    private $sysSetConf;
    private $sysSetConfUrl;

    public function __construct()
    {
        parent::__construct();
        $this->siteRedPre = C('SET_MESSAGE');
        $this->xkMod = new xk();
        $this->sysSetConf = 'sysSetInfo';
        $this->sysSetConfUrl = MODULE_PATH .'Conf/';
//        $this->setMessage = new sm();
    }

    public function index()
    {
        $sysConf = Fc($this->sysSetConf, '', $this->sysSetConfUrl);
//        p($sysConf,1);
        $this->assign('conf', $sysConf);
        $this->display();
    }

    public function update()
    {
        if (IS_POST) {
            if (Fc($this->sysSetConf, I('post.'), $this->sysSetConfUrl)) {
                $this->ajaxReturn([
                    'code'  => 200,
                    'msg'   => 'Set Successfully!'
                ]);
            }
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