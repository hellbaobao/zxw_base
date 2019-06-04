<?php

/**
 * @name SysPrivCatController
 * @info 描述：系统权限分类控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;

class SysPrivCatController extends BaseDBController {

    protected $catModel;
    protected $infoModel;

    public function _initialize() {
        parent::_initialize();
        $this->catModel = D('SysPrivCat');
        $this->infoModel = M('SysPrivInfo');
    }

    /**
     * function:显示权限分类列表
     */
    public function showList() {
        $fatherCat = $this->catModel->where('parent_id=0')->order('id asc')->select();
        foreach ($fatherCat as $v) {
            $v['catType'] = 'father';
            $v['cat_name'] = "<b>" . $v['cat_name'] . "</b>";
            $v['priInfo'] = array();
            $infoList[] = $v;
            $sonCat = $this->catModel->where('parent_id=' . $v['id'])->select();
            foreach ($sonCat as $value) {
                $priInfoList = $this->infoModel->where('cat_id=' . $value['id'])->select();
                $value['cat_name'] = '&#12288;&#12288;|--' . $value['cat_name'];
                $value['catType'] = 'son';
                $value['priInfo'] = $priInfoList;
                $infoList[] = $value;
            }
        }
        $this->assign('infoList', $infoList);
        $this->display();
    }

//    /**
//     * function:显示某一分类下权限信息列表
//     */
//    public function getInfoListByCatId() {
//        $catId = $_POST['cat_id'];
//        $fieldStr = parent::madField('sys_priv_info.*', 'sys_priv_cat.cat_name');
//        $joinStr = parent::madJoin('sys_priv_info.cat_id', 'sys_priv_cat.id');
//        $where[$this->dbFix . 'sys_priv_info.id'] = array('EQ', $catId);
//        $infoList = parent::getListData($this->infoModel, $where, $joinStr, $fieldStr);
//        $this->ajaxReturn($infoList, 'JSON');
//    }

    /**
     * function:获取权限分类下拉列表（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

    /**
     * function:添加/编辑权限分类
     * @return code(501验证未通过 500成功 502失败)
     */
    public function savePrivCat() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $returnData = parent::saveData($this->catModel, $param_arr);
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:根据ID查询某一条数据
     */
    public function findInfoById() {
        $condition['id'] = array('EQ', $_POST['id']);
        $result = $this->catModel->where($condition)->find();
        if (isset($result)) {
            if (!empty($result['parent_id'])) {
                $res = $this->catModel->field(array('cat_name' => 'category_name'))->where(array('id' => $result['parent_id']))->find();
                $result['category_name'] = $res['category_name'];
            } else {
                $result['category_name'] = '所有分类';
            }
            $returnData['code'] = '500';
            $returnData['data'] = $result;
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * function:删除权限分类及分类下的权限信息
     */
    public function delSysPrivCat() {
        $condition['id'] = array('EQ', $_POST['id']);
        $catInfo = $this->catModel->where($condition)->find(); //获取某条分类信息(ID)
        $childCatArray = $this->catModel->where(array('parent_id_path' => array('LIKE', $catInfo['parent_id_path'] . $catInfo['id'] . '.%')))->select();
        if (count($childCatArray) > 0) {
            foreach ($childCatArray as $value) {
                $noticeInfoList = $this->infoModel->where(array('cat_id' => $value['id']))->select();
            }
        }
        if (false !== $this->catModel->where($condition)->delete()) {
            if (count($childCatArray) > 0) {
                foreach ($childCatArray as $value) {
                    $this->catModel->where(array('id' => $value['id']))->delete();
                }
            }
            if (count($noticeInfoList) > 0) {
                foreach ($noticeInfoList as $value) {
                    $this->catModel->where(array('id' => $value['id']))->delete();
                }
            }
            $returnData['code'] = '500';
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    public function delArrayCat() {
        $this->catModel->delete(rtrim($_POST['ids'], ",")); // 删除主键为ids的数据
    }

}
