/**
 * @name notice_list
 * @info 描述：通知列表脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-2 14:17:41
 */

//全局变量---------------------------------------------------------------------------------------
var cat_id = getUrl('cat_id');
//初始化-----------------------------------------------------------------------------------------
$(function () {
    var model_key = "notice";
    getList(1, cat_id);
});

//函数--------------------------------------------------------------------------------------------

/**
 * 获取列表
 * @param {type} type
 * @param {type} page
 * @param {type} keyword
 * @returns {undefined}
 */
function getList(page, cat_id) {
    $("#searchBtn").attr('onclick', 'keyWordSelect()');
    $.post(c_path + "/getList", {'page': page, 'cat_id': cat_id}, function (data) {
        //通知公告
        var str = '';
        if (data.flag == 1) {
            for (var i = 0; i < data.data.length; i++) {
                if (data.data[i]["is_read"] == 0) {
//                    var readClass = 'font-wb';
                    var readClass = 'font333';
                } else {
                    var readClass = 'font333';
                }

                str += '<li class="mui-table-view-cell mui-media">';
                str += '<a href="#" onclick="getNoticeDetial(' + data.data[i]["id"] + ')">';
                str += '<img class="mui-media-object mui-pull-left" src="../../../' + data.data[i]["notice_pic"] + '">' +
                        '<div class="mui-media-body">' +
                        '<div class="mui-ellipsis-2 ' + readClass + '">' + data.data[i]["title"] + '</div>' +
                        '</div>' +
                        '<div class="meta-info">' +
                        ' <div class="author">[' + data.data[i]["cat_name"] + ']</div>' +
                        '<div class="time">' + data.data[i]["add_time"] + '</div>' +
                        '</div>' +
                        '</a>' +
                        '</li>';
            }
        } else {
            str = '<li class="mui-table-view-cell font999" style="padding-right: 10px;text-align:center;">(＞﹏＜)&#12288;暂无消息</li>';
        }

        $("#noticeList").html(str);
        $("#page").val(data.page);
        if (data.is_end == 1) {
            $("#loadMore").removeAttr('onclick');
        } else {
            $("#loadMore").attr('onclick', 'loadMore()');
        }

        mui("#loadMore").button('reset');
        $("#loadMore").html(data.ajaxLoad);

    }, 'json');
}

/**
 * 获取通知详情
 * @param {type} id
 * @param {type} type
 * @returns {undefined}
 */
function getNoticeDetial(id, url) {
    window.location.href = c_path + "/notice_wxdetail.html?id=" + id + '&cat_id=' + cat_id;
}
/**
 * 动态加载数据
 * @param {Object} type
 */
function loadMore() {
    mui("#loadMore").button('loading');
    var page = parseInt($("#page").val()) + 1;
    getList(page, cat_id);
}