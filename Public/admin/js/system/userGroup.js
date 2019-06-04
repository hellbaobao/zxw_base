/**
 * @name userGroup-javascript
 * @info 描述：用户组相关脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2018-4-13 14:39:17
 */
$(function() {
    //新增按钮绑定事件
    $('#saveInfo-btn').click(function(){
        var priviledges='';
        $("input[class='pri_unit']:checked").each(function(){
            priviledges+=$(this).val()+',';
        });
        $('input[name="priviledges"]').val(priviledges);
        $.post(c_path + '/saveUserGroupInfo', {"form_data": $('#save-form').serialize()}, function (result) {
            if (result.code == '500') {
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    window.location.href=c_path + '/showList';
                });
            } else if(result.code == '502') {
                layer.msg(constants.FAILD,{time: 1000});
            }else{
                layer.msg(result.msgError,{time: 2000});
            }
        },'json');
    });

    $('#delArrayGroup-btn').click(function(){
        var isChecked='';
        if($("input[name='rowChecked']:checked").length <= 0){
            layer.msg('请选择批量删除的数据！',{time: 2000});return;
        }else{
            $('input[name="rowChecked"]:checked').each(function(){
                isChecked+=$(this).val()+',';
            });
            delGroupLayer(isChecked);
        }
    });
});
//初始化权限面板
function initPrivPanel(){
    if($('input[name="priviledges"]').val()!=''){
        var priArray=$('input[name="priviledges"]').val().substring(0,$('input[name="priviledges"]').val().length-1).split(",");
        $.each(priArray,function(key,value){
            $('input[value="'+value+'"]').prop('checked', true);
        });
    }
}
//删除用户组信息
function delGroupLayer(isChecked){
    layer.confirm('确定要删除此用户组嘛？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/delArrUserGroup',{'ids':isChecked},function(result){
            if(result.code == '500'){
                layer.msg(constants.SUCCESS,{time: 1000},function(){
                    location.reload();
                });
            }else{
                layer.msg(constants.FAILD);
            }
        },'json');
    });
}
/**
 * function:权限面板复选框全选
 * @param value
 */
function setCheck(value,id){
    var node=$('input[name="'+value+'"]');
    if(node.is(':checked')) {//选中
        $('input[name="'+value+id+'"]').prop('checked', true);
    }else{
        $('input[name="'+value+id+'"]').prop('checked', false);
    }
}