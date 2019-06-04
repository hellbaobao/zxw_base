<?php

/**
 * @name ManageController
 * @info 描述：管理控制器
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2017-2-7 15:07:13
 */

namespace Admin\Controller;

use Think\Controller;

class ManageController extends BaseDBController {

    public function _initialize() {
        parent::_initialize();
    }

    public function index() {
        $this->display();
    }

    public function zxAction() {
        if (empty($_POST['keyword']) || empty($_POST['order'])) {
            $data = ['flag' => FALSE, 'msg' => '请填写关键字和命令'];
            $this->ajaxReturn($data);
            exit();
        }
        $bname = ucfirst($_POST['keyword']);
        switch ($_POST['order']) {
            case 'makec':
                $move1 = $this->moveFile($bname, "./Public/temp/cat/CatController.class.php", "./Application/Admin/Controller/" . $bname . "CatController.class.php");
                $move2 = $this->moveFile($bname, "./Public/temp/info/InfoController.class.php", "./Application/Admin/Controller/" . $bname . "InfoController.class.php");
                break;
            case 'makem':
                $move1 = $this->moveFile($bname, "./Public/temp/cat/CatModel.class.php", "./Application/Admin/Model/" . $bname . "CatModel.class.php");
                $move2 = $this->moveFile($bname, "./Public/temp/info/InfoModel.class.php", "./Application/Admin/Model/" . $bname . "InfoModel.class.php");
                break;
            case 'makev':
                $dir1 = $this->createDir("./Application/Admin/View/" . $bname . "Cat");
                $move1 = $this->moveFile($bname, "./Public/temp/cat/showList.html", "./Application/Admin/View/" . $bname . "Cat/showList.html");

                $dir2 = $this->createDir("./Application/Admin/View/" . $bname . "Info");
                $move2 = $this->moveFile($bname, "./Public/temp/info/showList.html", "./Application/Admin/View/" . $bname . "Info/showList.html");
                $move3 = $this->moveFile($bname, "./Public/temp/info/add.html", "./Application/Admin/View/" . $bname . "Info/add.html");
                $move4 = $this->moveFile($bname, "./Public/temp/info/detail.html", "./Application/Admin/View/" . $bname . "Info/detail.html");

                $dir3 = $this->createDir("./Public/admin/js/" . $bname);
                $move5 = $this->moveFile($bname, "./Public/temp/cat/cat.js", "./Public/admin/js/" . $bname . "/cat.js");
                $move6 = $this->moveFile($bname, "./Public/temp/info/info.js", "./Public/admin/js/" . $bname . "/info.js");
                break;
            case 'maket':
                $sql = file_get_contents("./Public/temp/catinfo.sql");
                $sql = str_replace("@pname@", $this->dbFix . lcfirst($bname), $sql);
                $sql = M()->execute($sql);
                dump($sql);
                break;
            case 'maker':
                $priCat = M('sys_priv_cat');
                $priInfo = M('sys_priv_info');
                $priPid = $priCat->add(['sys_name' => lcfirst($bname), 'cat_name' => '[' . $bname . ']栏目', 'is_enable' => 1]);
                $catId = $priCat->add(['sys_name' => lcfirst($bname) . 'Cat', 'cat_name' => '分类管理', 'parent_id' => $priPid, 'parent_id_path' => $priPid . '.', 'jump_url' => $bname . 'Cat/showList', 'is_enable' => 1]);
                $infoId = $priCat->add(['sys_name' => lcfirst($bname) . 'Info', 'cat_name' => '内容管理', 'parent_id' => $priPid, 'parent_id_path' => $priPid . '.', 'jump_url' => $bname . 'Info/showList', 'is_enable' => 1]);

                $priInfo->add(['cat_id' => 27, 'pri_name' => '[' . $bname . ']栏目', 'pri_value' => lcfirst($bname) . 'Menu']);

                $priInfo->add(['cat_id' => $catId, 'pri_name' => '编辑[' . $bname . ']分类', 'pri_value' => 'edit' . $bname . 'Cat']);
                $priInfo->add(['cat_id' => $catId, 'pri_name' => '删除[' . $bname . ']分类', 'pri_value' => 'del' . $bname . 'Cat']);
                $priInfo->add(['cat_id' => $catId, 'pri_name' => '查看[' . $bname . ']分类', 'pri_value' => 'show' . $bname . 'Cat']);
                $priInfo->add(['cat_id' => $catId, 'pri_name' => '新增[' . $bname . ']分类', 'pri_value' => 'add' . $bname . 'Cat']);

                $priInfo->add(['cat_id' => $infoId, 'pri_name' => '编辑[' . $bname . ']内容', 'pri_value' => 'edit' . $bname . 'Info']);
                $priInfo->add(['cat_id' => $infoId, 'pri_name' => '删除[' . $bname . ']内容', 'pri_value' => 'del' . $bname . 'Info']);
                $priInfo->add(['cat_id' => $infoId, 'pri_name' => '查看[' . $bname . ']内容', 'pri_value' => 'show' . $bname . 'Info']);
                $priInfo->add(['cat_id' => $infoId, 'pri_name' => '新增[' . $bname . ']内容', 'pri_value' => 'add' . $bname . 'Info']);
                $priInfo->add(['cat_id' => $infoId, 'pri_name' => '发布[' . $bname . ']内容', 'pri_value' => 'pub' . $bname . 'Info']);
                break;

            default:
                break;
        }
        $data = ['flag' => TRUE, 'msg' => '执行成功'];
        $this->ajaxReturn($data);
    }

    public function moveFile($bname, $from, $to) {
        $sname = lcfirst($bname);
        $a = copy($from, $to);
        if (file_exists($to)) {
            $fp = fopen($to, "r");
            $str = "";
            $buffer = 1024; //每次读取 1024 字节
            while (!feof($fp)) {//循环读取，直至读取完整个文件
                $str .= fread($fp, $buffer);
            }
            $str = str_replace("@bname@", $bname, $str);
            $str = str_replace("@sname@", $sname, $str);
            return file_put_contents($to, $str);
        } else {
            return FALSE;
        }
    }

    public function createDir($path) {
        if (!is_dir($path)) {
            mkdir($path, 0700); //如果不存在tmp目录，则建立
        }
    }

}
