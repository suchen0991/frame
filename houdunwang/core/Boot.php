<?php

/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2017/9/7
 * Time: 下午2:54
 */
//boot类所在的命名空间
namespace houdunwang\core;
//创建Boot类来完成框架的初始化和载入模版的操作
class Boot
{
//创建一个run方法来完成框架的初始化和执行应用的操作
    public static function run()
    {
//      3.  运行抛出的方法
        self::hander();
//    echo 1;
//  1.初始化框架
//    调用初始化方法完成框架初始化来开启session设置时区一些操作
        self::init();
//2.执行应用
//    调用appRun方法实现模版载入和调用应用类的操作
        self::appRun();

    }
    public  static function hander(){
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    /**
     * 执行应用
     */
//    创建一个appRun方法来执行应用
    public static function appRun()
    {
//        判断$get里面的s的值是否存在
        if (isset($_GET['s'])) {
//        将$s转换为数组，方便组合自动调用方法时调用的对应空间的类名和调用对应的方法名
            $info = explode('/', $_GET['s']);

//        组合类名，
//        如app\home\controller\Entry ,
//        类名首字母大写，如Entry，一个\可以转义{}，因此这里需要加上两个\\阻止转义
            $class = "\app\\{$info[0]}\controller\\" . ucfirst($info[1]);
//获取数组里面的index方法
            $action = $info['2'];

//        Array
//                    (
//                        [0] => home
//                        [1] => enrty
//                        [2] => index
//                    )
//                  dd($info);exit;
//        1.把应用，如'home'定义为常量，常量不受命名空间和类的限制
//        2.目的是组合文件路径
//       定义常量
            define('MODULE', $info[0]);
            define('CONTROLLER', $info[1]);
            define('ACTION', $info[2]);

        } else {
//        默认调用的类是app目录下的home里面的类
            $class = "\app\home\controller\Entry";
//        定义常量
            $action = 'index';
            define('MODULE', 'home');
            define('CONTROLLER', 'entry');
            define('ACTION', 'index');
        }
//        自动调用控制器里的方法，默认为controller空间下的entry类中的index方法，
//        因为只有输出对象时才会触发__tostring方法，所以要将返回的对象输出来触发__tostring方法完成载入
//        应用模版和提示信息的一些操作
        echo call_user_func_array([new $class, $action], []);


    }
    /**
     * 初始化框架
     */
//创建一个init方法完成框架的初始化，比如开启session和设置时区的一些操作
    public static function init()
    {
//声明头部
//     如果不加头部，浏览器访问页面时会出现乱码
        header('Content-type:text/html;charset=utf8');
//     设置时区,完成不同用户访问页面时显示的时间都是一样的时间
        date_default_timezone_set('PRC');
//开启session,  session_id(),获取或者修改目前session的value值，这里是获取的意思，能获取到表示已经开启session了，
// 右边的session_start()就不用再执行了，如果获取不到，那么执行右边的开始session
        session_id() || session_start();
    }
}