<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 上午 8:58
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class Order extends BaseController
{
    public function addOrder()
    {

        $request = Request::instance();
        $id = $request->get('id');

//        判断用户是否登陆
        $user = session('user');
        if (is_null($user)) {
            $data['code'] = 1;
            $data['msg'] = '没有登录, 请先登陆';
            return json($data);
        }

        $userType = session('userType');
        if ($userType == 2) {
            $data['code'] = 2;
            $data['msg'] = '请先登陆用户账号';
            return json($data);
        }
        $create_time = date('Y-m-d H:i:s', time());
        $yz = array('yuanid' => $id, 'userid' => $user['id'], 'create_time' => $create_time);
        $res = Db::name('user_yuan')->insert($yz);
        if (!$res) {
            $data['code'] = 3;
            $data['msg'] = '预约失败，请稍后重试';
        } else {
            $data['code'] = 0;
            $data['msg'] = '预约成功';
        }
        return json($data);
    }

}