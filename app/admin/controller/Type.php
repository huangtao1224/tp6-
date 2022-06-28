<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;

class Type extends BaseController
{
    //类型列表页
    public function index()
    {
        $table = Db::name('classify_type')->order('type_id', 'asc')->select()->toArray();
        return view('', [
            'table' => $table,
        ]);
    }

    //类型添加--页面
    public function add()
    {
        $table = Db::name('classify_type')->where('type_id>1 and show_id=2')->select()->toArray();
        return view('', [
            'table' => $table,
        ]);
    }

    //类型添加--保存
    public function add_save()
    {
        $data = $_REQUEST;
        $str = '';
        if (isset($data['glids'])) {
            for ($i = 0; $i < count($data['glids']); $i++) {
                $table_name = Db::name('classify_type')->where('type_id=' . $data['glids'][$i])->value('table_name');
                $str .= $table_name . '_id int(10) NOT NULL,';
            }
            $data['glids'] = implode(',', $data['glids']);
            $data['show_id'] = 1;
            $data['biaoshi'] = 2;
        }
        $data['date'] = time();
        $table = Db::name('classify_type')->where('table_name', '=', $data['table_name'])->select()->toArray();
        if ($table) {
            $arr['code'] = 300;
            $arr['msg'] = '表名重复，请修改';
            echo json_encode($arr);
            die();
        } else {
            $sql = "CREATE TABLE index_" . $data['table_name'] . "( " .
                $data['table_name'] . "_id INT NOT NULL AUTO_INCREMENT, " .
                "type_id int(10) NULL, " .
                "date int(10) NULL, " .
                "title VARCHAR(99) NULL, " .
                "keywords VARCHAR(199) NULL, " .
                "description VARCHAR(199) NULL, " .
                "version_id int(10) NULL," . $str .
                "PRIMARY KEY ( " . $data['table_name'] . "_id )) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            Db::query($sql);

            //记录类型
            Db::name('classify_type')->save($data);

            //创建前台相关页面
            if (!file_exists('app/index/controller/' . ucwords($data['table_name']) . '.php')) {
                copy('app/index/controller/Message.php', 'app/index/controller/' . ucwords($data['table_name']) . '.php');
                $content = read_file('app/index/controller/' . ucwords($data['table_name']) . '.php');
                $content = str_replace('Message', ucwords($data['table_name']), $content);
                write_file('app/index/controller/' . ucwords($data['table_name']) . '.php', $content);
                copy_dir('app/index/view/Message', 'app/index/view/' . ucwords($data['table_name']));
            }
            $arr['code'] = 200;
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }
    }

    //类型编辑--页面
    public function edit()
    {
        $type_id = pg('type_id');
        $list = Db::name('classify_type')->where('type_id=' . $type_id)->find();
        foreach ($list as $k => &$v) {
            if ($k == 'glids') {
                $v = explode(',', $v);
            }
        }
        $table = Db::name('classify_type')->where('type_id>1 and show_id=2')->select()->toArray();
        return view('', [
            'type_id' => $type_id,
            'list' => $list,
            'table' => $table,
        ]);
    }

    //类型编辑--保存
    public function edit_save()
    {
        $data = $_REQUEST;
        $res = Db::name('classify_type')->where('type_id=' . $data['type_id'])->find();
        if (isset($data['glids'])) {
            $glids = implode(',', $data['glids']);
            if ($glids != $res['glids']) {
                if ($res['glids'] == '') {
                    $arr = array();
                } else {
                    $arr = explode(',', $res['glids']);
                }
                $newArr = $data['glids'];
                $c = array_merge(array_diff($arr, $newArr), array_diff($newArr, $arr));
                $str = "";
                $str2 = "";
                for ($i = 0; $i < count($c); $i++) {
                    $rs = Db::name('classify_type')->where('type_id=' . $c[$i])->find();
                    if (in_array($c[$i], explode(',', $res['glids']))) {
                        $str2 .= " DROP " . $rs['table_name'] . '_id';
                    } else {
                        $str .= ' ADD ' . $rs['table_name'] . '_id int(10) NOT NULL';
                    }
                    $str = $str ? trim($str, ',') : '';
                    $str2 = $str2 ? trim($str2, ',') : '';
                    if (!empty($str)) {
                        //数据库追加字段
                        $sql = "ALTER TABLE index_" . $res['table_name'] . $str;
                    }
                    if (!empty($str2)) {
                        //删除数据库字段
                        $sql = "ALTER TABLE index_" . $res['table_name'] . $str2;
                    }
                    Db::query($sql);
                }
                Db::name('classify_type')->where('type_id=' . $data['type_id'])->data(['glids' => $glids])->save();
                $code['code'] = 200;
                $code['msg'] = '操作成功';
                echo json_encode($code);
                die();
            } else {
                $code['code'] = 300;
                $code['msg'] = '未修改数据';
                echo json_encode($code);
                die();
            }
        } else {
            $str = "";
            $glids = explode(',', $res['glids']);
            foreach ($glids as $v) {
                $rs = Db::name('classify_type')->where('type_id=' . $v)->value('table_name');
                $str .= " DROP " . $rs . '_id';
                if (!empty($str)) {
                    $sql = "ALTER TABLE index_" . $res['table_name'] . $str;
                }
                Db::query($sql);
            }
            Db::name('classify_type')->where('type_id=' . $data['type_id'])->data(['glids' => null])->save();
            $arr['code'] = 200;
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }
    }

    //类型显示、隐藏
    public function show_hide()
    {
        $data['type_id'] = pg('id');
        $data['show_id'] = pg('show_id');
        $res = Db::name('classify_type')->save($data);
        echo $res;
    }

    //删除
    public function del_save()
    {
        $type_id = pg('id');
        if ($type_id != '') {
            $classify_type = Db::name('classify_type')->where(array('type_id' => $type_id))->find();
            $sql = 'DROP TABLE IF EXISTS index_' . $classify_type['table_name'] . ';';
            Db::query($sql);//删除表

            Db::name('classify_type')->where(array('type_id' => $type_id))->delete();//删除类型
            Db::name('input')->where(array('type_id' => $type_id))->delete();//删除表单

            $arr['code'] = 200;
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        } else {
            $arr['code'] = 300;
            $arr['msg'] = '操作失败';
            echo json_encode($arr);
            die();
        }
    }

}
