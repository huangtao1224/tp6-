<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Classify extends BaseController
{
    public function index()
    {
        $classify_id = pg('classify_id');
        //当前分类
        $list = Db::name('classify')->where('classify_id='.$classify_id)->find();
        $list['count'] = Db::name('classify')->where('classify_pid='.$classify_id)->count();
        $list['type_name'] = Db::name('classify_type')->where('type_id='.$list['type_id'])->value('type_name');
        if($list['type_id']!=1){
            $table_name = Db::name('classify_type')->where('type_id='.$list['type_id'])->value('table_name');
            $list['relevanceTotal'] = Db::table('index_'.$table_name)->alias('c')->join(['index_relevance'=>'r'],'r.classify_id='.$classify_id.' and r.content_id='.$table_name.'_id')->count()?:0;
        }else{
            $list['relevanceTotal'] = 0;
        }

        //无限分类
        $list2 = Db::name('classify')->select()->toArray();
        foreach ($list2 as &$v){
            $v['count'] = Db::name('classify')->where('classify_pid='.$v['classify_id'])->count();
            $v['type_name'] = Db::name('classify_type')->where('type_id='.$v['type_id'])->value('type_name');
            if($v['type_id']!=1){
                $table_name = Db::name('classify_type')->where('type_id='.$v['type_id'])->value('table_name');
                $v['relevanceTotal'] = Db::table('index_'.$table_name)->alias('c')->join(['index_relevance'=>'r'],'r.classify_id='.$v['classify_id'].' and r.content_id='.$table_name.'_id')->count()?:0;
            }else{
                $v['relevanceTotal'] = 0;
            }
        }
        $list2 = $this->sort($list2,$classify_id,1);
        return view('',[
            'list'=>$list,
            'list2'=>$list2,
        ]);
    }

    //分类添加--页面
    public function add(){
        $classify_id = pg('classify_id');
        $classify = Db::name('classify')->where('classify_id='.$classify_id)->find();
        //无限分类列表
        $list = Db::name('classify')->select()->toArray();
        $list = treeMenu2($list, 'classify_id');
        //类型
        $type = Db::name('classify_type')->where('show_id=2')->select()->toArray();

        $input = Db::name('input')->where(array('type_id'=>3,'edit_switch'=>2))->select()->toArray();
        foreach ($input as &$v){
            switch ($v['input_type_id']){
                case 3:
                    $v['editor'] = 'editor'.mt_rand(100000,999999);
                    break;
                case 4:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    break;
                case 5:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    break;
                case 6:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    break;
            }
        }
        return view('',[
            'classify'=>$classify,
            'input'=>$input,
            'list'=>$list,
            'type'=>$type,
        ]);
    }

    //分类添加--保存
    public function add_save(){
        $data = $_REQUEST;
        $version_id = pg('version_id');
        $type_id=3;
        //多选框
        $list=Db::name('input')->where(array('type_id'=>$type_id,'edit_switch'=>2,'input_type_id'=>4))->select()->toArray();
        foreach ($list as $k => $v) {
            if(!empty($data[$v['field_name']])){
                $data[$v['field_name']] = serialize($data[$v['field_name']]);
            }
        }
        //上传口
        $list = Db::name('input')->where(array('type_id' =>$type_id, 'edit_switch' => 2, 'input_type_id' => 7))->select()->toArray();
        foreach ($list as $k => $v) {
            if (!empty($_FILES[$v['field_name']]['tmp_name'])) {
                $data[$v['field_name']] = $this->up_file(array('name' => $v['field_name']));
            }
        }
        //日期框
        $list = Db::name('input')->where(array('type_id' =>$type_id, 'edit_switch' => 2, 'input_type_id' => 8))->select()->toArray();
        foreach ($list as $k => $v) {
            $data[$v['field_name']] = strtotime($data[$v['field_name']]);
        }
        $data['level_id'] = Db::name('classify')->where('classify_id='.$data['classify_pid'])->value('level_id')+1;
        $data['date'] = time();
        $res = Db::name('classify')->save($data);
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

    //分类修改--页面
    public function edit(){
        $classify_id = pg('classify_id');
        $classify = Db::name('classify')->where('classify_id='.$classify_id)->find();
        //无限分类列表
        $list = Db::name('classify')->select()->toArray();
        $list = treeMenu2($list, 'classify_id');
        //类型
        $type = Db::name('classify_type')->where('show_id=2')->select()->toArray();

        $input = Db::name('input')->where(array('type_id'=>3,'edit_switch'=>2))->select()->toArray();
        foreach ($input as &$v){
            switch ($v['input_type_id']){
                case 3:
                    $v['editor'] = 'editor'.mt_rand(100000,999999);
                    break;
                case 4:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    if(!empty($classify[$v['field_name']])){
                        $v['site'] = @unserialize($classify[$v['field_name']]);
                    }
                    break;
                case 5:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    break;
                case 6:
                    $v['site_subclass'] = Db::name('input')->where('input_pid='.$v['input_id'])->select()->toArray();
                    break;
            }
        }
        return view('',[
            'classify'=>$classify,
            'input'=>$input,
            'list'=>$list,
            'type'=>$type,
        ]);
    }

    //分类修改--保存
    public function edit_save(){
        $data = $_REQUEST;

        $type_id = 3;
        $classify = Db::name('classify')->where('classify_id='.$data['classify_id'])->find();
        //多选框
        $list=Db::name('input')->where(array('type_id'=>$type_id,'edit_switch'=>2,'input_type_id'=>4))->select()->toArray();
        foreach ($list as $k => $v) {
            if(isset($data[$v['field_name']])){
                $data[$v['field_name']] = serialize($data[$v['field_name']]);
            }
        }
        //上传口
        $list = Db::name('input')->where(array('type_id' =>$type_id, 'edit_switch' => 2, 'input_type_id' => 7))->select()->toArray();
        foreach ($list as $k => $v) {
            if (!empty($_FILES[$v['field_name']]['tmp_name'])) {
                if (file_exists($classify[$v['field_name']])) {
                    unlink($classify[$v['field_name']]);//通过文件路径来删除
                };
                $data[$v['field_name']] = $this->up_file(array('name' => $v['field_name']));
            }
        }
        //日期框
        $list = Db::name('input')->where(array('type_id' =>$type_id, 'edit_switch' => 2, 'input_type_id' => 8))->select()->toArray();
        foreach ($list as $k => $v) {
            $data[$v['field_name']] = strtotime($data[$v['field_name']]);
        }

        $res = Db::name('classify')->save($data);
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

    //批量修改
    public function batch_edit_save()
    {
        $data = $_REQUEST;
        $newarray = array();
        foreach ($data as $k => $v) {
            foreach ($v as $key => $val) {
                $newarray[$key][$k] = $val;
            }
        }
        foreach ($newarray as $k => $v) {
            $v['date'] = strtotime($v['date']);
            Db::name('classify')->where(array('classify_id' => $v['classify_id']))->save($v);
        }
        $arr['code'] = 200;
        $arr['msg'] = '操作成功';
        echo json_encode($arr);
        die();
    }
}