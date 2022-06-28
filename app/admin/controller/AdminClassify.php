<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class AdminClassify extends BaseController
{
    public function index()
    {
        $list = Db::name('admin_classify')->where('classify_pid', '>', 0)->order('date', 'asc')->select()->toArray();
        foreach ($list as &$v){
            $v['count'] = Db::name('admin_classify')->where('classify_pid='.$v['admin_classify_id'])->count();
        }
        $list = treeMenu($list, 'admin_classify_id');
        return view('', [
            'list' => $list,
        ]);
    }

    public function add()
    {
        $admin_classify_id = pg('admin_classify_id');
        $list = Db::name('admin_classify')->where('classify_pid', '>', 0)->order('date', 'asc')->select()->toArray();
        $list = treeMenu2($list, 'admin_classify_id');
        return view('', [
            'admin_classify_id' => $admin_classify_id,
            'list' => $list,
        ]);
    }

    public function add_save()
    {
        $data = $_REQUEST;
        $level_id = Db::name('admin_classify')->where('admin_classify_id=' . $data['classify_pid'])->value('level_id');
        $data['level_id'] = $level_id + 1;
        $data['is_delete'] = 1;
        $data['date'] = time();
        $res = Db::name('admin_classify')->strict(false)->insert($data);
        if ($res) {
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

    public function edit()
    {
        $admin_classify_id = pg('admin_classify_id');
        $admin_classify = Db::name('admin_classify')->where('admin_classify_id=' . $admin_classify_id)->find();
        $list = Db::name('admin_classify')->where('classify_pid', '>', 0)->order('date', 'asc')->select()->toArray();
        $list = treeMenu2($list, 'admin_classify_id');
        return view('', [
            'list' => $list,
            'admin_classify' => $admin_classify,
        ]);
    }

    public function edit_save()
    {
        $data = $_REQUEST;
        $res = Db::name('admin_classify')->save($data);
        if ($res) {
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

    public function batch_edit_save()
    {
        $data = $_REQUEST;
        $newarray = array();
        foreach ($data as $k => $v) {
            foreach ($v as $key => $val) {
                $newarray[$key][$k] = $val;
            }
        }
        $success = 0;$fail = 0;
        foreach ($newarray as $k => $v) {
            $v['date'] = strtotime($v['date']);
            $res = Db::name('admin_classify')->save($v);
        }
        $arr['code'] = 200;
        $arr['msg'] = '操作成功';
        echo json_encode($arr);
        die();
    }
}