<?php

/**
 *操作数据库的工具类
 */
class DBUtils
{
    //私有 构造函数
    private function __construct(){}

    //数据库的配置信息
    private static $dbConfig  = array(
        "host" => "localhost",
        "username" => "root",
        "password" => "root",
        "db" => "bdnews"
    );
    //数据库连接资源
    private static $connectSource;

    public static function getConnection(){
        //捕获异常并处理
        try{
            self::$connectSource = @mysqli_connect(
                self::$dbConfig['host'],
                self::$dbConfig['username'],
                self::$dbConfig['password'],
                self::$dbConfig['db']
            );
            mysqli_query(self::$connectSource,"set names UTF8");
        }catch (Exception $e){
            echo "连接失败".$e.getMessage();
            exit;
        }
        return self::$connectSource;
    }

    //析构函数 关闭数据库连接
    private function __destruct()
    {
        if(self::$connectSource){
            mysqli_close(self::$connectSource);
        }
    }


}