<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 16:08
 */

namespace Admin_eu\Controller;

use Home\Controller\XkController as xk;
use Chat\Model\ChatListModel;
use Chat\Controller\AutomessageController;

class ChatController extends BaseadminController
{

    private $ChatListPre;
    private $sysSetChatPre;

    private $xkModel;
    private $cModel;

    public function __construct()
    {
        parent::__construct();
        $this->ChatListPre = C('CHAT_LISTS_PRE');
        $this->sysSetChatPre = C('SYS_SET_CHAT_PRE');
        $this->xkModel = new xk();
        $this->cModel = new ChatListModel();
    }

    public function chatInfoList()
    {
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
        $res = $this->cModel->where($where)->select();

    }

    private function resetChat()
    {
        $this->xkModel->RED->del([$this->ChatListPre]);
        if ($this->iniChatInfoToRed()) {
            echo 'done';
        }
    }

    private function iniChatInfoToRed()
    {
        if ($this->xkModel->RED->llen($this->ChatListPre) == 0) {
            $msgModel = new AutomessageController();
            if ($msgModel->iniChatInfoToRed()) {
                return true;
            }
        }
        return false;
    }


    public function updateChatInfo()
    {

    }

    public function addChatInfo()
    {

    }

//    public function firLoadInfo()
//    {
//        $list = httpGet('http://api.icndb.com/jokes/');
//        if ($list['type'] = 'success') {
//            $listInfo = [];
//            $time = time();
//            foreach ($list['value'] as $k => $v) {
//                $listInfo[$k] = [
//                    'info'       => $v['joke'],
//                    'level'      => 1,
//                    'addTime'    => $time,
//                    'updateTime' => $time
//                ];
//            }
////            p($listInfo,1);
//            $cModel = new cModel();
//            echo $cModel->addAll($listInfo);
//        }
//    }

}