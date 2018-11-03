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

        !isset($req['p']) ? ($page = 1) : ($page = $req['p']);
        !isset($req['type']) ?: ($where['type'] = $req['type']);
        !(isset($req['name']) && $req['name'] != '') ?: (
            $this->assign('name', $req['name'])&
            $where['res_name'] = [
                [
                    'like',
                    "%$req[name]%"
                ]
            ]
        );
        !((isset($req['sTime']) && $req['sTime'] != '') && (!isset($req['eTime']) || $req['eTime'] == '')) ?: (
            $this->assign('sTime', $req['sTime'])&
            $where['add_time'] = [
                [
                    'egt',
                    strtotime($req['sTime'])
                ]
            ]
        );
        !((isset($req['eTime']) && $req['eTime'] != '') && (!isset($req['sTime']) || $req['sTime'] == '')) ?: (
            $this->assign('eTime', $req['eTime'])&
            $where['add_time'] = [
                [
                    'elt',
                    strtotime($req['eTime'])
                ]
            ]
        );
        !((isset($req['sTime']) && ($req['sTime'] != '')) && (isset($req['eTime']) && ($req['eTime'] != ''))) ?: (
            $this->assign('sTime', $req['sTime'])&
            $this->assign('eTime', $req['eTime'])&
            $where['add_time'] = [
                [
                    'egt',
                    strtotime($req['sTime'])
                ],
                [
                    'elt',
                    strtotime($req['eTime'])
                ]
            ]
        );

//        p($where,1);
        $field = 'id, res_name, status, times, res_dirs, add_time, user_id';
        $limit = 15;
        $res = $this->mModel->getList($where, $field, $limit, $page);
//        p($res,1);

        $this->assign('info', $res);
        $this->display('listInfo');
    }

    public function addRes()
    {

        $this->display();
    }
}