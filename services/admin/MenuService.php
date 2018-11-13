<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/7
 * Time: 4:12 PM
 */

namespace app\services\admin;
use app\models\auth\AuthRule;
use app\services\basic\AuthService;
use Yii;

class MenuService
{
    /*
     * 获取对应权限的菜单规则
     * 调取对应的name规则
     * */
    function getMenu($userId,$groupId){
        $auth   =   new AuthService();
        $rules   =   $auth->getGroups($userId);
        //explode出rules，1,2，查询rule表对应的id
        $rule   =   explode(',',$rules['rules']);
        $data   =   [];
        foreach ($rule as $key =>$value){
            $data[$key]['name']   =   AuthRule::findOne(['id'=>$value])->name;
            $data[$key]['title']   =   AuthRule::findOne(['id'=>$value])->title;
        }
        return $data;
    }
}