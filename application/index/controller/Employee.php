<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 下午 7:28
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class Employee extends BaseController
{
    public function listEmployee()
    {
//        addrId=" + addrId + "&jobId=" + jobId + "&sortId=" + sortId;
        $request = Request::instance();
        $addrId = $request->get('addrId', 0);
        $jobId = $request->get('jobId', 0);
        $sortId = $request->get('sortId', 0);


//        获取所有区域信息
        $addrList = Db::name('addr')->select();
        $this->assign("addrList", $addrList);

//        获取所有家政人员服务类型

        $serverList = Db::name('service')->select();
        $this->assign('serverList', $serverList);


        $where = "";
        if ($addrId != 0) {
            $where = "addrId=" . $addrId;
        }
        if ($jobId != 0) {
            $where .= " and type=" . $jobId;
        }
        if ($sortId != 0) {
            $where .= " and sort=" . $sortId;
        }

        $where = trim($where);


        if ($addrId == 0) {
            $where = ltrim($where, "and");
        }

//        获取所有家政人员信息
        $emplList = Db::name('yuan')->where($where)->order('id desc')->select();

//        根据addrid查询地址名称

        foreach ($emplList as $key => $emp) {

            $addrItem = Db::name('addr')->where(array('id' => $emp['addrid']))->find();
            $emplList[$key]['addrname'] = $addrItem['name'];

        }


        $this->assign("addrId", $addrId);
        $this->assign("jobId", $jobId);
        $this->assign("sortId", $sortId);

        $this->assign('emplList', $emplList);


        return $this->fetch();
    }

}