<?php
/**
 * Created by PhpStorm.
 * 说明: HTTP请求处理工具
 * User: zhangzhihui
 * Date: 2018/4/28
 * Time: 下午3:16
 */

namespace Think\Tool;

class Request {

    /**
     * 获取全部请求参数
     * @return array
     */
    public static function all() {
        //去掉cookie中的元素
        if(!empty($_REQUEST) && is_array($_REQUEST)) {
            foreach($_REQUEST as $key => $value) {
                if(in_array($key, array_keys($_COOKIE))) {
                    unset($_REQUEST[$key]);
                }
            }
        }
        return $_REQUEST;
    }

    /**
     * 根据请求参数名称获取参数值
     * @param $param   请求参数名称
     * @return mixed   请求参数值
     */
    public static function param($param = null) {
        $request = self::all();
        if(isset($param) && !empty($param)) {
            if(!empty($request) && is_array($request)) {
                if(array_key_exists($param, $request)) {
                    return $request[$param];
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * 是否是AJAx提交的
     * @return bool
     */
    public static function isAjax(){
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 是否是GET提交的
     * @return bool
     */
    public static function isGet() {
        return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
    }
    /**
     * 是否是POST提交
     * @return bool
     */
    public static function isPost() {
        return ($_SERVER['REQUEST_METHOD'] == 'POST' && checkurlHash($GLOBALS['verify']) && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']))) ? true : false;
    }



}