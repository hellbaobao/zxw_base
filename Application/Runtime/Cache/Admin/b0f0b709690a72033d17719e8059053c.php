<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <!--自定义样式及脚本放于此处-->
        <link rel="stylesheet" href="/Public/admin/css/index.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/admin/js/index/index.js"></script>
        <?php echo (ANIMATION); ?>
        <title><?php echo ($config['system_name']); ?></title>
    </head>
    <body
        <div class="container" style="width: 100%;">
            <div class="row" style="background-color: #fff;margin-bottom: 20px;" >
                <div class="b-tip-div col-xs-6 col-sm-3">
                    <div class="b-tip b-color-tip1 hvr-buzz-out">
                        <div class="b-tip-body">
                            <div class="b-tip-left">
                                <i class="glyphicon glyphicon-send"></i>
                            </div>
                            <div class="b-tip-right">
                                <div class="b-tip-titleb"><?php echo ($mainNum['notice']); ?>&#12288;条</div>
                                <div class="b-tip-titlel"> 累计发布&#12288;<b>内容信息</b></div>
                            </div>
                        </div>
                        <div class="b-tip-footer">
                            截至<?php echo ($nowTime); ?>
                            <span class='b-more'><span class="pull-right glyphicon glyphicon-time b-more"></span></span>
                        </div>
                    </div>
                </div>
                <div class="b-tip-div col-xs-6 col-sm-3">
                    <div class="b-tip b-color-tip2 hvr-buzz-out">
                        <div class="b-tip-body">
                            <div class="b-tip-left">
                                <i class="glyphicon glyphicon-globe"></i>
                            </div>
                            <div class="b-tip-right">
                                <div class="b-tip-titleb"><?php echo ($mainNum['appt_learn']); ?>&#12288;条</div>
                                <div class="b-tip-titlel"> 累计发布&#12288;<b>培训信息</b></div>
                            </div>
                        </div>
                        <div class="b-tip-footer">
                            截至<?php echo ($nowTime); ?>
                            <span class='b-more'><span class="pull-right glyphicon glyphicon-time b-more"></span></span>
                        </div>
                    </div>
                </div>
                <div class="b-tip-div col-xs-6 col-sm-3">
                    <div class="b-tip b-color-tip3 hvr-buzz-out">
                        <div class="b-tip-body">
                            <div class="b-tip-left">
                                <i class="glyphicon glyphicon-user"></i>
                            </div>
                            <div class="b-tip-right">
                                <div class="b-tip-titleb"><?php echo ($mainNum['visit_num']); ?>&#12288;人次</div>
                                <div class="b-tip-titlel"> 累计&#12288;<b>参观预约</b></div>
                            </div>
                        </div>
                        <div class="b-tip-footer">
                            截至<?php echo ($nowTime); ?>
                            <span class='b-more'><span class="pull-right glyphicon glyphicon-time b-more"></span></span>
                        </div>
                    </div>
                </div>
                <div class="b-tip-div col-xs-6 col-sm-3">
                    <div class="b-tip b-color-tip4 hvr-buzz-out" >
                        <div class="b-tip-body">
                            <div class="b-tip-left">
                                <i class="glyphicon glyphicon-gift"></i>
                            </div>
                            <div class="b-tip-right">
                                <div class="b-tip-titleb"><?php echo ($mainNum['learn_num']); ?>&#12288;人次</div>
                                <div class="b-tip-titlel"> 累计&#12288;<b>培训预约</b></div>
                            </div>
                        </div>
                        <div class="b-tip-footer">
                            截至<?php echo ($nowTime); ?>
                            <span class='b-more'><span class="pull-right glyphicon glyphicon-time b-more"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="b-main-list col-xs-12 col-sm-6">
                    <div class="b-main-list-info">
                        <table class="table table-hover">
                            <tr>
                                <th colspan="4" style="text-align: left;color: #45c8dc;"><i class="glyphicon glyphicon-globe hvr-bounce-in"></i>&#12288;最新内容信息</th>
                            </tr>
                            <?php if(!empty($noticeArr)): if(is_array($noticeArr)): foreach($noticeArr as $k=>$v): ?><tr class="tr">
                                        <td>
                                            <?php echo ($v["icon"]); ?><a href="/index.php/Admin/NoticeInfo/noticeDetail/id/<?php echo ($v["id"]); ?>"><?php echo (msubstr($v["title"],0,17,'utf-8',true)); ?></a>
                                        </td>
                                        <td><span class="label label-info" style="font-size: 13px;line-height: 13px;"><?php echo ($v["realname"]); ?></span></td>
                                        <td style="text-align: right;"><?php echo ($v["add_time"]); ?></td>
                                    </tr><?php endforeach; endif; endif; ?>
                            <?php if(empty($noticeArr)): ?><tr><td colspan="4" style="text-align: center;">(＞﹏＜)&#12288;暂无数据</td></tr><?php endif; ?>
                        </table>
                    </div>
                </div>
                <div class="b-main-list col-xs-12 col-sm-6">
                    <div class="b-main-list-info">
                        <table class="table table-hover">
                            <tr>
                                <th colspan="4" style="text-align: left;color: #45c8dc;"><i class="glyphicon glyphicon-globe"></i>&#12288;最新培训信息</th>
                            </tr>
                            <?php if(!empty($apptlearnArr)): if(is_array($apptlearnArr)): foreach($apptlearnArr as $k=>$v): ?><tr class="tr">
                                        <td>
                                            <?php echo ($v["icon"]); ?><a href="/index.php/Admin/Apptlearn/apptlearnDetail/id/<?php echo ($v["id"]); ?>"><?php echo (msubstr($v["title"],0,17,'utf-8',true)); ?></a>
                                        </td>
                                        <td>
                                            <span class="label label-success" style="font-size: 13px;line-height: 13px;">讲师：<?php echo ($v["teacher"]); ?></span>
                                        </td>
                                        <td style="text-align: right;"><?php echo ($v["start_time"]["ymd"]); ?></td>
                                    </tr><?php endforeach; endif; endif; ?>
                            <?php if(empty($apptlearnArr)): ?><tr><td colspan="4" style="text-align: center;">(＞﹏＜)&#12288;暂无数据</td></tr><?php endif; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>