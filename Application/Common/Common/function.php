<?php

/**
 * @name function
 * @info 描述：公用框架方法
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:35:22
 */

/**
 * 获取access_token
 * @return type
 */
function getAccessToken() {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(get_php_file("/sys/access_token.php"));
    if ($data->expire_time < time()) {
        // 如果是企业号用以下URL获取access_token
        // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . WXAPPID . "&secret=" . WXSECRET;
        $res = json_decode(httpGet($url));
        $access_token = $res->access_token;
        if ($access_token) {
            $data->expire_time = time() + 7000;
            $data->access_token = $access_token;
            set_php_file("/sys/access_token.php", json_encode($data));
        }
    } else {
        $access_token = $data->access_token;
    }
    return $access_token;
}

/**
 * 发送微信模版消息
 */
function sendWxTemMsg($str) {
    $access_token_arr = getAccessToken();
    $return = httpRequest('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token_arr, $str);
    M('test')->add(array('json_str' => $return));
    return $return;
}

/**
 * 清理所有cookie
 */
function DeleteAllCookies() {
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, null);
    }
}

/**
 * * 截取中文字符串
 * */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    if (function_exists("mb_substr")) {
        $slice = mb_substr($str, $start, $length, $charset);
    } elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
    } else {
        $re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
        $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
        $re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
        $re['big5'] = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    $fix = '';
    if (strlen($slice) < strlen($str)) {
        $fix = '...';
    }
    return $suffix ? $slice . $fix : $slice;
}

/**
 * 生成查询条件
 * @param type $array 0变量 1key名 2条件 4标识（特殊条件）
 * @return type
 */
function creatWhere($array) {
    $return['where'] = array();
    $return['assignWhere'] = array();
    if (count($array) > 0) {
        foreach ($array as $val) {
            if (!empty($val[0])) {
                if ($val[2] == "LIKE") {
                    switch ($val[3]) {
                        case 'l':
                            $return['where'][$val[1]] = array($val[2], '%' . $val[0]);
                            break;
                        case 'r':
                            $return['where'][$val[1]] = array($val[2], $val[0] . '%');
                            break;
                        default:
                            $return['where'][$val[1]] = array($val[2], '%' . $val[0] . '%');
                            break;
                    }
                } else {
                    $return['where'][$val[1]] = array($val[2], $val[0]);
                }
                $return['assignWhere'][$val[1]] = $val[0];
            }
        }
    }
    return $return;
}

/**
 * 分页
 * @param type $m
 * @param type $where
 * @param type $page_size
 * @return \Think\Page
 */
function getPage($m, $where, $map, $page_size) {
    $count = $m->where($where)->count();
    $Page = new Think\Page($count, $page_size);
    foreach ($map as $key => $val) {
        $Page->parameter[$key] = urlencode($val);
    }
    $Page->lastSuffix = false;
    $Page->setConfig('prev', '上一页');
    $Page->setConfig('next', '下一页');
    $Page->setConfig('last', '末页');
    $Page->setConfig('first', '首页');
    $Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
    return $Page;
}

/**
 * 生成随机字符串
 * @param type $length
 * @return string
 */
function make_char($length = 8) {
    // 密码字符集，可任意添加你需要的字符  
    if ($length == 'm') {
        $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        // 在 $chars 中随机取 $length 个数组元素键名  
        $char_txt = '';
        for ($i = 0; $i < 6; $i++) {
            // 将 $length 个数组元素连接成字符串  
            $char_txt .= $chars[array_rand($chars)];
        }
    } else {
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        // 在 $chars 中随机取 $length 个数组元素键名  
        $char_txt = '';
        for ($i = 0; $i < $length; $i++) {
            // 将 $length 个数组元素连接成字符串  
            $char_txt .= $chars[array_rand($chars)];
        }
    }

    return $char_txt;
}

/**
 * 时间轴转换函数
 * @param type $time
 * @return type
 */
function tranTime($time) {
    $time = strtotime($time);
    $rtime = date("m-d H:i", $time);
    $htime = date("H:i", $time);
    $time = time() - $time;

    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . '分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h = floor($time / (60 * 60));
        $str = $h . '小时前 ' . $htime;
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 1)
            $str = '昨天 ' . $htime;
        else
            $str = '前天 ' . $htime;
    }
    else {
        $str = $rtime;
    }
    return $str;
}

/**
 * 时间转化中文格式
 * @param type $time
 * @return type
 */
function tranTimeToCom($time) {
    $ctime = strtotime($time);
    $str['ymdz'] = date("Y年m月d日", $ctime);
    $str['ymd'] = date("Y.m.d", $ctime);
    $str['his'] = date("H:i:s", $ctime);
    $str['ymd'] = date("Y.m.d", $ctime);
    $str['hi'] = date("H:i", $ctime);
    $str['time'] = $time;
    return $str;
}

/**
 * 生成单号
 * @param type $order_id
 * @return type
 */
function createOrderNo($str) {
    return 'D' . number_format(microtime(true), 2, '', '') . $str;
}

/**
 * 邮件发送函数
 */
function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null) {

    $config = C('THINK_EMAIL');
    vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
    vendor('SMTP');
    $mail = new PHPMailer(); //PHPMailer对象
    $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP(); // 设定使用SMTP服务
    $mail->SMTPDebug = 0; // 关闭SMTP调试功能
    $mail->SMTPAuth = true; // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'ssl'; // 使用安全协议
    $mail->Host = $config['SMTP_HOST']; // SMTP 服务器
    $mail->Port = $config['SMTP_PORT']; // SMTP服务器的端口号
    $mail->Username = $config['SMTP_USER']; // SMTP服务器用户名
    $mail->Password = $config['SMTP_PASS']; // SMTP服务器密码
    $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
    $replyEmail = $config['REPLY_EMAIL'] ? $config['REPLY_EMAIL'] : $config['FROM_EMAIL'];
    $replyName = $config['REPLY_NAME'] ? $config['REPLY_NAME'] : $config['FROM_NAME'];
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $name);
    if (is_array($attachment)) { // 添加附件
        foreach ($attachment as $file) {
            is_file($file) && $mail->AddAttachment($file);
        }
    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}

function createQrcode($data) {
    vendor("phpqrcode.phpqrcode");
    // 纠错级别：L、M、Q、H
    $level = 'M';
    // 点的大小：1到10,用于手机端4就可以了
    $size = 4;
    // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数false
    $path = "Public/Temfile/qrcode/";
    // 生成的文件名
    $fileName = $path . date('YmdHis', time()) . '-' . rand(1000, 9999) . '.png';
    //$fileName = $path . $data . '.png';
    QRcode::png($data, $fileName, $level, $size);
    return $fileName;

//    demo
//    $a = createQrcode('http://192.168.1.91:9014/index.php/Appm/index/index');
//    dump($a);
}

function getExchangeMethod($id) {
    switch ($id) {
        case 0:
            return '用户扫码商家收取';
            break;
        case 1:
            return '用户扫码商家兑换';
            break;
        case 2:
            return '商家扫码用户转账';
            break;
        case 3:
            return '商家扫码用户兑换';
            break;
        case 4:
            return '感应卡扣分';
            break;
        case 5:
            return '用户扫码转账积分';
            break;
        case 6:
            return '商家兑换广告';
            break;
    }
}

//获取社区名称
function getConameById($id) {
    switch ($id) {
        case 0:
            return '全体社区';
            break;
        case 1:
            return '翠景北里';
            break;
        case 2:
            return '翠屏北里';
            break;
        case 3:
            return '翠屏南里';
            break;
        case 4:
            return '大方居';
            break;
        case 5:
            return '格瑞雅居';
            break;
        case 6:
            return '葛布店东里';
            break;
        case 7:
            return '金侨时代';
            break;
        case 8:
            return '京洲园';
            break;
        case 9:
            return '靓景明居';
            break;
        case 10:
            return '梨园东里';
            break;
        case 11:
            return '龙鼎园';
            break;
        case 12:
            return '曼城家园';
            break;
        case 13:
            return '群芳园';
            break;
        case 14:
            return '万盛北里';
            break;
        case 15:
            return '欣达园';
            break;
        case 16:
            return '新城乐居';
            break;
        case 17:
            return '新华联南区';
            break;
        case 18:
            return '颐瑞东里';
            break;
        case 19:
            return '颐瑞西里';
            break;
        case 20:
            return '云景北里';
            break;
        case 21:
            return '云景东里';
            break;
        case 22:
            return '云景里';
            break;
        default:
            return '全体社区';
            break;
    }
}

/**
 * 计算季度
 * @return string
 */
function getQuarter() {
    $year = date('Y', time());
    $month = (int)date('m', time());
    if ($month > 9) {
        $data['nstart'] = $year . '-' . '10-01 00:00:00';
        $data['nend'] = $year . '-' . '12-31 23:59:59';
        $data['lstart'] = $year . '-' . '07-01 00:00:00';
        $data['lend'] = $year . '-' . '09-30 23:59:59';
    } elseif ($month >6 && $month < 10) {
        $data['nstart'] = $year . '-' . '07-01 00:00:00';
        $data['nend'] = $year . '-' . '09-30 23:59:59';
        $data['lstart'] = $year . '-' . '04-01 00:00:00';
        $data['lend'] = $year . '-' . '06-30 23:59:59';
    } elseif ($month > 3 && $month < 7) {
        $data['nstart'] = $year . '-' . '04-01 00:00:00';
        $data['nend'] = $year . '-' . '06-30 23:59:59';
        $data['lstart'] = $year . '-' . '01-01 00:00:00';
        $data['lend'] = $year . '-' . '03-31 23:59:59';
    } else {
        $data['nstart'] = $year . '-' . '01-01 00:00:00';
        $data['nend'] = $year . '-' . '03-31 23:59:59';
        $data['lstart'] = ((int) $year - 1) . '-' . '10-01 00:00:00';
        $data['lend'] = ((int) $year - 1) . '-' . '12-31 23:59:59';
    }
    return $data;
}

function dd($data, $is_exist = true) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if ($is_exist != false) {
        exit;
    }
}

/**
 * 异步返回数据
 * @param   integer  $ret   状态码: 成功为0;其他自定义
 * @param   string   $msg   返回信息说明
 * @param   array    $data  返回数据
 * @return  array
 */
function syncData($ret = 0, $msg = '操作成功', $data = []) {
    $returnData = [
        'ret' => $ret,
        'msg' => $msg,
    ];
    if (!empty($data)) {
        $returnData['data'] = $data;
    }
    return $returnData;
}

/**
 * 根据交易类型id获取交易详情
 * @param  integer $methodId  交易类型id
 * @return array
 */
function getExchangeMethodById($methodId) {
    $exchangeMethod = C('EXCHANGE_METHOD');
    foreach ($exchangeMethod as $val) {
        if ($val['method_id'] == $methodId) {
            return $val;
        }
    }
}

function getFormData() {
    $param_arr = array();
    $form_data = $_POST['form_data'];
    parse_str($form_data, $param_arr); //转换数组
    return $param_arr;
}

function httpRequest($pUrl, $pData) {
    $tCh = curl_init();
    if ($pData) {
        is_array($pData) && $pData = http_build_query($pData);
        curl_setopt($tCh, CURLOPT_POST, true);
        curl_setopt($tCh, CURLOPT_POSTFIELDS, $pData);
    }
    curl_setopt($tCh, CURLOPT_HTTPHEADER, array("Content-type:application/json;charset=UTF-8"));
    curl_setopt($tCh, CURLOPT_URL, $pUrl);
    curl_setopt($tCh, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($tCh, CURLOPT_TIMEOUT, 10);
    curl_setopt($tCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($tCh, CURLOPT_SSL_VERIFYPEER, false);
    $tResult = curl_exec($tCh);
    curl_close($tCh);
    return $tResult;
}

function httpGet($pUrl, $pData = null) {
    $tCh = curl_init();
    if ($pData) {
        is_array($pData) && $pData = http_build_query($pData);
        curl_setopt($tCh, CURLOPT_POST, true);
        curl_setopt($tCh, CURLOPT_POSTFIELDS, $pData);
    }
    curl_setopt($tCh, CURLOPT_HTTPHEADER, array("Content-type:application/json;charset=UTF-8"));
    curl_setopt($tCh, CURLOPT_URL, $pUrl);
    curl_setopt($tCh, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($tCh, CURLOPT_TIMEOUT, 10);
    curl_setopt($tCh, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($tCh, CURLOPT_SSL_VERIFYPEER, false);
    $tResult = curl_exec($tCh);
    curl_close($tCh);
    return $tResult;
}

function get_php_file($filename) {
    return trim(substr(file_get_contents($filename), 15));
}

function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
}

/**
 * 发送微信通知（签到）
 * @param type $data
 */
function sendSignMsg($data) {
    $addArr['open_id'] = $data['wx_num'];
    $addArr['json_str'] = json_encode($data);
    $id = M('sys_wx_msg')->add($addArr);
    //设置模板消息
    $str = '{
	"touser": "' . $data['wx_num'] . '",
	"template_id": "l6t0WSabIXd3JHgus-7T6QAUcG5bCLeuSltLetzR-OM",
	"url": "http://lyznsq.qmtsc.com/index.php/appm/index/wxDetail?id=' . $id . '",
	"topcolor": "#FF0000",
	"data": {
		"first": {
			"value": "亲爱的“' . $data['realname'] . '”,通过' . $data['sign_type'] . '签到",
			"color": "#FFA500"
		},
		"keyword1": {
			"value": "' . $data['title'] . '",
			"color": "#173177"
		},
                "keyword2": {
			"value": "' . date('Y年m月d日 H:i:s') . '",
			"color": "#173177"
		},
                "keyword3": {
			"value": "' . $data['address'] . '",
			"color": "#173177"
		},
		"remark": {
			"value": "非常感谢您的到来，您可以获得【' . $data['sign_integral'] . '】积分！",
			"color": "#FFA500"
		}
	}
}';
    //发送模板消息
    sendWxTemMsg($str);
}

/**
 * 发送微信通知（交易）
 * @param type $data
 */
function sendTradingMsg($data) {
    $addArr['open_id'] = $data['open_id'];
    $addArr['json_str'] = json_encode($data);
    $id = M('sys_wx_msg')->add($addArr);
    //设置模板消息
    $str = '{
	"touser": "' . $data['open_id'] . '",
	"template_id": "dnBhToLU9wd1oqirEZu9a-TfqZjwT2kCDvSpgEFqmoM",
	"url": "http://lyznsq.qmtsc.com/index.php/appm/index/wxDetail?id=' . $id . '",
	"topcolor": "#FF0000",
	"data": {
		"first": {
			"value": "【梨园智能商圈】提醒您正在进行积分交易",
			"color": "#FFA500"
		},
		"account": {
			"value": "' . $data['name'] . '",
			"color": "#173177"
		},
		"time": {
			"value": "' . date('Y年m月d日 H:i:s') . '",
			"color": "#173177"
		},
                "type": {
			"value": "' . $data['type'] . '",
			"color": "#173177"
		},
		"creditChange": {
			"value": "' . $data['io'] . '",
			"color": "#000"
		},
		"number": {
			"value": "' . $data['exchange_integral'] . '分",
			"color": "#173177"
		},
		"amount": {
			"value": "' . $data['integral_num'] . '分",
			"color": "#173177"
		},
		"remark": {
			"value": "",
			"color": "#173177"
		}
	}
}';
    //发送模板消息
    sendWxTemMsg($str);
}
