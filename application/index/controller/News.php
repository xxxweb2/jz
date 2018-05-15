<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 下午 10:20
 */

namespace app\index\controller;


class News extends BaseController
{
    public function index()
    {
        return $this->fetch();
    }
    public function detail(){
        return $this->fetch();
    }

}