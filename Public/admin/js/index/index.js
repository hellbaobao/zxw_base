/**
 * @name index
 * @info 描述：主页脚本
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-27 8:54:15
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------
$(function () {
    var timer2 = '';
    $(function () {
        clearInterval(timer2);
        timer2 = setInterval(getTxNum, 1000 * 60 * 3);
    });
    resize();
    getTxNum();
});
$(window).resize(function () {          //当浏览器大小变化时
    resize();
});

//函数--------------------------------------------------------------------------------------------
//重置窗口大小
function resize() {
    menuh = $(window).height() - 63;
    $('#menu').css('height', menuh + 'px');
    mainh = $(window).height() - 150;
    $('#main').css('height', mainh + 'px');
}

function zkTab(id) {
    $('#main-nav li ul').each(function () {
        $(this).collapse('hide');
    });
    $('#' + id).collapse('show');

}
function jumpPage(url, obj) {
    $('#rightMain').attr('src', url);
    if (obj == 0) {
        $('#firCat').html('后台');
        $('#secCat').html('首页');
    } else {
        $('#firCat').html($(obj).parent().parent().prev('div').text());
        $('#secCat').html($(obj).text());
    }
}

function jumpHome() {
    $('#firCat').html('后台');
    $('#secCat').html('首页');
}

function zkDropDown(id) {
    $(".dropdown-toggle").dropdown('toggle');
    $('#' + id).dropdown('toggle');
}

/**
 * 获取提醒数据
 * @returns {undefined}
 */
function getTxNum() {
//    $.post(c_path + "/getTxNum", function (data) {
//        console.log(data);
//        var str = '';
//        $('#countSum').html(data.all);
//        if (data.all == 0) {
//
//        } else {
//            str += '<li><a href="' + m_path + '/SellerInfo/showList" target="right">&#12288;<b>未审核商家</b>&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;<span class="label label-danger">' + data.seller + '</span></a></li>';
//            str += '<li class="divider"></li>';
//            str += '<li><a href="' + m_path + '/SellerPromInfo/showList" target="right">&#12288;<b>未审核广告</b>&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;<span class="label label-danger">' + data.prom + '</span></a></li>';
//            str += '<li class="divider"></li>';
//            str += '<li><a href="' + m_path + '/SellerComplaint/showList" target="right">&#12288;<b>未处理反馈</b>&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;&#12288;<span class="label label-danger">' + data.complaint + '</span></a></li>';
//        }
//        $('#txNum').html(str);
//    }, 'json');
}
