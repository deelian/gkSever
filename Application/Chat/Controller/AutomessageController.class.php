<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:57
 */

namespace Chat\Controller;


use Admin_eu\Controller\ChatController;
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
        $this->ChatModel = new xk();
        $this->ChatPre = C('CHAT_LISTS_PRE');
        $this->ChatSysSetPre = C('SYS_SET_CHAT_PRE');
    }

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
        $len = $this->ChatModel->RED->llen($this->ChatPre);
        if ($len == 0) {
            if ($this->iniChatInfoToRed()) {
                $this->getChatInfo();
            } else {
                pLog('iniChatInfoToRedFailed!', 'LEVEL: Sys', 'system.log');
            }
        }
        $id = rand(1, $len);
        $info = $this->ChatModel->RED->lrange($this->ChatPre, $id, $id);
        $info = $info[0];
//        p($info,1);
        return $info;
    }

    public function iniChatInfoToRed()
    {
        $this->ChatModel->RED->del([$this->ChatPre]);
        $cModel = new cModel();
        $lists  = $cModel->where(['level'=>1])->field('info')->select();
        $res = [];
        foreach ($lists as $k => $v) {
            $res[$k] = $v['info'];
        }
        shuffle($res);
        if ($this->ChatModel->RED->lpush($this->ChatPre, $res)) {
            return true;
        } else {
            return false;
        }
    }

    public function iniChatInfoToRedBySys()
    {
        $this->ChatModel->RED->del([$this->ChatSysSetPre]);
        $cModel = new cModel();
        $lists  = $cModel->where(['level'=>2])->field('info')->select();
        $res = [];
        foreach ($lists as $k => $v) {
            $res[$k] = $v['info'];
        }
        shuffle($res);
        if ($this->ChatModel->RED->lpush($this->ChatSysSetPre, $res)) {
            return true;
        } else {
            return false;
        }
    }
}