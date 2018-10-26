<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/17
 * Time: 16:08
 */

namespace Admin_eu\Controller;

use Home\Controller\XkController as xk;
use Chat\Model\ChatListModel;
use Chat\Controller\AutomessageController;

class ChatController extends BaseadminController
{

    private $ChatListPre;
    private $sysSetChatPre;

    private $xkModel;
    private $cModel;

    public function __construct()
    {
        parent::__construct();
        $this->ChatListPre   = C('CHAT_LISTS_PRE');
        $this->sysSetChatPre = C('SYS_SET_CHAT_PRE');
        $this->xkModel       = new xk();
        $this->cModel        = new ChatListModel();
    }

    public function chatInfoList()
    {
        $req = I('get.');
        $where  = [];
        !isset($req['p']) ? ($page = 1) : ($page = $req['p']);
        !(isset($req['content']) && $req['content'] != '') ?: (
            $this->assign('content', $req['content'])&
            $where['content'] = [
                [
                    'like',
                    "%$req[content]%"
                ]
            ]
        );
        !((isset($req['sTime']) && $req['sTime'] != '') && (!isset($req['eTime']) || $req['eTime'] == '')) ?: (
            $this->assign('sTime', $req['sTime'])&
            $where['time'] = [
                [
                    'egt',
                    strtotime($req['sTime'])
                ]
            ]
        );
        !((isset($req['eTime']) && $req['eTime'] != '') && (!isset($req['sTime']) || $req['sTime'] == '')) ?: (
            $this->assign('eTime', $req['eTime'])&
            $where['time'] = [
                [
                    'elt',
                    strtotime($req['eTime'])
                ]
            ]
        );
        !((isset($req['sTime']) && ($req['sTime'] != '')) && (isset($req['eTime']) && ($req['eTime'] != ''))) ?: (
            $this->assign('sTime', $req['sTime'])&
            $this->assign('eTime', $req['eTime'])&
            $where['time'] = [
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

        $limit = 15;
        $res   = $this->cModel->where($where)->order('updatetime DESC')->page($page . ',' . $limit)->select();
        $this->assign('res', $res);

        $count = $this->cModel->where($where)->count();
        $this->assign('num', $count);

        $Page = new \Think\Page($count, $limit);
        $Page->setConfig('header', '');
        $Page->setConfig('prev', 'Pre');
        $Page->setConfig('next', 'Next');
        $Page->setConfig('last', 'End');
        $Page->setConfig('first', 'First');
        $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = bootstrap_page_style($Page->show());
        $this->assign('page', $show);

        $this->display();
//        p($res,1);

    }

    private function resetChat()
    {
        $this->xkModel->RED->del([$this->ChatListPre]);
        if ($this->iniChatInfoToRed()) {
            echo 'done';
        }
    }

    private function iniChatInfoToRed()
    {
        if ($this->xkModel->RED->llen($this->ChatListPre) == 0) {
            $msgModel = new AutomessageController();
            if ($msgModel->iniChatInfoToRed()) {
                return true;
            }
        }
        return false;
    }

    public function addChatInfo()
    {
        if (IS_AJAX) {
            $req = I('');
            if (!empty($req)) {
                if (!empty($req['id'])) {
                    //update
                    $req['updateTime'] = time();
//                    p($req,1);
                    $res = $this->cModel->save($req);
                } else {
                    //addNew
                    $req['info'] = explode(',', str_replace("\n",",",$req['info']));
                    $sub = [];
                    foreach($req['info'] as $k =>$v) {
                        if (!empty($v)) {
                            $time = time();
                            $sub[$k] = [
                                'info'       => $v,
                                'level'      => $req['level'],
                                'addTime'    => $time,
                                'updateTime' => $time
                            ];
                        }
                    }
//                    p($sub,1);
                    $res = $this->cModel->addAll($sub);
//                    p($res,1);
                }

                if ($res) {
                    $code = 200;
                } else {
                    $code = 501;
                }
                $this->ajaxReturn([
                    'code'  => $code,
                ]);
            }
        }
        $req = I('get.id');
        $info = $this->cModel->where(['id'  => $req])->find();
//        p($info,1);
        if ($info) {
            $this->assign('info', $info);
        }
        $this->display('add');
    }

    public function del()
    {
        if (IS_POST) {
            $req = I('post.');
//            p($req,1);
            $res = $this->cModel->delete($req['id']);
            if ($res) {
                $this->ajaxReturn([
                    'code'  => 200
                ]);
            }
        } else {
            $this->ajaxReturn([
                'code'  => 501,
                'msg'   => 'Sys Error!'
            ]);
        }
    }

//    public function firLoadInfo()
//    {
//        $list = httpGet('http://api.icndb.com/jokes/');
//        if ($list['type'] = 'success') {
//            $listInfo = [];
//            $time = time();
//            foreach ($list['value'] as $k => $v) {
//                $listInfo[$k] = [
//                    'info'       => $v['joke'],
//                    'level'      => 1,
//                    'addTime'    => $time,
//                    'updateTime' => $time
//                ];
//            }
////            p($listInfo,1);
//            $cModel = new cModel();
//            echo $cModel->addAll($listInfo);
//        }
//    }

}