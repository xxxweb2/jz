<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 下午 7:52
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class Person extends BaseController
{
    public function index()
    {
//        判断用户是否登陆
        $user = session('user');
        if (is_null($user)) {
            $this->error('请先登陆系统', 'index/login/index');
        }


        return $this->fetch();
    }

    public function update()
    {

        $request = Request::instance();
        $params = $request->post();

        $password = $params['password'];
        $newpassword = $params['newpassword'];

        unset($params['password']);
        unset($params['newpassword']);
        $id = $params['id'];
        if (!is_null($password) && !is_null($newpassword)) {
            $user = Db::name('yuan')->where(array('id' => $id))->field('password')->find();

            if ($password == $user['password']) {
                Db::name('yuan')->where(array('id' => $id))->update(array('password' => $newpassword));
            }
        }
        $name = $params['name0'];
        unset($params['name0']);
        unset($params['id']);
        $params['name'] = $name;

        $res = Db::name('yuan')->where(array('id' => $id))->update($params);
        if ($res) {
            $this->success('信息修改成功', '/index/person/index');
        } else {
            $this->error('信息修改失败， 请稍后重试', '/index/person/index');
        }
    }

    public function updateUser()
    {

        $request = Request::instance();
        $params = $request->post();

        $password = $params['password'];
        $newpassword = $params['newpassword'];

        unset($params['password']);
        unset($params['newpassword']);
        $id = $params['id'];
        if (!is_null($password) && !is_null($newpassword)) {
            $user = Db::name('user')->where(array('id' => $id))->field('password')->find();

            if ($password == $user['password']) {
                Db::name('user')->where(array('id' => $id))->update(array('password' => $newpassword));
            }
        }
        $name = $params['name0'];
        unset($params['name0']);
        unset($params['id']);
        $params['name'] = $name;

        $res = Db::name('user')->where(array('id' => $id))->update($params);
        if ($res) {
            $this->success('信息修改成功', '/index/person/index');
        } else {
            $this->error('信息修改失败， 请稍后重试', '/index/person/index');
        }
    }

    public function order()
    {
//        获取所有订单
//        获取所有订单信息
        $request = Request::instance();
        $id = $request->get('id', -1);


        if ($id == -1) {
            $orderList = Db::name('user_yuan')->select();
        } else {
            $orderList = Db::name('user_yuan')->where(array('state' => $id))->select();
        }


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
        $this->assign('type', $id);
        return $this->fetch();
    }

    public function updateOrder()
    {
        $request = Request::instance();
        $id = $request->get('id');
        $typeId = $request->get('typeId');

        $res = Db::name('user_yuan')->where(array('id' => $id))->update(array('state' => $typeId));

        if ($res) {
            $data['code'] = 0;
        } else {
            $data['code'] = 1;
        }
        return json($data);
    }
}