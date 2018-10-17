<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/25
 * Time: 11:49
 */

namespace Home\Controller;


use Home\Model\ResModel;

class ListController extends XkController
{
    private $listPre;
    private $siderbarPre;

    public function __construct()
    {
        parent::__construct();
        $this->listPre = C('LIST_PRE');
        $this->siderbarPre = C('SIDERBAR_PRE');
    }

    public function setList(){
        $this->RED->set(C('SYS_STATUS_PRE'),1);
        for ($a=1; $a<=10; $a++) {
            for ($i=1; $i<=15; $i++) {
                $this->RED->hmset($this->listPre."$a:".$i, $this->getRangeList());
                $this->RED->expire($this->listPre."$a:".$i, C('LIST_EXPIRE'));
            }
        }
        $this->RED->set(C('SYS_STATUS_PRE'),0);
    }

    public function setSiderBar(){
        $this->RED->set(C('SYS_STATUS_PRE'),1);
        for ($a=1; $a<=2; $a++) {
            for ($i=1; $i<=15; $i++) {
                $this->RED->hmset($this->siderbarPre."$a:".$i, $this->getRangeList());
                $this->RED->expire($this->siderbarPre."$a:".$i, C('SIDERBAR_EXPIRE'));
            }
        }
        $this->RED->set(C('SYS_STATUS_PRE'),0);
    }

    public function getList($listId){
        $list = [];
        for ($i=1; $i<=15; $i++) {
            $temp = $this->RED->hgetall($this->listPre."$listId:".$i);
            if (empty($temp)) {
                $this->setList();
                return [
                    'status'    => 301,
                ];
            }
            $list[$i] = $temp;
        }
        return $list;
    }

    public function getSiderBar($listId){
        $list = [];
        for ($i=1; $i<=15; $i++) {
            $temp = $this->RED->hgetall($this->siderbarPre."$listId:".$i);
            if (empty($temp)) {
                $this->setSiderBar();
                return [
                    'status'    => 301,
                ];
            }
            $list[$i] = $temp;
        }
        return $list;
    }

    public function getRangeList(){
        $ResModel = new ResModel();
        $count = $ResModel->count();
        $id = rand(1, $count[0]['id']);
        $res = $this->RED->hgetall(C('REDIS_PRE').$id);
        return [
            'id'        => encrypt($res['id']),
            'res_name'  => $res['res_name']
        ];
    }

    public function getResTotal(){
        $ResModel = new ResModel();
        $count = $ResModel->count();
        return $count[0]['id'];
    }
}