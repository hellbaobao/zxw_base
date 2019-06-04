<?php

/**
 * @name ZxwInfoModel
 * @info 描述：Zxw信息表model
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 10:35:17
 */

namespace Admin\Model;

use Think\Model;

class ZxwInfoModel extends Model {

    public $tableName = 'zxw_info';
    protected $_validate = array(
        array('title', 'require', '标题为必填项！'),
        array('title', '1,200', '标题长度应在1-200之间！', 0, 'length'),
        array('cat_id', 'require', '类别为必选项！'),
    );

}
