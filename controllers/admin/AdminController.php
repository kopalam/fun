<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/7
 * Time: 2:07 PM
 */

namespace app\controllers\admin;
use app\commands\BaseController;
use app\services\admin\MenuService;
use app\services\basic\Authory;
use app\services\basic\Utils;
use SebastianBergmann\CodeCoverage\Util;
use Yii;

class AdminController   extends BaseController
{
    /*
     * 通过权限获取相应的菜单
     * */
    function actionGetMenu(){
        $request    =   Yii::$app->request;
        $groupId    =   $request->post('groupId');
        $userId     =   $request->post('userId');
        $token      =   $request->post('token');
        $authory    =   new Authory($token);
        $authory->checkToken($userId);

        $menu       =   new MenuService();
        $result     =   $menu->getMenu($userId,$groupId);
        Utils::apiDisplay(['status'=>1,'data'=>$result]);

    }
}