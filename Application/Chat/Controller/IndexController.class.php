<?php
namespace Chat\Controller;
use Home\Controller\ChatController;
use Think\Controller;
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
}