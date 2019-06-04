<?php

/**
 * @name DbbackupController
 * @info 描述：数据库备份操作控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 14:57:46
 */

namespace Admin\Controller;

use Think\Controller;

class DbbackupController extends BaseDBController {
    /**
     * -------------------------------------------------------------------------
     * 前台接口
     * -------------------------------------------------------------------------
     */

    /**
     * 备份数据库
     */
    public function backupDb() {
        $returnInfo = $this->exportDb();
        if ($returnInfo['flag'] == 'success') {
            $backupModel = M(C('DB_DB_BACKUP'));
            $addDate['db_name'] = $returnInfo['msg'];
            $addDate['db_path'] = C('BACKUP_MYSQL_PATH');
            $flag = $backupModel->add($addDate);
            if ($flag > 0) {
                $jsonData['code'] = 500;
                $jsonData['msg'] = '备份数据库成功！';
            } else {
                $jsonData['code'] = 502;
                $jsonData['msg'] = '备份成功，入库失败！';
            }
        } else {
            $jsonData['code'] = 502;
            $jsonData['msg'] = $returnInfo['msg'];
        }
        $this->ajaxReturn($jsonData);
    }

    /**
     * 删除该条备份记录
     */
    public function delBackupDb() {
        $backupModel = M(C('DB_DB_BACKUP'));
        $flag = $backupModel->delete($_GET['id']);
        if ($flag > 0) {
            $jsonData['code'] = 500;
            $jsonData['msg'] = '删除记录成功！';
        } else {
            $jsonData['code'] = 502;
            $jsonData['msg'] = '删除记录失败！';
        }
        $this->ajaxReturn($jsonData);
    }

    /**
     * 还原数据库至某一节点
     */
    public function restoreDbById() {
        $backupModel = M(C('DB_DB_BACKUP'));
        $flag = $backupModel->find($_GET['id']);
//        $flag = $backupModel->find(6);
        if (!is_null($flag)) {
            $res = $this->restoreDb($flag['db_path'] . $flag['db_name']);
            if ($res) {
                $jsonData['code'] = 500;
                $jsonData['msg'] = '数据库还原成功！';
            } else {
                $jsonData['code'] = 502;
                $jsonData['msg'] = '数据库还原失败，请重试！';
            }
        } else {
            $jsonData['code'] = 502;
            $jsonData['msg'] = '未找到该备份节点！';
        }
        $this->ajaxReturn($jsonData);
    }

    /**
     * 展示数据库备份列表（兼具查询）
     */
    public function showList() {
        $backupModel = M(C('DB_DB_BACKUP'));
        parent::showData($backupModel, [], [], '', '');
    }

    /**
     * -------------------------------------------------------------------------
     * 内部接口
     * -------------------------------------------------------------------------
     */

    /**
     * 导出数据库为sql文件并保存
     * @return string
     */
    public function exportDb() {
        header("Content-type:text/html;charset=utf-8");
        $path = C('BACKUP_MYSQL_PATH');
        $model = M();
        //查询所有表
        $sql = "show tables";
        $result = $model->query($sql);
        $info = "\r\n";
        $info .= "CREATE DATABASE IF NOT EXISTS `" . C('DB_NAME') . "` DEFAULT CHARACTER SET utf8 @@@\r\n\r\n";
        $info .= "USE `" . C('DB_NAME') . "`@@@\r\n\r\n";
        // 检查目录是否存在
        if (is_dir($path)) {
            // 检查目录是否可写
            if (is_writable($path)) {
                
            } else {
                $returnData['flag'] = 'error';
                $returnData['msg'] = '目录不可写';
                return $returnData;
            }
        } else {
            // 新建目录
            mkdir($path, 0777, true);
        }
        // 检查文件是否存在
        $sql_name = C('DB_NAME') . '-' . date("Ymd", time()) . '-' . date("His", time()) . '.sql';
        $file_name = $path . $sql_name;
        if (file_exists($file_name)) {
            $returnData['flag'] = 'error';
            $returnData['msg'] = '数据备份文件已存在';
            return $returnData;
        }
        file_put_contents($file_name, $info, FILE_APPEND);
        foreach ($result as $k => $v) {
            //查询表结构
            $val = $v['tables_in_' . C('DB_NAME')];
            $sql_table = "show create table " . $val;
            $res = $model->query($sql_table);
            $info_table = "\r\n";
            $info_table .= "DROP TABLE IF EXISTS `" . $val . "`@@@\r\n\r\n";
//            dump($res);exit;
            $info_table .= $res[0]['create table'] . "@@@\r\n\r\n";
            //查询表数据
            $info_table .= "\r\n";
            file_put_contents($file_name, $info_table, FILE_APPEND);
            $sql_data = "select * from " . $val;
            $data = $model->query($sql_data);
            $count = count($data);
            if ($count < 1) {
                continue;
            } else {
                foreach ($data as $key => $value) {
                    $sqlStr = "INSERT INTO `" . $val . "` VALUES (";
                    foreach ($value as $v_d) {
                        $v_d = str_replace("'", "\'", $v_d);
                        $sqlStr .= "'" . $v_d . "', ";
                    }
                    //去掉最后一个逗号和空格
                    $sqlStr = substr($sqlStr, 0, strlen($sqlStr) - 2);
                    $sqlStr .= ");\r\n";
                    file_put_contents($file_name, $sqlStr, FILE_APPEND);
                }
            }
            $info = "\r\n";
            file_put_contents($file_name, $info, FILE_APPEND);
        }
        $returnData['flag'] = 'success';
        $returnData['msg'] = $sql_name;
        return $returnData;
    }

    /**
     * 数据库还原
     * @param type $filepath
     */
    public function restoreDb($filepath) {
        set_time_limit(0);
        $dbname = C('DB_NAME');
        $model = M();
        if ($dbname != '') {
            $result = $model->execute("use `$dbname`");
        }

        $sql_str = file_get_contents($filepath);
        $sql_str = preg_replace('/\/\*([\S\s]*?)\*\/(;)?/', '', $sql_str); //preg_replace
        $sql_str = str_replace('USE', ';USE', $sql_str);
        $sql_str = str_replace("\n", '', $sql_str);
        $sql_str = str_replace("\r", '', $sql_str);
        $sql_str_Arr = explode('@@@', $sql_str);
        $model->execute(trim($sql_str_Arr[0]) . ';');
        foreach ($sql_str_Arr as $key => $val) {
            if (trim($val) != '') {
                $model->execute(trim($val));
            }
        }
        return ture;
    }

}
