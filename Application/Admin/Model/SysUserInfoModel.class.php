<?php

/**
 * @name SysUserInfoModel
 * @info 描述：后台用户信息表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class SysUserInfoModel extends Model {

    public $tableName = 'sys_user_info';
    protected $_validate = array(
        array('usr', 'require', '用户名为必填项！'),
        array('usr', '', '该用户已存在！', 0, 'unique'),
        array('usr', '1,50', '用户组名称长度应在1-50之间！', 0, 'length'),
        array('cat_id', 'require', '请选择用户组！'),
        array('realname', 'require', '真实姓名为必填项！'),
        array('realname', '0,50', '真实姓名长度应在0-50之间！', 0, 'length'),
        array('tel', 'require', '手机号码为必填项！'),
        array('tel', '/^1[3|5|7|8|][0-9]{9}$/', '手机格式不正确！', 2),
        array('email', 'require', '电子邮箱为必填项！'),
        array('email', '/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', '邮箱格式不正确！', 2),
    );

}
