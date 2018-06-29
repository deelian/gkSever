<?php
namespace Search\Controller;

use Api\Controller\ListssearchController;
use Api\Controller\RelsearchController;
use Home\Controller\HotController;
use Home\Controller\IndexController as dataModel;
use Home\Controller\ListController;

class IndexController extends BaseController {

    /**
     * HomePage
     */
    public function index(){
        $HotWordModel = new HotController();
        $hotWord = $HotWordModel->getHotList();
        if (empty($hotWord)) {
            $HotModel  = new RelsearchController();
            $hots = $HotModel->getHot();
            if ($hots['code'] == 200){
                $hotw = array_keys($hots['data']);
                $HotWordModel->setHotList($hotw);
                $hotWord = $hotw;
            }
        }
        $this->assign('hot', $hotWord);

        $listModel = new ListController();
        $List = [];
        $a = 1;
        for ($i=1; $i<=10; $i++){
            $temp = $listModel->getList($i);
            if ($temp['status'] == 301){
                $this->display('Common/error');
                exit();
            }
            if ($i<=6){
                $List['A'][$i] = $temp;
            } else {
                $List['B'][$a] = $temp;
                $a++;
            }
        }

        $this->assign('listA', $List['A']);
        $this->assign('listB', $List['B']);
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

            $sider = $this->siderBarList();
//            pLog($sider['1'],'debug');
//            p($sider['1'],1);
            $this->assign('siderA', $sider['1']);
            $this->assign('siderB', $sider['2']);

            $this->assign('data', $res);
            $this->display();
        } else {
            $spanModel = new RelsearchController();
            $span   = $spanModel->getHot();
            if ($span['code'] == 200){
                $hotw = array_keys($span['data']);
                $this->assign('span', $hotw);
            }

            $this->display('Common/error');
        }
    }

    public function detail(){
        if (empty(I('get.code'))){
            $this->display('Common/error');
        }
        $data = new dataModel();
        $res = $data->getInfo(I('get.code'));
        if (empty($res['info']['res_desc'])){
            $res['info']['res_desc']['0'] = $res['info']['res_name'];
        }
//        p($res,1);

        $sider = $this->siderBarList();
        $this->assign('siderA', $sider['1']);
        $this->assign('siderB', $sider['2']);

        $this->assign('info', $res);
        $this->display();
    }

    public function siderBarList(){
        $siderBarModel = new ListController();
        $sider = [];
        for ($i=1; $i<=2; $i++){
            $temp = $siderBarModel->getSiderBar($i);
            if ($temp['status'] == 301){
                $this->display('Common/error');
                exit();
            }
            $sider[$i] = $temp;
        }
        return $sider;
    }

    public function deelian(){
        phpinfo();
    }
}