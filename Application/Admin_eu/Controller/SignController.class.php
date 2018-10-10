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
        $this->verify = A('Verify');
    }

    /**
     * signPage
     */
    public function index()
    {
        session('loginId',24);
//        p(U('Admin/index'),1);
        $this->redirect('Admin/index');
//        $this->display();
    }


    public function loginCheck()
    {
        if (IS_AJAX) {
//			 $this->ajaxReturn(I());
            // echo "string";
            if($this->verify->checkVerify(I('subData')['verify'])){

                $admin 		= M('admin');
                $res 		= $admin->where(['account'=>I('subData')['account']])->find();

                pLog($res, I('subData')['account']);
                if($res['passwd'] == md5(I('subData')['passwd'])){
                    session('loginId', $res['id']);
                    jRet([
                        'code'	=> '200',
                        'msg'	=> 'Verification passed! Entering the system...',
                        'url'	=> U('Index/index')
                    ]);
                }else{
                    jRet([
                        'code'	=> '502',
                        'msg'	=> 'Incorrect username or password! Please try again...',
                        'url'	=> U('Login/index')
                    ]);
                }
            }else{
                jRet([
                    'code'	=> '501',
                    'msg'	=> 'Verification code input is incorrect!'
                ]);
            }
        } else {
            $this->display();
        }
    }


    public function loginOut(){
        session('loginId', null);
//        p(U('Sign/index'),1);
        $this->redirect('Sign/index');
    }

}