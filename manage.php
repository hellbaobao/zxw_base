<?php

/**
 * @name manage
 * @info 描述：
 * @author Hellbao <1036157505@qq.com>
 * @datetime 2019-5-31 17:02:01
 */
$bname = ucfirst($argv[2]);
switch ($argv[1]) {
    case 'makec':
        $move1 = moveFile($bname, "./Public/temp/cat/CatController.class.php", "./Application/Admin/Controller/" . $bname . "CatController.class.php");
        $move2 = moveFile($bname, "./Public/temp/info/InfoController.class.php", "./Application/Admin/Controller/" . $bname . "InfoController.class.php");
        break;
    case 'makem':
        $move1 = moveFile($bname, "./Public/temp/cat/CatModel.class.php", "./Application/Admin/Model/" . $bname . "CatModel.class.php");
        $move2 = moveFile($bname, "./Public/temp/info/InfoModel.class.php", "./Application/Admin/Model/" . $bname . "InfoModel.class.php");
        break;
    case 'makev':
        $dir1 = createDir("./Application/Admin/View/" . $bname . "Cat");
        $move1 = moveFile($bname, "./Public/temp/cat/showList.html", "./Application/Admin/View/" . $bname . "Cat/showList.html");

        $dir2 = createDir("./Application/Admin/View/" . $bname . "Info");
        $move2 = moveFile($bname, "./Public/temp/info/showList.html", "./Application/Admin/View/" . $bname . "Info/showList.html");
        $move3 = moveFile($bname, "./Public/temp/info/add.html", "./Application/Admin/View/" . $bname . "Info/add.html");
        $move4 = moveFile($bname, "./Public/temp/info/detail.html", "./Application/Admin/View/" . $bname . "Info/detail.html");

        $dir3 = createDir("./Public/admin/js/" . $bname);
        $move5 = moveFile($bname, "./Public/temp/cat/cat.js", "./Public/admin/js/" . $bname . "/cat.js");
        $move6 = moveFile($bname, "./Public/temp/info/info.js", "./Public/admin/js/" . $bname . "/info.js");
        break;
    case 'maket':
        $move1 = moveFile($bname, "./Public/temp/cat/CatModel.class.php", "./Application/Admin/Model/" . $bname . "CatModel.class.php");
        $move2 = moveFile($bname, "./Public/temp/info/InfoModel.class.php", "./Application/Admin/Model/" . $bname . "InfoModel.class.php");
        break;
    default:
        break;
}

function moveFile($bname, $from, $to) {
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
        echo file_put_contents($to, $str);
    }
}

function createDir($path) {
    if (!is_dir($path)) {
        mkdir($path, 0700); //如果不存在tmp目录，则建立
    }
}
