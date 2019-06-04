<?php

/**
 * @name @bname@InfoController
 * @info 描述：@bname@信息控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Config;
use QL\QueryList;

class @bname@InfoController extends BaseDBController {

    protected $catModel;
    protected $infoModel;
    protected $attachModel;

    public function _initialize() {
        parent::_initialize();

        $this->catModel = D('@bname@Cat');
        $this->infoModel = D('@bname@Info');
        $this->attachModel = D('SysAllAttach');
    }

    /**
     * function:显示@bname@信息列表
     */
    public function showList() {
        if (!empty($_GET['title'])) {
            $where['title'] = array('LIKE', '%' . urldecode($_GET['title']) . '%');
            $pageCondition['title'] = urldecode($_GET['title']);
        }
        if (!empty($_GET['cat_id'])) {
            $where[$this->dbFix . '@sname@_info.cat_id'] = array('EQ', $_GET['cat_id']);
            $pageCondition['category_name'] = urldecode($_GET['category_name']);
            $pageCondition['cat_id'] = $_GET['cat_id'];
        }
        $fieldStr = parent::madField('@sname@_info.*', '@sname@_cat.cat_name') . ',' . parent::madField('sys_user_info.usr', 'sys_user_info.realname');
        $joinStr = parent::madJoin('@sname@_info.cat_id', '@sname@_cat.id') . ' ' . parent::madJoin('@sname@_info.user_id', 'sys_user_info.id');
        parent::showData($this->infoModel, $where, $pageCondition, $joinStr, $fieldStr);
    }

    /**
     * function:跳转添加页面
     */
    public function add() {
        $this->assign('address_id', $_SESSION['address_id']);
        $this->display();
    }

    /**
     * function:编辑@bname@信息
     */
    public function edit() {
        $this->assign('address_id', $_SESSION['address_id']);
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        if ($returnData['code'] == '500') {
            if (!empty($returnData['data']['cat_id'])) {
                $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $returnData['data']['cat_id']))->find();
                $returnData['data']['category_name'] = $res['category_name'];
                $condition['module_info_id'] = array('EQ', $returnData['data']['id']);
                $condition['module_name'] = array('EQ', '@sname@');
                $attachList = $this->attachModel->where($condition)->select(); //if(is_array($res) && count($res)>0)
                $this->assign('attachList', json_encode($attachList));
//                dump($attachList);
            } else {
                $returnData['data']['category_name'] = '所有分类';
            }
            $this->assign('@sname@Info', $returnData['data']);
        } else {
            $this->assign();
        }
        $this->display('add');
    }

    /**
     * function:保存@bname@信息
     * @return $returnData(501验证未通过 500添加成功 502添加失败)
     */
    public function save@bname@Info() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $param_arr['user_id'] = $_SESSION['user_id'];
        $param_arr['read_ids'] = ',';
        $returnData = parent::saveData($this->infoModel, $param_arr);
        if ($returnData['code'] == '500') {
            foreach ($param_arr['files'] as $value) {
                $condition['id'] = array('EQ', $value);
                if ($returnData['flag'] == 'add') {
                    $data = array('module_info_id' => $returnData['dataID']);
                } else {
                    $data = array('module_info_id' => $param_arr['id']);
                }
                $this->attachModel->where($condition)->setField($data);
            }
            $logC = A('Actionlog')->addLog('@bname@Info', 'save@bname@Info', '添加/编辑@bname@信息');
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除单条数据
     * @param $id
     * @return bool
     */
    public function del@bname@Info($id) {
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
    public function delArrayInfo() {
        $returnData['code'] = '500';
        $idArray = explode(',', rtrim($_POST['ids'], ","));
        foreach ($idArray as $value) {
            if (!$this->del@bname@Info($value)) {
                $returnData['code'] = '502';
            }
        }
        $logC = A('Actionlog')->addLog('@bname@Info', 'delArrayInfo', '删除@bname@信息');
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:发布
     */
    public function publ@bname@Info() {
        $condition['id'] = array('EQ', $_POST['id']);
        $data = array('is_publish' => '1');
        $result = $this->infoModel->where($condition)->setField($data);
        if ($result !== false) {
            $returnData['code'] = '500';
            $logC = A('Actionlog')->addLog('@bname@Info', 'publ@bname@Info', '发布@bname@信息');
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:@bname@详情
     */
    public function detail() {
        $returnData = parent::getData($this->infoModel, $_GET['id']);
        $sysUserInfo = D('SysUserInfo')->where(array('id' => $returnData['data']['user_id']))->find();
        $returnData['data']['usr'] = (!empty($sysUserInfo['realname']) ? $sysUserInfo['realname'] : $sysUserInfo['usr']);


        $condition['module_info_id'] = $returnData['data']['id'];
        $condition['module_name'] = array('EQ', '@sname@');
        $imgInfoList = $this->attachModel->where($condition)->order('id desc')->select();
        $this->assign('imgInfo', $imgInfoList);


        $this->assign('@sname@', $returnData['data']);
        $this->display();
    }

    /**
     * function:获取@bname@列表彈出框中（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

}
