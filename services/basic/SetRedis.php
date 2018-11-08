<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/7
 * Time: 3:26 PM
 */

namespace app\services\basic;
use Yii;

class SetRedis
{
    /*
     * 生成Token方式
     * */
    public function createToken()
    {
        $token  =   sha1(md5(uniqid(md5(microtime(true)),true)));  //生成一个不会重复的字符串
        return $token;
    }

    /*
     * 写入redis缓存中
     * @token token值,$data存储内容，数组形式
     * @$expTime 过期时间
     * */
    public function createResdis($token,$data,$expTime){
        Yii::$app->redis->set($token,$data);
        return true;
    }

    /*
     * 获取redis中对应token键值的内容
     * */
    public function getRedis($token){
        $data   =   Yii::$app->get($token);
    }
}