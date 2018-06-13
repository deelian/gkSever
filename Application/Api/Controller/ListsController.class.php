<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/13
 * Time: 15:04
 */

namespace Api\Controller;


class ListsController extends SearchController
{

    private $XS;

    public function __construct()
    {
        parent::__construct();
        $searchObj = new \XS(C('RES_SEARCH'));
        $this->XS = $searchObj->search;
        $this->XS->setCharset('UTF-8');
    }

    public function get($kw){
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

        $search_begin = microtime(true);
        $lists = $this->XS->search();
        $search_cost = microtime(true) - $search_begin;
        return [
            'list'  => $lists,
            'costTime'  => $search_cost
        ];
    }
}