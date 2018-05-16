<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/16 0016
 * Time: 上午 9:42
 */

namespace app\admin\controller;


use think\Db;
use think\Request;

class News extends BaseController
{
    public function index()
    {
//        获取所有新闻
        $newsList = Db::name('news')->select();
        $this->assign('newsList', $newsList);

        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function save()
    {

        $request = Request::instance();
        $params = $request->post();

        $time = date("y/m/d h:i", time());
        $params['time'] = $time;
        $res = Db::name('news')->insert($params);
        if (!$res) {
            $this->error('保存失败，请稍后重试', '/admin/news/index');
            exit();
        }
        $this->success('保存成功', '/admin/news/index');
    }

    public function edit()
    {
        $request = Request::instance();
        $id = $request->get('id');
        $res = Db::name('news')->where(array('id' => $id))->find();
        if (empty($res)) {
            $this->error('没有找到该新闻', '/admin/news/index');
            exit();
        }

        $this->assign('news', $res);
        return $this->fetch();
    }

    public function update()
    {
        $request = Request::instance();
        $param = $request->post();

        $res = Db::name('news')->where(array('id' => $param['id']))->update($param);
        if ($res) {
            $this->success('数据更新成功', '/admin/news/index');
        } else {
            $this->error('数据更新失败，请稍后重试');
        }
    }

    public function del()
    {
        $request = Request::instance();
        $id = $request->get('id');
        $res = Db::name('news')->where(array('id' => $id))->delete();
        if ($res) {
            $data['code'] = 0;
        } else {
            $data['code'] = 1;
        }
        return json($data);
    }
}