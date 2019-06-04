<?php

/**
 * @name BaseController
 * @info 描述：公共控制器
 * @author xiaohuihui <2568514154@qq.com>
 * @datetime 2018-04-28 12:05:00
 */

namespace Home\Controller;

use Think\Controller;

header('Access-Control-Allow-Origin:*');  //支持全域名访问，不安全，部署后需要固定限制为客户端网址
header('Access-Control-Allow-Methods:POST,GET'); //支持的http 动作
header('Access-Control-Allow-Headers:x-requested-with,content-type');  //响应头 请按照自己需求添加。

class BaseController extends Controller {

//------------------------------------------------------------------------------
    protected $config;
    protected $dbFix;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Admin/Configdef');
        $this->config = $configdefC->getAllDef();
        $this->dbFix = $this->config['db_fix'];
        $this->assign('config', $this->config);
    }

   /**
     * function:获取某一条数据By ID
     * @param $model
     * @param $id
     * @return mixed
     */
    public function getDataKey($model, $id, $key) {
        $condition['id'] = array('EQ', $id);
        $result = $model->where($condition)->find();
        if (isset($result)) {
            $returnData = $result[$key];
        } else {
            $returnData = 'error';
        }
        return $returnData;
    }
    
    /**
     * 获取附件
     * @param type $activ_id
     * @return type
     */
    public function getAttachArr($key,$id) {
        $model = M(C('DB_ALL_ATTACH'));
        $selectArr = $model->where('module_name="' . $key . '" and module_info_id=' . $id)->select();
        if (empty($selectArr)) {
            $returnData['flag'] = 0;
        } else {
            $returnData['flag'] = 1;
            for ($i = 0; $i < count($selectArr); $i++) {
                $data[$i]['url'] = $selectArr[$i]['file_path'];
                $data[$i]['id'] = $selectArr[$i]['id'];
            }
            $returnData['data'] = $data;
        }
        return $returnData;
    }

}
