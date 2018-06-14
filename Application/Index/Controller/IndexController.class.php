<?php
namespace Index\Controller;

use Api\Controller\ListssearchController;

class IndexController extends BaseController {
    /**
     * HomePage
     */
    public function index(){
        $this->display();
    }

    public function search(){
        if (I('get.kw')){
            $req = I('get.');
            $SearchModel = new ListssearchController();
            $res = $SearchModel->get($req['kw'], $req['p']);

            $this->assign('data', $res);
            $this->display();
        } else {
            echo 11;
        }

    }
}