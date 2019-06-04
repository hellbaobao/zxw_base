<?php

/**
 * @name config
 * @info 描述：Admin模块配置文件
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:35:19
 */
return array(
    //'配置项'=>'配置值'
    //基础架构模块
    'PAGE_SIZE' => 10,//分页条数
    'DB_ACTION_LOG' => 'Sys_action_log', //配置日志数据库
    'DB_ALL_ATTACH' => 'Sys_all_attach', //配置附件数据库
    'DB_CONFIG_DEF' => 'Sys_config_def', //配置系统字典数据库
    'DB_DB_BACKUP' => 'Sys_db_backup', //配置数据备份数据库
    'BACKUP_MYSQL_PATH' => 'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/', //配置数据备份数据库
    'DB_USER_INFO' => 'Sys_user_info', //配置用户信息数据库
    'DB_USER_GROUP' => 'Sys_user_group', //配置用户组数据库
	
    //附件处理模块
    'UPLOAD_SIZE'=>3145728,//上传文件大小限制
    'UPLOAD_ROOT'=>'Public/Upload',//上传文件根目录
    'UPLOAD_PATH'=>'E:/wamp/www/qskj_project_sqk_debug/trunk/sqk/',//上传文件绝对路径
    'UPLOAD_EXT'=> array(
        'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
        'photo' => array('jpg', 'jpeg', 'png'),
        'flash' => array('swf', 'flv'),
        'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
        'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2', 'pdf'),
        'excel' => array('xls', 'xlsx')
    ),//上传类型
	
    // 配置邮件发送服务器
    'THINK_EMAIL' => array(
        'SMTP_HOST' => 'smtp.163.com', //SMTP服务器
        'SMTP_PORT' => '587', //SMTP服务器端口
        'SMTP_USER' => 'zxwcx0222@163.com', //SMTP服务器用户名
        'SMTP_PASS' => 'zxw18303012080', //SMTP服务器密码
        'FROM_EMAIL' => 'zxwcx0222@163.com',
        'FROM_NAME' => '梨园智能商圈-社区卡系统', //发件人名称
        'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
        'REPLY_NAME' => '', //回复名称（留空则为发件人名称）
        'SESSION_EXPIRE' => '72'
    ),
);
