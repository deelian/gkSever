<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:57
 */

namespace Chat\Controller;


use Admin_eu\Controller\ChatController;
use Search\Controller\BaseController;
use Think\Controller;
use Home\Controller\XkController as xk;
use Chat\Model\ChatListModel as cModel;

class AutomessageController extends Controller
{
    private $ChatModel;

    private $ChatSysSetPre;
    private $ChatPre;

    public function __construct()
    {
        parent::__construct();
        $this->ChatModel     = new xk();
        $this->ChatPre       = C('CHAT_LISTS_PRE');
        $this->ChatSysSetPre = C('SYS_SET_CHAT_PRE');
    }

    /**
     * sysSendByCorn
     */
    public function sendJoke(){
        if ($jok = $this->getChatInfo()){
            $jok = str_replace(' ', '%20', $jok);
            $url = C('CHAT_SERVER').$jok;
            httpGet($url);
        } else {
            pLog('jokeError!', 'ERRORLOG', 'jokeLog.txt');
        }
    }

//    private function getJokes(){
//        $joke = httpGet('http://api.icndb.com/jokes/random/');
//        if ($joke['type'] == 'success'){
//            $res = substr($joke['value']['joke'], 0, 80);
//            return $res;
//        } else {
//            return false;
//        }
//    }

    private function getChatInfo()
    {
        $Bc = new BaseController();
        $sysConf = $Bc->getSysInfo();
        (rand(0,100) > $sysConf['chatSetPresent']) ? ($pre = $this->ChatPre) : ($pre = $this->ChatSysSetPre);

        $len = $this->ChatModel->RED->llen($pre);
        if ($len == 0) {
            if ($this->iniChatInfoToRed('init')) {
                $this->getChatInfo();
            } else {
                pLog('iniChatInfoToRedFailed!', 'LEVEL: Sys', 'system.log');
            }
        }
        $id = rand(1, $len);
        $info = $this->ChatModel->RED->lrange($pre, $id, $id);
        $info = $info[0];
//        p($info,1);
        return $info;
    }

    /**
     * initChatListStore
     *
     * @param $type
     * @return bool
     */
    public function iniChatInfoToRed($type)
    {
        if ($type == 'init') {
            if ($this->storeChatRed(1) && $this->storeChatRed(2)) {
                return true;
            } else {
                return false;
            }
        } else {
            ($type === 'Sys') ? ($level = 2) : ($level = 1);
//            echo $type;
            if ($this->storeChatRed($level)) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function storeChatRed($level)
    {
        if ($level == 1) {
            $pre = $this->ChatPre;
        } else {
            $pre = $this->ChatSysSetPre;
        }
        $this->ChatModel->RED->del([$pre]);
        $cModel = new cModel();
        $lists  = $cModel->where(['level'=>$level])->field('info')->select();
        if (empty($lists)) {
            return true;
        }
        $res = [];
        foreach ($lists as $k => $v) {
            $res[$k] = $v['info'];
        }
        shuffle($res);
        if ($this->ChatModel->RED->lpush($pre, $res)) {
            return true;
        } else {
            return false;
        }
    }

//    public function iniChatInfoToRedBySys()
//    {
//        $this->ChatModel->RED->del([$this->ChatSysSetPre]);
//        $cModel = new cModel();
//        $lists  = $cModel->where(['level'=>2])->field('info')->select();
//        $res = [];
//        foreach ($lists as $k => $v) {
//            $res[$k] = $v['info'];
//        }
//        shuffle($res);
//        if ($this->ChatModel->RED->lpush($this->ChatSysSetPre, $res)) {
//            return true;
//        } else {
//            return false;
//        }
//    }
}