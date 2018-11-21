<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/9
 * Time: 17:35
 */
namespace Admin_eu\Controller;


use Think\Controller;

class SignController extends Controller
{
    private $verify;

    public function __construct()
    {
        parent::__construct();
//        $this->verify = A('Verify');
    }

    /**
     * signPage
     */
    public function index()
    {
        if (IS_POST) {
            if (I('get.code')) {
                $admin = M('admin');
                if (($res = $admin->where(['account' => I('get.code')])->find()['passwd']) == md5(md5(I('pass')))) {
                    session('loginId',I('get.code'));
                    $this->ajaxReturn([
                        'code'  => 200,
                        'url'   => U('/Admin_eu/admin'),
                        'msg'   => 'Logged in successfully'
                    ]);
                }
            }
            //retFalse
            $this->ajaxReturn([
                'code'  => 205,
                'url'   => '/Login.jsp',
                'msg'   => 'Sigh Failure'
            ]);
        }
        if (!empty(session('loginId'))) {
            $this->redirect(U('/Admin_eu/admin', '', false));
        }

        $lists = [
            'String.fromCharCode(34+Math.random()*33)',
            'parseInt(2*Math.random())',
            'String.fromCharCode(3e4+Math.random()*33)'
        ];
        $k = rand(0, 2);
        $type = $lists[$k];
        $this->assign('type', $type);

        $this->display();
    }

    public function set()
    {
        if (I('get.code') == 'init') {
            $admin = M('admin');
            $res   = $admin->add([
                'account'    => 'deelian',
                'passwd'     => md5(md5('xinduanlian')),
                'login_ip'   => get_client_ip(),
                'last_login' => get_client_ip(),
                'add_time'   => time()
            ]);
            if ($res) {
                $this->ajaxReturn([
                    'code' => 200,
                    'msg'  => 'init successfully!'
                ]);
            } else {
                echo 'nil';
            }
        } else {
            echo 'nil';
        }

    }

//    public function loginCheck()
//    {
//        if (IS_AJAX) {
////			 $this->ajaxReturn(I());
//            // echo "string";
//            if($this->verify->checkVerify(I('subData')['verify'])){
//
//                $admin 		= M('admin');
//                $res 		= $admin->where(['account'=>I('subData')['account']])->find();
//
//                pLog($res, I('subData')['account']);
//                if($res['passwd'] == md5(I('subData')['passwd'])){
//                    session('loginId', $res['id']);
//                    jRet([
//                        'code'	=> '200',
//                        'msg'	=> 'Verification passed! Entering the system...',
//                        'url'	=> U('Index/index')
//                    ]);
//                }else{
//                    jRet([
//                        'code'	=> '502',
//                        'msg'	=> 'Incorrect username or password! Please try again...',
//                        'url'	=> U('Login/index')
//                    ]);
//                }
//            }else{
//                jRet([
//                    'code'	=> '501',
//                    'msg'	=> 'Verification code input is incorrect!'
//                ]);
//            }
//        } else {
//            $this->display();
//        }
//    }


    public function loginOut($code){
        session('loginId', null);
        $this->redirect("/Login", ['code'=>$code]);
    }

}