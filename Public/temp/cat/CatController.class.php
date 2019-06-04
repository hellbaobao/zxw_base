<?php

/**
 * @name @bname@CatController
 * @info 描述：@bname@分类控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;

class @bname@CatController extends BaseDBController {

    protected $catModel;
    protected $infoModel;

    public function _initialize() {
        parent::_initialize();
        $this->catModel = D('@bname@Cat');
        $this->infoModel = M('@bname@Info');
    }

    /**
     * function:显示@bname@分类列表
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
                $value['cat_name'] = '&#12288;&#12288;|--' . $value['cat_name'];
                $value['catType'] = 'son';
                $infoList[] = $value;
            }
        }
        $this->assign('infoList', $infoList);
        $this->display();
    }

    /**
     * function:获取@bname@列表（返回下拉树中数据）
     */
    public function getTreeViewData() {
        $result = queryCatList(0, $this->catModel);
        $treeData[0] = array('id' => 0, 'cat_name' => '', 'parent_id_path' => '', 'children' => $result);
        echo json_encode($treeData);
    }

    /**
     * function:添加/编辑@bname@分类
     * @return code(501验证未通过 500成功 502失败)
     */
    public function save@bname@Cat() {
        $param_arr = array();
        $form_data = $_POST['form_data'];
        parse_str($form_data, $param_arr); //转换数组
        $returnData = parent::saveData($this->catModel, $param_arr);
        if ($returnData['code'] == '500') {
            if (!empty($param_arr['id'])) {//编辑分类是否禁用
                $condition['parent_id_path'] = array('LIKE', $param_arr['parent_id_path'] . $param_arr['id'] . '.%');
                $catInfo = $this->catModel->where($condition)->select();
                if (is_array($catInfo) && count($catInfo) > 0) {
                    foreach ($catInfo as $key => $value) {
                        $where['id'] = $value['id'];
                        $data['is_enable'] = $param_arr['is_enable'];
                        $this->catModel->where($where)->setField($data);
                    }
                }
            }
            $logC = A('Actionlog')->addLog('@bname@Cat', 'save@bname@Cat', '添加/编辑@bname@分类');
        }
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
     * function:删除@bname@分类及分类下的@bname@信息
     */
    public function del@bname@Cat() {
        $condition['id'] = array('EQ', $_POST['id']);
        $catInfo = $this->catModel->where($condition)->find(); //获取某条分类信息(ID)
        $childCatArray = $this->catModel->where(array('parent_id_path' => array('LIKE', $catInfo['parent_id_path'] . $catInfo['id'] . '.%')))->select();
        if (count($childCatArray) > 0) {
            foreach ($childCatArray as $value) {
                $@sname@InfoList = $this->infoModel->where(array('cat_id' => $value['id']))->select();
            }
        }
        if (false !== $this->catModel->where($condition)->delete()) {
            if (count($childCatArray) > 0) {
                foreach ($childCatArray as $value) {
                    $this->catModel->where(array('id' => $value['id']))->delete();
                }
            }
            if (count($@sname@InfoList) > 0) {
                foreach ($@sname@InfoList as $value) {
                    $this->catModel->where(array('id' => $value['id']))->delete();
                }
            }
            $returnData['code'] = '500';
            $logC = A('Actionlog')->addLog('@bname@Cat', 'del@bname@Cat', '删除@bname@分类');
        } else {
            $returnData['code'] = '502';
        }
        $this->ajaxReturn($returnData, 'JSON');
    }

    /**
     * 批量删除分类
     */
    public function delArrayCat() {
        $this->catModel->delete(rtrim($_POST['ids'], ",")); // 删除主键为ids的数据
        $logC = A('Actionlog')->addLog('@bname@Cat', 'delArrayCat', '删除@bname@分类');
    }

}
