<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/7
 * Time: 2:07 PM
 */

namespace app\controllers\admin;
use app\services\basic\UserService;
use Faker\Provider\Base;
use SebastianBergmann\CodeCoverage\Util;
use Yii;
use app\commands\BaseController;
use app\services\basic\AuthService;
use app\services\basic\Utils;
use app\services\basic\Authory;

class LoginController   extends BaseController
{
    /*
    * 管理员/后台用户登录
    * */
    public function actionLogin(){
        $request    =   Yii::$app->request;
        $account    =   $request->post('account');
        $password   =   $request->post('password');

        try{
            $service    =   new UserService();
            $result     =   $service->checkLogin($account,$password);
            Utils::apiDisplay($result);
        }catch(\Exception $e){
            $result =   ['message'=>$e->getMessage(),'code'=>$e->getCode()];
            Utils::apiDisplay($result);
        }
        
    }
}