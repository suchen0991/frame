<?php

/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2017/9/8
 * Time: 下午4:12
 */
//View类所在的空间名
namespace houdunwang\view;
//用来让app/home/controller中的entry类中的index方法调用
//view类时自动触发Base类中的方法完成载入app中的模版和需要显示的数据的操作
class View
{
//    创建一个普通调用不存在的方法执行base方法中对应的方法名和参数
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
//    返回一个静态的自定义调用 的方法
        return self::parseAction($name, $arguments);

    }

//  创建一个静态调用不存在的方法时执行的方法执行Base类中对应的方法名和参数
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
//    返回一个自定义的静态方法当找不到的时候就执行nuw base
        return self::parseAction($name, $arguments);
    }

//  创建一个自定义的方法调用不存在的方法时执行的方法执行Base类中对应的方法名和参数
    public static function parseAction($name, $arguments)
    {
//    普通方法和静态方法都可以调用自定义的方法
//    将当前中base类对应方法返回的对象值返回到entry类中的index方法中，
//    并返回到houdunwang/core/boot类中的appRUN方法中echo出来触发当前空前的__tostring完成载入模版和对应数据的操作

        return call_user_func_array([new Base, $name], $arguments);
    }
}