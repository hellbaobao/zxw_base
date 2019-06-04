<?php

/**
 *  应用入口文件
 */
 
// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<')&&version_compare(PHP_VERSION, '5.6.0', '>')) {
    die('require PHP > 5.3.0 !');
}

header("content-type:text/html;charset=utf-8");
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);
define ('NO_CACHE_RUNTIME',true);

// 定义应用目录
define('APP_PATH', './Application/');

//Admin模块------------------------------------------------------------------------------
//
//定义Admin模版meta
define('ADMIN_META', '<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp" />');
//定义admin模版css
define('ADMIN_CSS', '<link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap.min.css">');
//定义admin模版兼容
define('ADMIN_COMPATIBLE', '<!--[if lte IE 9]>
	<script type="text/javascript" src="/Public/Plugin/bootstrap/js/respond.min.js"></script>
	<script type="text/javascript" src="/Public/Plugin/bootstrap/js/html5shiv.min.js"></script>
	<![endif]-->');
//定义admin模版js
define('ADMIN_JS', '<script type="text/javascript" src="/Public/Plugin/bootstrap/js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="/Public/Plugin/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/Public/Plugin/bootstrap/js/jquery.placeholder.js"></script>
        <script type="text/javascript">
            $(function () {
                $("input, textarea").placeholder();
            });
        </script>');
//APP模块------------------------------------------------------------------------------
//
//定义APP模版meta
define('APP_META', '<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp" />');
//定义APP模版css
define('APP_CSS', '<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">');
//定义APP模版js
define('APP_JS', '<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.placeholder.js"></script>
        <script type="text/javascript">
            $(function () {
                $("input, textarea").placeholder();
            });
        </script>');
//定义时间日期插件
define('DATEPICKER', '<script type="text/javascript" src="/Public/Plugin/datepicker/jquery-ui.js"></script>
        <script type="text/javascript" src="/Public/Plugin/datepicker/datepicker.js"></script>
        <link rel="stylesheet" href="/Public/Plugin/datepicker/jquery-ui.css">
        <link rel="stylesheet" media="all" type="text/css" href="/Public/Plugin/timepicker/jquery-ui-timepicker-addon.css" />
        <script type="text/javascript" src="/Public/Plugin/timepicker/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="/Public/Plugin/timepicker/jquery-ui-sliderAccess.js"></script>
		<script type="text/javascript" src="/Public/Plugin/timepicker/jquery-ui-timepicker-zh-CN.js"></script>');
//定义动画css
define('ANIMATION', '<link rel="stylesheet" href="/Public/Plugin/animation/csshake.min.css">'
        . '<link rel="stylesheet" href="/Public/Plugin/animation/hover-min.css">');
//定义系统自定义路由
//
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
?>