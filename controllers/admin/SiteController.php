<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/8
 * Time: 3:28 PM
 */

namespace app\controllers\admin;
use app\models\SiteSet;
use app\models\WechatSet;
use app\services\basic\Authory;
use app\services\basic\AuthService;
use app\services\basic\General;
use app\services\basic\Utils;
use Yii;
use app\commands\BaseController;
use yii\db\Exception;
use app\services\api\EasyWechat;


class SiteController extends BaseController
{

    /*
     * 网站基础设置
     * */
    function actionSiteSet(){
        $request    =   Yii::$app->request;
        $token      =   $request->post('token');
        $uid        =   $request->post('uid');
        $authory   =   new Authory($token);
        $authory->checkToken($uid);
        $data['site_title']   =     $request->post('site_title');
        $data['site_logo']   =     $request->post('site_logo');
        $data['telephone']   =     $request->post('telephone');
        $data['site_description']   =     $request->post('site_description');
        $data['site_keyword']   =     $request->post('site_keyword');
        $data['site_icp']   =     $request->post('site_icp');
        $data['visit_code']   =     $request->post('visit_code');
        $data['baidu_push']   =     $request->post('baidu_push');
        $data['copyright_all']  =   $request->post('copyright_all');

        try{
            $general    =   new General();//通用业务类
            $result     =   $general->site($data);
            Utils::apiDisplay($result); //成功返回 true

        }catch(\Exception $e){
            $result     =   ['message'=>$e->getMessage(),'code'=>$e->getCode()];
            Utils::apiDisplay($result);
        }
    }

    /*
     * 公众号设置
     * */
    function actionWechatSet(){
        $request    =   Yii::$app->request;
        $token      =   $request->post('token');
        $uid        =   $request->post('uid');
        $authory   =   new Authory($token);//检查是否存在token
        $authory->checkToken($uid);

        $data['wechat_account']     =   $request->post('wechat_account');
        $data['wechat_id']     =   $request->post('wechat_id');
        $data['wechat_rank']     =   $request->post('wechat_rank');
        $data['wechat_appid']     =   $request->post('wechat_appid');
        $data['wedchat_secret']     =   $request->post('wedchat_secret');
        $data['wechat_token']     =   $request->post('wechat_token');
        $data['wechat_encoding']     =   $request->post('wechat_encoding');
        $data['wechat_qrcode']     =   $request->post('wechat_qrcode');

        try{
            $service     =   new General();
            $result     =   $service->wechatSet($data,$uid);
            Utils::apiDisplay($result); //成功返回 true
        }catch(\Exception $e){
            $result     =   ['message'=>$e->getMessage(),'code'=>$e->getCode()];
            Utils::apiDisplay($result);
        }
    }

    /*
     * 获取网站设置
     * */
    function actionGetSiteSet(){
        $request    =   Yii::$app->request;
        $token      =   $request->post('token');
        $uid        =   $request->post('uid');
        $authory   =   new Authory($token);//检查是否存在token
        $authory->checkToken($uid);

        try{
            $service     =   new General();
            $result     =   $service->getSiteData();
            Utils::apiDisplay($result); //成功返回 true
        }catch(\Exception $e){
            $result     =   ['message'=>$e->getMessage(),'code'=>$e->getCode()];
            Utils::apiDisplay($result);
        }
    }

    /*
     * 获取微信设置
     * */
    function actionGetWechatSet(){
        $request    =   Yii::$app->request;
        $token      =   $request->post('token');
        $uid        =   $request->post('uid');
        $authory   =   new Authory($token);//检查是否存在token
        $authory->checkToken($uid);

        try{
            $service     =   new General();
            $result     =   $service->getWechatData($uid);
            Utils::apiDisplay($result); //成功返回 true
        }catch(\Exception $e){
            $result     =   ['message'=>$e->getMessage(),'code'=>$e->getCode()];
            Utils::apiDisplay($result);
        }
    }

    function actionTest(){
        $service    =   new EasyWechat( 'gh_211321');
        $res    =   $service->WechatConfig();
        print_r($res);

    }
}