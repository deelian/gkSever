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
    private $ChatPre;

    public function __construct()
    {
        parent::__construct();
        $this->ChatModel = new xk();
        $this->ChatPre = C('CHAT_LISTS_PRE');
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

    private function getJokes(){
        $joke = httpGet('http://api.icndb.com/jokes/random/');
        if ($joke['type'] == 'success'){
            $res = substr($joke['value']['joke'], 0, 80);
            return $res;
        } else {
            return false;
        }
    }

    public function getChatInfo()
    {
        $len = $this->ChatModel->RED->llen($this->ChatPre);
//        echo $len;
//        p($len,1);
        if ($len == 0) {
            if ($this->iniChatInfoToRed()) {
                $this->getChatInfo();
            }
        }
        $id = rand(1, $len);
        $info = $this->ChatModel->RED->lrange($this->ChatPre, $id, $id);
        $info = $info[0];
//        p($info,1);
        return $info;
    }

    private function iniChatInfoToRed()
    {
        $this->ChatModel->RED->del([$this->ChatPre]);
        $cModel = new cModel();
        $lists  = $cModel->field('info')->select();
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
}