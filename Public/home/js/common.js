res_path = '/Public/Upload';
appUpload_path = '/';
root_path = '';
/**
 * 页面条转
 * @param {Object} sys_name
 */
function aHref(sys_name) {
    window.location.href = sys_name;
}
/**
 * 返回首页 （弃用）
 * @returns {undefined}
 */
function aHome() {
    mui.openWindow({
        url: 'main.html',
        extras: {
            //传递参数
        },
        show: {
            autoShow: true, //页面loaded事件发生后自动显示，默认为true  
            aniShow: 'slide-in-right', //页面显示动画，默认为”slide-in-right“；  
            duration: 1000, //页面动画持续时间，Android平台默认100毫秒，iOS平台默认200毫秒；  
        },
    });
}

/**
 * 正则表达式方法获取url参数获取时记着解码 decodeURI(getUrl(name));
 * @param {type} name
 * @returns {getUrl.r}
 */
function getUrl(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return r[2];
    return null;
}

/**
 * 重置img部分代码
 * @param {type} htmlstr
 * @returns {unresolved}
 */
function img_reset(htmlstr) {
    var arr = htmlstr.match(/<(div|p)(\W|\w)*?<img(\W|\w)*?<\/(div|p)>/gi);

    for (var key in arr) {
        var img_arr = arr[key].match(/<img(.|\s)*?>/gi);
        var img_html = '<div>' + img_arr[0] + '</div>';
        htmlstr = htmlstr.replace(img_arr[0], img_html);
    }
    return htmlstr;
}


/**
 * 编辑器地址去掉前缀
 * @param {Object} str
 */
function delHttp(str) {
    var arr = str.split('/');
    var newStr = '';
    for (var i = 3; i < arr.length; i++) {
        newStr += '/' + arr[i];
    }
    return root_path + newStr;
}


/**
 * 关于app介绍
 * @returns {undefined}
 */
function about() {
    mui.alert('xxx。', '关于APP', '确定');
}

/**
 * 拨打电话
 * @param {Object} phone
 */
function callPhone(phone) {
    var btnArray = ['拨打', '取消'];
    mui.confirm('是否拨打' + phone + '?', '提示', btnArray, function (e) {
        if (e.index == 0) {
            plus.device.dial(phone, false);
        }
    });
}

/**
 * 打开模态框
 */
function openModal() {
    $(".m-modal-content").fadeIn(200);
    $(".m-modal").fadeIn(200);

    $(".m-modal").bind('click', function () {
        closeModal();
    });
}
/**
 * 关闭模态框
 */
function closeModal() {
    $(".m-modal-content").fadeOut(200);
    $(".m-modal").fadeOut(200);
}

