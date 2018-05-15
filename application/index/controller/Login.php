<?php

namespace app\index\controller;


use think\Db;
use think\Request;

class Login extends BaseController
{
    public function index()
    {
        return $this->fetch();
    }

    public function select()
    {
        return $this->fetch();
    }

    public function user()
    {
        return $this->fetch();
    }

    public function employees()
    {
//   查询家政类型
        $service = Db::name('service')->where(array('flag' => 0))->order('order desc, id desc')->select();
        $this->assign("list", $service);

        //   查询地点
        $addrList = Db::name('addr')->select();
        $this->assign("addrList", $addrList);

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

//        先查找用户表判断是否存在 如果存在则判断密码是否正确
        $count = Db::name('user')->where(array('email' => $username, 'password' => $password))->find();
        if (!is_null($count)) {
            session('user', $count);
            session('userType', 1);
            $this->success('登陆成功', '/');
            exit();
        }

        $count = Db::name('yuan')->where(array('email' => $username, 'password' => $password))->find();
        if (!is_null($count)) {
            session('userType', 2);
            session('user', $count);
            $this->success('登陆成功', '/');
            exit();
        }

        $this->error('账号或者密码错误，请重新登陆', '/index/login/index');
        exit();
    }

    public function logout()
    {
        session('user', null);
        session('userType', null);

        $this->success('退出登陆成功', "/index/Employee/listEmployee");
    }
}
