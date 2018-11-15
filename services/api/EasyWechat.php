<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/7
 * Time: 4:12 PM
 */

namespace app\services\api;
use app\models\auth\AuthRule;
use app\models\WechatSet;
use app\services\basic\AuthService;
use Yii;
use yii\db\Exception;
use jianyan\easywechat\Wechat;

class EasyWechat
{
    private $wechat_id;
    function __construct($appId)
    {
        $this->appId    =   $appId;
    }

    /*
     * 微信组件封装
     * 调取appid，secret
     * */
    function WechatConfig(){
        $config     =   Yii::$app->params['wechatConfig'];
        $wechatData     =   WechatSet::findOne(['app_id'=>$this->appId]);
        $config['wechat_appid']     =   $wechatData->wechat_appid;
        $config['wechat_secret']    =   $wechatData->wechat_secret;
        $config['wechat_rank']  =   $wechatData->wechat_rank;

        return $config;
    }

    /*
     * 网页授权
     * */
    function WebPage(){

    }
}