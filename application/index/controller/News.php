<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/15 0015
 * Time: 下午 10:20
 */

namespace app\index\controller;


use think\Db;
use think\Request;

class News extends BaseController
{
    public function index()
    {

//        获取所有新闻
//        $newsList = Db::name('news')->select();
        $newsList = Db::name('news')->paginate(8)->each(function ($item, $key) {
            $time = $item['time'];
            if (!empty($time)) {
                $timeArr = explode(" ", $time);
                $ymd = $timeArr[0];
                $ymdArr = explode("/", $ymd);
                $day = $ymdArr[2];
                $yearMonth = $ymdArr[0] . '/' . $ymdArr[1];
                $item['day'] = $day;
                $item['yearMonth'] = $yearMonth;
            }
            return $item;
        });
        $this->assign('newsList', $newsList);
        return $this->fetch();
    }

    public function detail()
    {
        $request = Request::instance();
        $id = $request->get('id');

        $news = Db::name('news')->where(array('id' => $id))->find();
        if (is_null($news)) {
            $this->error('没有该条新闻', '/index/news/index');
            exit();
        }

        $this->assign('news', $news);


//        判断是否有上一篇 和下一篇
        $isPre = Db::query("select * from news where id < " . $id . ' limit 1');
        $isNext = Db::query("select * from news where id > " . $id . ' limit 1');

        $hasPre = 0;
        $hasNext = 0;
        if (!empty($isPre)) {
            $hasPre = 1;
        }
        if (!empty($isNext)) {
            $hasNext = 1;
        }



        $this->assign('hasPre', $hasPre);
        $this->assign('hasNext', $hasNext);


        return $this->fetch();
    }

    public function next()
    {
        $request = Request::instance();
        $pre = $request->get('pre', 0);
        $next = $request->get('next', 0);
        if (!is_null($pre)) {
            $news = Db::query("select * from news where id < " . $pre . ' limit 1');
        }
        if (!is_null($next)) {
            $news = Db::query("select * from news where id > " . $next . ' limit 1');
        }

        if (empty($news)) {
            $this->error('没有其他新闻了', '/index/news/index');
            exit();
        }

        if ($pre == 0) {
            $pre = $next;
            $pre+=1;
        }
        if ($next == 0) {
            $next = $pre;
            $pre-=1;
        }

//        print_r($pre);print_r($next);die;

//        判断是否有上一篇 和下一篇
        $isPre = Db::query("select * from news where id < " . $pre . ' limit 1');
        $isNext = Db::query("select * from news where id > " . $pre . ' limit 1');
        $hasPre = 0;
        $hasNext = 0;
        if (!empty($isPre)) {
            $hasPre = 1;
        }

        if (!empty($isNext)) {
            $hasNext = 1;
        }

        $this->assign('hasPre', $hasPre);
        $this->assign('hasNext', $hasNext);


        $news = $news[0];
        $this->assign('news', $news);
        return $this->fetch('detail');
    }

}