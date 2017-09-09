<?php

/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2017/9/8
 * Time: 下午4:11
 */
//Base类所在的空间名
namespace houdunwang\view;
//创建一个Base类，当app/home/controller/entry中的entry类中的index方法调用View类时
//会调用这个类中的方法完成载入前台页面的操作和载入显示的数据
class Base
{
//创建一个属性默认为空数组，用来接收传过来的数据，
//并将接收的数据返回到/houdunwang/core/boot文件中的boot类中的appRun方法并echo时触发__tostring，
//完成先加载数据再载入模版的操作
    protected $data = [];
//    创建一个$file属性 用来组建引用的模版路径
    protected $file;

//创建一个with方法变量方法用来接收传过来的数据并返回到当前对象触发__tostring，完成数据加载
    public function with($var)
    {
//    dd($var);
//    Array
//    (
//        [test] => houdunwang
//    )
//    将传递的数据赋值给属性$var并将获得的数据返回到当前对象触发__tostring,完成加载数据
        $this->data = $var;
//    返回给对象触发__totring方法
        return $this;
    }

    /**
     * 显示模版
     * @return $this
     */
//创建一个make方法完成路径组合的操作
    public function make()
    {
//    组合当前对象需要引入的模版路径，
//    并返回到app/home/view/entry/index中的appRun方法中输出当前对象，触发__tostring方法载入当前路径完成载入模版的操作
        $this->file = "../app/" . MODULE . "/view/" . strtolower(CONTROLLER) . "/" . ACTION . "." . c('view.suffix');
//    返回对象触发__tostring方法
        return $this;
    }
    /**
     * 自动触发
     * @return string
     */
//创建一个输出对象是自动触发的方法完成现在如数据再载入模版的操作，
//让所对应的数据能在对应的模版中调用
    public function __toString()
    {
        // TODO: Implement __toString() method.
//    echo 1;
//    dd($this->data);
//    Array
//    (
//        [test] => houdunwang
//    )
//    将或得数据进行转换，将对应的键名转换为变量名，
//    将对应的键值转换为变量值，方便页面调用时使用
        extract($this->data);
//    dd($this->file);
//    ../app/home/view/entry/index.
//    引用当前对象对应得模版
        include "$this->file";
//    因为__tostring方法必须返回一个字符串，所以要返回一个空字符串
        return '';
    }
}