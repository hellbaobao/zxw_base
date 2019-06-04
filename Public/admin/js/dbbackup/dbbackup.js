/**
 * Created by GX on 2017-02-20.
 */
$(function () {
    $('#backupDb-btn').click(function () {
        layer.msg('正在备份中', {
            icon: 16
            , shade: 0.01
        });
        $.post(c_path + '/backupDb', function (result) {
            location.reload();
        });
    });
});


/**
 * 删除备份信息
 * @param {type} id
 * @returns {undefined}
 */
function delBackupDb(id) {
    layer.confirm('确定要删除此信息嘛？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.get(c_path + '/delBackupDb', {'id': id}, function (result) {
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
 * 还原数据库 到 某一备份节点
 * @param {type} id
 * @returns {undefined}
 */
function refreshBackupDb(id) {
    layer.confirm('确定要还原数据库至这个节点吗？', {
        icon: 2,
        title: '提示信息',
        btn: ['确定', '取消'] //按钮
    }, function (index) {
        $.get(c_path + '/restoreDbById', {'id': id}, function (result) {
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
 * 代码备份
 */
//treeview数据格式
//var defaultData = [{"id":0,"cat_name":"","children":[{"id":"1","cat_name":"qqqqq","children":[{"id":"2","cat_name":"sssss","children":[]}]},{"id":"3","cat_name":"\u5bf9\u5bf9\u5bf9","children":[]}]}]
//模态框属性
//$("#addCatModal").modal({show:false});
//$("#addCatModal").modal({keyboard:false});