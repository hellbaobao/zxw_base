<?php
/**
 * @name function
 * @info 描述：Admin公用框架方法
 * @author GX
 * @datetime 2017-2-24 10:40:22
 */
/**
 * function:查询分类列表数据（树形结构）
 * @param $parent_id,$model
 * @return array
 */
function queryCatList($parent_id,$model){
    $returnData=array();
    $condition['parent_id']=array('EQ',$parent_id);
    $condition['is_enable']=array('EQ',1);
    $result=$model->where($condition)->select();
    foreach($result as $key=>$value){
        $returnData[$key]=array('id'=>$value['id'],'cat_name'=>$value['cat_name'],'parent_id_path'=>$value['parent_id_path'],'children'=>queryCatList($value['id'],$model));
    }
    return $returnData;
}

/**
 * function:返回分类ID
 * @param $sys_name
 * @param $model
 * @return mixed
 */
function getCatId($sys_name,$model){
    $condition['sys_name']=array('EQ',$sys_name);
    $returnData=$model->field('id')->where($condition)->find();
    return $returnData['id'];
}

