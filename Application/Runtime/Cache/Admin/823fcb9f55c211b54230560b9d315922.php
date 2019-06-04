<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo (ADMIN_META); echo (ADMIN_CSS); echo (ADMIN_COMPATIBLE); echo (ADMIN_JS); echo ($Assigndata); ?>
        <link rel="stylesheet" href="/Public/Plugin/bootstrap/css/bootstrap-treeview.css">
        <link rel="stylesheet" href="/Public/admin/css/common.css">
        <link rel="stylesheet" type="text/css" href="/Public/Plugin/tab_little/css/style.css"/>
        <script src="/Public/Plugin/tab_little/js/event.js"></script>
        <script src="/Public/Plugin/tab_little/js/tween.js"></script>
        <script type="text/javascript" src="/Public/Plugin/bootstrap/js/bootstrap-treeview.js"></script>
        <script type="text/javascript" src="/Public/Plugin/layer-v3.0.2/layer.js"></script>
        <script type="text/javascript" src="/Public/admin/js/common.js"></script>
        <script type="text/javascript" src="/Public/admin/js/system/userGroup.js"></script>
    </head>
    <body>
        <!--添加用户组信息-->
        <div class="container">
            <form method="post" action="#" class="form-horizontal" id="save-form" style="margin-top: 20px;">
                <input type="hidden" name="id" value="<?php echo ($userGroupInfo["id"]); ?>"/>
                <div class="form-group">
                    <label for="category_name" class="col-sm-2 control-label">上级分组</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($userGroupInfo["category_name"]); ?>" onclick="showTreeView();" placeholder="请选择类别" readonly>
                        <input type="hidden" name="parent_id_path" id="parent_id_path" value="<?php echo ($userGroupInfo["parent_id_path"]); ?>"/>
                        <input type="hidden" id="parent_id" name="parent_id" value="<?php echo ($userGroupInfo["parent_id"]); ?>"/>
                        <div class="col-sm-11 dropdown-menu" id="treeview" style="display: none;margin-left:15px;"></div>
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必选</span></label>
                    <!--<label class="col-sm-2 control-label"></label>-->
                    <!--<div class="col-sm-9" id="treeview" style="display: none;"></div>-->
                </div>
                <div class="form-group">
                    <label for="cat_name" class="col-sm-2 control-label">用户组名称</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="cat_name" name="cat_name" value="<?php echo ($userGroupInfo["cat_name"]); ?>" placeholder="请输入用户组名称">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                </div>
                <div class="form-group">
                    <label for="sys_name" class="col-sm-2 control-label">系统名称</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="sys_name" name="sys_name" value="<?php echo ($userGroupInfo["sys_name"]); ?>" placeholder="请输入系统名称">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">是否禁用</label>
                    <div class="radio-inline" style="padding-left: 35px;">
                        <input type="radio" name="is_enable" id="able" value="1" checked>启用
                    </div>
                    <div class="radio-inline">
                        <input type="radio" name="is_enable" id="enable" value="0">禁用
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">权限设置</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="priviledges" value="<?php echo ($userGroupInfo["priviledges"]); ?>" style="width: 500px;"/>
                        <div class="tabmain" style="height: 485px;">
                            <div id="outerWrap">
                                <div id="sliderParent"></div>
                                <div class="blueline" id="blueline" style="top: 0px; "></div>
                                <ul class="tabGroup"><!--panel左侧-->
                                    <?php if(!empty($priv)): if(is_array($priv)): foreach($priv as $k=>$v): if($k == 0): ?><li class="tabOption selectedTab"><?php echo ($v["cat_name"]); ?></li>
                                                <?php else: ?>
                                                <li class="tabOption"><?php echo ($v["cat_name"]); ?></li><?php endif; endforeach; endif; endif; ?>
                                </ul>
                                <div id="container"><!--panel右侧-->
                                    <div id="content" >
                                        <?php if(!empty($priv)): if(is_array($priv)): foreach($priv as $k=>$v): ?><div class="tabContent">
                                                    <?php if(!empty($v["children"])): if(is_array($v["children"])): foreach($v["children"] as $k1=>$v1): ?><div style="line-height: 30px;">
                                                                <input type="checkbox" name="<?php echo ($v1["sys_name"]); ?>" value="<?php echo ($v1["sys_name"]); ?>" onclick="setCheck(this.value, <?php echo ($v1["id"]); ?>);"/><?php echo ($v1["cat_name"]); ?></br>
                                                                <?php if(!empty($v1["children"])): ?><div style="margin-left: 20px;">
                                                                        <?php if(is_array($v1["children"])): foreach($v1["children"] as $k2=>$v2): if(($k2+1) %4 == 0): ?><input style="margin-left: 10px;" type="checkbox" class="pri_unit" name="<?php echo ($v1["sys_name"]); echo ($v1["id"]); ?>" value="<?php echo ($v2["pri_value"]); ?>"/><?php echo ($v2["pri_name"]); ?></br>
                                                                                <?php else: ?>
                                                                                <input style="margin-left: 10px;" type="checkbox" class="pri_unit" name="<?php echo ($v1["sys_name"]); echo ($v1["id"]); ?>" value="<?php echo ($v2["pri_value"]); ?>"/><?php echo ($v2["pri_name"]); endif; endforeach; endif; ?>
                                                                    </div><?php endif; ?>
                                                            </div><?php endforeach; endif; endif; ?>
                                                </div><?php endforeach; endif; endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-primary" id="saveInfo-btn">提&#12288;&#12288;交</button>
                        <button type="button" class="btn btn-warning" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserGroup/showList')">取&#12288;&#12288;消</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script type="application/javascript">
        $(document).ready(function(){
        var container=document.getElementById('container');
        var content=document.getElementById('content');
        var oDivs=DOM.children(content,"div");oDivs[0].st=0;
        for(var i=1;i<oDivs.length;i++){oDivs[i].st=oDivs[i].offsetTop;}
        var oLis=DOM.getElesByClass("tabOption");
        var flag=0;
        var upFlag=oLis.length;
        ;(function(){function fn(e){e=e||window.event;
        if(e.wheelDelta){var n=e.wheelDelta;}else if(e.detail){var n=e.detail*-1;}
        if(n>0){container.scrollTop-=12;}else if(n<0){	container.scrollTop+=12;}
        slider.style.top=container.scrollTop*container.offsetHeight/content.offsetHeight+"px";
        slider.offsetTop*(content.offsetHeight/container.offsetHeight);
        var st=container.scrollTop;
        if(st>this.preSt){
        for(var j=0;j<oLis.length;j++){	if(st<oDivs[j].st) break;}
        if(oLis[j-2]&&this.preLi!==j){
        if((j)>(flag+1)){DOM.removeClass(oLis[j-2],"selectedTab");	DOM.addClass(oLis[j-1],"selectedTab");animate(blueline,{top:(j-1)*48},500,2);}}	flag=j-1;
        }else if(st<this.preSt){
        for(var j=oLis.length-1;j>=0;j--){if(st>oDivs[j].st) break;}
        if(oLis[j+2]&&this.preLi!==j){if(flag===undefined)return ;
        if((j)<(flag)){	for(var k=0;k<oLis.length;k++){	DOM.removeClass(oLis[k],"selectedTab");};DOM.addClass(oLis[j+1],"selectedTab");	animate(blueline,{top:(j+1)*48},500,2);upFlag=j+1;}}}	this.preSt=st;if(e.preventDefault)e.preventDefault();return false;}
        container.onmousewheel=fn;
        if(container.addEventListener)container.addEventListener("DOMMouseScroll",fn,false);
        slider=document.createElement('span');
        slider.id="slider";
        slider.style.height=container.offsetHeight*(container.offsetHeight/content.offsetHeight)+"px";
        sliderParent.appendChild(slider);
        on(slider,"mousedown",down);
        var blueline=document.getElementById("blueline");
        function changeTab(){
        var index=DOM.getIndex(this);
        for(var i=0;i<oLis.length;i++){	DOM.removeClass(oLis[i],"selectedTab");	}
        DOM.addClass(this,"selectedTab");
        animate(container,{scrollTop:oDivs[index].st},500,1);
        var t=oDivs[index].st*container.offsetHeight/content.offsetHeight;
        animate(slider,{top:t},500);animate(blueline,{top:index*48},500,2);
        }
        var tabPannel1=document.getElementById("outerWrap");
        var oLis=DOM.children(DOM.children(tabPannel1,"ul")[0],"li");
        for(var i=0;i<oLis.length;i++){	oLis[i].onclick=changeTab;};
        })();
        initPrivPanel();
        $("input[name='is_enable'][value='<?php echo ($userGroupInfo["is_enable"]); ?>']").prop("checked", true);
        })
    </script>
</html>