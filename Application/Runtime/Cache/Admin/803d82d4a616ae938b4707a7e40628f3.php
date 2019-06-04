<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <script type="application/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="application/javascript" src="/Public/admin/js/common.js"></script>
        <script type="application/javascript" src="/Public/admin/js/Zxw/cat.js"></script>
    </head>
    <body>
        <div class="option_search">
            <button type="button" class="btn btn-success addZxwCat" id="addCatLayer-btn" style="height: 34px;">
                <span class="glyphicon glyphicon-plus"></span> 新增
            </button>
            <button type="button" class="btn btn-danger delZxwCat" id="delArrayCat-btn" style="height: 34px;">
                <span class="glyphicon glyphicon-trash"></span> 批量删除
            </button>
        </div>
        <div class="table_content">
            <table class="table table-hover">
                <tr>
                    <th style="width: 50px;">全选</th>
                    <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                    <th>分类名称</th>
                    <th>系统名称</th>
                    <th>是否禁用</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): if($v["catType"] == 'father'): ?><tr class="tr" style='background-color: #45c8dc;'>
                            <?php else: ?><tr class="tr"><?php endif; ?>
                        <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                        <td><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/></td>
                        <td><?php echo ($v["cat_name"]); ?></td>
                        <td><?php echo ($v["sys_name"]); ?></td>
                        <td>
                        <?php if($v["is_enable"] == 0): ?>禁用
                            <?php else: ?>启用<?php endif; ?>
                        </td>
                        <td><?php echo ($v["add_time"]); ?></td>
                        <td>
                            <div>
                                <button class="btn btn-default edit-btn editZxwCat" onclick="editCatLayer(<?php echo ($v["id"]); ?>);" >
                                    <span class="glyphicon glyphicon-edit"></span> 编辑
                                </button>
                                <button class="btn btn-default del-btn delZxwCat" onclick="delCatLayer(<?php echo ($v["id"]); ?>)">
                                    <span class="glyphicon glyphicon-trash"></span> 删除
                                </button>
                            </div>
                        </td>
                        </tr><?php endforeach; endif; endif; ?>
            </table>
            <?php if(empty($infoList)): ?><div style="text-align: center;">暂无数据</div><?php endif; ?>
            <noempty name="infoList">
                <div style="text-align: center;"><?php echo ($page); ?></div>
            </noempty>
        </div>
    </body>
    <div class="catLayer" style="display: none;">
        <div class="container" style="width: 500px;">
            <div class="row">
                <form method="post" action="#" class="form-horizontal" id="form_data" style="margin-top: 20px;">
                    <input type="hidden" name="id" id="id" value=""/>
                    <div class="form-group">
                        <label for="category_name" class="col-sm-3 control-label">所属分类</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="category_name" name="category_name" value="" onclick="showTreeView();" placeholder="请选择分类名称" readonly>
                            <input type="hidden" name="parent_id" id="parent_id" value=""/>
                            <input type="hidden" name="parent_id_path" id="parent_id_path" value=""/>
                            <div class="col-sm-11 dropdown-menu" id="treeview" style="display: none;margin-left:15px;"></div>
                        </div>
                        <label class="col-sm-2"><span class="tipMsg">*必选</span></label>
                        <!--<label class="col-sm-2 control-label"></label>-->
                        <!--<div class="col-sm-9 dropdown-menu" id="treeview" style="display: none;"></div>-->
                    </div>
                    <div class="form-group">
                        <label for="cat_name" class="col-sm-3 control-label">分类名称</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="cat_name" name="cat_name" value="" placeholder="请输入分类名称">
                        </div>
                        <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                    </div>
                    <div class="form-group">
                        <label for="sys_name" class="col-sm-3 control-label">系统名称</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="sys_name" value="" id="sys_name" placeholder="请输入系统名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sys_name" class="col-sm-3 control-label">是否禁用</label>
                        <div class="radio-inline" style="padding-left: 35px;">
                            <input type="radio" name="is_enable" id="able" value="1" checked>启用
                        </div>
                        <div class="radio-inline">
                            <input type="radio" name="is_enable" id="enable" value="0">禁用
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>