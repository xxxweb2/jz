<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Cache;

class Index extends BaseController
{
    public function index()
    {


//        if (Cache::has('index')) {
//            return Cache::get('index');
//        }

//        获取推荐用户
        $userList = Db::name('yuan')->order('id desc')->limit(6)->select();

        foreach ($userList as $key => $user) {
            $addrid = $user['addrid'];
            $addr = Db::name('addr')->where(array('id' => $addrid))->field('name')->find();
            $userList[$key]['addrname'] = $addr['name'];
        }
        $this->assign('userList', $userList);


//        获取新闻推荐
        $newsList = Db::name('news')->order('id desc')->limit(3)->select();
        $this->assign('newsList', $newsList);


//        Cache::set('index', $this->fetch(), 60);
        return $this->fetch();
    }

    private function getIndexNews()
    {
        return Db::name('news')->order('id desc')->limit(3)->select();
    }

}
