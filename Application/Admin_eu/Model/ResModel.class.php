<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 16:57
 */
namespace Admin_eu\Model;


use Think\Model;

class ResModel extends Model
{

    public function getList($where, $field,  $limit, $page)
    {
        $count = $this->where($where)->count();
        $Page  = new \Think\Page($count, $limit);
        $show  = $Page->show();//
        $list  = $this->where($where)->order('add_time')->page($page . ',' . $limit)->select();
        return [
            'page'  => $show,
            'list'  => $list
        ];
    }

    public function saveRes($data)
    {
        return $this->add($data);
    }
}