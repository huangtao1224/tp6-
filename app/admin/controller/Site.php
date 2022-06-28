<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Site extends BaseController
{
    public function index()
    {
        $input = Db::name('input')->where([['type_id','=',2],['edit_switch','=',2],['input_pid','=',null]])->order('date','asc')->select()->toArray();
        $site = Db::name('site')->where('version_id=1')->find();
        $input = $this->input_edit($input,$site);
        return view('',[
            'site'=>$site,
            'input'=>$input,
        ]);
    }

    public function edit_save(){
        $data = $_REQUEST;
        $version_id = $data['version_id']?:'1';
        $site = Db::name('site')->where(array('version_id'=>$version_id))->find();
        //多选框
        $list=Db::name('input')->where(array('type_id'=>$data['type_id'],'edit_switch'=>2,'input_type_id'=>4))->select()->toArray();
        foreach ($list as $k => $v) {
            $data[$v['field_name']] = serialize($data[$v['field_name']]);
        }
        //上传口
        $list = Db::name('input')->where(array('type_id' => $data['type_id'], 'edit_switch' => 2, 'input_type_id' => 7))->select()->toArray();
        foreach ($list as $k => $v) {
            if (!empty($_FILES[$v['field_name']]['tmp_name'])) {
                if (file_exists($site[$v['field_name']])) {
                    unlink($site[$v['field_name']]);//通过文件路径来删除
                };
                $data[$v['field_name']] = $this->up_file(array('name' => $v['field_name']));
            }
        }
        //日期框
        $list = Db::name('input')->where(array('type_id' => $data['type_id'], 'edit_switch' => 2, 'input_type_id' => 8))->select()->toArray();
        foreach ($list as $k => $v) {
            $data[$v['field_name']] = strtotime($data[$v['field_name']]);
        }
        $res = Db::name('site') ->where('version_id='.$version_id)->data($data)->save();
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

    public function details()
    {
        return view();
    }


}