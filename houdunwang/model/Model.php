<?php

/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2017/9/8
 * Time: 下午4:56
 */
//model类所在的空间名
namespace houdunwang\model;

//创建一个model类当entry类中的方法调用houdunwang\model空间的
//这个类时触发当前空间的BASE类完成连接数据库显示数据库数据的操作
class Model
{
//创建一个普通调用不存在的方法执行base方法中对应的方法名和参数
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
//        返回一个静态的自定义调用 的方法
        return self::parseAction($name, $arguments);
    }

//创建一个静态调用不存在的方法时执行的方法执行Base类中对应的方法名和参数
    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
//        返回一个自定义的静态方法当找不到的时候就执行nuw base方法名和参数
        return self::parseAction($name, $arguments);
    }

    public static function parseAction($name, $arguments)
    {
//        返回当前调用的类名
        $class = get_called_class();
//        将base类中对应的方法返回的操作和数据返回到entry中的对应的方法中
        return call_user_func_array([new Base ($class), $name], $arguments);
    }
}