<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/30
 * Time: 15:08
 */

namespace Home\Controller;


class UserController extends XkController
{
    private $userLockPre;

    public function __construct()
    {
        parent::__construct();
        $this->userLockPre = C('USER_LOCK_PRE');
    }

    public function userLock($ip){
        $this->RED->set($this->userLockPre.$ip,1);
        $this->RED->expire($this->userLockPre.$ip,10);
    }

    public function getUserStatus($ip){
        return $this->RED->get($this->userLockPre.$ip);
    }
}