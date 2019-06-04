<?php
if(C('LAYOUT_ON')) {
echo '{__NOLAYOUT__}';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>跳转提示</title>
        <style type="text/css">
            * {
                padding: 0;
                margin: 0;
            }
            body {
                background: #fff;
                font-family: '微软雅黑';
                color: #333;
                font-size: 16px;
            }
            .system-message {
                position:absolute;
                top:50%;
                left:40%;
                margin:-150px 0 0 -150px;
                width:750px;
                height:320px;
            }
            .left-img{
                width:360px;
                height:320px;
                float: left;
                background-size: 360px 320px;
            }
            .right-img{
                width:390px;
                height:320px;
                float: left;

            }
            .right-detail{
                width:390px;
                height:100px;
                line-height: 26px;
                font-size: 26px;
                margin-top: 50px;
                margin-left: 20px;
                //background-color: red;
                float: left;
            }
            .right-jump{
                width:360px;
                height:auto;
                line-height: 1.8em;
                font-size: 20px;
                //background-color: red;
                float: left;
                margin-left: 20px;
            }
            .right-jump a{
                border-radius: 4px;
                color: #fff;
                background-color: #3eb7d2;
                padding: 5px;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="system-message">

            <div class="left-img" style="background-image: url(../../../ThinkPHP/Tpl/img/404.png);">

            </div>
            <div class="right-img">
                <div class="right-detail">
                    很抱歉,您访问的页面出错了
                </div>
                <div class="right-jump">
                    <p> 您可以去其他页面看看 </p><p>&#12288;</p><p><a id="href" href="/index.php/Admin/index/main">回到首页</a> </b></p>
                </div>
            </div>

        </div>

        <div style="display: none;"><?php echo strip_tags($e['message']);?></div>
        <div style="display: none;">
            <?php if(isset($e['file'])) {?>
			<p>FILE: <?php echo $e['file'] ;?> &#12288;LINE: <?php echo $e['line'];?></p>
</div>
       <?php }?>
    </body>
</html>
