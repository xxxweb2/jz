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

    public function cancelOrder()
    {
//        首先判断是否为用户账号

        $userType = session('userType');

        if ($userType != 1) {
            $this->error('您不能删除该订单', '/');
            exit();
        }


        $user = session('user');
//        $userType = session('userType');
//        再次判断是否为该用户的订单
        $request = Request::instance();
        $id = $request->post('id');
        $info = $request->post('rea');
        $userid = $request->post('userid');

        if ($user['id'] != $userid) {
            $this->error('您不能删除该订单', '/');
            exit();
        }

        $res = Db::name('user_yuan')->where(array('id' => $id))->update(array('info' => $info, 'state' => 4));
        if (!$res) {
            $this->error('操作失败，请稍后重试', '/');
            exit();
        }
        $this->success('申请退单中', '/index/person/order');
    }

//评价

    public function eva()
    {

        $request = Request::instance();
//       evaOrderId
//eva

        $evaOrderId = $request->post('evaOrderId');

        $eva = $request->post('eva');

        $evaUserId = $request->post('evaUserId');

        Db::name('user_yuan')->where(array('id'=>$evaOrderId))->update(array('eva'=>1));




//        获取家政人员评分
        $emp = Db::name('yuan')->where(array('id'=>$evaOrderId))->find();
        $sort = $emp['sort'];
        $count = Db::name('user_yuan')->where(array('yuanid'=>$evaOrderId, 'state'=>3))->count();

        $sort = ($sort*($count-1)+$eva)/$count;


        $res =  Db::name('yuan')->where(array('id'=>$evaOrderId))->update(array('sort'=>$sort));


//        获取家政人员一共接过多少单

        if ($res) {
            $this->success('评价成功', '/index/person/order');
        } else {
            $this->error('评价失败，请稍后重试', '/index/person/order');
        }
    }
}