<?php
/**
 * Created by PhpStorm.
 * User: zhangzhihui
 * Date: 2018/4/27
 * Time: 下午4:55
 */

namespace Think\Tool;

/**
 * 生成唯一编号工具类
 * 调用方式 如: \Think\Tool\GenerateUnique::generateExchangeNumber();
 */

class GenerateUnique {

    protected static $startDate = '2018-01-01 00:00:00';

    /**
     * 生成积分商品兑换交易单号
     */
    public static function generateExchangeNumber() {
        $left = time() - strtotime(self::$startDate);
        $center = date("Ymd", time());
        $right = mt_rand(1000, 9999);
        return $left . $center . $right;
    }

    /**
     * 生成积分商品编号
     */
    public static function generateGoodsNumber() {
        $left = mt_rand(1000, 9999);
        $center = date("Ymd", time());
        $right = mt_rand(1000, 9999);
        return $left . $center . $right;
    }


}