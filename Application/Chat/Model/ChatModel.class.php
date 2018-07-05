<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/5
 * Time: 15:29
 */
namespace Chat\Model;

use Think\Model;

class ChatModel extends Model
{
    public function storeMsg($data){
        $this->add($data);
    }

    public function getMsg($where=[]){
        return $this->where($where)->select();
    }
}