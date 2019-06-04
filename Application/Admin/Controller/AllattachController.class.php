<?php

/**
 * @name AllattachController
 * @info 描述：附件操作控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:29:29
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Upload;

class AllattachController extends Controller {

    public function index() {
        $this->display();
    }

    /**
     * 上传文件并入库
     * @return string
     */
    public function uploadFileADb() {
        $model = M(C('DB_ALL_ATTACH'));
        $fileExt = $_POST['file_ext'];
        $moduleName = $_POST['module_name'];
        //以模块名作为附件的子目录
        $filePath = C('UPLOAD_ROOT') . '/' . $moduleName . '/';
        // 检查目录是否存在
        if (is_dir($filePath)) {
            // 检查目录是否可写
            if (!is_writable($filePath)) {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '目录不可写';
                return $returnData;
            }
        } else {
            // 新建目录
            mkdir($filePath, 0777, true);
        }
        $fileInfo = $this->uploadFile($fileExt, $moduleName);
        if ($fileInfo['flag'] == 'error') {
            $returnData['flag'] = 'error';
            $returnData['msg'] = '上传附件失败！';
        } else {
            $subName = ltrim($fileInfo['file']['savepath'], "."); //附件子子目录(日期)
            $path = C('UPLOAD_ROOT') . $subName . $fileInfo['file']['savename']; //该文件全路径
            $addData['module_name'] = $moduleName;
            $addData['file_path'] = $path;
            $addData['file_real_name'] = $fileInfo['file']['name'];
            $addData['file_ext'] = $fileInfo['file']['ext'];
            $addData['file_size'] = $fileInfo['file']['size'];
            $flag = $model->add($addData);
            if ($flag > 0) {
                $returnData['flag'] = 'success';
                $returnData['msg'] = '上传附件入库成功！';
                $returnData['att_id'] = $flag;
            } else {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '上传附件入库失败';
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 上传文件(内部接口)
     * @author:hellbao
     * @param $file_ext 设置附件上传类型
     * @param $save_path 设置附件上传目录
     * @return array 返回的上传文件信息
     */
    public function uploadFile($file_ext, $save_path) {
        $file_size = C('UPLOAD_SIZE');
        $sub_name = array('date', 'Y-m-d');
        $upload = new \Think\Upload(); //实例化上传类
        $ext_arr = C('UPLOAD_EXT');
        $upload->maxSize = $file_size; // 设置附件上传大小
        $upload->exts = $ext_arr[$file_ext]; // 设置附件上传类型
        $upload->rootPath = C('UPLOAD_ROOT'); // 设置附件上传根目录
        $upload->savePath = './' . $save_path . '/'; // 设置附件上传（子）目录
        $upload->autoSub = true;
        $upload->subName = $sub_name;
        $upload->callback = ture;
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $info['flag'] = 'error';
            $info['msg'] = $upload->getError();
            return $info;
        } else {
            $info['flag'] = 'success';
            return $info;
        }
    }

    public function uploadAttach() {
        $model = M(C('DB_ALL_ATTACH'));
        $fileExt = 'image';
        $moduleName = $_GET['module_name']; //"prop";
        //以模块名作为附件的子目录
        $filePath = C('UPLOAD_ROOT') . '/' . $moduleName . '/';
        // 检查目录是否存在
        if (is_dir($filePath)) {
            // 检查目录是否可写
            if (!is_writable($filePath)) {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '目录不可写';
                return $returnData;
            }
        } else {
            // 新建目录
            mkdir($filePath, 0777, true);
        }
        $fileInfo = $this->uploadFile($fileExt, $moduleName);
        if ($fileInfo['flag'] == 'error') {
            $returnData['flag'] = 'error';
            $returnData['msg'] = '上传附件失败！';
        } else {
            $subName = ltrim($fileInfo['file']['savepath'], "."); //附件子子目录(日期)
            $path = C('UPLOAD_ROOT') . $subName . $fileInfo['file']['savename']; //该文件全路径
            $addData['module_name'] = $moduleName;
            $addData['file_path'] = $path;
            $addData['file_real_name'] = $fileInfo['file']['name'];
            $addData['file_ext'] = $fileInfo['file']['ext'];
            $addData['file_size'] = $fileInfo['file']['size'];
            $flag = $model->add($addData);
            if ($flag > 0) {
                $returnData['flag'] = 'success';
                $returnData['msg'] = '上传附件入库成功！';
                $returnData['att_id'] = $flag;
                $returnData['url'] = $path;
            } else {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '上传附件入库失败';
            }
        }
        $this->ajaxReturn($returnData);
    }

    /**
     * 清除未绑定数据的图片数据和源文件
     */
    public function delAttachs() {
        $model = M(C('DB_ALL_ATTACH'));
        $selectArr = $model->where('module_info_id=0')->select();
        foreach ($selectArr as $v) {
            $path = C('UPLOAD_PATH') . $v['file_path'];
            if (unlink($path)) {
                $delFlag = $model->delete($v['id']);
                if ($delFlag > 0) {
                    echo $path . '<font color="green">-------删除成功！</font></br></br>';
                } else {
                    echo $path . '<font color="red">-------删除失败！</font></br></br>';
                }
            };
        }
        $this->success('删除成功', U('index/main'), 3);
    }

    /**
     * function:删除附件
     */
    public function delAttach() {
        $model = M(C('DB_ALL_ATTACH'));
        $condition['id'] = array('EQ', $_POST['id']);
        if ($model->where($condition)->delete() !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

}
