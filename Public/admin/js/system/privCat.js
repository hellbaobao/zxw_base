/**
 * Created by GX on 2017-02-20.
 */
var treeData=[];
$(function() {
    //添加分类按钮绑定click事件
    $('#addCatLayer-btn').click(function(){
        clearForm(save_form);
        $("#treeview").hide();
        layer.open({
            type: 1,
            title: ['分类信息','font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
            skin: 'layui-layer-rim', //加上边框
            shadeClose:true,//是否点击遮罩关闭
            resize:false,//是否允许拉伸
            area: ['650px', '350px'], //宽高
            content: $('.catLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            btn: ['确定', '取消'],
            yes: function (index) {
                savePrivCat(index);
            },
            cancel: function (index) {
            }
        });
    });
    $('#delArrayCat-btn').click(function(){
        var isChecked='';
        if($("input[name='rowChecked']:checked").length <= 0){
            layer.msg('请选择批量删除的数据！',{time: 2000});return;
        }else{
            $('input[name="rowChecked"]:checked').each(function(){
                isChecked+=$(this).val()+',';
            });
            $.post(c_path + '/delArrayCat', {'ids':isChecked},function(result){
                location.reload();
            });
        }
    });
});

//编辑分类
function editCatLayer(id){
    $("#treeview").hide();
    layer.open({
        type: 1,
        title: ['分类信息','font-size:16px;font-weight: bold;color: #2e8ded;'], //标题信息及样式
        skin: 'layui-layer-rim', //加上边框
        shadeClose:true,//是否点击遮罩关闭
        resize:false,//是否允许拉伸
        area: ['650px', '350px'], //宽高
        content: $('.catLayer'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        btn: ['确定', '取消'],
        yes: function (index) {
            savePrivCat(index);
        },
        cancel: function (index) {
        },
        success: function(layero){
            $.post(c_path + '/findInfoById',{'id':id},function(result){
                if(result.code=='500'){
                    $.each(result.data,function(key,value){
                        if(key=='is_enable'){
                            $('input[name="'+key+'"][value="'+value+'"]').prop("checked",true);return;
                        }
                        $('#'+key).val(value);
                    });
                }
            },'json');
        }
    });
}
//保存权限分类信息
function savePrivCat(index) {
    $.post(c_path + '/savePrivCat', {"form_data": $('#save_form').serialize()}, function (result) {
        if (result.code == '500') {
            layer.close(index);
            layer.msg(constants.SUCCESS,{time: 1000},function(){
                location.reload();
            });
        } else if(result.code == '502') {
            layer.msg(constants.FAILD);
        }else{
            layer.msg(result.msgError);
        }
    },'json');
}

//删除权限分类信息
function delCatLayer(id){
    layer.confirm('确定要删除此信息嘛？', {
        icon:2,
        title:'提示信息',
        btn: ['确定','取消'] //按钮
    }, function(index){
        $.post(c_path + '/delSysPrivCat',{'id':id},function(result){
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