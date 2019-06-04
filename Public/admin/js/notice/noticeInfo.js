/**
 * Created by GX on 2017-02-20.
 */
$(function () {
    //提交按钮绑定事件
    $('#saveInfo-btn').click(function () {
        $.post(c_path + '/saveNoticeInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS, {time: 1000, zIndex: 111111111}, function () {
                    window.location.href = c_path + '/showList';
                });
            } else if (result.code == '502') {
                layer.msg(constants.FAILD, {time: 1000, zIndex: 111111111});
            } else {
                layer.msg(result.msgError, {time: 2000, zIndex: 111111111});
            }
        }, 'json');
    });
    //批量删除按钮绑定事件
    $('#delArrayInfo-btn').click(function () {
        var isChecked = '';
        if ($("input[name='rowChecked']:checked").length <= 0) {
            layer.msg('请选择批量删除的数据！', {time: 2000});
            return;
        } else {
            $('input[name="rowChecked"]:checked').each(function () {
                isChecked += $(this).val() + ',';
            });
            layer.confirm('确定要批量删除嘛？', {
                icon: 2,
                title: '提示信息',
                btn: ['确定', '取消'] //按钮
            }, function (index) {
                $.post(c_path + '/delArrayInfo', {'ids': isChecked}, function (result) {
                    if (result.code == '500') {
                        layer.msg(constants.SUCCESS, {time: 1000}, function () {
                            location.reload();
                            $('input[name="rowChecked"]:checked').each(function () {
                                $(this).removeAttr('checked');
                            });
                        });
                    } else {
                        layer.msg(constants.FAILD);
                    }
                }, 'json');
            });
        }
    });

});
//删除某条通知信息
function delInfoLayer(id) {
    layer.confirm('确定要删除此信息嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/delNoticeInfo', {'id': id}, function (result) {
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
//发布某条通知信息
function pubInfoLayer(id) {
    layer.confirm('确定要发布此信息嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.post(c_path + '/publNoticeInfo', {'id': id}, function (result) {
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

function getWxArr() {
    var url = $('#url').val();
    $.post(c_path + '/getWxArr', {'url': url}, function (result) {
        if (result.flag == '1') {
            $('#title').val(result.data.title);
            $('#texta').html(result.data.content);
        } else {
            layer.msg("抓取失败！请重新尝试");
        }
    }, 'json');
}

