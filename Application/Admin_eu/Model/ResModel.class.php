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

    public function getList($where, $field = '*',  $limit, $page = 1)
    {
        $count = $this->where($where)->count();
        $Page  = new \Think\Page($count, $limit);
        $show  = $Page->show();
//        $show  = bootstrap_page_style($Page->show());
        p($show,1);

        $limit = (string)$limit;
        $page  = (string)$page;

        $list  = $this->where($where)->order('add_time')->field($field)->page($page.",$limit")->select();
//        p($this->getLastSql(),1);
        return [
            'all'   => $count,
            'page'  => $show,
            'list'  => $list
        ];
    }

    public function saveRes($data)
    {
        return $this->add($data);
    }
}