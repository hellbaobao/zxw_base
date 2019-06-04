<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>通知</title>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript" src="/Public/admin/js/notice/noticeInfo.js"></script>
    </head>
    <body>
        <div class="option_search">
            <form method="get" action="/index.php/Admin/NoticeInfo/showList" class="form-horizontal" id="search-form" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-sm-3" style="min-width: 200px;">
                        <button type="button" class="btn btn-success addNoticeInfo" id="addInfo-btn" onclick="javascript:void(window.location.href = '/index.php/Admin/NoticeInfo/add')" style="height: 34px;">
                            <span class="glyphicon glyphicon-plus"></span> 新增
                        </button>
                        <button type="button" class="btn btn-danger delNoticeInfo" id="delArrayInfo-btn" style="height: 34px;">
                            <span class="glyphicon glyphicon-trash"></span> 批量删除
                        </button>
                    </div>
                    <div class="col-sm-3">
                    </div>

                    <div class="col-sm-2" style="text-align: right;">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($searchInfo["category_name"]); ?>" onclick="showTreeView();" placeholder="请选择类别" readonly>
                        <input type="hidden" id="parent_id" name="cat_id" value="<?php echo ($searchInfo["cat_id"]); ?>"/>
                        <div class="dropdown-menu" id="treeview" style="display: none;margin-left:15px;"></div>
                    </div>
                    <div class="col-sm-3" style="text-align: right;">
                        <div class='input-group'>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo ($searchInfo["title"]); ?>" placeholder="请输入标题">
                            <span class='input-group-btn'>
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
                    <th>全选</th>
                    <th><input type="checkbox" name="allChecked" onclick="setAllChecked(this);"/></th>
                    <th>标题</th>
                    <th>类别</th>
                    <th>发布人</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>
                <?php if(!empty($infoList)): if(is_array($infoList)): foreach($infoList as $k=>$v): ?><tr class="tr">
                            <td><?php echo (I('get.p'))?((I('get.p')-1)*C('PAGE_SIZE')+$k+1):($k+1);?></td>
                            <td>
                        <?php if($v["address_id"] == $address_id||$address_id == 0): ?><input type="checkbox" name="rowChecked" value="<?php echo ($v["id"]); ?>"/>
                            <?php else: ?><input type="checkbox" name="" value="" disabled="disabled"/><?php endif; ?>
                        </td>
                        <td>
                        <?php if($v["is_publish"] == 0): ?><span class="label label-default" style="padding: 4px">未发布</span>
                            <?php else: ?>
                            <span class="label label-success" style="padding: 4px">已发布</span><?php endif; ?>
                        <a href="/index.php/Admin/NoticeInfo/detail/id/<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></a>
                        
                        </td>
                        <td><?php echo ($v["cat_name"]); ?></td>
                        <td>
                        <?php if($v["realname"] == '' || $v["realname"] == null): echo ($v["usr"]); ?>
                            <?php else: echo ($v["realname"]); endif; ?>
                        </td>
                        <td><?php echo ($v["add_time"]); ?></td>
                        <td>
                            <div>

                                <button class="btn btn-default edit-btn editNoticeInfo" onclick="javascript:void(window.location.href = '/index.php/Admin/NoticeInfo/edit/id/<?php echo ($v["id"]); ?>')">
                                    <span class="glyphicon glyphicon-edit"></span> 编辑
                                </button>
                                <button class="btn btn-default pubNoticeInfo" onclick="pubInfoLayer(<?php echo ($v["id"]); ?>)">
                                    <span class="glyphicon glyphicon-bullhorn"></span> 发布
                                </button>


                                <!--<button class="btn btn-default del-btn" onclick="delInfoLayer(<?php echo ($v["id"]); ?>)">-->
                                <!--<span class="glyphicon glyphicon-trash"></span> 删除-->
                                <!--</button>-->

                            </div>
                        </td>
                        </tr><?php endforeach; endif; endif; ?>
                <?php if(empty($infoList)): ?><tr><td colspan="8">暂无数据</td></tr><?php endif; ?>
            </table>
            <div style="text-align: center;"><?php echo ($page); ?></div>
        </div>
    </body>
</html>