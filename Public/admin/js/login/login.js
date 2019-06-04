/**
 * @name login.js
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-3-23 15:11:02
 */


//全局变量---------------------------------------------------------------------------------------


//初始化-----------------------------------------------------------------------------------------


$(function () {
    if ($('#url').val() == 'register') {
        $('#cat_id').val(0);
    }
    document.onkeydown = function (event_e) {
        if (window.event) {
            event_e = window.event;
        }
        var int_keycode = event_e.charCode || event_e.keyCode;
        if (int_keycode == '13') {
            if ($('#url').val() == 'register') {
                subReg();
            } else if ($('#url').val() == 'login') {
                subLogin();
            } else if ($('#url').val() == 'findpwd') {
                subFindPwd();
            } else if ($('#url').val() == 'editpwd') {
                editPwd();
            }
            return false;
        }
    }
});


//函数--------------------------------------------------------------------------------------------
function aHrefNew(sys_name) {
    window.open(sys_name);
}

function aHref($a) {
    window.location.href = c_path +"/"+ $a;
}
/**
 * 登录
 * @returns {undefined}
 */
function subLogin() {
    $('#warning').css('display', 'none');
    var user = $('#loginUser').val();
    var pwd = $('#loginPwd').val();
    var validate = $('#loginYzm').val();
    $.post(c_path + "/loginSys", {'username': user, 'password': pwd, 'validate': validate}, function (data) {
        console.log(data);
        if (data.flag == 0) {
            $('#warnMsg').html(data.msg);
            $('#warning').css('display', 'block');
        } else {
            window.location.href = m_path + "/index/index";
        }
    }, 'json');
}

/**
 * 注册
 * @returns {undefined}
 */
function subReg() {
    $('#warning').css('display', 'none');
    $.post(c_path + "/registerUser", {'cat_id': $('#cat_id').val(), 'username': $('#username').val(), 'password': $('#password').val(), 'passworda': $('#passworda').val()}, function (data) {
        if (data.flag == 0) {
            $('#warnMsg').html(data.msg);
            $('#warning').css('display', 'block');
        } else {
            aHref(c_path + '/login');
        }
    }, 'json');
}

/**
 * 获取验证码
 * @returns {undefined}
 */
function getKeyCode() {
    $('#warning').css('display', 'none');
    var flag = 1;
    emailCheck = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
    if ($('#email').val() != '') {
        if (emailCheck.test($('#email').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '电子邮箱不正确';
        }
    }
    if (flag == 0) {
        $('#warnMsg').html(msg);
        $('#warning').css('display', 'block');
    } else {
        $.post(c_path + "/forget", {'usr': $('#usr').val(), 'email': $('#email').val()}, function (data) {
            if (data.flag == 0) {
                $('#warnMsg').html(data.msg);
                $('#warning').css('display', 'block');
            } else {

            }
        }, 'json');
    }
}

/**
 * 提交找回密码
 * @returns {undefined}
 */
function subFindPwd() {
    $('#warning').css('display', 'none');
    var flag = 1;
    emailCheck = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
    if ($('#email').val() != '') {
        if (emailCheck.test($('#email').val())) {
            flag = 1;
        } else {
            flag = 0;
            msg = '电子邮箱不正确';
        }
    }
    if (flag == 0) {
        $('#warnMsg').html(msg);
        $('#warning').css('display', 'block');
    } else {
        $.post(c_path + "/checkKeyCode", {'usr': $('#usr').val(), 'email': $('#email').val(), 'keycode': $('#keycode').val()}, function (data) {
            if (data.flag == 1) {
                $('#findpwd').css('display', 'none');
                $('#editpwd').css('display', 'block');
                $('#url').val('editpwd');
                if (data.user_id != null) {
                    $('#user_id').val(data.user_id);
                }
            } else {
                $('#warnMsg').html(data.msg);
                $('#warning').css('display', 'block');
            }
        }, 'json');
    }
}

/**
 * 修改密码
 * @returns {undefined}
 */
function editPwd() {
    $.post(c_path + "/editPwd", {'newPwd': $('#newPwd').val(), 'confirmPwd': $('#confirmPwd').val(), 'user_id': $('#user_id').val()}, function (data) {
        if (data.flag == 1) {
            window.location.href = c_path + "/login";
        } else {
            $('#warnMsg1').html(data.msg);
            $('#warning1').css('display', 'block');
        }
    }, 'json');

}
/**
 * function:点击图片刷新验证码
 */
function changeValidate() {
    var captcha_img = $('#yzm').find('img');
    var verifyimg = captcha_img.attr("src");
    if (verifyimg.indexOf('?') > 0) {
        captcha_img.attr("src", verifyimg + '&random=' + Math.random());
    } else {
        captcha_img.attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
    }
}
/**
 * 选择用户类型
 * @param {type} cid
 * @param {type} obj
 * @returns {undefined}
 */
function selectCat(cid, obj) {
    $('#cat_id').val(cid);
    $('#cat_title').html($(obj).text());
}