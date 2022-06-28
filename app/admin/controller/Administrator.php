<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Administrator extends BaseController
{
    //管理员--页面
    public function index()
    {
        $data = Db::name('user')->where('user_id','>',1)->paginate(20)->each(function($item, $key){
            $item['role'] = '';
            $user_role = Db::name('user_role')->where('user_id='.$item['user_id'])->field('role_id')->select()->toArray();
            foreach ($user_role as $val){
                $item['role'] .= Db::name('role')->where('role_id='.$val['role_id'])->value('role_name').',';
            }
            $item['role'] = trim($item['role'],',');
            return $item;
        });
        return view('',[
            'list'=>$data,
        ]);
    }

    //添加管理员--页面
    public function list_add(){
        $role = Db::name('role')->field('role_id,role_name')->select()->toArray();
        return view('',[
            'role'=>$role,
        ]);
    }

    //添加管理员--保存
    public function add_save(){
        $data = $_REQUEST;

        if(isset($data['state'])){
            $data['state'] = 1;
        }else{
            $data['state'] = 2;
        }
        $data['password']=md5($data['password']);
        $user = Db::name('user')->where(array('username'=>$data['username']))->find();
        if($user){
            $arr['code'] = '300';
            $arr['msg'] = '登陆名已存在，请重新输入';
            echo json_encode($arr);
            die();
        }
        $data['date'] = time();
        $data['state'] = 1;
        $res = Db::name('user')->insertGetId($data);
        if($res){
            foreach ($data['role'] as $k=>$v){
                $data2['user_id'] = $res;
                $data2['role_id'] = $v;
                Db::name('user_role')->save($data2);
            }
            $arr['code'] = '200';
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }else{
            $arr['code'] = '300';
            $arr['msg'] = '操作失败';
            echo json_encode($arr);
            die();
        }
    }

    //编辑管理员--页面
    public function list_edit(){
        $user_id = pg('user_id');
        $administrator = Db::name('user')->where('user_id='.$user_id)->find();
        $role = Db::name('role')->field('role_id,role_name')->select()->toArray();
        $user_role = array();
        $list = Db::name('user_role')->where('user_id='.$user_id)->field('role_id')->select()->toArray();
        foreach ($list as $k=>$v){
            array_push($user_role,$v['role_id']);
        }
        return view('',[
            'administrator'=>$administrator,
            'role'=>$role,
            'user_role'=>$user_role,
        ]);
    }

    // 编辑管理员--保存
    public function edit_save(){
        $data = $_REQUEST;
        $user=Db::name('user')->where(array('user_id'=>$data['user_id']))->find();
        if($data['password']!='')
        {
            if(intval($user['secret'])){
                $data['password']=md5(md5($data['password']).$user['secret']);
            }else{
                $data['password']=md5($data['password']);
            }
        }
        else
        {
            unset($data['password']);
        }
        if(isset($data['state'])){
            $data['state'] = 1;
        }else{
            $data['state'] = 2;
        }

        $res = Db::name('user')->save($data);
        if($res>=0){
            //删除数据库原绑定的角色数据
            $user_role = Db::name('user_role')->where('user_id='.$data['user_id'])->select()->toArray();
            $glids = array();
            foreach ($user_role as $v){
                if(in_array($v['role_id'],$data['role'])){
                    array_push($glids,$v['role_id']);
                }else{
                    Db::name('user_role')->where('user_role_id='.$v['user_role_id'])->delete();
                }
            }
            //查找新添加的角色
            $difference = array_merge(array_diff($data['role'],$glids),array_diff($glids,$data['role']));
            foreach ($difference as $v){
                $data2['user_id'] = $data['user_id'];
                $data2['role_id'] = $v;
                Db::name('user_role')->save($data2);
            }
            $arr['code'] = '200';
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }else{
            $arr['code'] = '300';
            $arr['msg'] = '操作失败';
            echo json_encode($arr);
            die();
        }
    }

    //角色页面
    public function role()
    {
        $list = Db::name('role')->paginate(20)->each(function($item, $key){
            $item['user'] = '';
            $user_role = Db::name('user_role')->where('role_id='.$item['role_id'])->field('user_id')->select()->toArray();
            foreach ($user_role as $val){
                $item['user'] .= Db::name('user')->where('user_id='.$val['user_id'])->value('name').',';
            }
            $item['user'] = trim($item['user'],',');
            return $item;
        });
        return view('',[
            'list'=>$list,
        ]);
    }

    //添加角色--页面
    public function role_add()
    {
        $admin_classify = Db::name('admin_classify')->where('classify_pid=1')->order('date','asc')->select()->toArray();
        foreach ($admin_classify as &$v){
            if($v['admin_classify_id']==3){
                $v['subclass'] = Db::name('classify')->where('classify_pid=1')->order('date','asc')->select()->toArray();
            }else{
                $v['subclass'] = Db::name('admin_classify')->where('classify_pid='.$v['admin_classify_id'])->order('date','asc')->select()->toArray();
            }

        }
        $rule = Db::name('rule')->select()->toArray();
        return view('',[
            'admin_classify'=>$admin_classify,
            'rule'=>$rule,
        ]);
    }

    //添加角色--保存
    public function role_add_save()
    {

        $data = $_REQUEST;
        $res = Db::name('role')->insertGetId($data);
        if($res){
            foreach ($data['rule'] as $k=>$v){
                $data2['admin_classify_id'] = $k;
                foreach ($v as $val){
                    $data2['rule_id'] = $val;
                    $data2['role_id'] = $res;
                    Db::name('rule_role')->save($data2);
                }
            }
            foreach ($data['rule2'] as $k=>$v){
                $data3['classify_id'] = $k;
                //$data3['admin_classify_id'] = 3;
                foreach ($v as $val){
                    $data3['rule_id'] = $val;
                    $data3['role_id'] = $res;
                    Db::name('rule_role')->save($data3);
                }
            }
            $arr['code'] = '200';
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }else{
            $arr['code'] = '300';
            $arr['msg'] = '操作失败';
            echo json_encode($arr);
            die();
        }
    }

    //编辑角色--页面
    public function role_edit()
    {
        $role_id = pg('role_id');
        $role = Db::name('role')->where('role_id='.$role_id)->find();
        //分类列表
        $admin_classify = Db::name('admin_classify')->where('classify_pid=1')->order('date','asc')->select()->toArray();
        foreach ($admin_classify as &$v){
            if($v['admin_classify_id']==3){
                $v['subclass'] = Db::name('classify')->where('classify_pid=1')->order('date','asc')->select()->toArray();
            }else{
                $v['subclass'] = Db::name('admin_classify')->where('classify_pid='.$v['admin_classify_id'])->order('date','asc')->select()->toArray();
            }
            if($v['subclass']){
                if($v['admin_classify_id']==3){
                    foreach ($v['subclass'] as &$val){
                        $rule_arr = Db::name('rule_role')->where([['role_id','=',$role_id],['classify_id','=',$val['classify_id']]])->column('rule_id');
                        $val['rule'] = $rule_arr;
                    }
                }else{
                    foreach ($v['subclass'] as &$val){
                        $rule_arr = Db::name('rule_role')->where([['role_id','=',$role_id],['admin_classify_id','=',$val['admin_classify_id']]])->column('rule_id');
                        $val['rule'] = $rule_arr;
                    }
                }

            }else{
                $rule_arr = Db::name('rule_role')->where([['role_id','=',$role_id],['admin_classify_id','=',$v['admin_classify_id']]])->column('rule_id');
                $v['rule'] = $rule_arr;
            }
        }

        //权限列表
        $rule = Db::name('rule')->select()->toArray();
        return view('',[
            'role'=>$role,
            'admin_classify'=>$admin_classify,
            'rule'=>$rule,
        ]);
    }

    //编辑角色--保存
    public function role_edit_save()
    {
        $data = $_REQUEST;
        $res = Db::name('role')->save($data);
        if($res>=0){
            Db::name('rule_role')->where('role_id='.$data['role_id'])->delete();
            foreach ($data['rule'] as $k=>$v){
                $data2['role_id'] = $data['role_id'];
                $data2['admin_classify_id'] = $k;
                foreach ($v as $val){
                    $data2['rule_id'] = $val;
                    Db::name('rule_role')->save($data2);
                }
            }
            foreach ($data['rule2'] as $k=>$v){
                $data3['role_id'] = $data['role_id'];
                $data3['classify_id'] = $k;
                foreach ($v as $val){
                    $data3['rule_id'] = $val;
                    Db::name('rule_role')->save($data3);
                }
            }
            $arr['code'] = '200';
            $arr['msg'] = '操作成功';
            echo json_encode($arr);
            die();
        }else{
            $arr['code'] = '300';
            $arr['msg'] = '操作失败';
            echo json_encode($arr);
            die();
        }
    }

    //权限管理
    public function rule()
    {
        return view();
    }

    //管理员启用、禁用
    public function show_hide(){
        $data['user_id'] = pg('id');
        $data['state'] = pg('show_id');
        $res = Db::name('user')->save($data);
        echo $res;
    }
}