<?php

/**
 * @name SysUserGroupModel
 * @info 描述：后台用户组表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class SysUserGroupModel extends Model {

    public $tableName = 'sys_user_group';
    protected $_validate = array(
        array('parent_id', 'require', '所属分类为必选项！'),
        array('cat_name', 'require', '用户组名称为必填项！'),
        array('cat_name', '', '分类名称已存在！', 0, 'unique'),
        array('cat_name', '1,50', '用户组名称长度应在1-50之间！', 0, 'length'),
        array('sys_name', 'require', '系统名称为必填项！'),
        array('sys_name', '', '系统名称已存在！', 0, 'unique'),
        array('sys_name', '1,50', '系统名称长度应在0-50之间！', 0, 'length'),
    );

}
