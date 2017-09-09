<?php
/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2017/9/8
 * Time: 下午3:38
 */
//Controller类所在的空间名
namespace houdunwang\core;

//创建一个Controller类用来执行一些对应的提示信息和载入提示模版
class Controller
{
//创建一个属性url默认值为window.history.back(),
//表示如果跳转地址没有传递默认跳转到上一级
    private $url = "window.history.back()";
//创建一个message方法用来显示操作成功后的提示信息，
//并将提示信息返回到当前对象，输出在提示页面
    public function message($message)
    {
//    将提示要载入的示页面地址给include返回到当前对象，
//    触发__tostring方法完成载入提示模版并显示提示信息
        include "./view/message.php";
//    这里已经终止代码不会再往下执行
        exit;
    }
//创建一个setRedirect方法用来跳转到默认的页面，并将获得的跳转地址返回到/houdunwang/core中的
//boot类中的appRun方法触发__tostring方法
    public function setRedirect($url = '')
    {
//      判断empty的$url值
        if (empty($url)) {
//如果是url值为window.history.back(),
//表示如果跳转地址没有传递默认跳转
            $this->url = "window.history.back()";
        } else {
//        将跳转的地址接收并返回到appRun方法触发__toString方法载入跳转到默认页面完成跳转
            $this->url = "location.href='$url'";
        }
//    返回当前对象
        return $this;
    }
}