<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
    <link rel="stylesheet" href="/Public/admin/css/common.css">
    <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
    <script type="application/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
    <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
    <script type="application/javascript" src="/Public/admin/js/common.js"></script>
    <script type="application/javascript" src="/Public/admin/js/dbbackup/dbbackup.js"></script>
</head>
<body>
    <div class="option_search" >
        <button type="button" class="btn btn-warning backupDb" id="backupDb-btn" style="height: 34px;">
            <span class="glyphicon glyphicon-hdd"></span> 备份数据库
        </button>
    </div>
    <div class="table_content">
        <table class="table table-hover">
            <tr>
                <th style="width: 50px;">全选</th>
                <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                <th>数据名称</th>
                <th>数据路径</th>
                <th>备份时间</th>
                <th>操作</th>
            </tr>
            <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                        <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                        <td><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/></td>
                        <td><?php echo ($v["db_name"]); ?></td>
                        <td><?php echo ($v["db_path"]); ?></td>
                        <td><?php echo ($v["backup_time"]); ?></td>
                        <td>
                            <div>
<!--                                <button class="btn btn-default edit-btn" onclick="refreshBackupDb(<?php echo ($v["id"]); ?>);">
                                    <span class="glyphicon glyphicon-refresh"></span> 还原
                                </button>-->
                                <button class="btn btn-default del-btn delBackupDb" onclick="delBackupDb(<?php echo ($v["id"]); ?>)">
                                    <span class="glyphicon glyphicon-trash"></span> 删除
                                </button>
                            </div>
                        </td>
                    </tr><?php endforeach; endif; endif; ?>
            <?php if(empty($infoList)): ?><tr><td colspan="7">暂无数据</td></tr><?php endif; ?>
        </table>
        <div style="text-align: center;"><?php echo ($page); ?></div>
    </div>
</body>
</html>