<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <!--自定义样式及脚本放于此处-->
        <link rel="stylesheet" href="/Public/admin/css/index.css">
        <script type="text/javascript" src="/Public/admin/js/index/index.js"></script>
        <?php echo (ANIMATION); ?>
        <title><?php echo ($config['system_name']); ?></title>
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top b-header">
            <div class="container-fluid">
                <div class="navbar-header ">
                    <div class="b-systitle"><?php echo ($config['system_name']); ?></div>
                </div>
                <div class="navbar-collapse collapse" >
                    <ul class="nav navbar-nav navbar-right" style="margin: 5px 0px;">
                        <li class="dropdown ">
                            <a href="#" class="dropdown-toggle b-top b-icon-tix hvr-buzz-out" style="color: #fff;display:<?php echo ($tixing); ?>" data-toggle="dropdown">
                                提醒
                                <span class="label label-danger" id="countSum">0</span>
                            </a>
                            <ul class="dropdown-menu" style="width: auto" id="txNum">

                            </ul>
                        </li>
                        <li>
                            <a  href="javascript:void(0)" onclick="jumpPage('/index.php/Admin/SysUserInfo/saveUserMyInfo', 0)" class="b-top b-icon-user hvr-buzz-out" style="color: #fff;" target="right">
                                <?php echo ($realname); ?>
                            </a>
                        </li>
                        <li ><a href="/index.php/Admin/login/logout" class="b-top b-icon-logout hvr-buzz-out" style="color: #fff;">退出</a></li>

                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid b-menu">
            <div class="row">
                <div class="col-md-2 b-div-menu" id="menu">
                    <ul id="main-nav" class="nav nav-list nav-stacked" >

                        <li style="border-left-color: #3fb2ac">
                            <div class="li-color-1" onclick="jumpPage('/index.php/Admin/index/main', 0)">
                                <i class="glyphicon glyphicon-home"></i>
                                首&#12288;&#12288;页         
                                <span class="pull-right glyphicon">&#12288;</span>
                            </div>
                        </li>

                        <?php if(is_array($navList)): foreach($navList as $k=>$v): if($v["parent_id"] == 0): ?><li class="<?php echo ($v["sys_name"]); ?>Menu">
                                    <div href="#div<?php echo ($k); ?>" class="nav-header collapsed li-color-<?php echo ($k%6+2); ?>" onclick="zkTab('div<?php echo ($k); ?>')">
                                        <i class="glyphicon glyphicon-list-alt"></i>
                                        <?php echo ($v["cat_name"]); ?>
                                        <span class="pull-right glyphicon glyphicon-chevron-down"></span>
                                    </div>
                                    <ul id="div<?php echo ($k); ?>" class="nav nav-list collapse secondmenu" style="height: 0px;">
                                        <?php if(is_array($navList)): foreach($navList as $kk=>$vv): if($v["id"] == $vv['parent_id']): ?><li class="show<?php echo ($vv["sys_name"]); ?>"><div onclick="jumpPage('/index.php/Admin/<?php echo ($vv["jump_url"]); ?>', this)" class="li-color-<?php echo ($k%6+2); ?>"><?php echo ($vv["cat_name"]); ?></div></li><?php endif; endforeach; endif; ?>
                                    </ul>
                                </li><?php endif; endforeach; endif; ?>


                    </ul>
                </div>
                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-body b-main-title">
                            <a id="firCat" style="color:#3fb2ac;" href="javascript:void(0)">后台</a>&nbsp;&raquo;&nbsp;<a id="secCat" style="color:#3fb2ac;" href="javascript:void(0)">首页</a>
                        </div>
                    </div>
                    <div class="panel panel-default" id="main">
                        <iframe name="right" id="rightMain" src="/index.php/Admin/index/main" frameborder="no" scrolling="auto" width="100%" height="100%" allowtransparency="true"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>