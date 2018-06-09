<?php
namespace Home\Model;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 17:05
 */

use Think\Model;

class ResModel extends Model
{
    public function getDetail($id){
        return $this->where(['id'=>$id])->find();
    }
}