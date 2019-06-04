<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/admin/css/common.css"/>
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css"/>
        <script type="application/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="application/javascript" src="/Public/admin/js/common.js"></script>
        <script type="application/javascript" src="/Public/admin/js/system/userInfo.js"></script>
    </head>
    <body>
        <div class="option_search">
            <form method="get" action="/index.php/Admin/SysUserInfo/showList" class="form-horizontal" id="search-form" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-sm-2" style="min-width: 200px;">
                        <button type="button" class="btn btn-success addUserInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserInfo/saveUserInfo')" style="height: 34px;">
                            <span class="glyphicon glyphicon-plus"></span> 新增
                        </button>
                        <button type="button" class="btn btn-danger delUserInfo" id="delArrayGroup-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-trash"></span> 批量删除
                        </button>
                    </div>
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($searchInfo["category_name"]); ?>" onclick="showTreeView();" placeholder="请选择类别" readonly>
                        <input type="hidden" id="parent_id" name="cat_id" value="<?php echo ($searchInfo["cat_id"]); ?>"/>
                        <div class="dropdown-menu" id="treeview" style="display: none;margin-left:15px;"></div>
                    </div>
                    <div class="col-sm-2" style="text-align: right;">
                        <div class="input-group">
                            <input type="text" class="form-control" id="usr" name="usr" value="<?php echo ($searchInfo["usr"]); ?>" placeholder="请输入用户名">

                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success" id="searchInfo-btn" style="height: 34px;">
                                    <span class="glyphicon glyphicon-search"></span> 搜索
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="table_content">
            <table class="table table-hover">
                <tr>
                    <th style="width: 50px;">序号</th>
                    <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                    <th>姓名</th>
                    <th>角色</th>
                    <th>用户名</th>
                    <th>电话</th>
                    <th>最后登录</th>
                    <th>操作</th>
                </tr>
                <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                            <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                            <td><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/></td>
                            <td>
                        <?php if($v["is_enable"] == 0): ?><span class="label label-default">禁用</span>
                            <?php else: ?><span class="label label-success">启用</span><?php endif; ?>
                        <?php echo ($v["realname"]); ?>
                        </td>
                        <td><?php echo ($v["cat_name"]); ?></td>
                        <td><?php echo ($v["usr"]); ?></td>
                        <td><?php echo ($v["tel"]); ?></td>
                        <td title="登录IP:<?php echo ($v["last_ip"]); ?>"><?php echo ($v["last_login_time"]); ?></td>
                        <td>
                            <div>
                                <button class="btn btn-default edit-btn editUserInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserInfo/edit/id/<?php echo ($v["id"]); ?>');">
                                    <span class="glyphicon glyphicon-edit"></span> 编辑
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