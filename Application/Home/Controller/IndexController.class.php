<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 11:01
 */

namespace Home\Controller;

use Home\Model\ResModel;
use Search\Model\MessageModel;

class IndexController extends XkController
{
    //资源前缀
    protected $redPre;

    public function __construct()
    {
        parent::__construct();
        $this->redPre = C('REDIS_PRE');
    }

    public function msg(){
        $msgModel = new MessageModel();
        p($msgModel->getUserMsg());
    }

    /**
     * 数据虚拟化
     *
     * @param $start
     */
    public function init($start = 1)
    {
        ini_set('max_execution_time', 0);
        $resM = new ResModel();
//        $start = I('get.start');
        $all = new ListController();
        $end = $all->getResTotal();

        $start = (int)$start;
        for ($i = $start; $i<=$end; $i++){
            $info = $resM->getDetail($i);
            if ($info){
                $res = $this->RED->hmset($this->redPre.$i, $info);
                if($res == 'OK'){
                    $l = ceil(($i/$end)*100).'%';
                    pLog("写入成功！当前写入第$i 条，总共$end 条，完成度$l");
                }
            }
        }
        echo 'done!';
    }

    /**
     * 虚拟数据重置
     *
     * @param int $start
     */
    public function reSet($start = 1){
        $this->RED->flushall();
        $this->init($start);
    }

    /**
     * 获取详情
     *
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
                //filterUselessInfo
                foreach ($res['res_desc'] as $k => $v) {
                    if (strlen(strstr($v, '果您看到此文件，请升级到BitComet(比特彗')) > 0) {
                        unset($res['res_desc'][$k]);
                    }
                }
            }
            array_pop($res['res_desc']);
            return [
                'code'  => 200,
                'info'  => $res
            ];
        }
    }

    /**
     * New Res Insert
     * @param $data
     * @return mixed
     */
    public function insertRes($data){
        return $this->RED->hmset($this->redPre.$data['id'], $data);
    }


}