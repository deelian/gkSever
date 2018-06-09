<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 11:01
 */

namespace Home\Controller;

use Home\Model\ResModel;
class IndexController extends XkController
{
    //资源前缀
    protected $redPre = 'Resource:ResInfo:';

    /**
     * 数据虚拟化
     */
    public function init(){
        ini_set('max_execution_time', 0);
        $resM = new ResModel();
        $start = I('get.start');
        $end = 208888;
        for ($i = $start; $i<=$end; $i++){
            $info = $resM->getDetail($i);

            if ($info){
                $res = $this->RED->hmset($this->redPre.$i, $info);
            }

            if($res == 'OK'){
                $l = (($i/$end)*100).'%';
                pLog("写入成功！当前写入第$i 条，总共$end 条，完成度$l");
            }
        }

    }

    /**
     * 虚拟数据重置
     */
    public function reSet(){
        $this->RED->flushall();
        $this->init();
    }

    public function index(){
        $data = '9';        // 被加密信息
        $encrypt = encrypt($data);
        $decrypt = decrypt($encrypt);
        echo $encrypt, "\n", $decrypt;
    }


}