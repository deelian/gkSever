<?php

namespace Api\Controller;

class RelsearchController extends SearchController {

    private $XS;

    private $XL;

    public function __construct()
    {
        parent::__construct();
        $searchObj = new \XS(C('REL_SEARCH'));
        $this->XS = $searchObj->search;
        $this->XL = $searchObj->index;
        $this->XS->setCharset('UTF-8');
    }

    /**
     * 获取热词
     * @return array
     */
    public function getHot(){
        $hot = $this->XS->getHotQuery();
        if ($hot){
            if(IS_POST){
                $this->retSuccess([
                    'list'  => $hot,
                ]);
            }
            return [
                'code'  => 200,
                'data'  => $hot
            ];
        } else {
            if(IS_POST){
                $this->retFalse('Empty hot lists!');
            }
            return [
                'code'  => 400
            ];
        }
    }


    public function getRel(){
        //searchLock


        if (!IS_POST){
            $this->retFalse('Unlawful request！');
        }

        $req = I('post.');
        if (empty($req['kw'])) {
            $this->retFalse('Search key should not be empty!');
        }

        $f = 'res_name';
        $q = get_magic_quotes_gpc() ? stripslashes($req['kw']) : $req['kw'];
        $s = 'id';

        // fuzzy search
        $this->XS->setFuzzy(true);

        // synonym search
        $this->XS->setAutoSynonyms(true);

        // set query
        $this->XS->setQuery($f . ':(' . $q . ')');

        // set sort
        if (($pos = strrpos($s, '_')) !== false) {
            $sf = substr($s, 0, $pos);
            $st = substr($s, $pos + 1);
            $this->XS->setSort($sf, $st === 'ASC');
        }

        $search_begin = microtime(true);
        $relLists = $this->XS->search();
        $search_cost = microtime(true) - $search_begin;
        $lists = [];
        foreach ($relLists as $k => $v){
            array_push($lists, $v->res_name);
        }
        $this->retSuccess([
            'lists' => $lists,
            'costTime' => $search_cost
        ]);
    }

    public function setList($data){
        //创建文档对象
        $doc = new \XSDocument();
        $doc->setFields($data);
//        $this->XL->add($doc);
        $this->XL->update($doc);
    }
}