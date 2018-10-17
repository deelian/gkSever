<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 16:08
 */

namespace Admin_eu\Controller;

use Home\Controller\XkController as xk;
use Chat\Model\ChatListModel as cModel;

class ChatController extends BaseadminController
{

    private $ChatListPre;
    private $xkModel;

    public function __construct()
    {
        parent::__construct();
        $this->ChatListPre = C('CHAT_LISTS_PRE');
        $this->xkModel = new xk();
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

    public function iniChatInfoToRed()
    {
        $this->xkModel->RED->del([$this->ChatListPre]);
        $cModel = new cModel();
        $lists  = $cModel->field('info')->select();
        $res = [];
        foreach ($lists as $k => $v) {
            $res[$k] = $v['info'];
        }
        shuffle($res);
//        p($res,1);
        if ($this->xkModel->RED->lpush($this->ChatListPre, $res)) {
            return true;
        } else {
            return false;
        }
    }

    public function chatInfoList()
    {

    }

    public function updateChatInfo()
    {

    }

    public function addChatInfo()
    {

    }
}