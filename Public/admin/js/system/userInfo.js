/**
 * @name userInfo-javascript
 * @info 描述：用户信息相关脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 14:39:17
 */
$(function () {
    //新增按钮绑定事件
    $('#saveInfo-btn').click(function () {
        var priviledges = '';
        $("input[class='pri_unit']:checked").each(function () {
            if ($(this).attr("disabled") != "disabled") {
                priviledges += $(this).val() + ',';
            }
        });
        $('input[name="priviledges"]').val(priviledges);
        $.post(c_path + '/saveUserInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    window.location.href = c_path + '/showList';
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000});
            } else {
                layer.msg(result.msgError, {time: 2000});
            }
        }, 'json');
    });
    //编辑按钮绑定事件
    $('#editInfo-btn').click(function () {
        var priviledges = '';
        $("input[class='pri_unit']:checked").each(function () {
            if ($(this).attr("disabled") != "disabled") {
                priviledges += $(this).val() + ',';
            }
        });
        $('input[name="priviledges"]').val(priviledges);
        $.post(c_path + '/editUserInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    window.location.href = c_path + '/showList';
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000});
            } else {
                layer.msg(result.msgError, {time: 2000});
            }
        }, 'json');
    });

    //修改资料事件
    $('#saveMyInfo-btn').click(function () {
        $.post(c_path + '/saveUserMyInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    window.location.href = m_path + '/index/main';
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000});
            } else {
                layer.msg(result.msgError, {time: 2000});
            }
        }, 'json');
    });

    $('#delArrayGroup-btn').click(function () {
        var isChecked = '';
        if ($("input[name='rowChecked']:checked").length <= 0) {
            layer.msg('请选择批量删除的数据！', {time: 2000});
            return;
        } else {
            $('input[name="rowChecked"]:checked').each(function () {
                isChecked += $(this).val() + ',';
            });
            delUserLayer(isChecked);
        }
    });

    //select回显相关
    if (action == "edit") {
        $("#address_id").find("option[value='" + assignData.userInfo.address_id + "']").attr("selected", 'selected');
    }
});
//初始化权限面板
function initPrivPanel() {
    if ($('input[name="priviledges"]').val() != '') {
        var priArray = $('input[name="priviledges"]').val().substring(0, $('input[name="priviledges"]').val().length - 1).split(",");
        $.each(priArray, function (key, value) {
            $('input[value="' + value + '"]').prop('checked', true);
        });
    }
}
//显示TreeViewPanel
function showUserGroupView() {
    //加载下拉树列表
    $.post(c_path + '/getTreeViewData', function (result) {
        treeData = result;//返回TreeView数据
        $('#treeview').show();
        var options = {
            bootstrap2: false,
            showTags: true,
            levels: 5,
            //showCheckbox : true,
            //checkedIcon : "glyphicon glyphicon-check",
            data: buildDomTree(),
            onNodeSelected: function (event, data) {
                $("#category_name").val(data.text);
                $("#parent_id").val(data.id);
                $('input[type="checkbox"]:disabled').prop('checked', false);
                $('input[type="checkbox"]:disabled').attr('disabled', false);
                initGroupPrivPanel(data.id)
                $("#treeview").hide();
            }
        };
        $('#treeview').treeview(options);
        $('#treeview').treeview('collapseAll', {silent: true});
    }, 'json');
}
//初始化用户组权限
function initGroupPrivPanel(id) {
    $.post(c_path + '/getGroupPrivInfo', {'id': id}, function (result) {
        if (result.code == '500') {
            var priArray = result.data.priviledges.substring(0, result.data.priviledges.length - 1).split(",");
            $.each(priArray, function (key, value) {
                $('input[value="' + value + '"]').prop('checked', true);
                $('input[type="checkbox"][value="' + value + '"]').attr('disabled', 'disabled');
            });
        }
    }, 'json');
}
//删除用户信息
function delUserLayer(isChecked) {
    layer.confirm('确定要删除此用户嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delArrUserInfo', {'ids': isChecked}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000}, function () {
                    location.reload();
                });
            } else {
                layer.msg(constants.FAILD);
            }
        }, 'json');
    });
}
/**
 * function:权限面板复选框全选
 * @param value
 */
function setCheck(value, id) {
    var node = $('input[name="' + value + '"]');
    if (node.is(':checked')) {//选中
        $('input[name="' + value + id + '"]').prop('checked', true);
    } else {
        $('input[name="' + value + id + '"]:checked').each(function () {
            if ($(this).attr("disabled") != "disabled") {
                $(this).prop('checked', false);
            }
        });
    }
}