<?php
namespace Chat\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){$url = 'http://52.79.219.61';
        $url .=':2121';
        if (IS_POST){
            $req = I('post.');
            if (empty($req['content'])){
                $this->ajaxReturn([
                    'code'  => 401,
                    'message'   => 'Missing necessary parameters!'
                ])
            }
            httpGet($url, ['content' => ]);
        } else {
            p($url);
        }
    }

}