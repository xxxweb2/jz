<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends BaseController
{
    public function index()
    {

//        获取推荐用户
        $userList = Db::name('yuan')->order('id desc')->limit(6)->select();

        foreach ($userList as $key=>$user){
            $addrid = $user['addrid'];
            $addr = Db::name('addr')->where(array('id' => $addrid))->field('name')->find();
            $userList[$key]['addrname'] = $addr['name'];
        }
        $this->assign('userList', $userList);
        return $this->fetch();
    }
}
