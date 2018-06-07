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


            $this->success('登录成功', '/');
            exit();
        }

        $count = Db::name('yuan')->where(array('email' => $username, 'password' => $password))->find();
        if (!is_null($count)) {
            if ($count['state'] == 0) {
                $this->error('账号审核中，暂不能登录', '/index/login/index');
                exit();
            }
            if ($count['state'] == 1) {
                $this->error('账号审核未通过，暂不能登录', '/index/login/index');
                exit();
            }


            session('userType', 2);
            session('user', $count);
            $this->success('登录成功', '/');
            exit();
        }

        $this->error('账号或者密码错误，请重新登录', '/index/login/index');
        exit();
    }

    public function logout()
    {
        session('user', null);
        session('userType', null);



        $this->success('退出登录成功', "/index/login/index");
    }

    public function pwd()
    {
        return $this->fetch();
    }

    public function sendEmailToPwd()
    {

        $request = Request::instance();
        if (!$request->isAjax()) {
            $this->error("···············");
            exit();
        }
        $type = 1;
//        首先查找该邮箱是否注册在账号表中
        $email = $request->get('email');
        $user = Db::name('user')->where(array('email' => $email))->count();
        if ($user == 0) {
            $type = 2;
            $user = Db::name('yuan')->where(array('email' => $email))->count();
        }
        if ($user == 0) {
            $data['code'] = 1;
            return json($data);
        }
        $code = rand(1000, 9999);
        sendEmail($email, "验证码: " . $code);
        $data['code'] = 0;
        session('checkEmail', $email);
        session('checkCode', $code);
        session('type', $type);
        return json($data);
    }

    public function resetPwd()
    {
        $request = Request::instance();
        $email = $request->post('email');
        $code = $request->post('code');
        $password = $request->post('password');
        $rpassword = $request->post('rpassword');

        if ($password != $rpassword) {

            $this->error('两次输入的密码不一致', '/index/login/pwd');
        }

        $checkEmail = session('checkEmail');
        $checkCode = session('checkCode');
//        print_r("checkEmail: " . $checkEmail . ' | email: ' . $email . ' | checkcode: ' . $checkCode . ' : code: ' . $code);
        if ($checkEmail != $email || $checkCode != $code) {

            $this->error('验证码错误', '/index/login/pwd');
        }
        $type = session('type');
        if ($type == 1) {
            $table = "user";
        } else {
            $table = "yuan";
        }
        $res = Db::name($table)->where(array('email' => $email))->update(array('password' => $password));
        if ($res) {
            $this->success('密码重置成功', '/index/login/index');
        } else {
            $this->error('稍后重试', '/index/login/pwd');
        }

    }
}
