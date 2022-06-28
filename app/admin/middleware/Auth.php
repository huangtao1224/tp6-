<?php
declare(strict_types=1);
namespace app\admin\middleware;
use think\facade\Session;

/**
 * Class LoginMiddleware ��¼�����м��
 * @package app\admin\middleware
 */
class Auth
{
    public function handle($request, \Closure $next)
    {

        // ǰ���м��
        $adminData = session('user_id');
        if (empty($adminData) && !preg_match('/login/i', $request->pathinfo())) {
            return redirect((string)url('admin/login/'));
        }

        return $next($request);
    }
}
