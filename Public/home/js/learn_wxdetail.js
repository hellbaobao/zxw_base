/**
 * @name notice_detail
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 8:47:14
 */

//全局变量---------------------------------------------------------------------------------------
var id = getUrl('id');
//初始化-----------------------------------------------------------------------------------------
$(function () {
    var id = getUrl('id');
    getApptlearnDetail(id);
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取通知详情
 * @param {type} id
 * @returns {undefined}
 */
function getApptlearnDetail(id) {
    $.get(c_path + "/getApptlearnDetail/", {'id': id}, function (data) {
        if (data.flag == 1) {
            $(".title").html("【培训】" + data.data.title);
            $("title").html("【培训】" + data.data.title);
            $(".teacher").html(data.data.teacher);
            $(".start_time").html(data.data.start_time);
            $(".addtime").html(data.data.add_time);
            $(".kr-article-author").html(data.data.realname);
            $(".kr-article-time").html(data.data.add_time);
            $(".viewnum").html("阅读&nbsp;" + data.data.read_num);
            //为增强体验 图片加载完成之前隐藏，加载完成后显示
            $(".content").css('display', 'none');
//            $(".content").html(data.data.content.replace(/style="(.)*?"|^\s*|\&nbsp;/gi, ''));
            $(".content").html(data.data.content + '</br></br>');
            $('.content table').css({'width': '100%'});
            $('.content table').attr({'border': '1'});
            $('.content').html(img_reset($('.content').html()));

            if ($('.content img').length > 0) {
                $('.content img').each(function () {
                    $(this).css({'padding': '5px 0'});
                    $(this).attr('src', delHttp(this.src));
                    $(this).load(function () {
                        var img = new Image();
                        img.src = this.src;
                        $(this).css({'width': '100%'});
                        $(".content").css('display', 'block');
                    });
                });
            } else {
                $(".content").css('display', 'block');
            }

        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            window.location.href = "learn_list.html";
        }

    }, 'json');

}

/**
 * 提交
 * @returns {undefined}
 */
function subLearnOrder() {
    var flag = 1;
    telCheck = /^1[3|5|7|8|][0-9]{9}$/;
    if ($('#linkman_tel').val() != '' && $('#linkman_name').val() != '' && $('#appt_num').val() != '') {
        if (telCheck.test($('#linkman_tel').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '手机号码不正确';
        }
    } else {
        flag = 0;
        msg = '请完善信息';
    }
    if (flag == 0) {
        mui.toast(msg, {duration: 'long', type: 'div'});
    } else {
        $.post("../appt/addLearnOrder", {
            'linkman_tel': $('#linkman_tel').val(),
            'linkman_name': $('#linkman_name').val(),
            'appt_num': $('#appt_num').val(),
            'learn_id': id,
        }, function (data) {
            if (data.flag == 1) {
                mui.toast("提交培训预约成功！", {duration: 'long', type: 'div'});
                var str = '<div class="mui-card">' +
                        '<div class="mui-card-content">' +
                        '<div class="mui-card-content-inner" style="color:green;">' +
                        '您已成功预约培训！' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                $('#subBtn').html(str);
            } else {
                mui.toast(data.msg, {duration: 'long', type: 'div'});
            }
        }, 'json');
    }

}
