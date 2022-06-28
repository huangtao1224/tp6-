<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Member extends BaseController
{
    public function index()
    {
        $list = db::name('member')->paginate(20);
        $input = Db::name('input')->where(array('type_id'=>8,'list_switch'=>2))->select()->toArray();
        return view('', [
            'list' => $list,
            'input'=>$input,
        ]);
    }

    public function add()
    {
        $input = Db::name('input')->where(array('type_id'=>8,'list_switch'=>2))->select()->toArray();
        $input = $this->input_add($input);
        return view('', [
            'input'=>$input,
        ]);
    }

    public function add_save()
    {
        $data = $_REQUEST;
        $type_id = 8;
        $table_name = Db::name('classify_type')->where('type_id='.$type_id)->value('table_name');
        if($data['password']!='')
        {
            $data['title']=$data['password'];
            $data['password']=md5($data['password']);
        }
        //多选框
        $list=Db::name('input')->where(array('type_id'=>$type_id,'edit_switch'=>2,'input_type_id'=>4))->select()->toArray();
        foreach ($list as $k => $v) {
            $data[$v['field_name']] = serialize($data[$v['field_name']]);
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
        $data['date'] = time();
        $res = Db::name($table_name)->save($data);
        if ($res) {
            Db::name('relevance')->save(['classify_id'=>$data['classify_id'],'content_id'=>2,'type_id'=>$type_id]);
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
        $type_id = 8;
        $content_id = pg('content_id');
        $table_name = Db::name('classify_type')->where('type_id='.$type_id)->value('table_name');
        $content = Db::name($table_name)->where($table_name.'_id='.$content_id)->find();
        $input = Db::name('input')->where(array('type_id'=>$type_id,'edit_switch'=>2))->select()->toArray();
        $input = $this->input_edit($input,$content);
        return view('',[
            'table_name'=>$table_name,
            'type_id'=>$type_id,
            'input'=>$input,
            'content_id'=>$content_id,
            'content'=>$content,
        ]);
    }

    public function edit_save(){
        $data = $_REQUEST;
        $type_id = $data['type_id'];
        if($data['password']!='')
        {
            $data['title']=$data['password'];
            $data['password']=md5($data['password']);
        }else{
            unset($data['password']);
        }
        $table_name = Db::name('classify_type')->where('type_id='.$type_id)->value('table_name');
        $content = Db::name($table_name)->where($table_name.'_id='.$data[$table_name.'_id'])->find();
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
                if (file_exists($content[$v['field_name']])) {
                    unlink($content[$v['field_name']]);//通过文件路径来删除
                };
                $data[$v['field_name']] = $this->up_file(array('name' => $v['field_name']));
            }
        }
        //日期框
        $list = Db::name('input')->where(array('type_id' =>$type_id, 'edit_switch' => 2, 'input_type_id' => 8))->select()->toArray();
        foreach ($list as $k => $v) {
            $data[$v['field_name']] = strtotime($data[$v['field_name']]);
        }
        $data['date'] = time();
        $res = Db::name($table_name)->save($data);
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
}