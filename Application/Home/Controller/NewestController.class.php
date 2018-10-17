<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/16
 * Time: 17:28
 */

namespace Home\Controller;


class NewestController extends XkController
{
    private $newestPre;

    public function __construct()
    {
        parent::__construct();
        $this->newestPre = C('TOP_PRE').'Newest';
    }

    /**
     * init
     *
     * @return bool
     */
    public function initNewestLists()
    {
        //clearListKey
        $this->RED->del([$this->newestPre]);

        $all = new ListController();
        $total = $all->getResTotal();
//        p($total);
        for ($i = 0; $i < 10; $i++) {
            $res = $this->RED->hgetall(C('REDIS_PRE').($total - $i));
            $temp = [
                'id'       => $res['id'],
                'time'     => $res['add_time'],
                'res_name' => $res['res_name']
            ];
//            $newest[$i] = $temp;
            $this->RED->lpush($this->newestPre, json_encode($temp));
        }

//        $newest = json_encode($newest);
//        p($newest);
        return true;
    }

    /**
     * getLists
     *
     * @return array
     */
    public function getNewestLists()
    {
        $res = $this->RED->lrange($this->newestPre,0,-1);
        if (empty($res)) {
            $this->initNewestLists();
            $this->getNewestLists();
        }
        p($res,1);
        return $res;
    }

    /**
     * pushInLists
     *
     * @param $data
     * @return bool
     */
    public function pushNewestLists($data = [])
    {
//        $data = [
//            'id'    => 11,
//            'time'  => 'tt',
//            'res_name'  => 'dee'
//        ];
        $res = $this->RED->lrange($this->newestPre,0,-1);
        if (empty($res)) {
            $this->initNewestLists();
            $this->pushNewestLists($data);
        }
        if (empty($data)) {
            return false;
        }

        $data = json_encode($data);
        if ($this->RED->lpushx($this->newestPre, $data) && $this->RED->ltrim($this->newestPre, 0, 9)) {
            return true;
        } else {
            return false;
        }
    }
}