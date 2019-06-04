<?php

/**
 * @name ActionlogController
 * @info 描述：操作日志控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:02:04
 */

namespace Admin\Controller;

use Think\Controller;

class ActionlogController extends BaseDBController {

    public function _initialize() {
        parent::_initialize();
    }

    /**
     * 添加日志
     * @param type $controllerName
     * @param type $actionName
     * @param type $actionInfo
     * @return boolean
     */
    public function addLog($controllerName, $actionName, $actionInfo) {
        $data['c_name'] = $controllerName;
        $data['a_name'] = $actionName;
        $data['action_info'] = $actionInfo;

        if (session('realname') != NULL) {
            $data['user_name'] = session('realname');
        } elseif (session('usr') != NULL) {
            $data['user_name'] = session('usr');
        }else{
            $data['user_name'] = "超级管理员";
        }
        $data['ip'] = get_client_ip();
        $flag = M(C('DB_ACTION_LOG'))->add($data);
        if ($flag > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 显示日志列表
     */
    public function showLogList() {
        $model = M(C('DB_ACTION_LOG')); //实例化模型
        //生成查询条件
        if (!empty($_GET)) {
            if (!empty($_GET['keyword'])) {
                $where['user_name|c_name|a_name|action_info|ip'] = array('LIKE', '%' . urldecode($_GET['keyword']) . '%');
                $pageCondition['keyword'] = urldecode($_GET['keyword']);
            }
            if (empty($_GET['start_time'])) {
                $start_time = '1970-01-01 00:00:00';
            } else {
                $start_time = $_GET['start_time'];
                $pageCondition['start_time'] = $_GET['start_time'];
            }
            if (empty($_GET['end_time'])) {
                $end_time = '3000-01-01 00:00:00';
            } else {
                $end_time = $_GET['end_time'];
                $pageCondition['end_time'] = $_GET['end_time'];
            }
            $where['log_time'] = array('BETWEEN', $start_time . ',' . $end_time);
        }
        parent::showData($model, $where, $pageCondition, '', '');
    }

}
