<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script src="/Public/Plugin/tab_little/js/event.js"></script>
        <script src="/Public/Plugin/tab_little/js/tween.js"></script>
        <script type="text/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript" src="/Public/admin/js/system/userInfo.js"></script>
    </head>
    <body>
        <!--添加用户组信息-->
        <div class="container">
            <form method="post" action="#" class="form-horizontal" id="save-form" style="margin-top: 20px;">
                <input type="hidden" name="id" value="<?php echo ($userInfo["id"]); ?>"/>
                <div class="form-group">
                    <label for="usr" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="usr" name="usr" value="<?php echo ($userInfo["usr"]); ?>" placeholder="请输入用户名">
                    </div>
                </div>
                <div class="form-group">
                    <label for="realname" class="col-sm-2 control-label">姓&#12288;&#12288;名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="realname" name="realname" value="<?php echo ($userInfo["realname"]); ?>" placeholder="请输入姓名">
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-sm-2 control-label">手机号码</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="tel" name="tel" value="<?php echo ($userInfo["tel"]); ?>" placeholder="请输入手机号码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">座机号码</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo ($userInfo["phone"]); ?>" placeholder="请输入座机号码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">电子邮箱</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo ($userInfo["email"]); ?>" placeholder="请输入邮箱">
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-2 control-label">地&#12288;&#12288;址</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo ($userInfo["address"]); ?>" placeholder="请输入地址">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-primary" id="saveMyInfo-btn">提&#12288;&#12288;交</button>
                        <button type="button" class="btn btn-warning" onclick="javascript:void(window.location.href = '/index.php/Admin/index/main')">取&#12288;&#12288;消</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>