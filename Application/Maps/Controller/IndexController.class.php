<?php

namespace Maps\Controller;


use Home\Controller\BaiduController;
use Home\Controller\ListController;
use Org\Util\Sitemap;

class IndexController extends BaseController {

    public $maps;

    public function index(){
//        p(I('get.code'));
        if (I('get.code') != 'deelian'){
            echo 'nil';
            die;
        }
        $urlModel = new BaiduController();
        $all = new ListController();
        $total = $all->getResTotal();
        $num = 40000;
        $page = $total/$num;
        $tempMaps = [];
        for ($a=1; $a<=ceil($page); $a++){
            $listInfo = $urlModel->MapsUrl(1+($a-1)*$num, $a*$num, $total);
            $tempMaps[$a] = $listInfo;
        }
        foreach ($tempMaps as $k => $v){
            $this->maps = new Sitemap();
            foreach ($v as $l){
                $this->maps ->AddItem($l, 1);
            }
            $this->maps ->SaveToFile('sitemaps/', "sitemap$k.xml");
        }
        echo 'done';
    }

}