<?php
// 应用公共文件

//清楚缓存
function deldir($dir)
{
    //先删除目录下的文件：
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                deldir($fullpath);
            }
        }
    }

    closedir($dh);
    //删除当前文件夹：
    if (rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}

//获取数据
function pg($var)
{
    $value = '';
    if (isset($_POST[$var])) {
        $value = $_POST[$var];
    } else if (isset($_GET[$var])) {
        $value = $_GET[$var];
    }

    if (!get_magic_quotes_gpc()) {//防止重复转义
        //$value=saddslashes($value);
    }
    return $value;
}

// 无限分类 1;
function treeMenu($cate, $type_id, $joinStr = '|-', $pid = 1, $level = 1)
{
    $arr = array();
    foreach ($cate as $k => $v) {
        if ($v['classify_pid'] == $pid) {
            if ($level == 1) {
                $joinStr = '';
            } else {
                for ($i = 1; $i < $v['level_id']; $i++) {
                    $joinStr .= '-';
                }
            }
            //$joinStr = ($level==0?"":'-'); //判断是否是第一级分类
            $v['level_id'] = $level + 1;
            $v['classify_name'] = $joinStr . $v['classify_name'];
            $arr[] = $v;
            unset($cate[$k]); //删除该节点，减少递归的消耗
            $arr = array_merge($arr, treeMenu($cate, $type_id, $joinStr = '|-', $v[$type_id], $level + 1));
        }
    }
    return $arr;
}

// 无限分类 2;
function treeMenu2($cate, $type_id, $joinStr = '|-', $pid = 1, $level = 1)
{
    $arr = array();
    foreach ($cate as $k => $v) {
        if ($v['classify_pid'] == $pid) {
            for ($i = 1; $i < $v['level_id']; $i++) {
                $joinStr .= '-';
            }
            //$joinStr = ($level==0?"":'-'); //判断是否是第一级分类
            $v['level_id'] = $level + 1;
            $v['classify_name'] = $joinStr . $v['classify_name'];
            $arr[] = $v;
            unset($cate[$k]); //删除该节点，减少递归的消耗
            $arr = array_merge($arr, treeMenu($cate, $type_id, $joinStr = '|-', $v[$type_id], $level + 1));
        }
    }
    return $arr;
}

//同类型下拉分类列表
function recursive_menu($list,$type_id,$classify_pid='1',$recursive=array()){
    foreach($list as $k=>$v)
    {
        $joinStr = '|';
        if($v['type_id']==$type_id){
            $middleware['classify_id'] = $v['classify_id'];
            for ($i = 1; $i < $v['level_id']; $i++) {
                $joinStr .= '-';
            }
            $middleware['classify_name'] = $joinStr.$v['classify_id'].':'.$v['classify_name'];
            array_push($recursive,$middleware);
        }
    }

    return $recursive;
}

//字母序列化为数字
function ABC2decimal($abc)
{
    $ten = 0;
    $len = strlen($abc);
    for ($i = 1; $i <= $len; $i++) {
        $char = substr($abc, 0 - $i, 1);//反向获取单个字符
        $int = ord($char);
        $ten += ($int - 65) * pow(26, $i - 1);
    }
    return $ten;
}

//建立文件
function creat_file($path)
{
    if (!file_exists($path)) {
        if (touch($path)) {
            return true;
        } else {
            return false;
        }
    }
}

//写入文件-生成静态文件
function write_file($path, $data)
{
    creat_file($path);
    $fp = fopen($path, "w+");
    if (!fwrite($fp, $data)) {
        return false;
    } else {
        fclose($fp);
        return true;
    }
}

//读取文件
function read_file($path)
{
    $filename = $path;
    $handle = fopen($filename, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
    $filesize = filesize($filename);
    if ($filesize > 0) {
        $contents = fread($handle, $filesize);
    }
    fclose($handle);
    return $contents;
}

//删除文件
function delete_file($path)
{
    if (file_exists($path)) {
        unlink($path);
    }
}

//复制文件
function copy_dir($sourceDir, $aimDir)
{
    $succeed = true;
    if (!file_exists($sourceDir)) {
        return false;
    }
    if (!file_exists($aimDir)) {
        if (!mkdir($aimDir, 0777)) {
            return false;
        }
    }
    $objDir = opendir($sourceDir);
    while (false !== ($fileName = readdir($objDir))) {
        if (($fileName != ".") && ($fileName != "..")) {
            if (!is_dir($sourceDir . '/' . $fileName)) {
                if (!copy($sourceDir . '/' . $fileName, $aimDir . '/' . $fileName)) {
                    $succeed = false;
                    break;
                }
            } else {
                copy_dir($sourceDir . '/' . $fileName, $aimDir . '/' . $fileName);
            }
        }
    }
    closedir($objDir);
    return $succeed;
}

//创建文件夹
function create_dir($dir)
{
    if (!is_dir($dir)) {
        if (!create_dir(dirname($dir))) {
            return false;
        }
        if (!mkdir($dir, 0777)) {
            return false;
        }
    }
    return true;
}

//删除文件夹
function del_dir($dir)
{
    if (!file_exists($dir)) {
        return true;
    } else {
        @chmod($dir, 0777);
    }
    $dh = opendir($dir);
    while ($file = readdir($dh)) {
        if ($file != "." && $file != "..") {
            $fullpath = $dir . "/" . $file;
            if (!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                del_dir($fullpath);
            }
        }
    }
    closedir($dh);

    if (rmdir($dir)) {
        return true;
    } else {
        return false;
    }
}