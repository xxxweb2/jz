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
        if (!empty($password) && !empty($newpassword)) {
            $user = Db::name('yuan')->where(array('id' => $id))->field('password')->find();

            if ($password == $user['password']) {
                Db::name('yuan')->where(array('id' => $id))->update(array('password' => $newpassword));
                $this->success("密码修改成功", '/index/person/index');
            }else {
                $this->error("原密码错误", '/index/person/index');
            }
        }
        $name = $params['name0'];
        unset($params['name0']);
        unset($params['id']);
        $params['name'] = $name;

        $a = session('user');
        $a['img']=$params['img'];
        session('user', $a);

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


        if (!empty($password) && !empty($newpassword)) {
            $user = Db::name('user')->where(array('id' => $id))->field('password')->find();

            if ($password == $user['password']) {
                Db::name('user')->where(array('id' => $id))->update(array('password' => $newpassword));
                $this->success("密码修改成功", '/index/person/index');
            } else {
                $this->error("原密码错误", '/index/person/index');
            }

        }
        $name = $params['name0'];
        unset($params['name0']);
        unset($params['id']);
        $params['name'] = $name;
        $a = session('user');
        $a['img']=$params['img'];
        session('user', $a);
        $res = Db::name('user')->where(array('id' => $id))->update($params);

        $this->success('信息修改成功', '/index/person/index');

    }

    public function order()
    {
//        获取所有订单
//        获取所有订单信息
        $request = Request::instance();
        $id = $request->get('id', -1);

        $user = session('user');
        $userType = session('userType');
        if ($userType == 1) {
            $tables = "userid";
        } else {
            $tables = "yuanid";
        }

        if ($id == -1) {

            $orderList = Db::name('user_yuan')->where(array('state' => array('<', 5), $tables => $user['id']))->select();

        } else {
            $orderList = Db::name('user_yuan')->where(array('state' => $id, $tables => $user['id']))->select();
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

    public function uploadFile() {
        $data = array();

        // 获取表单上传文件 例如上传了001.jpg

        $file = request()->file('file0');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                // 成功上传后 获取上传信息
//                // 输出 jpg
//                echo $info->getExtension();
//                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();
                $request = Request::instance();
                $id = $request->get('id');

                $data['msg'] = $info->getSaveName();




            } else {
                // 上传失败获取错误信息
                $data['msg'] = $file->getError();
            }
        }

        return json($data);
    }

}