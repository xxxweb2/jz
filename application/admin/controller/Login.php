<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 上午 9:23
 */

namespace app\admin\controller;

use think\Db;
use think\Request;
use think\Session;

class Login extends \app\admin\controller\BaseController
{
    public function index()
    {
        return $this->fetch();
    }

    public function check()
    {
        $request = Request::instance();

        $captcha = $request->post('qrcode');
        if (!captcha_check($captcha)) {
            //验证失败
            $this->error('验证码输入错误，请重新输入', '/index/login/index');
        };

//        获取账号
        $username = $request->post('username');
        $password = $request->post('password');

        if ($username != 'admin' || $password != 'admin') {
            $this->error('账号或者密码错误，请重新登陆', '/index/login/index');
            exit();
        }
        $count = Db::name('user')->where(array('id' => 1))->find();

        session('user', $count);
        session('userType', 3);
        $this->success('登陆成功', '/admin/index/index');
    }

    public function logout()
    {
        Session::clear();
    }

}