<?php

/**
 * @name ConfigdefController
 * @info 描述：系统配置字典控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:53:29
 */

namespace Admin\Controller;

use Think\Controller;

class ConfigdefController extends Controller {

    /**
     * 添加一条配置字典
     */
    public function addDef() {
        $model = M(C('DB_CONFIG_DEF'));
        $addData['sys_name'] = $_POST['sys_name'];
        $addData['set_key'] = $_POST['set_key'];
        $addData['set_value'] = $_POST['set_value'];
        $flag = $model->add($addData);
        if ($flag > 0) {
            $ajaxData['code'] = 500;
            $ajaxData['msg'] = '添加配置字典成功！';
        } else {
            $ajaxData['code'] = 502;
            $ajaxData['msg'] = '添加配置字典失败！';
        }
        $this->ajaxReturn($ajaxData);
    }

    /**
     * 修改配置字典信息
     */
    public function editDef() {
        $model = M(C('DB_CONFIG_DEF'));
        $updData['sys_name'] = $_POST['sys_name'];
        $updData['set_key'] = $_POST['set_key'];
        $updData['set_value'] = $_POST['set_value'];
        $flag = $model->where('id=' . $_POST['id'])->save($updData);
        if ($flag === FALSE) {
            $ajaxData['code'] = 502;
            $ajaxData['msg'] = '更新配置字典失败！';
        } else {
            $ajaxData['code'] = 500;
            $ajaxData['msg'] = '更新配置字典成功！';
        }
        $this->ajaxReturn($ajaxData);
    }

    /**
     * 删除一条配置字典
     */
    public function delDef() {
        $model = M(C('DB_CONFIG_DEF'));
        $flag = $model->delete($_GET['id']);
        if ($flag > 0) {
            $ajaxData['code'] = 500;
            $ajaxData['msg'] = '删除配置字典成功！';
        } else {
            $ajaxData['code'] = 502;
            $ajaxData['msg'] = '删除配置字典失败！';
        }
        $this->ajaxReturn($ajaxData);
    }

    /**
     * 回显一条配置字典信息
     */
    public function showDefById() {
        $model = M(C('DB_CONFIG_DEF'));
        $flag = $model->find($_GET['id']);
        if (!is_null($flag)) {
            $ajaxData['code'] = 500;
            $ajaxData['msg'] = $flag;
        } else {
            $ajaxData['code'] = 502;
            $ajaxData['msg'] = '回显配置字典失败！';
        }
        $this->ajaxReturn($ajaxData);
    }

    /**
     * 通过系统名称获取配置字典信息
     */
    public function getDefBySysname($sys_name) {
        $model = M(C('DB_CONFIG_DEF'));
        $flag = $model->where('sys_name="' . $sys_name . '"')->find();
        if (!is_null($flag)) {
            $ajaxData['code'] = 500;
            $ajaxData['msg'] = $flag;
        } else {
            $ajaxData['code'] = 502;
            $ajaxData['msg'] = '获取配置字典失败！';
        }
        return $ajaxData;
    }

    /**
     * 展示配置字典列表
     */
    public function showDefList() {
        $model = M(C('DB_CONFIG_DEF')); //实例化模型
        //生成查询条件
        $condition[] = array($_GET['set_key'], 'set_key', 'LIKE', 'b');
        $condition[] = array($_GET['set_value'], 'set_value', 'LIKE', 'b');
        $condition[] = array($_GET['sys_name'], 'sys_name', 'EQ');
        $where = creatWhere($condition);
        //分页
        $page = getPage($model, $where['where'], C('PAGE_SIZE'));
        $defList = $model->where($where['where'])->order("id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
        $page = $page->show();
        //分配数据
        $this->assign('page', $page);
        $this->assign('defList', $defList);
        $this->assign('assignWhere', $where['assignWhere']);
        //显示
        $this->display();
    }

    /**
     * 获取所有配置字典
     */
    public function getAllDef() {
        $model = M(C('DB_CONFIG_DEF')); //实例化模型
        $defList = $model->select();
        if(empty($defList)){
            return FALSE;
        }else{
            foreach ($defList as $key => $value) {
                $returnArr[$value['set_key']]=$value['set_value'];
            }
            return $returnArr;
        }
    }

}
