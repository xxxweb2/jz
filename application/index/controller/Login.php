<?php

namespace app\index\controller;


use think\Db;

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
        return $this->fetch();
    }
}
