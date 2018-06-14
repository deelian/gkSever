<?php
namespace Search\Controller;

use Api\Controller\ListssearchController;
use Home\Controller\IndexController as dataModel;

class IndexController extends BaseController {
    /**
     * HomePage
     */
    public function index(){
        $this->display();
    }

    /**
     * SearchPage
     */
    public function search(){
        if (I('get.key')){
            $req = I('get.');
            $SearchModel = new ListssearchController();
            $res = $SearchModel->get($req['key'], $req['p']);

            $this->assign('data', $res);
            $this->display();
        } else {
            echo 11;
        }
    }

    public function detail(){
        if (empty(I('get.code'))){
            $this->redirect(U('/'));
        }
        $data = new dataModel();
        $res = $data->getInfo(I('get.code'));
//        p($res,1);
        $this->assign('info', $res);
        $this->display();
    }
}