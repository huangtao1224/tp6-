<?php

namespace app\admin\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\View;

class Common extends BaseController
{
    public function index()
    {

        return view();
    }

    //主页
    public function welcome()
    {
        $version = Db::query("select version() as ver");
        $mysql_version =  $version[0]['ver'];
        View::assign("mysql_version",$mysql_version);
        return view();
    }

    //验证码
    public function code()
    {
        $code = pg('verify');
        if (!captcha_check($code)) {
            echo 1;
        }
    }

}