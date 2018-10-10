<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10
 * Time: 11:44
 */

namespace Admin_eu\Controller;


use Admin_eu\Model\ResModel;

class ResController extends BaseadminController
{
    //mysqlModel
    private  $mModel;

    public function __construct()
    {
        parent::__construct();
        $this->mModel = new ResModel();
    }

    public function listInfo()
    {
        $req = I('get.');
        $where = [];
//        if (isset($req['name'])) {
//            $where['res_name'] = $req['name'];
//        }
        !isset($req['name']) ? :($where['res_name'] = $req['name']);
        !isset($req['type']) ? :($where['type'] = $req['type']);
        !(isset($req['sTime']) && !isset($req['eTime'])) ? :(
            $where['add_time'] = [
               [
                   'gt',
                   $req['sTime']
               ]
            ]
        );
        !(!isset($req['sTime']) && isset($req['eTime'])) ? :(
            $where['add_time'] = [
                [
                    'lt',
                    $req['eTime']
                ]
            ]
        );
        !(isset($req['sTime']) && isset($req['eTime'])) ? :(
            $where['add_time'] = [
                [
                    'gt',
                    $req['sTime']
                ],
                [
                    'lt',
                    $req['eTime']
                ]
            ]
        );

//        p($where,1);
        $field = '*';
        $limit = 25;
        $page  = $req['p'];
        $res = $this->mModel->getList($where, $field, $limit, $page);
        p($res,1);
        $this->display();
    }

    public function addRes()
    {

        $this->display();
    }
}