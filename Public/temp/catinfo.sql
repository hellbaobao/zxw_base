SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `@pname@_cat`;
CREATE TABLE `@pname@_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `sys_name` varchar(50) DEFAULT NULL COMMENT '系统名称',
  `cat_name` varchar(50) NOT NULL COMMENT '分类名称',
  `parent_id_path` varchar(50) NOT NULL DEFAULT '' COMMENT '所属上级目录',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级ID',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `is_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否禁用 0：禁用，1：启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `@pname@_info`;
CREATE TABLE `@pname@_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `address_id` int(11) NOT NULL DEFAULT '0' COMMENT '社区id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布人id',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `is_publish` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否发布 0：未发布，1：发布',
  `add_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `read_ids` text COMMENT '已读人id',
  `read_num` int(11) NOT NULL DEFAULT '0' COMMENT '阅读数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;