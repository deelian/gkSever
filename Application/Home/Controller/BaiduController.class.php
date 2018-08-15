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

    private function urls($id, $total){
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

    public function tuiBaidu(){
        $urls = $this->urls($this->startId(),100);
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
        if ($result->success == 20)
            pLog('当前推送指针id：'.$urls['numId'], '百度主动式推送日志', 'tuiLogs.txt');
//        if ($result->remain == 0)
//            $this->RED->set();
        echo 'nil';
    }

}