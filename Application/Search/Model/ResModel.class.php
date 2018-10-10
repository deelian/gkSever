<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/22
 * Time: 10:54
 */

namespace Search\Model;


use Think\Model;

class ResModel extends Model
{
    public function saveRes($data){
        return $this->add($data);
    }
}