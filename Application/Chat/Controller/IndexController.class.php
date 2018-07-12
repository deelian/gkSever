<?php

namespace Chat\Controller;

use Chat\Model\ChatModel;
use Home\Controller\ChatController;

class IndexController extends BaseController {
    public function index(){
        if (IS_POST){
            $req = I('post.');
            if (empty($req['content'])){
                $this->ajaxReturn([
                    'code'      => 401,
//                    'message'   => 'Missing necessary parameters!'
                    'message'   => 'Do not submit empty data!'
                ]);
            }
            if ($w = checkWord($req['content'])){
                $this->ajaxReturn([
                    'code'      => 501,
                    'message'   => "ERROR: Forbidden Words [ $w ]!"
                ]);
            }
            $chatModel = new ChatController();
            if ($chatModel->getUserStatus($this->userIP)){
                $this->ajaxReturn([
                    'code'      => 402,
//                    'message'   => 'Missing necessary parameters!'
                    'message'   => 'Data submission is too frequent！'
                ]);
            }
            $req['content'] = str_replace(' ', '%20', $req['content']);
            $url = C('CHAT_SERVER').$req['content'];
            $res = httpGet($url);

            $chatMdoel = new ChatModel();
            $chatMdoel->storeMsg([
                'content'   => $req['content'],
                'ip'        => $this->userIP,
                'time'      => time()
            ]);

            $chatModel->userLock($this->userIP);
            $this->ajaxReturn([
                'code'      => 200,
                'ret'       => $res,
                'message'   => 'Success!'
            ]);
        } else {
            echo 'nil';
        }
    }

    public function getChatList(){
        $chatModel = new ChatModel();
        $this->ajaxReturn($chatModel->getMsg());
    }

    public function sendNow(){
//        p($data);
//        p($data['hitokoto']);
        for ($x=0; $x<=60; $x++){
            $data = httpsGet('https://sslapi.hitokoto.cn/?encode=json');
            httpsPost(
                'http://dazi.dazima.cn/gd/senpost.php',
                [
                    'username'  => $data['creator'],
                    'text'      => $data['hitokoto'].'___PoweredBy :: http://www.ebolaunion.gq/ '
//                    'text'      => '___PoweredBy :: http://www.ebolaunion.gq/ '
                ]
            );
        }
    }
}