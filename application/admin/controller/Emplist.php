<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 上午 11:34
 */

namespace app\admin\controller;


use think\Db;
use think\Request;

class Emplist extends BaseController
{
    public function index()
    {
//        获取所有员工信息
        $empList = Db::name('yuan')->select();
        $this->assign('empList', $empList);
        return $this->fetch();
    }

    public function update()
    {
        $data['code'] = 1;
//        'id': element.getAttribute('data-id'),
//                    'key': element.id,
//                    'val': this.value,
        $request = Request::instance();
        $id = $request->post('id');
        $key = $request->post('key');
        $val = $request->post('val');
        $res = 0;
        if ($val == 0 || $val == 1 || $val == 2) {
            $data['code'] = 0;
            $res = Db::name('yuan')->where(array('id' => $id))->update(array($key => $val));
            $data['res'] = $val;
        }
        if ($res == 0) {
            $data['code'] = 1;
        }
        return json($data);
    }
}