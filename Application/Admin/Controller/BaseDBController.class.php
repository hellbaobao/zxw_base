<?php

/**
 * @name BaseDBController
 * @info 描述：基础数据库控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:29:29
 */

namespace Admin\Controller;

use Think\Controller;

class BaseDBController extends Controller {

    protected $dbFix;

    public function _initialize() {
        //配置字典信息
        $configdefC = A('Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);
        $this->dbFix = $this->config['db_fix'];
        //初始化do something
    }

    public function showData($model, $where, $pageCondition, $joinStr, $fieldStr, $order = null) {
        $page = getPage($model, $where, $pageCondition, C('PAGE_SIZE'));
        if ($order != null) {
            $infoList = $model->join($joinStr)->field($fieldStr)->where($where)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();
        } else {
            $infoList = $model->join($joinStr)->field($fieldStr)->where($where)->order('id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
        }
        $page = $page->show();
        $this->assign('page', $page);
        $this->assign('searchInfo', $pageCondition);
        $this->assign('infoList', $infoList);
//        dump($model->getLastSql());
//        dump($infoList);
        $this->display();
    }

    /**
     * function:保存数据
     * @param $model
     * @param $Array
     * @return mixed
     */
    public function saveData($model, $Array) {
        if (!$model->create($Array)) {
            $returnData['code'] = '501'; //验证未通过
            $returnData['msgError'] = $model->getError();
        } else {
            if (empty($Array['id'])) {
                $result = $model->add($Array); //数据写入
                $returnData['dataID'] = $result;
                $returnData['flag'] = 'add';
            } else {
                $result = $model->save($Array); //数据更新
                $returnData['flag'] = 'edit';
            }
            if ($result !== false) {
                $returnData['code'] = '500';
            } else {
                $returnData['code'] = '502';
            }
        }
        return $returnData;
    }

    /**
     * function:删除单条数据
     * @param $model
     * @param $id
     * @return mixed
     */
    public function delData($model, $id) {
        $condition['id'] = array('EQ', $id);
        if ($model->where($condition)->delete() !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
    }

    /**
     * function:批量删除数据
     * @param $model
     * @param $str
     */
    public function delArrayData($model, $str) {
        $model->delete($str);
    }

    /**
     * function:根据条件设置某个字段的值
     * @param $condition
     * @param $data
     * @return mixed
     */
    public function setFieldData($condition, $data) {
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
    }

    /**
     * function:根据条件设置某个字段的值
     * @param $model
     * @param $condition
     * @param $data
     * @return mixed
     */
    public function setField($model, $condition, $data) {
        $result = $model->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
    }

    /**
     * function:根据条件获取值
     * @param $condition
     * @param $data
     * @return mixed
     */
    public function getDataByWhere($model, $condition, $type = 'all') {
        if ($type == 1) {
            $result = $model->where($condition)->find();
        } else {
            $result = $model->where($condition)->select();
        }
        if ($result !== false) {
            $returnData['code'] = '500';
            $returnData['data'] = $result;
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
    }

    /**
     * function:获取某一条数据By ID
     * @param $model
     * @param $id
     * @return mixed
     */
    public function getData($model, $id) {
        $condition['id'] = array('EQ', $id);
        $result = $model->where($condition)->find();
        if (isset($result)) {
            $returnData['code'] = '500';
            $returnData['data'] = $result;
        } else {
            $returnData['code'] = '502';
        }
        return $returnData;
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

    public function madField($field0, $field1) {
        return $this->dbFix . $field0 . ',' . $this->dbFix . $field1;
    }

    public function madJoin($join0, $join1) {
        $arr = explode('.', $this->dbFix . $join1);
        return 'left join ' . $arr[0] . ' on ' . $this->dbFix . $join0 . ' = ' . $this->dbFix . $join1;
    }

}
