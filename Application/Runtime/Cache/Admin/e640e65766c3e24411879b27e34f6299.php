<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); echo (DATEPICKER); ?>
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#start_time').datepicker({changeMonth: true, changeYear: true}); //绑定输入框
                $('#end_time').datepicker({changeMonth: true, changeYear: true}); //绑定输入框
            });
        </script>
    </head>
    <body>
        <div class="option_search">
            <form method="get" action="/index.php/Admin/Actionlog/showLogList" class="form-horizontal" id="search-form" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-3" >
                        <div class="input-group">
                            <input type="text" class="form-control" id="start_time" name="start_time" value="<?php echo ($searchInfo['start_time']); ?>" placeholder="请输入起始时间" onchange="checkse('start_time', 'end_time', 'start_time')" readonly="readonly">
                            <span class="input-group-addon">至</span>
                            <input type="text" class="form-control" id="end_time" name="end_time" value="<?php echo ($searchInfo['end_time']); ?>" placeholder="请输入结束时间" onchange="checkse('start_time', 'end_time', 'end_time')" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-sm-2" style="text-align: right;">
                        <div class="input-group">
                            <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo ($searchInfo['keyword']); ?>" placeholder="请输入关键字">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-success" id="searchInfo-btn" style="height: 34px;">
                                    <span class="glyphicon glyphicon-search"></span> 搜索
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div class="table_content">
            <table class="table table-hover">
                <tr>
                    <th>序号</th>
                    <th>控制器名称</th>
                    <th>操作名称</th>
                    <th>操作描述</th>
                    <th>操作人</th>
                    <th>操作IP</th>
                    <th>操作时间</th>
                </tr>
                <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                            <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                            <td><?php echo ($v["c_name"]); ?></td>
                            <td><?php echo ($v["a_name"]); ?></td>
                            <td><?php echo ($v["action_info"]); ?></td>
                            <td><?php echo ($v["user_name"]); ?></td>
                            <td><?php echo ($v["ip"]); ?></td>
                            <td><?php echo ($v["log_time"]); ?></td>
                        </tr><?php endforeach; endif; endif; ?>
                <?php if(empty($infoList)): ?><tr><td colspan="9">暂无数据</td></tr><?php endif; ?>
            </table>
            <div style="text-align: center;"><?php echo ($page); ?></div>
        </div>
    </body>
</html>