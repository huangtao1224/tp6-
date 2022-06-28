<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Input extends BaseController
{
    //表单列表页面
    public function index()
    {
        $id = pg('content_id');
        $list = Db::name('input')->where(array('type_id'=>$id,'input_pid'=> NULL))->order('date','asc')->select()->toArray();
        foreach ($list as &$v){
            $v['is_parent'] = Db::name('input_type')->where('input_type_id='.$v['input_type_id'])->value('is_parent');
            $v['child'] = Db::name('input')->where('input_pid='.$v['input_id'])->order('date','asc')->select()->toArray();
        }
        $type_list = Db::name('input_type')->select()->toArray();
        $data_list = Db::name('data_type')->select()->toArray();
        return view('',[
            'id'=>$id,
            'list'=>$list,
            'type_list'=>$type_list,
            'data_list'=>$data_list,
        ]);
    }

    //表单添加--页面
    public function add(){
        $type_id = pg('content_id');
        $list = Db::name('input_type')->select()->toArray();
        $list2 = Db::name('data_type')->select()->toArray();
        return view('',[
            'type_id'=>$type_id,
            'list'=>$list,
            'list2'=>$list2,
        ]);
    }

    //表单添加--保存
    public function add_save(){
        $data = $_REQUEST;
        $data['date'] = time();
        $input = Db::name('input')->where([['type_id','=',$data['type_id']],['field_name','=',$data['field_name']]])->find();
        if($input){
            $arr['code'] = 300;
            $arr['msg'] = '字段名重复，重新输入';
            echo json_encode($arr);
            die();
        }
        $re = Db::name('input')->save($data);
        if($re){
            $list = Db::name('data_type')->where(array('data_type_id'=>$data['data_type_id']))->find();

            if ($list['value'] == 'longtext') {
                $field_type = $list['value'];
            } else if ($list['value'] == 'decimal') {
                $field_type = $list['value'] . '(' . $data['data_length'] . ',' . $data['decimal_point'] . ')';
            } else {
                $field_type = $list['value'] . '(' . $data['data_length'] . ')';
            }
            $list=Db::name('classify_type')->where(array('type_id'=>$data['type_id']))->find();
            $sql='ALTER TABLE index_'.$list['table_name'].' add '.$data['field_name'].' '.$field_type;
            Db::execute($sql);
            $arr['code'] = 200;
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }else{
            $arr['code'] = 300;
            $arr['msg'] = '操作失败';
            echo json_encode($arr);
            die();
        }
    }

    //表单批量提交
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
            $list = Db::name('input')->where(array('input_id' => $v['input_id']))->find();
            $type_id = $list['type_id'];
            $arr['field_name'] = $list['field_name'];

            Db::name('input')->where(array('input_id' => $v['input_id']))->save($v);

            $list = Db::name('data_type')->where(array('data_type_id' => $v['data_type_id']))->find();

            if ($list['value'] == 'longtext') {
                $arr['field_type'] = $list['value'];
            } else if ($list['value'] == 'decimal') {
                $arr['field_type'] = $list['value'] . '(' . $v['data_length'] . ',2)';
            } else {
                $arr['field_type'] = $list['value'] . '(' . $v['data_length'] . ')';
            }

            $arr['new_field_name'] = $v['field_name'];
            $table_name = Db::name('classify_type')->where(array('type_id' => $type_id))->value('table_name');
            if($arr['field_name']!=''){
                $sql = 'ALTER TABLE index_' . $table_name . ' change ' . $arr['field_name'] . ' ' . $arr['new_field_name'] . ' ' . $arr['field_type'] . ' NULL';
                Db::query($sql);
            }
        }
        $arr['code'] = 200;
        $arr['msg'] = '操作成功';
        echo json_encode($arr);
        die();
    }

    //表单子类--页面
    public function child_add(){
        $input_pid = pg('input_pid');
        $type_id = Db::name('input')->where('input_id='.$input_pid)->value('type_id');
        return view('',[
            'input_pid'=>$input_pid,
            'type_id'=>$type_id,
        ]);
    }

    //表单子类--添加
    public function child_add_save(){
        $data = $_REQUEST;
        $data['date'] = time();
        $res = Db::name('input')->data($data)->save();
        if($res){
            $arr['code'] = 200;
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }else{
            $arr['code'] = 300;
            $arr['msg'] = '操作失败';
            echo json_encode($arr);
            die();
        }
    }

    //表单删除
    public function del_save(){
        $input_id = pg('id');
        if($input_id!='') {
            $input = Db::name('input')->where('input_id='.$input_id)->find();
            $table_name = Db::name('classify_type')->where('type_id='.$input['type_id'])->value('table_name');
            $table_name='index_'.$table_name;
            Db::name('input')->where(array('input_id'=>$input_id))->delete();
            if($input['input_pid']==''){
                $sql='ALTER TABLE '.$table_name.' drop column '.$input['field_name'];
                Db::query($sql);
            }
            $arr['code'] = 200;
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }else{
            $arr['code'] = 300;
            $arr['msg'] = '操作失败';
            echo json_encode($arr);
            die();
        }
    }
}