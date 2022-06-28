<?php

namespace app\admin\controller;

use app\BaseController;
use think\captcha\facade\Captcha;
use think\facade\Db;

class Login extends BaseController
{
    public function index()
    {
        return view();
    }

    public function verify()
    {
        return Captcha::create('verify');
    }

    public function login_save()
    {
        $data['username'] = pg('username');
        $user = Db::name('user')->where($data)->find();

        if($user['state']!=1){
            echo '账号已禁用，请联系管理员';
            exit();
        }
        if(intval($user['secret']) && $user['password'] != md5(md5(pg('password')).$user['secret'])){
            echo '账号密码错误';
            exit();
        }
        if (empty($user)) {
            echo '查无此号，请联系管理员';
            exit();
        } else {
            $udata['user_id'] = $user['user_id'];
            $udata['date'] = $_SERVER['REQUEST_TIME'];
            $udata['secret'] = rand(100000, 900000);
            $udata['password'] = md5(md5(pg('password')) . $udata['secret']);
            Db::name('user')->save($udata);

            unset($user['password'], $user['secret']);
            session('user_id', $user['user_id']);
            setcookie('user_id', $user['user_id'], time() + 86400);
            echo '1';
        }
    }
    public function logout()
    {
        session('user_id',null);
        setcookie('user_id');
        return redirect((string)url('/admin/login/'));
    }
}
