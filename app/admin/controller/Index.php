<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;


class Index extends BaseController
{
    public function index()
    {
        $role_id = db::name('user')->alias('u')->join('user_role c','u.user_id=c.user_id')->where('u.user_id='.session('user_id'))->value('role_id');
        if($role_id==1){ //开发者
            $classify = Db::name('admin_classify')->where('classify_pid=1')->select()->toArray();
            foreach ($classify as &$v){
                $v['subclass'] = Db::name('admin_classify')->where('classify_pid='.$v['admin_classify_id'])->select()->toArray();
            }
            $classify2 = Db::name('classify')->where('classify_pid=1')->select()->toArray();
        }else{ //其他管理员
            $roleStr = ''; //获取角色权限ID
            $role = db::name('user')->alias('u')->join('user_role c','u.user_id=c.user_id')->where('u.user_id='.session('user_id'))->select()->toArray();
            foreach ($role as $v){
                $roleStr .= $v['role_id'].',';
            }
            $admin_classify_id = array(); //获取角色对应的导航内容ID
            $classify_id = ''; //获取分类管理内容ID
            $admin_classify = db::name('rule_role')->whereIn('role_id',$roleStr)->where('rule_id=1')->select()->toArray();
            foreach ($admin_classify as $v){
                array_push($admin_classify_id,$v['admin_classify_id']);
                $classify_id .= $v['classify_id'].',';
            }
            $classify = Db::name('admin_classify')->where('classify_pid=1')->select()->toArray();
            foreach ($classify as $k=>&$v){
                $child_classify_id = array(); //获取导航对应的子ID
                $child_classify = Db::name('admin_classify')->where('classify_pid='.$v['admin_classify_id'])->field('admin_classify_id')->select()->toArray();
                foreach ($child_classify as $v2){
                    array_push($child_classify_id,$v2['admin_classify_id']);
                }
                if($v['admin_classify_id']==3&&trim($classify_id,',')){
                    $classify2 = Db::name('classify')->whereIn('classify_id',trim($classify_id,','))->where('classify_pid=1')->select()->toArray();
                }else if(!in_array($v['admin_classify_id'],$admin_classify_id) && empty(array_intersect($child_classify_id,$admin_classify_id))){
                    unset($classify[$k]);
                }else{
                    $v['subclass'] = Db::name('admin_classify')->whereIn('admin_classify_id',array_intersect($child_classify_id,$admin_classify_id))->select()->toArray();
                }
            }

        }
        return view('',[
            'classify'=>$classify,
            'classify2'=>$classify2,
        ]);
    }

    public function code()
    {
        $code = pg('verify');
        if (!captcha_check($code)) {
            echo 1;
        }
    }

    //清缓存
    public function del_cache(){

        $res = deldir(root_path().'runtime');
        echo $res;
    }

}