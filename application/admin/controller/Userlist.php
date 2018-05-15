<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 上午 10:38
 */

namespace app\admin\controller;


use think\Db;

class Userlist extends BaseController
{
    public function index()
    {

//        获取所有用户信息
        $userList = Db::name('user')->select();
        $this->assign('userList', $userList);
        return $this->fetch();
    }

}