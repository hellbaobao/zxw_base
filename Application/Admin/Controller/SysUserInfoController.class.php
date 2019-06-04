<?php

/**
 * @name SysUserInfoController
 * @info 描述：系统用户信息控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Controller;

use Think\Controller;

class SysUserInfoController extends BaseDBController {

    protected $groupModel;
    protected $userInfoModel;
    protected $privCatModel;
    protected $privInfoModel;

    /**
     * 初始化函数
     */
    public function _initialize() {
        parent::_initialize();
        $this->groupModel = D('SysUserGroup');
        $this->userInfoModel = D('SysUserInfo');
        $this->privCatModel = D('SysPrivCat');
        $this->privInfoModel = D('SysPrivInfo');
    }

    /**
     * 显示管理员用户列表
     */
    public function showList() {
        $address_id = $_SESSION['address_id'];
        if ($_SESSION['address_id'] != 0) {
            $where['address_id'] = array('EQ', $_SESSION['address_id']);
            $pageCondition['address_id'] = urldecode($_SESSION['address_id']);
        }
        if (!empty($_GET['usr'])) {
            $where['usr'] = array('LIKE', '%' . urldecode($_GET['usr']) . '%');
            $pageCondition['usr'] = urldecode($_GET['usr']);
        }
        if (!empty($_GET['cat_id'])) {
            $where['cat_id'] = array('EQ', $_GET['cat_id']);
            $pageCondition['category_name'] = urldecode($_GET['category_name']);
            $pageCondition['cat_id'] = $_GET['cat_id'];
        }
        $fieldStr = parent::madField('sys_user_info.*', 'sys_user_group.cat_name');
        $joinStr = parent::madJoin('sys_user_info.cat_id', 'sys_user_group.id');
        parent::showData($this->userInfoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:保存用户信息
     */
    public function saveUserInfo() {
        if (IS_POST) {
            $param_arr = array();
            $form_data = $_POST['form_data'];
            parse_str($form_data, $param_arr); //转换数组
            $param_arr['pwd'] = R('Login/EncriptPWD', array($param_arr['pwd'])); //密码加密
            $param_arr['repwd'] = R('Login/EncriptPWD', array($param_arr['repwd'])); //密码加密
            $param_arr['token_num'] = make_char('m');
            $returnData = parent::saveData($this->userInfoModel, $param_arr);
            $logC = A('Actionlog')->addLog('SysUserInfo', 'saveUserInfo', '添加/编辑用户信息');
            $this->ajaxReturn($returnData, 'JSON');
            exit;
        }
        $this->assign('priv', $this->getPriviledges());
        $this->display();
    }

    /**
     * function:保存用户信息
     */
    public function saveUserMyInfo() {
        if (IS_POST) {
            $param_arr = array();
            $form_data = $_POST['form_data'];
            parse_str($form_data, $param_arr); //转换数组
            foreach ($param_arr as $k => $v) {
                if ($param_arr[$k] == null) {
                    unset($param_arr[$k]);
                }
            }
            $returnData = parent::saveData($this->userInfoModel, $param_arr);
            $this->ajaxReturn($returnData, 'JSON');
            exit;
        } else {
            $userInfo = M('SysUserInfo')->where('id=' . $_SESSION['user_id'])->find();
            $this->assign('userInfo', $userInfo);
            $this->display();
        }
    }

    /**
     * function:跳转编辑页面
     */
    public function edit() {
        $this->getUserInfo($_GET['id']);
        $this->display('editUserInfo');
    }

    public function editUserInfo() {
        if (IS_POST) {
            $param_arr = array();
            $form_data = $_POST['form_data'];
            parse_str($form_data, $param_arr); //转换数组
            $returnData = parent::saveData($this->userInfoModel, $param_arr);
            $this->ajaxReturn($returnData, 'JSON');
            exit;
        }
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function delUserInfo($id) {

        $successFlag = true;
        $returnData = parent::delData($this->userInfoModel, $id);

        if ($returnData['code'] == '502') {
            $successFlag = fasle;
        } 
        return $successFlag;
    }

    /**
     * function:批量删除数据
     */
    public function delArrUserInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->delUserInfo($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('SysUserInfo', 'delArrUserInfo', '删除用户信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取信息
     */
    public function getData() {
        $returnData = parent::getData($this->userInfoModel, $_POST['id']);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:获取用户信息
     * @param $id
     */
    public function getUserInfo($id) {
        $returnData = parent::getData($this->userInfoModel, $id);
        if ($returnData['code'] == '500') {
            $returnData['data']['category_name'] = $this->getCatName($returnData['data']['cat_id']);
            $this->assign('priv', $this->getPriviledges());
            $this->assign('userInfo', $returnData['data']);
        } else {
            $this->assign();
        }
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
     * function:添加用户时，返回初始化选择用户组权限值
     */
    public function getGroupPrivInfo() {
        $returnData = parent::getData($this->groupModel, $_POST['id']);
        $this->ajaxReturn($returnData, 'JSON');
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

    /**
     * 通过分类id获取分类信息
     * @param type $cat_id
     * @return int
     */
    public function getCatInfoByCid($cat_id) {
        $userModel = M(C('DB_USER_GROUP'));
        $catArr = $userModel->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr;
        }
    }

}
