<?php
namespace Api\Controller;

require_once '/usr/local/xunsearch/sdk/php/lib/XS.php';
class RelsearchController extends SearchController {

    private $XS;

    public function __construct()
    {
        parent::__construct();
        $searchObj = new XS(C('ERL_SEARCH'));
        $this->XS = $searchObj->search;
        $this->XS->setCharset('UTF-8');
    }

    /**
     * 获取热词
     * @return array
     */
    public function getHot(){
        $hot = $this->XS->getHotQuery();
        if ($hot){
            return [
                'code'  => 200,
                'data'  => $hot
            ];
        } else {
            return [
                'code'  => 400
            ];
        }
    }


    public function getRel(){
        if (!IS_POST){
            $this->retFalse('Unlawful request！');
        }

        $req = I('post.');
        if (empty($req['kw'])) {
            $this->retFalse('Search key should not be empty!');
        }

        $f = 'res_name';
        $q = $req['kw'];
        $s = 'id';

        // fuzzy search
        $this->XS->setFuzzy(true);

        // synonym search
        $this->XS->setAutoSynonyms(true);

        // set query
        if (!empty($f) && $f != '_all') {
            $this->XS->setQuery($f . ':(' . $q . ')');
        } else {
            $this->XS->setQuery($q);
        }

        // set sort
        if (($pos = strrpos($s, '_')) !== false) {
            $sf = substr($s, 0, $pos);
            $st = substr($s, $pos + 1);
            $this->XS->setSort($sf, $st === 'ASC');
        }

        $search_begin = microtime(true);
        $relLists = $this->XS->search();
        $search_cost = microtime(true) - $search_begin;

        $this->retSuccess([
            'lists' => $relLists,
            'costTime' => $search_cost
        ]);
    }
}