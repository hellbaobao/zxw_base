<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title><?php echo ($webTitle); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <link rel="stylesheet" href="/Public/home/css/mui.min.css" type="text/css"/>
        <link rel="stylesheet" href="/Public/home/css/icons-extra.css" type="text/css"/>
        <link rel="stylesheet" href="/Public/home/css/common.css" type="text/css"/>
        <link href="/Public/home/css/notice.css" rel="stylesheet" type="text/css"/>
        <script src="/Public/home/js/jquery-1.11.0.js"></script>
    </head>

    <body id="body">
        <!--主体部分-->
        <div class="mui-content" style="background-color: #fff;">


            <div>
                <!--list页面部分-->
                <ul class="mui-table-view" id="noticeList"></ul>
                <!--动态加载模块-->
                <button id="loadMore" type="button" data-loading-icon="mui-spinner mui-spinner-custom" style="border:0px;width: 100%;color:#999;padding: 12px 0px;" class="mui-btn" sth onclick="loadMore()"></button>
                <input type="hidden" id="page" value="1">
            </div>
        </div>
    </body>

</html>
<script src="/Public/home/js/mui.min.js"></script>
<script type="text/javascript">
                    //启用双击监听
                    mui.init({
                        gestureConfig: {
                            doubletap: true, //双击关闭
                        }
                    });
</script>
<?php echo ($Assigndata); ?>
<script src="/Public/home/js/common.js"></script>
<script src="/Public/home/js/notice_list.js"></script>