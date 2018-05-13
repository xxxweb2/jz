<?php

namespace app\index\controller;


use think\Db;
use think\Request;

class User extends BaseController
{
    public function saveUser()
    {
        $request = Request::instance();
        $user = $request->post();
        unset($user['rpassword']);

//        查询邮箱是否 已经被注册

        $userItem = Db::name('user')->where(array('email' => $user['email']))->find();

        if (!is_null($userItem)) {
            $this->error('注册失败，该邮箱已经被注册', '/index/login/user');
            exit;
        }

//        生成随机串

        $str = $user['name'] . $user['password'] . $user['email'];
        $str = md5($str);
        $str .= rand(0, 100);
        $str = sha1($str);

        $user['emilestr'] = $str;
//        sendEmail("1070529431@qq.com", "http://xxxweb.top/index/user/checkEmail?str=" . $str);
//        发邮件

        $res = Db::name("user")->insert($user);

        if ($res) {
            $this->success("注册成功", '/index/login/index');
        } else {
            $this->error('注册失败，请重新注册', '/index/login/user');
        }

    }


    public function checkEmail()
    {
        $request = Request::instance();
        $str = $request->get('str');

        $res = Db::name('user')->where(array('emilestr' => $str))->find();
        if ($res) {
            Db::name('user')->where(array('emilestr' => $str))->update(array('isemail' => 1));
            $this->success('激活成功', '/index/login/index');
        } else {
            $this->error('激活失败');
        }

    }


    public function saveEmployees()
    {
        $request = Request::instance();
        $user = $request->post();
        unset($user['rpassword']);

//        查询邮箱是否 已经被注册
//        employees


        $userItem = Db::name('yuan')->where(array('email' => $user['email']))->find();

        if (!is_null($userItem)) {
            $this->error('注册失败，该邮箱已经被注册', '/index/login/employees');
            exit;
        }

//        生成随机串

        $str = $user['name'] . $user['password'] . $user['email'];
        $str = md5($str);
        $str .= rand(0, 100);
        $str = sha1($str);

        $user['emilestr'] = $str;
//        sendEmail("1070529431@qq.com", "http://xxxweb.top/index/user/checkEmployeesEmail?str=" . $str);
//        发邮件

        $res = Db::name("yuan")->insert($user);

        if ($res) {
            $this->success("注册成功", '/index/login/index');
        } else {
            $this->error('注册失败，请重新注册', '/index/login/employees');
        }
    }

    public function checkEmployeesEmail()
    {
        $request = Request::instance();
        $str = $request->get('str');

        $res = Db::name('yuan')->where(array('emilestr' => $str))->find();
        if ($res) {
            Db::name('yuan')->where(array('emilestr' => $str))->update(array('isemail' => 1));
            $this->success('激活成功', '/index/login/index');
        } else {
            $this->error('激活失败');
        }
    }

    public function uploadFile()
    {
        $data = array();

        // 获取表单上传文件 例如上传了001.jpg

        $file = request()->file('file0');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 成功上传后 获取上传信息
//                // 输出 jpg
//                echo $info->getExtension();
//                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();
                $data['msg'] = $info->getSaveName();
            } else {
                // 上传失败获取错误信息
                $data['msg'] = $file->getError();
            }
        }

        return json($data);
    }

}