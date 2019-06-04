<?php

/**
 * @name SysPrivInfoController
 * @info 描述：系统权限信息控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;

class SysPrivInfoController extends BaseDBController {

    protected $catModel;
    protected $infoModel;

    public function _initialize() {
        parent::_initialize();
        $this->catModel = D('SysPrivCat');
        $this->infoModel = D('SysPrivInfo');
    }

    /**
     * function:显示权限信息列表
     */
    public function showList() {
        $fieldStr = parent::madField('sys_priv_info.*', 'sys_priv_cat.cat_name');
        $joinStr = parent::madJoin('sys_priv_info.cat_id', 'sys_priv_cat.id');
        parent::showData($this->infoModel, [], [], $joinStr, $fieldStr, $this->dbFix . 'sys_priv_cat.parent_id asc');
    }

    /**
     * function:保存权限信息
     * @return code(501验证未通过 500成功 502失败)
     */
    public function savePrivInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $returnData = parent::saveData($this->infoModel, $param_arr);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:根据ID查询某一条数据
     */
    public function findInfoById() {
        $returnData = parent::getData($this->infoModel, $_POST['id']);
        if ($returnData['code'] == '500') {
            if (!empty($returnData['data']['cat_id'])) {
                $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $returnData['data']['cat_id']))->find();
                $returnData['data']['category_name'] = $res['category_name'];
            } else {
                $returnData['data']['category_name'] = '所有分类';
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delPrivInfo($id) {
        $successFlag = true;
        $returnData = parent::delData($this->infoModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        }
        return $successFlag;
    }

    /**
     * function:批量删除数据
     */
    public function delArrPrivInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delPrivInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取权限分类下拉列表（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

    /**
     * 返回用户权限
     */
    public function getPriviledges() {
        if ($_SESSION['user_id'] != NULL) {
            $userPriv = M('SysPrivInfo')->field('pri_value')->select();
            foreach ($userPriv as $value) {
                $userPrivAll[] = $value['pri_value'];
            }
            $findArr = M('SysUserInfo')->where('id=' . $_SESSION['user_id'])->find();
            if (empty($findArr)) {
                $return['data'][] = '';
            } else {
                $userPrivMy = explode(',', rtrim($findArr['priviledges'] . $this->getGroupPriv($findArr['cat_id']), ','));
                $userPrivDiff = array_diff($userPrivAll, $userPrivMy);
                foreach ($userPrivDiff as $value) {
                    $return['data'][] = $value;
                }
            }
            $this->ajaxReturn($return);
        }
    }

    /**
     * 获取组权限
     * @param type $cat_id
     */
    public function getGroupPriv($cat_id) {
        $findArr = M('SysUserGroup')->where('id=' . $cat_id)->find();
        if (empty($findArr)) {
            return '';
        } else {
            return $findArr['priviledges'];
        }
    }

}
