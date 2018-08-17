<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/14
 * Time: 17:41
 */

namespace Home\Controller;


class BaiduController extends XkController
{
    private $BaiduPre;
    public function __construct()
    {
        parent::__construct();
        $this->BaiduPre = C('BAIDU_TUI_PRE');
    }


    private function startId(){
        $this->RED->get($this->BaiduPre)?$start = $this->RED->get($this->BaiduPre):$start = 1;

        $all = new ListController();
        $total = $all->getResTotal();
        if ($start>$total)
            $start = 1;

        return $start;
    }

    public function urls($id, $total){
        $urls = [];
        $total = $id + $total;
        $domain = C('MAIN_DOMAIN');
        for ($i=$id; $i<$total; $i++){
            array_push($urls, $domain."detail/".encrypt($i).".jsp");
        }
        $this->RED->set($this->BaiduPre,$i);
        return [
            'lists'     => $urls,
            'numId'     => $i
        ];
    }

    public function MapsUrl($start, $end, $exit){
        $urls = [];
        $domain = C('MAIN_DOMAIN');
        for ($i=$start; $i<=$end; $i++){
            if ($i>$exit)
                break;
            array_push($urls, $domain."detail/".encrypt($i).".jsp");
        }
        return $urls;
    }

    public function tuiBaidu(){
        $num = 100;
        $urls = $this->urls($this->startId(),$num);
        $api = 'http://data.zz.baidu.com/urls?site=www.ebolaunion.gq&token=DdEL0tMABDU3vRLf';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls['lists']),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = json_decode(curl_exec($ch));
        if ($result->success == $num)
            pLog('当前推送指针id：'.$urls['numId'], '百度主动式推送日志', 'tuiLogs.txt');
//        if ($result->remain == 0)
//            $this->RED->set();
        if (I('get.code') == 'deelian')
            pLog(json_encode($urls['lists']), 'urls', 'listsLog.txt');
            p($result,1);
        echo 'nil';
    }

}