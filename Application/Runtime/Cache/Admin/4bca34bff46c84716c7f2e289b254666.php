<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <link rel="stylesheet" type="text/css" href="/Public/admin/plugin/webuploader/webuploader.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <script type="text/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" charset="utf-8" src="/Public/Plugin/ueditor1.4.3.3/ueditor.config.js"></script>
        <script type="text/javascript" charset="utf-8" src="/Public/Plugin/ueditor1.4.3.3/ueditor.all.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="/Public/Plugin/ueditor1.4.3.3/lang/zh-cn/zh-cn.js"></script>
        <script type="text/javascript" src="/Public/admin/plugin/webuploader/webuploader.min.js"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript" src="/Public/admin/js/Zxw/info.js"></script>
    </head>
    <body>
        <!--添加信息-->
        <div class="container">
            <form method="post" action="#"  class="form-horizontal"  id="save-form" style="margin-top: 20px;">
                <input type="hidden" name="id" value="<?php echo ($zxwInfo["id"]); ?>"/>
                <div id="fileJson" name="fileJson" style="display: none;"><?php echo ($attachList); ?></div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">标&#12288;&#12288;题</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo ($zxwInfo["title"]); ?>" placeholder="请输入标题">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填(1-200个字符)</span></label>
                </div>
                <div class="form-group">
                    <label for="category_name" class="col-sm-2 control-label">类&#12288;&#12288;别</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($zxwInfo["category_name"]); ?>" onclick="showTreeView();" placeholder="请选择类别" readonly>
                        <input type="hidden" id="parent_id" name="cat_id" value="<?php echo ($zxwInfo["cat_id"]); ?>"/>
                        <div class="col-sm-11 dropdown-menu" id="treeview" style="display: none;margin-left:15px;z-index: 111111111;"></div>
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必选</span></label>
                </div>
                <div class="form-group">
                    <label for="editor" class="col-sm-2 control-label">缩略图</label>
                    <div class="col-sm-8">
                        <div  id="filePicker">添加图片</div>
                        <div id="fileList" id="upload" class="uploader-list" style="width: 100%;height: 120px;background-color: #fff;border:1px solid #ccc;border-radius: 4px;padding: 10px;"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editor" class="col-sm-2 control-label">内&#12288;&#12288;容</label>
                    <div class="col-sm-8">
                        <script id="editor" type="text/plain" name="content"></script>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-primary" id="saveInfo-btn">提&#12288;&#12288;交</button>
                        <button type="button" class="btn btn-warning" onclick="javascript:void(window.location.href = '/index.php/Admin/ZxwInfo/showList')">取&#12288;&#12288;消</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(function () {

            if ($('#fileJson').text().length > 0) {
                var jsonObj = $.parseJSON($('#fileJson').text());
                if (jsonObj.length > 0) {
                    var strHtml = '';
                    $.each(jsonObj, function (index, value) {
                        strHtml += '<div id="WU_FILE_10' + index + '" class="file-item thumbnail" style="float:left;">';
                        strHtml += '<div style="width:100px;margin-right:10px;">';
                        strHtml += '<img src="/' + value.file_path + '" style="width:100px;height:70px;">';
                        strHtml += '<div class="del fontred font12" style="background-color:#bbb;width:100px;border-radius:2px;">删除</div>';
                        strHtml += '<input type="hidden" name="files[]" value="' + value.id + '" />';
                        strHtml += '</div></div>';
                    });
                    $('#fileList').append(strHtml);// $list为容器jQuery实例
                }
            }
            
            
            // 初始化Web Uploader
            var uploader = WebUploader.create({
                auto: true, // 选完文件后，是否自动上传。
                swf: '/Public/admin/plugin/webuploader/Uploader.swf', // swf文件路径
                server: '/index.php/Admin/allattach/uploadAttach/module_name/zxw', // 文件接收服务端。
                // 选择文件的按钮。可选。内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                duplicate: true//可重复上传
            });
            // 当有文件添加进来的时候
            uploader.on('fileQueued', function (file) {
                var $li = $('<div id="' + file.id + '" class="file-item thumbnail" style="float:left;"></div> ');
                var $img = $li.find('img');
                $('#fileList').append($li);// $list为容器jQuery实例
            });

            // 文件上传过程中创建进度条实时显示。
            uploader.on('uploadProgress', function (file, percentage) {
                var $li = $('#' + file.id);
                var $percent = $li.find('.progress span');
                $percent.css('width', percentage * 100 + '%');
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function (file, response) {
                $file = $('#' + file.id);
                if (response.flag == 'success') {
                    $file.append('<div style="width:100px;margin-right:10px;"><img src="/' + response.url + '" style="width:100px;height:70px;"><div class="del fontred font12" style="background-color:#bbb;width:100px;border-radius:2px;">删除</div><input type="hidden" name="files[]" value="' + response.att_id + '" /></div>');
                    $file.css('background-img', 'url()');
                    if ($('#input-title').val() == '') {
                        $('#input-title').val(file.name);
                    }
                } else {
                    upload_error(file, response);
                }
            });
            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on('uploadComplete', function (file) {
                $('#' + file.id).find('.progress').remove();
                uploader.removeFile(file.id);
            });

            function upload_error(file, response) {
                var $li = $('#' + file.id);
                $li.remove();
                $.messager.alert('上传错误', response.msg);
            }

            // 删除图片
            var $filelist = $('#fileList');
            $filelist.on('click', '.del', function (e) {
                $obj = $(this);
                $.post('/index.php/Admin/allattach/delAttach', {'id': $(this).next().val()}, function (result) {
                    if (result.code == '500') {
                        var id = $obj.parent().attr('id');
                        if (typeof (id) != 'undefined') {
                            uploader.removeFile($obj.parent().attr('id'));
                        }
                        $obj.parent().parent().remove();
                    }
                });
            });

            var contentEditor = UE.getEditor('editor', {
                //这里可以选择自己需要的工具按钮名称
                toolbars: [[
                        'fullscreen', 'source', '|', 'undo', 'redo', '|',
                        'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                        'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                        'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                        'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                        'link', 'unlink', '|', 'simpleupload', 'insertimage'
                    ]],
                //focus时自动清空初始化时的内容
                autoClearinitialContent: true,
                //关闭字数统计
                wordCount: true,
                //关闭elementPath
                elementPathEnabled: false,
                //默认的编辑区域高度
                initialFrameHeight: 450,
            })
            //初始化编辑器的值
            contentEditor.ready(function () {
                contentEditor.setContent('<?php echo ($zxwInfo["content"]); ?>');
            });
        });
    </script>
</html>