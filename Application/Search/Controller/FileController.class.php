<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20
 * Time: 11:48
 */

namespace Search\Controller;


use Think\Controller;

class FileController extends Controller
{
    private $upModel;

    public function __construct()
    {
        parent::__construct();
        $setting = C('UPLOAD_FILE_QINIU');
        $this->upModel = new \Think\Upload($setting);
    }

    public function index(){
        if (IS_POST){
            $res = $this->saveFile();
            if ($res['status'] == 1){
                pLog($res);
                pLog($_FILES);
                //storeMysql
                $subData = [
                    'res_dirs'  => $res['info']->savepath,
                    'res_links' => $res['info']->savename,
                    'res_name'  => $_FILES['kartik-input-709[]']['name'],
                    'times'     => 0,
                    'show_times'=> rand(1000, 99999),
                    'status'    => 1,
                    'add_time'  => time(),
                    'user_id'   => 0,
                ];
                //storeRedis

                $this->ajaxReturn([
                    'code'  => 200,
                    'info'  => $subData
                ]);
            } else {
                $this->ajaxReturn([
                    'code'  => 500,
                    'msg'   => 'upload failed'
                ]);
            }
        } else {
            $this->ajaxReturn([
                'code'  => 400,
                'msg'   => 'Illegal request!'
            ]);
        }
    }

    public function saveFile(){
        $info = $this->upModel->upload($_FILES);

        if (!$info) {
            $data = ['status'=>0,'msg'=>'上传失败，'.$this->upModel->getError()];
        } else {
            $data = [
                'status'=> 1,
                'info'  => $info
            ];
        }
        return $data;
    }


    public function deleteFile(){
//        $setting = C('UPLOAD_FILE_QINIU');
//
//        $file_name = I('post.file_name');//要删除的文件名称
//
//        $Qiniu = new \Think\Upload\Driver\Qiniu\QiniuStorage($setting['driverConfig']);
//
//        $result = $Qiniu->del($file_name);
//
//        $error = $Qiniu->errorStr;//错误信息
//
//        if(is_array($result) && !($error))
//        {
//            $data = ['status'=>1,'msg'=>'删除文件成功'];
//        }
//        else
//        {
//            $data = ['status'=>0,'msg'=>'删除文件失败，'.$error];
//        }
//
//        echo json_encode($data);
//
//        exit;
    }
}