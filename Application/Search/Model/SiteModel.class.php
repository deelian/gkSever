<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/19
 * Time: 11:34
 */
namespace Search\Model;

use Think\Model;

class SiteModel extends Model
{
    public function getSysInfo(){
        return [
            'siteName'       => 'Ebola union of Korea',
            'description'    => 'Ebola union of Korea',
            'copyRight'      => date('Y', time()),
            'chatSetPresent' => 25
        ];
    }
}