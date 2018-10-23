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

    private $setMessage;
    private $smRed;
    private $smRedPre;

    public function __construct()
    {
        parent::__construct();
        $this->smRedPre = C('SET_MESSAGE');
        $this->smRed = new xk();
        $this->setMessage = new sm();
    }

    public function sysChatInfoSet()
    {
//        $this->setMessage;
//        if ($this->smRed->RED->hmset($this->smRedPre, $data)) {
//
//        }
    }

    public function sysChatInfLists()
    {
        $list = $this->smRed->RED->hgetall($this->smRedPre);
        if (empty($list)) {
            $list = $this->sysChatInfoSet();
        }
        $sum = array_sum($list);

        $limit = 20;
        $Page  = new \Think\Page($sum, $limit);
        $Page->setConfig('header','');
        $Page->setConfig('prev','Pre');
        $Page->setConfig('next','Next');
        $Page->setConfig('last','End');
        $Page->setConfig('first','First');
        $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show  = bootstrap_page_style($Page->show());

        $data = [
            'list'  => $list,
            'page'  => $show,
            'sum'   => $sum
        ];
        $this->assign('data', $data);
        $this->display();
    }

    public function sysChatInfoUpdate()
    {

    }
}