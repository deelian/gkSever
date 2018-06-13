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
            $SearchModel = new ListssearchController();
            $res = $SearchModel->get(I('get.kw'));
            p($res);
        } else {
            echo 11;
        }

    }
}