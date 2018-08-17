<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/3
 * Time: 11:41
 */

namespace Maps\Controller;

use Org\Util\Sitemap;
use Think\Controller;

class BaseController extends Controller
{
    public $maps;
    public $fileName;

    public function __construct()
    {
        parent::__construct();
        $this->maps = new Sitemap();
    }
}