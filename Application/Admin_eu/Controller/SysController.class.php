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

    public function __construct()
    {
        parent::__construct();
        $this->siteRedPre = C('SET_MESSAGE');
        $this->xkMod = new xk();
//        $this->setMessage = new sm();
    }

    public function index()
    {
//        p(1,1);
        $this->display();
    }

    public function update()
    {
        echo 111;
        p($_POST,1);
    }

    /**
     * 系统chat设置列表
     */
    public function sysChatInfLists()
    {

    }
}