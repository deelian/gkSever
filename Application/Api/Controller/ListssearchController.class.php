<?php

namespace Api\Controller;

class ListssearchController extends SearchController{

    private $XS;

    private $XSS;

    public function __construct()
    {
        parent::__construct();
        $searchObj = new \XS(C('RES_SEARCH'));
        $this->XS = $searchObj->search;
        $this->XS->setCharset('UTF-8');

        $this->XSS = new \XSSearch();
    }

    public function get($kw, $p){
        $f = 'res_name';
        $q = get_magic_quotes_gpc() ? stripslashes($kw) : $kw;
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

        $p = max(1, intval($p));
        $n = $this->XSS::PAGE_SIZE;
        $this->XS->setLimit($n, ($p - 1) * $n);

        $search_begin   = microtime(true);
        $lists          = $this->XS->search();
        $search_cost    = microtime(true) - $search_begin;

        $count      = $this->XS->getLastCount();
        $Page       = new \Think\Page($count,$n);
        $Page->lastSuffix = false;
        $Page->setConfig('header','<li class="disabled hwh-page-info"><a>共<em>%TOTAL_ROW%</em>条  <em>%NOW_PAGE%</em>/%TOTAL_PAGE%页</a></li>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $page_show = bootstrap_page_style($Page->show());

        return [
            'list'      => $lists,
            'costTime'  => $search_cost,
            'page'      => $page_show
        ];
    }
}