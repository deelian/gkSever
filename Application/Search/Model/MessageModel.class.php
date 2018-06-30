<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/30
 * Time: 11:31
 */

namespace Search\Model;


use Think\Model;

class MessageModel extends Model
{
    public function userMsg($data){
        return $this->add($data);
    }
}