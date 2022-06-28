<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Region extends BaseController
{
    public function index()
    {
        $list = Db::name('region')->where('region_pid=0')->select()->toArray();
        return view('',[
            'list'=>$list,
        ]);
    }

    //城市 ------  省份 ------ 市区
    public function city()
    {
        $region_pid = pg('region_pid');
        $region_type = pg('region_type')+1;
        $list = Db::name('region')->where('region_pid='.$region_pid)->select()->toArray();
        $str = '';$str2 = '';
        switch ($region_type) {
            case 1:
                $str = '添加省份';
                $str2 = '城市';
                break;
            case 2:
                $str = '添加城市';
                $str2 = '市区';
            break;
            case 3:
                $str = '添加市区';
                break;
            default:
                break;
        }
        return view('',[
            'title'=>$str,
            'title2'=>$str2,
            'region_pid'=>$region_pid,
            'region_type'=>$region_type,
            'list'=>$list,
        ]);
    }

    public function add()
    {
        $region_pid = pg('region_pid');
        $region_type = pg('region_type');

        return view('',[
            'region_type'=>$region_type,
            'region_pid'=>$region_pid,
        ]);
    }

    public function add_save()
    {
        $data = pg('data');
        $res = Db::name('region')->strict(false)->insert($data);
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

    public function edit()
    {
        $region_id = pg('region_id');
        $region_name = Db::name('region')->where('region_id='.$region_id)->value('region_name');
        return view('',[
            'region_id'=>$region_id,
            'region_name'=>$region_name,
        ]);
    }

    public function edit_save()
    {
        $data = pg('data');
        if($data['region_id']){
            Db::name('region')->save($data);
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

    public function del_save(){
        $region_id = pg('id');
        $res = Db::name('region')->where(array('region_id'=>$region_id))->delete();
        if($res){
            Db::name('region')->where(array('region_pid'=>$region_id))->delete();
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