<?php
declare(strict_types=1);
namespace app\admin\middleware;
use think\facade\Session;

/**
 * Class LoginMiddleware 登录控制中间件
 * @package app\admin\middleware
 */
class Auth
{
    public function handle($request, \Closure $next)
    {

        // 前置中间价
        $adminData = session('user_id');
        if (empty($adminData) && !preg_match('/login/i', $request->pathinfo())) {
            return redirect((string)url('admin/login/'));
        }

        return $next($request);
    }
}
