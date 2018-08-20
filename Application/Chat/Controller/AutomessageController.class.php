<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/20
 * Time: 15:57
 */

namespace Chat\Controller;


use Think\Controller;

class AutomessageController extends Controller
{
    public function sendJoke(){
        if ($jok = $this->getJokes()){
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
}