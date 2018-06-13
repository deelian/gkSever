<?php
namespace Index\Controller;

use Api\Controller\ListsController;
use Api\Controller\SearchController;

class IndexController extends BaseController {
    /**
     * HomePage
     */
    public function index(){
        $this->display();
    }

    public function search(){
        if (I('get.kw')){
            $SearchModel = new ListsController();
            $res = $SearchModel->get(I('get.kw'));
            p($res);
        } else {
            echo 11;
        }

    }
}