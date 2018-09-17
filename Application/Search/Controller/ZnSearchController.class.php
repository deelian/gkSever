<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17
 * Time: 10:17
 */

namespace Search\Controller;


class ZnSearchController extends BaseController
{
    public function index ()
    {
        $code = "<script type='text/javascript'>(function(){document.write(unescape('%3Cdiv id=\"bdcs\"%3E%3C/div%3E'));var bdcs = document.createElement('script');bdcs.type = 'text/javascript';bdcs.async = true;bdcs.src = 'http://znsv.baidu.com/customer_search/api/js?sid=6217318113172727661' + '&plate_url=' + encodeURIComponent(window.location.href) + '&t=' + Math.ceil(new Date()/3600000);var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(bdcs, s);})();</script>";
        $this->assign('tt', 'tt');
        $this->assign('search', $code);
        $this->display();
    }

}