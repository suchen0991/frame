<?php

/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2017/9/8
 * Time: 下午4:56
 */
//base类所在的空间名
namespace houdunwang\model;

//开启pdo所在的空间，完成操作数据库的一些操作
use PDO;
//开启PDOException所在的空间
use PDOException;
//开启Exception所在的空间
use Exception;

//创建一个base类用来执行连接数据库的一些操作并对应的数据返回给对应的方法中
class Base
{
//创建一个静态属性pdo用来连接数据库，如果为空就连接数据库，如果不为空表示数据库已经连接
    private static $pdo = null;
//操作数据表名
    private $table;

//当调用BASE类时自动执行这个方法，并调用当前类的connect方法连接数据库
    public function __construct($class)
    {
//    判断静态属性的值是不是为NULL如果为NULL表示没有连接数据库，
//    如果不为NULL表示数据库已经连接，防止重复连接数据库
        if (is_null(self::$pdo)) {
//            调用静态方法
            self::connect();
        }

        $info = strtolower(ltrim(strrchr($class, '\\'), '\\'));
//        dd($class);
        $this->table = $info;
    }

    /**
     * 连接数据库
     * @throws Exception 跑出异常错误
     */
//创建一个connect方法用来连接数据库的操作
    private static function connect()
    {
//    将产生的错误转化为异常错误，因为只有异常错误才能捕获到，并将异常错误输出到页面
        try {
//        调用C函数引用c函数中的参数连接对应的数据库
            $dsn = c('database.driver') . ":host=" . c('database.host') . ";dbname=" . c('database.dbname');
//        连接数据库用户名
            $user = c('database.user');
//        连接数据库密码
            $password = c('database.password');
//        连接数据库
            self::$pdo = new PDO($dsn, $user, $password);
//        设置字符集
            self::$pdo->query('set names utf8');
//        设置错误方法为异常错误
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//      捕获错误信息并传到对象$e
        } catch (PDOException $e) {
//        输出抓获的异常错误
            throw  new Exception($e->getMessage());
        }
    }

//创建一个find方法用来获取对应表的所有数据
    public function find($id)
    {
//    先获取主键，获取当前操作的数据表的主键到底是谁
        $pk = $this->getpk();

//    获取传过来的对应的表的数据，将对应的表添加到获取所有数据的SQL语句中，并通过有结果集的操作完成获取数据，
//    并将获取的数据转换才关联数组返回到对应的对象
        $sql = "select * from {$this->table} where {$pk}={$id}";
//    dd($sql);
//    通过有结果集的操作执行sql语句完成获取对应表的数据
        $data = $this->query($sql);
//    将转好的数据返回给当前的对象
        return current($data);
    }


    /**
     * 获取表主键到底是id还是aid
     * @return string
     */
//创建一个getpk方法用来获取对应表的id
    private function getpk()
    {
//    查看表结构
        $sql = 'desc ' . $this->table;
//    通过有结果集的操作执行sql语句完成获取对应表的数据
        $data = $this->query($sql);
//    dd($data);
//    给一个默认值
        $pk = '';

//        dd($data);
//        Array
//        (
//            [0] => Array
//            (
//                [Field] => aid
//                [Type] => int(10) unsigned
//    [Null] => NO
//    [Key] => PRI
//    [Default] => 0
//            [Extra] =>
//        )
//)
//        给每一个表起别名
        foreach ($data as $v) {

//      判断表里的主键是不是等等于prt
            if ($v['Key'] == 'PRI') {
//   获得主键的名字有可能是id或者aid
                $pk = $v['Field'];
//                终止循环，代码不会往下执行
                break;
            }
        }
//  返回给主键
        return $pk;
    }

    /**
     * 执行有结果集的查询
     * @param $sql
     * @return mixed
     * @throws Exception
     */
//创建一个query方法用来执行一些有结果集的sql语句，并将获取的数据返回给当前对象
    public function query($sql)
    {
//    将错误信息转换成异常错误，因为只有异常错误才能捕获
        try {
//        通过有结果集的操作执行传递过来的sql语句，并将获取的结果赋值给$res
            $res = self::$pdo->query($sql);
//        将获取的结果转换成关联数组返回给当前对象
            return $row = $res->fetchAll(PDO::FETCH_ASSOC);
//        捕获错误信息并传到对象$e
        } catch (PDOException $e) {
//        抛出一个有结果集的数据
            throw  new Exception($e->getMessage());
        }
    }
}