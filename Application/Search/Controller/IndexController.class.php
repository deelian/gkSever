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
            $res['kw'] = I('get.key');

            $this->assign('data', $res);
            $this->display();
        } else {
            $this->display('Common/error');
        }
    }

    public function detail(){
        if (empty(I('get.code'))){
            $this->display('Common/error');
        }
        $data = new dataModel();
        $res = $data->getInfo(I('get.code'));
//        p($res,1);
        $this->assign('info', $res);
        $this->display();
    }

    public function deelian(){
        phpinfo();
    }
}