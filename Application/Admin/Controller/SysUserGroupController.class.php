<?php

/**
 * @name SysUserGroupController
 * @info 描述：系统用户角色控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Controller;

use Think\Controller;

class SysUserGroupController extends BaseDBController {

    protected $groupModel;
    protected $userInfoModel;
    protected $privCatModel;
    protected $privInfoModel;

    public function _initialize() {
        $this->groupModel = D('SysUserGroup');
        $this->userInfoModel = D('SysUserInfo');
        $this->privCatModel = D('SysPrivCat');
        $this->privInfoModel = D('SysPrivInfo');
    }

    /**
     * function:显示用户组列表
     */
    public function showList() {
        parent::showData($this->groupModel, [], [], '', '');
    }

    public function saveUserGroup() {
        $this->assign('priv', $this->getPriviledges());
        $this->display();
    }

    /**
     * function:跳转编辑页面
     */
    public function edit() {
        $returnData = parent::getData($this->groupModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            $returnData['data']['category_name'] = $this->getCatName($returnData['data']['parent_id']);
            $this->assign('priv', $this->getPriviledges());
            $this->assign('userGroupInfo', $returnData['data']);
        } else {
            $this->assign();
        }
        $this->display('saveUserGroup');
    }

    /**
     * function:保存用户组信息
     */
    public function saveUserGroupInfo() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $returnData = parent::saveData($this->groupModel, $param_arr);
        if ($returnData['code'] == '500') {
            if (!empty($param_arr['id'])) {//编辑用户是否禁用
                $condition['cat_id'] = $param_arr['id'];
                $userInfo = $this->userInfoModel->where($condition)->select();
                if (is_array($userInfo) && count($userInfo) > 0) {
                    foreach ($userInfo as $key => $value) {
                        $where['id'] = $value['id'];
                        $data['is_enable'] = $param_arr['is_enable'];
                        $this->userInfoModel->where($where)->setField($data);
                    }
                }
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delUserGroup($id) {
        $successFlag = true;
        $returnData = parent::delData($this->groupModel, $id);
        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        } else {
            $condition['cat_id'] = $id;
            $userInfo = $this->userInfoModel->where($condition)->select();
            foreach ($userInfo as $key => $value) {
                parent::delData($this->userInfoModel, $value['id']);
            }
        }
        return $successFlag;
    }

    /**
     * function:批量删除数据
     */
    public function delArrUserGroup() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delUserGroup($value)) {
                $returnData['code'] = '502';
            }
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:返回权限信息
     * @return mixed
     */
    public function getPriviledges() {
        $condition['parent_id'] = array('EQ', 0);
        $result = $this->privCatModel->where($condition)->select();
        foreach ($result as $key => $value) {
            $childrenResult = $this->privCatModel->where(array('parent_id' => $value['id']))->select();
            foreach ($childrenResult as $key1 => $value1) {
                $childrenResult[$key1]['children'] = $this->privInfoModel->where(array('cat_id' => $value1['id']))->select();
            }
            $result[$key]['children'] = $childrenResult;
        }
        return $result;
    }

    /**
     * function:获取通知列表彈出框中（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->groupModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

    /**
     * function:获取信息中所属分类名称
     * @param $cat_id
     * @return string
     */
    public function getCatName($cat_id) {
        if (!empty($cat_id)) {
            $res = $this->groupModel->field(array('cat_name' => 'category_name'))->where(array('id' => $cat_id))->find();
            $category_name = $res['category_name'];
        } else {
            $category_name = '所有分类';
        }
        return $category_name;
    }

}
