<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Order extends BaseController
{
    public function index()
    {
        $state = pg('state');

        $input = Db::name('input')->where(array('type_id'=>11,'list_switch'=>2))->select()->toArray();
        $input = $this->input_add($input);
        $statelike = db::name('input')->where('input_pid=56')->select()->toArray();
        if($state){
            $list = db::name('order')->where('state='.$state)->paginate(20)->each(function($item, $key){
                $item['member_name'] = Db::name('member')->where('member_id='.$item['member_id'])->value('username');
                $item['state'] = Db::name('input')->where('input_pid=56 and input_value='.$item['state'])->value('input_name');
                return $item;
            });
        }else{
            $list = db::name('order')->paginate(20)->each(function($item, $key){
                $item['member_name'] = Db::name('member')->where('member_id='.$item['member_id'])->value('username');
                $item['state'] = Db::name('input')->where('input_pid=56 and input_value='.$item['state'])->value('input_name');
                return $item;
            });;
        }
        return view('', [
            'list' => $list,
            'input'=>$input,
            'state'=>$state,
            'statelike'=>$statelike,
        ]);
    }
    public function edit()
    {
        $content_id = pg('content_id');
        $order = db::name('order')->where('order_id='.$content_id)->find();
        $input = Db::name('input')->where(array('type_id'=>11,'edit_switch'=>2))->select()->toArray();
        $input = $this->input_edit($input,$order);
        return view('', [
            'order' => $order,
            'input' =>$input,
        ]);
    }
    public function edit_save()
    {
        $data = $_REQUEST;
        $type_id = $data['type_id'];
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
        //$data['date'] = time();
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
    public function goods(){
        $order_id = pg('content_id');
        $list = db::name('order_goods')->where('order_id='.$order_id)->select()->toArray();
        $input = Db::name('input')->where(array('type_id'=>12,'edit_switch'=>2))->select()->toArray();
        $input = $this->input_add($input);
        return view('', [
            'list' => $list,
            'input' =>$input,
        ]);
    }
}