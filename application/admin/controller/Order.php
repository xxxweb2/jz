<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 下午 12:05
 */

namespace app\admin\controller;


use think\Db;

class Order extends BaseController
{
    public function index()
    {
//        获取所有订单信息

        $orderList = Db::name('user_yuan')->select();


//        通过yuanid查询员工姓名
        foreach ($orderList as $key => $order) {

            $yuanid = $order['yuanid'];
            $userid = $order['userid'];

            $yun = Db::name('yuan')->where(array('id' => $yuanid))->find();
            $user = Db::name('user')->where(array('id' => $userid))->find();
            $orderList[$key]['yunName'] = $yun['name'];
            $orderList[$key]['userName'] = $user['name'];
        }

//        通过userid查询用户姓名
        $this->assign('orderList', $orderList);
        return $this->fetch();

    }

}