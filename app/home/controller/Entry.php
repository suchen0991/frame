<?php

/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2017/9/7
 * Time: 下午3:12
 */
//entry类所在的空间名
namespace app\home\controller;

//开启houdunwang\core\空间用来调用父类中的对应方法时去对应的空间查找
use houdunwang\core\Controller;
//开启houdunwang\view\空间用来调用View类时去对应的空间查找
use houdunwang\view\View;
//开启system\model空间用来调用Article类时去对应的空间查找
use system\model\Article;

//建一个entry类来完成一些载入数据
class Entry extends Controller
{
    //创建一个index方法
    public function index()
    {
//        调用一个静态方法
        Article::find(1);
//   dd($data);
//        给一个默认值
        $test = '';
//        将返回的对象返回到houdunwang/core/boot文件中的boot类中的appRun方法中，
//        echo触发__tostring方法，
        return View::with(compact('test'))->make();

    }

    //创建一个add方法
    public function add()
    {
        //    输出add
//        echo 'add';
        $this->setRedirect()->message("添加成功");
    }
}