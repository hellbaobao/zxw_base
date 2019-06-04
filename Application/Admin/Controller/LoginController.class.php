<?php

/**
 * @name LoginController
 * @info 描述：登录，注册，找回密码，登出等操作控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller {

    protected $config;

    public function _initialize() {
//        配置字典信息
        $configdefC = A('Configdef');
        $this->config = $configdefC->getAllDef();
        $this->assign('config', $this->config);
//        读取配置menu
    }

    public function index() {
        $this->redirect('login');
    }

    public function login() {
        //$this->assign();
        $this->display();
    }

    public function main() {
        //$this->assign();
        $this->display();
    }

    public function downloadapp() {
        $this->display();
    }

    /**
     * 检测是否登录
     */
    public function checkIsLogin() {
        if ($_POST['c_name'] != 'Login') {
            if (isset($_SESSION['user_id'])) {
                if ($_SESSION['sys_token'] == SYSTEM_TOKEN) {
                    $return['flog'] = 1;
                } else {
                    $return['flog'] = 1;
                }
            } else {
                $return['flog'] = 0;
            }
        } else {
            if ($_POST['a_name'] == 'main') {
                if (isset($_SESSION['user_id'])) {
                    if ($_SESSION['sys_token'] == SYSTEM_TOKEN) {
                        $return['flog'] = 1;
                    } else {
                        $return['flog'] = 1;
                    }
                } else {
                    $return['flog'] = 0;
                }
            }
        }
        $this->ajaxReturn($return);
    }

    public function register() {
        $Model = M(C('DB_USER_GROUP'));
        $selectArr = $Model->where('is_enable=1 and sys_name<>"appUser"')->select();
        if (empty($selectArr)) {
            $options = '<li class="b-text-center">暂无用户类型</li>';
        } else {
            for ($i = 0; $i < count($selectArr); $i++) {
                $options .= '<li class="b-text-center"><a href="javascript:void(0)" onclick="selectCat(' . $selectArr[$i]['id'] . ',this)">' . $selectArr[$i]['cat_name'] . '</a></li>' .
                        '<li class="divider"></li>';
            }
        }
        $this->assign('options', $options);
        $this->display();
    }

    public function findpwd() {
        $this->assign();
        $this->display();
    }

    /**
     * 密码sha1加密
     */
    public function EncriptPWD($pwd) {
        $a = 'lee';
        $b = 'hawking';
        return sha1(sha1($a) . sha1($pwd) . sha1($b));
    }

    /**
     * 生成验证码
     */
    public function verify_c() {
        $Verify = new \Think\Verify();
//        $Verify->codeSet = '0123456789'; //验证码字符
        $Verify->fontSize = 18; //字体大小
        $Verify->length = 4; //字体长度
        $Verify->useNoise = FALSE; //使用噪点
        $Verify->useCurve = FALSE; //使用干扰线
        $Verify->entry();
    }

    /**
     * 验证码验证
     * @param type $code
     * @return type
     */
    public function check_verify($code) {
        $verify = new \Think\Verify();
        return $verify->check($code);
    }

    /**
     * 用户登录
     */
    public function loginSys() {
        if ($_POST['username'] == '') {
            $errorMsg['flag'] = 0;
            $errorMsg['msg'] = '你还没有输入用户名！';
        } else if ($_POST['password'] == '') {
            $errorMsg['flag'] = 0;
            $errorMsg['msg'] = '你还没有输入密码！';
        } else if ($_POST['validate'] == '') {
            $errorMsg['flag'] = 0;
            $errorMsg['msg'] = '你还没有输入验证码！';
        } else {
            if (!$this->check_verify($_POST['validate'])) {
                $errorMsg['flag'] = 0;
                $errorMsg['msg'] = '验证码错误！';
            } else {

                $userModel = M(C('DB_USER_INFO'));
                $userArr = $userModel->where('binary usr="' . $_POST['username'] . '" and pwd="' . $this->EncriptPWD($_POST['password']) . '"')->find();
                if (!empty($userArr)) {
                    $userInfoC = A('SysUserInfo');
                    $catInfo = $userInfoC->getCatInfoByCid($userArr['cat_id']);


                    $loginUpd['last_ip'] = get_client_ip();
                    $loginUpd['last_login_time'] = date('Y-m-d H:i:s', time());
                    $userModel->where('id=' . $userArr['id'])->save($loginUpd);

                    session('usr', $userArr['usr']);
                    session('sys_token', $this->config['system_token']);
                    session('pwd', $userArr['pwd']);
                    session('user_id', $userArr['id']);
                    session('cat_id', $userArr['cat_id']);
                    session('address_id', $userArr['address_id']);
                    session('realname', $userArr['realname']);
                    $logC = A('Actionlog')->addLog('login', 'loginSys', '登录系统');
                    $errorMsg['flag'] = 1;
                    $errorMsg['cat_id'] = $userArr['cat_id'];
                } else {
                    $errorMsg['flag'] = 0;
                    $errorMsg['msg'] = '用户名或密码输入错误！';
                }
            }
        }
        $this->ajaxReturn($errorMsg);
    }

    /**
     * 注册用户
     */
    public function registerUser() {

        if ($_POST['cat_id'] == '' || $_POST['cat_id'] == '0') {
            $errorMsg['flag'] = 0;
            $errorMsg['msg'] = '请选择用户类型！';
        } else if ($_POST['username'] == '') {
            $errorMsg['flag'] = 0;
            $errorMsg['msg'] = '请输入用户名！';
        } else if ($_POST['password'] == '') {
            $errorMsg['flag'] = 0;
            $errorMsg['msg'] = '请输入密码！';
        } else if ($_POST['passworda'] == '') {
            $errorMsg['flag'] = 0;
            $errorMsg['msg'] = '请再次输入密码！';
        } else if ($_POST['password'] != $_POST['passworda']) {
            $errorMsg['flag'] = 0;
            $errorMsg['msg'] = '两次密码不一致！';
        } else {
            $userModel = M(C('DB_USER_INFO'));
            $userArr = $userModel->where('binary usr="' . $_POST['username'] . '"')->select();
            if (empty($userArr)) {
                $createArr['usr'] = $_POST['username'];
                $createArr['pwd'] = $this->EncriptPWD($_POST['password']);
                $createArr['cat_id'] = $_POST['cat_id'];
                $createArr['realname'] = $this->getGroupNameById($_POST['cat_id']) . $this->getLastId();
                $createFlag = $userModel->add($createArr);
                $errorMsg['flag'] = 1;
            } else {
                $errorMsg['flag'] = 0;
                $errorMsg['msg'] = '该用户已存在！';
            }
        }
        $this->ajaxReturn($errorMsg);
    }

    /**
     * 获取分类名称
     * @param type $cat_id
     * @return int
     */
    public function getGroupNameById($cat_id) {
        $Model = M(C('DB_USER_GROUP'));
        $catArr = $Model->where('id=' . $cat_id)->find();
        if (empty($catArr)) {
            return 0;
        } else {
            return $catArr['cat_name'];
        }
    }

    /**
     * 获取该表最新一个id
     * @return int
     */
    public function getLastId() {
        $userModel = M(C('DB_USER_INFO'));
        $findArr = $userModel->order('id desc')->limit(1)->select();
        if (empty($findArr)) {
            return 1;
        } else {
            return intval($findArr[0]['id'] + 1);
        }
    }

    /**
     * 用户退出
     */
    public function logout() {
        $logC = A('Actionlog')->addLog('login', 'logout', '退出系统');
        session('[destroy]');
        $this->redirect('Admin/login/login');
    }

    /**
     * 返回平台入口
     */
    public function shome() {
        $this->redirect('Admin/login/main');
    }

    /**
     * 找回密码-用户验证修改密码(通过电子邮箱验证)
     */
    public function forget() {
        $userModel = M(C('DB_USER_INFO'));
        if (IS_POST) {
            if ($_POST['usr'] == '') {
                $errorMsg = array('flag' => 0, 'msg' => '请输入用户名！');
            } else if ($_POST['email'] == '') {
                $errorMsg = array('flag' => 0, 'msg' => '你还没有输入验证邮箱！');
            } else {
                $userInfo = $userModel->where('binary usr="' . $_POST['usr'] . '" and email="' . $_POST['email'] . '"')->find();
                if (!empty($userInfo)) {
                    $keycode = make_char('m');
                    $msg = $this->sendEmail($userInfo['email'], $userInfo['id'], $userInfo['realname'], $keycode);
                    if ($msg == TRUE) {
                        $errorMsg = array('flag' => 'success', 'id' => $userInfo['id'], 'msg' => '恭喜您：邮件发送成功，请注意查收！');
                        $updateFlog = $userModel->where('id=' . $userInfo['id'])->setField('keycode', $keycode);
                    } else {
                        $errorMsg = array('flag' => 0, 'msg' => '邮件发送失败，请重新验证邮箱！');
                    }
                } else {
                    $errorMsg = array('flag' => 0, 'msg' => '用户名与邮箱不匹配！');
                }
            }
            $this->ajaxReturn($errorMsg);
        }
    }

    /**
     * 找回密码-验证验证码
     */
    public function checkKeyCode() {
        $userModel = M(C('DB_USER_INFO'));
        if (IS_POST) {
            if ($_POST['usr'] == '') {
                $errorMsg = array('flag' => 0, 'msg' => '请输入用户名！');
            } else if ($_POST['email'] == '') {
                $errorMsg = array('flag' => 0, 'msg' => '你还没有输入验证邮箱！');
            } else if ($_POST['keycode'] == '') {
                $errorMsg = array('flag' => 0, 'msg' => '你还没有输入验证码！');
            } else {
                $userInfo = $userModel->where('binary usr="' . $_POST['usr'] . '" and email="' . $_POST['email'] . '" and keycode="' . $_POST['keycode'] . '"')->find();
                if (empty($userInfo)) {
                    $errorMsg = array('flag' => 0, 'msg' => '验证信息不匹配！', 'sql' => $userModel->getLastSql());
                } else {
                    $errorMsg = array('flag' => 1, 'msg' => '验证信息正确,请修改密码', 'user_id' => $userInfo['id']);
                }
            }
            $this->ajaxReturn($errorMsg);
        }
    }

    /**
     * function:外部找回密码---修改密码
     */
    public function editPwd() {
        $userModel = M(C('DB_USER_INFO'));
        $user_id = $_POST['user_id'];
        if (IS_POST) {
            if ($_POST['newPwd'] == '') {
                $errorMsg = array('flag' => 0, 'msg' => '请输入新密码！');
            } else if ($_POST['confirmPwd'] == '') {
                $errorMsg = array('flag' => 0, 'msg' => '请输入确认密码！');
            } else if ($_POST['newPwd'] != $_POST['confirmPwd']) {
                $errorMsg = array('flag' => 0, 'msg' => '两次密码不一致！');
            } else {
                $update['pwd'] = $this->EncriptPWD($_POST['newPwd']);
                $update['keycode'] = make_char('m');
                $result = $userModel->where(array('id' => $user_id))->save($update);
                if ($result !== false) {
                    $errorMsg = array('flag' => 1, 'msg' => '修改密码成功!');
                } else {
                    $errorMsg = array('flag' => 0, 'msg' => '修改密码失败!');
                }
            }
            $this->ajaxReturn($errorMsg);
        }
    }

    /**
     * 发送邮件
     * @param type $emailAddress
     * @param type $userName
     * @param type $keycode
     */
    public function sendEmail($emailAddress, $user_id, $userName, $keycode) {
        $msg = think_send_mail($emailAddress, $userName, '找回密码', '尊敬的' . $userName . ',您的验证码是' . $keycode . ',有效期为一个小时请在页面中提交验证码完成验证。');
        return $msg;
    }

    public function zxw() {
        $smsC = A('Sms');
        $flag = $smsC->sendCode("13521447599", "123456");
//        $this->success('23423423sfasdfasdfasd4234', 'index/main', 300);
    }

}
