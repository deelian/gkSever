<?php

namespace Maps\Controller;


use Home\Controller\BaiduController;

class IndexController extends BaseController {

    public function index(){
        $urlModel = new BaiduController();
        $cate = $urlModel->urls(1,200000);
        foreach ($cate['lists'] as $v)
        {
            $this->maps ->AddItem($v, 1);
        }
        $this->maps ->SaveToFile('sitemap.xml');
    }

}