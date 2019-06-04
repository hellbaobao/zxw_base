/**
 * @name notice_detail
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-3 8:47:14
 */

//全局变量---------------------------------------------------------------------------------------
var cat_id = getUrl('cat_id')
//初始化-----------------------------------------------------------------------------------------
$(function () {
    var id = getUrl('id');
    getNoticeDetail(id);
});

//函数--------------------------------------------------------------------------------------------
/**
 * 获取通知详情
 * @param {type} id
 * @returns {undefined}
 */
function getNoticeDetail(id) {
    $.get(c_path + "/getNoticeDetail/id/" + id, function (data) {
        if (data.flag == 1) {
            $("#kr-article-pic").attr('src', '../../../' + data.data.notice_pic);
            $("#kr-article-title").html(data.data.title);
            $("title").html(data.data.title);
            $("#kr-article-author").html(data.data.realname);
            $("#kr-article-time").html(data.data.add_time);
            //为增强体验 图片加载完成之前隐藏，加载完成后显示
            $("#kr-article-article").css('display', 'none');
//            $("#kr-article-article").html(data.data.content.replace(/style="(.)*?"|^\s*|\&nbsp;/gi, ''));
            $("#kr-article-article").html(data.data.content + '</br></br>');
            $('#kr-article-article table').css({'width': '100%'});
            $('#kr-article-article table').attr({'border': '1'});
            $('#kr-article-article').html(img_reset($('#kr-article-article').html()));
            if ($('#kr-article-article img').length > 0) {
                $('#kr-article-article img').each(function () {
                    $(this).css({'padding': '5px 0'});
                    $(this).attr('src', delHttp(this.src));
                    $(this).load(function () {
                        var img = new Image();
                        img.src = this.src;
                        $(this).css({'width': '100%'});
                        $("#kr-article-article").css('display', 'block');
                    });
                });
            } else {
                $("#kr-article-article").css('display', 'block');
            }

        } else {
            mui.toast(data.msg, {duration: 'long', type: 'div'});
            window.location.href = "notice_list.html";
        }

    }, 'json');

}

/**
 * 返回上级
 * @returns {undefined}
 */
function back() {
    var url = getUrl('url');
    var type = getUrl('type');
    if (url == 'home') {
        aHref(m_path + '/index/main');
    } else {
        window.location.href = "notice_list.html";
    }
}