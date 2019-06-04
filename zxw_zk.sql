/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : zxw_zk

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2019-02-22 17:23:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `zxw_zk_notice_cat`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_notice_cat`;
CREATE TABLE `zxw_zk_notice_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_notice_cat
-- ----------------------------
INSERT INTO `zxw_zk_notice_cat` VALUES ('12', 'fl001', '分类001', '', '0', '2019-02-22 16:17:24', '1');

-- ----------------------------
-- Table structure for `zxw_zk_notice_info`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_notice_info`;
CREATE TABLE `zxw_zk_notice_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '社区id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布人id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `is_publish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布 0：未发布，1：发布',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `read_ids` text COMMENT '已读人id',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读人数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_notice_info
-- ----------------------------
INSERT INTO `zxw_zk_notice_info` VALUES ('2', '12', '0', '95', '2343254134', '<ol class=\"custom_num2 list-paddingleft-1\" style=\"list-style-type: num2;\"><li class=\"list-num-3-1 list-num2-paddingleft-1\">dfsasfdasdfasdfasdfasdfasdf</li></ol>', '0', '2019-02-22 16:17:53', ',', '0');
INSERT INTO `zxw_zk_notice_info` VALUES ('3', '12', '0', '1', '傻看大离放假啊抗裂砂浆的看法骄傲十点半', '<p>asdfasdfasdfasdf</p>', '1', '2019-02-22 17:06:26', ',', '0');

-- ----------------------------
-- Table structure for `zxw_zk_sys_action_log`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_sys_action_log`;
CREATE TABLE `zxw_zk_sys_action_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_name` varchar(20) NOT NULL DEFAULT '0' COMMENT '用户',
  `c_name` varchar(50) NOT NULL COMMENT '控制器名称',
  `a_name` varchar(50) NOT NULL COMMENT '方法名称',
  `action_info` varchar(100) NOT NULL COMMENT '操作描述',
  `ip` varchar(15) NOT NULL COMMENT 'ip地址',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_sys_action_log
-- ----------------------------
INSERT INTO `zxw_zk_sys_action_log` VALUES ('1', '微信管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2019-02-22 16:16:26');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('2', '微信管理员', 'NoticeInfo', 'delArrayInfo', '删除通知信息', '127.0.0.1', '2019-02-22 16:17:01');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('3', '微信管理员', 'NoticeCat', 'delArrayCat', '删除通知分类', '127.0.0.1', '2019-02-22 16:17:07');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('4', '微信管理员', 'NoticeCat', 'saveNoticeCat', '添加/编辑通知分类', '127.0.0.1', '2019-02-22 16:17:24');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('5', '微信管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2019-02-22 16:17:53');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('6', '微信管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2019-02-22 16:25:51');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('7', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2019-02-22 16:25:58');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('8', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2019-02-22 17:06:26');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('9', '管理员', 'NoticeInfo', 'publNoticeInfo', '发布通知信息', '127.0.0.1', '2019-02-22 17:06:59');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('10', '管理员', 'NoticeInfo', 'saveNoticeInfo', '添加/编辑通知信息', '127.0.0.1', '2019-02-22 17:07:20');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('11', '管理员', 'login', 'logout', '退出系统', '127.0.0.1', '2019-02-22 17:12:09');
INSERT INTO `zxw_zk_sys_action_log` VALUES ('12', '管理员', 'login', 'loginSys', '登录系统', '127.0.0.1', '2019-02-22 17:12:24');

-- ----------------------------
-- Table structure for `zxw_zk_sys_all_attach`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_sys_all_attach`;
CREATE TABLE `zxw_zk_sys_all_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `module_name` varchar(50) NOT NULL COMMENT '控制器名称',
  `module_info_id` int(11) NOT NULL DEFAULT '0' COMMENT '模块内容id',
  `file_path` tinytext NOT NULL COMMENT '附件路径',
  `file_real_name` varchar(100) NOT NULL COMMENT '附件真实名称',
  `file_ext` varchar(10) NOT NULL COMMENT '附件后缀',
  `file_size` varchar(50) NOT NULL COMMENT '附件大小',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_sys_all_attach
-- ----------------------------
INSERT INTO `zxw_zk_sys_all_attach` VALUES ('1', 'notice', '1', 'Public/Upload/notice/2019-02-22/5c6fafca9f1f1.PNG', '001.PNG', 'PNG', '787379');
INSERT INTO `zxw_zk_sys_all_attach` VALUES ('2', 'notice', '2', 'Public/Upload/notice/2019-02-22/5c6fb027c1bc4.jpg', '02.jpg', 'jpg', '162884');
INSERT INTO `zxw_zk_sys_all_attach` VALUES ('3', 'notice', '3', 'Public/Upload/notice/2019-02-22/5c6fbb8c0304f.PNG', '002.PNG', 'PNG', '877563');

-- ----------------------------
-- Table structure for `zxw_zk_sys_config_def`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_sys_config_def`;
CREATE TABLE `zxw_zk_sys_config_def` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) NOT NULL COMMENT '系统名称',
  `set_key` varchar(50) NOT NULL COMMENT '配置键',
  `set_value` varchar(500) NOT NULL COMMENT '配置值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_sys_config_def
-- ----------------------------
INSERT INTO `zxw_zk_sys_config_def` VALUES ('2', 'system_name', 'system_name', '总控系统');
INSERT INTO `zxw_zk_sys_config_def` VALUES ('3', 'db_fix', 'db_fix', 'zxw_zk_');
INSERT INTO `zxw_zk_sys_config_def` VALUES ('4', 'system_token', 'system_token', 'zxw_zk');
INSERT INTO `zxw_zk_sys_config_def` VALUES ('5', 'copy_right', 'copy_right', 'Copyright © 2018 All Rights Reserved Powered by Hellbao');
INSERT INTO `zxw_zk_sys_config_def` VALUES ('6', 'webroot', 'webroot', 'http://192.168.1.91:8895');

-- ----------------------------
-- Table structure for `zxw_zk_sys_db_backup`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_sys_db_backup`;
CREATE TABLE `zxw_zk_sys_db_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `db_path` tinytext NOT NULL COMMENT '备份路径',
  `db_name` varchar(100) NOT NULL,
  `backup_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '备份时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_sys_db_backup
-- ----------------------------
INSERT INTO `zxw_zk_sys_db_backup` VALUES ('16', 'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/', 'zxw_zk_db_debug-20180411-111534.sql', '2018-04-11 11:15:35');
INSERT INTO `zxw_zk_sys_db_backup` VALUES ('18', 'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/', 'zxw_zk_db-20180807-152816.sql', '2018-08-07 15:28:17');
INSERT INTO `zxw_zk_sys_db_backup` VALUES ('19', 'E:/wamp/www/qskj_project_sqk_debug/trunk/dbsql/', 'zxw_zk-20190222-165959.sql', '2019-02-22 16:59:59');

-- ----------------------------
-- Table structure for `zxw_zk_sys_priv_cat`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_sys_priv_cat`;
CREATE TABLE `zxw_zk_sys_priv_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  `jump_url` varchar(50) NOT NULL DEFAULT '0' COMMENT '跳转地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_sys_priv_cat
-- ----------------------------
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('2', 'notice', '内容管理', '', '0', '2017-03-17 11:36:09', '1', '0');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('40', 'socketHandAction', '手动终端', '6.', '6', '2019-02-21 10:47:38', '1', 'Socket/handAction');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('6', 'system', '系统设置', '', '0', '2017-03-21 09:54:09', '1', '0');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('7', 'noticeCat', '内容分类', '2.', '2', '2017-03-21 09:54:39', '1', 'NoticeCat/showList');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('8', 'noticeInfo', '内容列表', '2.', '2', '2017-03-21 09:54:58', '1', 'NoticeInfo/showList');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('20', 'privCat', '权限分类', '6.', '6', '2017-03-29 13:03:52', '1', 'SysPrivCat/showList');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('21', 'privInfo', '权限信息', '6.', '6', '2017-03-29 13:04:12', '1', 'SysPrivInfo/showList');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('22', 'userGroup', '角色管理', '6.', '6', '2017-03-29 13:04:28', '1', 'SysUserGroup/showList');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('23', 'userInfo', '用户信息', '6.', '6', '2017-03-29 13:04:45', '1', 'SysUserInfo/showList');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('24', 'dbBack', '数据备份', '6.', '6', '2017-03-29 13:05:03', '1', 'Dbbackup/showList');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('25', 'actionLog', '系统日志', '6.', '6', '2017-03-29 13:05:21', '1', 'Actionlog/showLogList');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('26', 'menuSet', '菜单设置', '', '0', '2017-03-29 16:10:19', '1', '0');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('27', 'menu', '菜单列表', '26.', '26', '2017-03-29 16:12:02', '1', '0');
INSERT INTO `zxw_zk_sys_priv_cat` VALUES ('35', 'cleanTemPic', '清理缓存', '6.', '6', '2018-04-03 17:11:58', '1', 'Allattach/delAttachs');

-- ----------------------------
-- Table structure for `zxw_zk_sys_priv_info`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_sys_priv_info`;
CREATE TABLE `zxw_zk_sys_priv_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限分类id',
  `pri_name` varchar(50) NOT NULL COMMENT '权限名称',
  `pri_value` varchar(50) NOT NULL COMMENT '权限值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_sys_priv_info
-- ----------------------------
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('2', '7', '新增分类', 'addNoticeCat');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('3', '7', '编辑分类', 'editNoticeCat');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('4', '8', '新增信息', 'addNoticeInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('5', '8', '编辑信息', 'editNoticeInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('6', '7', '删除分类', 'delNoticeCat');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('7', '8', '删除信息', 'delNoticeInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('8', '8', '发布信息', 'pubNoticeInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('9', '7', '查看分类', 'showNoticeCat');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('10', '8', '查看信息', 'showNoticeInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('52', '20', '新增分类', 'addPrivCat');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('53', '20', '编辑分类', 'editPrivCat');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('54', '20', '删除分类', 'delPrivCat');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('55', '20', '查看分类', 'showPrivCat');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('56', '21', '新增信息', 'addPrivInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('57', '21', '编辑信息', 'editPrivInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('58', '21', '删除信息', 'delPrivInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('59', '21', '查看信息', 'showPrivInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('60', '22', '新增信息', 'addUserGroup');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('61', '22', '编辑信息', 'editUserGroup');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('62', '22', '删除信息', 'delUserGroup');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('63', '22', '查看信息', 'showUserGroup');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('64', '23', '新增信息', 'addUserInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('65', '23', '编辑信息', 'editUserInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('66', '23', '删除信息', 'delUserInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('67', '23', '查看信息', 'showUserInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('70', '27', '内容管理', 'noticeMenu');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('74', '27', '系统设置', 'systemMenu');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('83', '24', '查看备份', 'showDbBack');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('84', '25', '查看日志', 'showLogInfo');
INSERT INTO `zxw_zk_sys_priv_info` VALUES ('85', '35', '清理缓存图片', 'cleanTemPic');

-- ----------------------------
-- Table structure for `zxw_zk_sys_user_group`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_sys_user_group`;
CREATE TABLE `zxw_zk_sys_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `priviledges` text COMMENT '组权限',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_sys_user_group
-- ----------------------------
INSERT INTO `zxw_zk_sys_user_group` VALUES ('8', 'sqAdmin', '管理员用户', '', '0', '2018-04-03 14:57:49', 'addNoticeCat,editNoticeCat,delNoticeCat,showNoticeCat,addNoticeInfo,editNoticeInfo,delNoticeInfo,pubNoticeInfo,showNoticeInfo,showLearnInfo,delApptlearnInfo,pubApptlearnInfo,addApptlearnInfo,editApptlearnInfo,showVisitInfo,addUserInfo,editUserInfo,delUserInfo,showUserInfo,noticeMenu,appointmentMenu,', '1');
INSERT INTO `zxw_zk_sys_user_group` VALUES ('5', 'sysAdmin', '系统', '', '0', '2017-03-30 13:37:28', 'addNoticeCat,editNoticeCat,delNoticeCat,showNoticeCat,addNoticeInfo,editNoticeInfo,delNoticeInfo,pubNoticeInfo,showNoticeInfo,showLearnInfo,delApptlearnInfo,pubApptlearnInfo,addApptlearnInfo,editApptlearnInfo,showVisitInfo,addPrivCat,editPrivCat,delPrivCat,showPrivCat,addPrivInfo,editPrivInfo,delPrivInfo,showPrivInfo,addUserGroup,editUserGroup,delUserGroup,showUserGroup,addUserInfo,editUserInfo,delUserInfo,showUserInfo,showDbBack,showLogInfo,cleanTemPic,noticeMenu,systemMenu,appointmentMenu,', '1');

-- ----------------------------
-- Table structure for `zxw_zk_sys_user_info`
-- ----------------------------
DROP TABLE IF EXISTS `zxw_zk_sys_user_info`;
CREATE TABLE `zxw_zk_sys_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '社区id',
  `usr` varchar(50) NOT NULL COMMENT '用户名',
  `pwd` varchar(40) NOT NULL DEFAULT '123' COMMENT '密码',
  `realname` varchar(50) DEFAULT NULL COMMENT '真实姓名',
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别 0男 1女',
  `email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `tel` varchar(20) DEFAULT NULL COMMENT '手机',
  `phone` varchar(20) DEFAULT NULL COMMENT '电话',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单提交时间',
  `last_ip` varchar(15) DEFAULT NULL COMMENT '最新一次登录IP',
  `last_login_time` datetime DEFAULT NULL,
  `priviledges` text COMMENT '用户权限',
  `is_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '启用状态 0：未启用，1：启用',
  `keycode` varchar(8) DEFAULT NULL COMMENT '标识码',
  `token_num` varchar(20) NOT NULL DEFAULT '000000' COMMENT '管理员设备码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zxw_zk_sys_user_info
-- ----------------------------
INSERT INTO `zxw_zk_sys_user_info` VALUES ('1', '5', '0', 'super', '592d510020d3eacdc3d5c89e2e148f7467de3e82', '管理员', '0', 'super@qq.com', '15823695896', '010-60551593', '2017-03-30 09:06:21', '127.0.0.1', '2019-02-22 17:12:23', '', '1', null, '000000');
INSERT INTO `zxw_zk_sys_user_info` VALUES ('95', '8', '0', 'admin', '27d1679e4f799930d6ccc05b6883fbc70b0eecce', '微信管理员', '0', '123@qq.com', '13800000000', '', '2018-08-13 14:58:57', '127.0.0.1', '2019-02-22 16:06:55', '', '1', null, '454243');
