<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/6
 * Time: 3:20 PM
 * Content:通用API接口管理
 */
namespace app\services\basic;
use Yii;

Class   General{

    function __construct()
    {
        $this->model = trim('app\models\ ');
    }

    /*
     * @table 'Auth...'
     * 状态处理，status = 0/1
     * */
    public function disableStatus($table,$id){
        $model  =   $this->model.$table;
        $result     =   $model::findOne($id);
        $check  =   is_object($result) ? 0 : 1;
        $result->status     =   $result->status == 0 ? 1: 0;
        if($result->save() == false)
            throw new \Exception('更新状态失败',30001);

        return true;
    }
    /*
     *删除用户
     * */
    function deleteGeneral($table,$id)
    {
        $model  =   $this->model.$table;
        $reslut     =   $model::find()->where(['id'=>$id])->one();
        $reslut->delete();

        return true;
    }

}