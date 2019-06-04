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
        <script type="text/javascript" src="/Public/admin/js/system/userInfo.js"></script>
    </head>
    <body>
        <!--编辑用户信息-->
        <div class="container">
            <form method="post" action="#" class="form-horizontal" id="save-form" style="margin-top: 20px;">
                <input type="hidden" name="id" value="<?php echo ($userInfo["id"]); ?>"/>
                <div class="form-group">
                    <label for="category_name" class="col-sm-2 control-label">用户角色</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo ($userInfo["category_name"]); ?>" onclick="showUserGroupView();" placeholder="请选择类别" readonly>
                        <input type="hidden" id="parent_id" name="cat_id" value="<?php echo ($userInfo["cat_id"]); ?>"/>
                        <div class="col-sm-11 dropdown-menu" id="treeview" style="display: none;margin-left:15px;z-index: 111111111;"></div>
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必选</span></label>
                </div>
                <div class="form-group">
                    <label for="address_id" class="col-sm-2 control-label">所属社区</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="address_id" name="address_id">
                            <option value='0'>系统管理</option>
                            <option value='1'>翠景北里</option>
                            <option value='2'>翠屏北里</option>
                            <option value='3'>翠屏南里</option>
                            <option value='4'>大方居</option>
                            <option value='5'>格瑞雅居</option>
                            <option value='6'>葛布店东里</option>
                            <option value='7'>金侨时代</option>
                            <option value='8'>京洲园</option>
                            <option value='9'>靓景明居</option>
                            <option value='10'>梨园东里</option>
                            <option value='11'>龙鼎园</option>
                            <option value='12'>曼城家园</option>
                            <option value='13'>群芳园</option>
                            <option value='14'>万盛北里</option>
                            <option value='15'>欣达园</option>
                            <option value='16'>新城乐居</option>
                            <option value='17'>新华联南区</option>
                            <option value='18'>颐瑞东里</option>
                            <option value='19'>颐瑞西里</option>
                            <option value='20'>云景北里</option>
                            <option value='21'>云景东里</option>
                            <option value='22'>云景里</option>
                        </select>
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必选</span></label>
                </div>
                <div class="form-group">
                    <label for="usr" class="col-sm-2 control-label">用户名</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="usr" name="usr" value="<?php echo ($userInfo["usr"]); ?>" placeholder="请输入用户名">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填(1-50字符)</span></label>
                </div>
                <div class="form-group">
                    <label for="realname" class="col-sm-2 control-label">姓&#12288;&#12288;名</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="realname" name="realname" value="<?php echo ($userInfo["realname"]); ?>" placeholder="请输入真实姓名">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-sm-2 control-label">手机号码</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="tel" name="tel" value="<?php echo ($userInfo["tel"]); ?>" placeholder="请输入手机号码">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">座机号码</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo ($userInfo["phone"]); ?>" placeholder="请输入座机号码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">电子邮箱</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo ($userInfo["email"]); ?>" placeholder="请输入邮箱">
                    </div>
                    <label class="col-sm-2"><span class="tipMsg">*必填</span></label>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-2 control-label">地&#12288;&#12288;址</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo ($userInfo["address"]); ?>" placeholder="请输入地址">
                    </div>
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
                    <div class="col-sm-8">
                        <input type="hidden" name="priviledges" value="<?php echo ($userInfo["priviledges"]); ?>" style="width: 500px;"/>
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
                                    <div id="content">
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
                        <button type="button" class="btn btn-primary" id="editInfo-btn">提&#12288;&#12288;交</button>
                        <button type="button" class="btn btn-warning" onclick="javascript:void(window.location.href = '/index.php/Admin/SysUserInfo/showList')">取&#12288;&#12288;消</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script type="text/javascript">
        $(document).ready(function(){
        var container = document.getElementById('container');
        var content = document.getElementById('content');
        var oDivs = DOM.children(content, "div"); oDivs[0].st = 0;
        for (var i = 1; i < oDivs.length; i++){oDivs[i].st = oDivs[i].offsetTop; }
        var oLis = DOM.getElesByClass("tabOption");
        var flag = 0;
        var upFlag = oLis.length;
        ; (function(){function fn(e){e = e || window.event;
        if (e.wheelDelta){var n = e.wheelDelta; } else if (e.detail){var n = e.detail * - 1; }
        if (n > 0){container.scrollTop -= 12; } else if (n < 0){	container.scrollTop += 12; }
        slider.style.top = container.scrollTop * container.offsetHeight / content.offsetHeight + "px";
        slider.offsetTop * (content.offsetHeight / container.offsetHeight);
        var st = container.scrollTop;
        if (st > this.preSt){
        for (var j = 0; j < oLis.length; j++){	if (st < oDivs[j].st) break; }
        if (oLis[j - 2] && this.preLi !== j){
        if ((j) > (flag + 1)){DOM.removeClass(oLis[j - 2], "selectedTab"); DOM.addClass(oLis[j - 1], "selectedTab"); animate(blueline, {top:(j - 1) * 48}, 500, 2); }}	flag = j - 1;
        } else if (st < this.preSt){
        for (var j = oLis.length - 1; j >= 0; j--){if (st > oDivs[j].st) break; }
        if (oLis[j + 2] && this.preLi !== j){if (flag === undefined)return;
        if ((j) < (flag)){	for (var k = 0; k < oLis.length; k++){	DOM.removeClass(oLis[k], "selectedTab"); }; DOM.addClass(oLis[j + 1], "selectedTab"); animate(blueline, {top:(j + 1) * 48}, 500, 2); upFlag = j + 1; }}}	this.preSt = st; if (e.preventDefault)e.preventDefault(); return false; }
        container.onmousewheel = fn;
        if (container.addEventListener)container.addEventListener("DOMMouseScroll", fn, false);
        slider = document.createElement('span');
        slider.id = "slider";
        slider.style.height = container.offsetHeight * (container.offsetHeight / content.offsetHeight) + "px";
        sliderParent.appendChild(slider);
        on(slider, "mousedown", down);
        var blueline = document.getElementById("blueline");
        function changeTab(){
        var index = DOM.getIndex(this);
        for (var i = 0; i < oLis.length; i++){	DOM.removeClass(oLis[i], "selectedTab"); }
        DOM.addClass(this, "selectedTab");
        animate(container, {scrollTop:oDivs[index].st}, 500, 1);
        var t = oDivs[index].st * container.offsetHeight / content.offsetHeight;
        animate(slider, {top:t}, 500); animate(blueline, {top:index * 48}, 500, 2);
        }
        var tabPannel1 = document.getElementById("outerWrap");
        var oLis = DOM.children(DOM.children(tabPannel1, "ul")[0], "li");
        for (var i = 0; i < oLis.length; i++){	oLis[i].onclick = changeTab; };
        })();
        initPrivPanel();
        initGroupPrivPanel(<?php echo ($userInfo["cat_id"]); ?>);
        $("input[name='is_enable'][value='<?php echo ($userInfo["is_enable"]); ?>']").prop("checked", true);
        });
    </script>
</html>