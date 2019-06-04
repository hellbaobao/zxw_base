<?php

/**
 * @name NoticeCatModel
 * @info 描述：通知分类表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class NoticeCatModel extends Model {

    public $tableName = 'notice_cat';
//    protected $patchValidate = true;//批量验证
    protected $_validate = array(
        array('parent_id', 'require', '所属分类为必选项！'),
        array('cat_name', 'require', '分类名称为必填项！'),
        array('cat_name', '', '分类名称已存在！', 0, 'unique'),
        array('cat_name', '1,50', '分类名称长度应在1-50之间！', 0, 'length'),
        array('sys_name', '0,50', '系统名称长度应在0-50之间！', 0, 'length'),
    );

}
