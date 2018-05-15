<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 上午 9:39
 */

namespace app\admin\controller;


class Index extends BaseController
{
    public function index()
    {
        return $this->fetch();
    }
}