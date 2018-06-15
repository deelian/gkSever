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
    protected $redPre;

    public function __construct()
    {
        parent::__construct();
        $this->redPre = C('REDIS_PRE');
    }

    /**
     * 数据虚拟化
     */
    public function init($start){
        ini_set('max_execution_time', 0);
        $resM = new ResModel();
//        $start = I('get.start');
        $end = 208889;
        for ($i = $start; $i<=$end; $i++){
            $info = $resM->getDetail($i);

            if ($info){
                $res = $this->RED->hmset($this->redPre.$i, $info);
            }

            if($res == 'OK'){
                $l = ceil(($i/$end)*100).'%';
                pLog("写入成功！当前写入第$i 条，总共$end 条，完成度$l");
            }
        }

    }

    /**
     * 虚拟数据重置
     */
    public function reSet($start){
        $this->RED->flushall();
        $this->init($start);
    }

    /**
     * 获取详情
     * @param $data
     * @return array
     */
    public function getInfo($data){
        $res = $this->RED->hgetall(C('REDIS_PRE').decrypt($data));
//        $res = $this->RED->hgetall(C('REDIS_PRE').'2088897');
        if (empty($res)){
            return [
                'code'  => 400
            ];
        } else {
            if (!empty($res['res_desc'])){
                $res['res_desc'] = explode('|', $res['res_desc']);
            }
            array_pop($res['res_desc']);
            return [
                'code'  => 200,
                'info'  => $res
            ];
        }
    }


}