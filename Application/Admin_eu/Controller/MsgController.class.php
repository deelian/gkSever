<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18
 * Time: 9:55
 */

namespace Admin_eu\Controller;

use Search\Model\MessageModel;

class MsgController extends BaseadminController
{

//    public function __construct()
//    {
//        parent::__construct();
//    }

    public function lists()
    {
        $mModel = new MessageModel();
        $req = I('get.');
        $where  = [];
        !isset($req['p']) ? ($page = 1) : ($page = $req['p']);
        !(isset($req['content']) && $req['content'] != '') ?: (
            $this->assign('content', $req['content'])&
            $where['content'] = [
                [
                    'like',
                    "%$req[content]%"
                ]
            ]
        );
        !((isset($req['sTime']) && $req['sTime'] != '') && (!isset($req['eTime']) || $req['eTime'] == '')) ?: (
            $this->assign('sTime', $req['sTime'])&
            $where['time'] = [
                [
                    'egt',
                    strtotime($req['sTime'])
                ]
            ]
        );
        !((isset($req['eTime']) && $req['eTime'] != '') && (!isset($req['sTime']) || $req['sTime'] == '')) ?: (
            $this->assign('eTime', $req['eTime'])&
            $where['time'] = [
                [
                    'elt',
                    strtotime($req['eTime'])
                ]
            ]
        );
        !((isset($req['sTime']) && ($req['sTime'] != '')) && (isset($req['eTime']) && ($req['eTime'] != ''))) ?: (
            $this->assign('sTime', $req['sTime'])&
            $this->assign('eTime', $req['eTime'])&
            $where['time'] = [
                [
                    'egt',
                    strtotime($req['sTime'])
                ],
                [
                    'elt',
                    strtotime($req['eTime'])
                ]
            ]
        );
        $limit = 10;
        $lists = $mModel->where($where)->order('time DESC')->page($page . ',' . $limit)->select();
        $count = $mModel->where($where)->count();
        $Page  = new \Think\Page($count, $limit);
        $show  = $Page->show();
//        p($show);
//        p($lists, 1);
        $this->assign('list', $lists);
        $this->assign('page', $show);
//        $this->display();
    }
}