<?php

namespace app\controllers\basic;
use app\models\auth\AuthGroup;
use app\models\auth\AuthGroupAccess;
use app\models\auth\AuthRule;
use app\services\basic\General;
use app\services\basic\SetRedis;
use app\services\basic\UserService;
use Yii;
use app\commands\BaseController;
use app\services\basic\AuthService;
use app\services\basic\Utils;
use app\services\basic\Authory;
class UserController extends BaseController
{


    /* 
     * 用户增删改查中控，转到UserService业务类中
     * @handle 中转关键字 create(创建)     edit(编辑)    delete(删除)    disable(禁用)
     * @passwd  用户密码
     * @uid     用户id
     * @account   邮箱账户
     *
    */
  function actionUserHandle()
  {
    $request    =   Yii::$app->request;
    $handle     =   $request->post('handle');
    $uid        =   $request->post('uid');
    $password   =   $request->post('password');
    $telephone  =   $request->post('telephone');
    $username   =   $request->post('username');
    $group      =   $request->post('group');
    $avatar     =   $request->post('avatar');
    $token     =   $request->post('token');
      $userId   =   $request->post('userId');
      $authory    =   new Authory($token);
      $authory->checkToken($uid);
    try{
        $avatar     =   empty($avatar)?null:$avatar;
        $password   =   $hash = Yii::$app->getSecurity()->generatePasswordHash($password); //进行密码加密
        $service    =   new UserService();
        $type       =   new General();
        switch ($handle){
            case    'create':
                    $result     =   $service->createUser($telephone,$password,$username,$group);
                break;
            case    'edit':
                    $result     =   $service->editUser($uid,$password,$telephone,$username,$avatar,$group);
                break;
            case    'delete':
                    $result     =   $type->deleteGeneral('auth\AuthUser',$uid);
                break;
            case    'disable':
                    $result     =   $type->disableStatus('auth\AuthUser',$uid);
                break;
            default:
                    $result     =   ['message'=>'出错了','code'=>10001];
                break;
        }
        Utils::apiDisplay($result);
    }catch(\Exception $e){
        $result =   ['message'=>$e->getMessage(),'code'=>$e->getCode()];
        Utils::apiDisplay($result);
    }
  }

  /*
   * 查询Group下属所有id的rules及name
   * 通过rules查询对应的rules表内容 tile name
   * @handle    group(用户组内的规则)  rule(rule全部规则)
   * */
  function actionAuthList()
  {
      $request    =   Yii::$app->request;
      $handle     =   $request->post('handle');
      $token     =   $request->post('token');
      $userId   =   $request->post('userId');
      $authory    =   new Authory($token);
      $authory->checkToken($userId);
      $service    =   new AuthService();
      switch($handle){
          case 'group':
              $result   =   $service->AuthGroupInfo();
              break;
          case 'rule':
              $result   =   $service->getAuthInfo();
              break;
          default:
              $result   =   ['message'=>'出错了','code'=>10001];
              break;
      }
    Utils::apiDisplay(['code'=>1,'data'=>$result]);
  }

  /*
   * 新增规则
   * handle create   edit    disable    delete
   * */
  function actionAuthHandle(){
      $request  =   Yii::$app->request;
      $token    =   $request->post('token');
      $userId   =   $request->post('userId');
      $authory    =   new Authory($token);
      $authory->checkToken($userId);
      $ruleName     =   $request->post('ruleName');
      $ruleTitle    =   $request->post('ruleTitle');
      $ruleId       =   $request->post('ruleId');
      $handle   =   $request->post('handle');

      try{
          $service  =   new UserService();
          $general  =   new General();
          switch( $handle ){
              case 'create':
                    $result     =   $service->createRule($ruleName,$ruleTitle);
                  break;
              case 'edit':
                    $result     =   $service->editRule($ruleId,$ruleName,$ruleTitle);
                  break;
              case 'disable':
                    $result     =   $general->disableStatus('auth\AuthRule',$ruleId);
                  break;
              case 'delete':
                    $result     =   $general->deleteGeneral('auth\AuthRule',$ruleId);
                  break;
              default:
                  $result   =   ['message'=>'出错了','code'=>10001];
          }
          Utils::apiDisplay($result);
      }catch(\Exception $e){
          $result =   ['message'=>$e->getMessage(),'code'=>$e->getCode()];
          Utils::apiDisplay($result);
      }
  }

  /*
   * 用户组的增删改查
   * handle create   edit    disable    delete
   * rules传递方式为 2,3,4
   * */
  function actionGroupHandle(){
      $request  =   Yii::$app->request;
      $token    =   $request->post('token');
      $userId   =   $request->post('userId');
      $authory    =   new Authory($token);
      $authory->checkToken($userId);
      $groupStatus    =  $request->post('groupStatus');
      $groupTitle    =  $request->post('groupTitle');
      $groupId       =  $request->post('groupId');
      $groupRules    =  $request->post('groupRules');
      $handle   =   $request->post('handle');

      try{
          $service  =   new UserService();
          $general  =   new General();
          switch( $handle ){
              case 'create':
                  $result     =   $service->createGroup($groupStatus,$groupTitle,$groupRules);
                  break;
              case 'edit':
                  $result     =   $service->editGroup($groupId,$groupStatus,$groupTitle,$groupRules);
                  break;
              case 'disable':
                  $result     =   $general->disableStatus('auth\AuthGroup',$groupId);
                  break;
              case 'delete':
                  $result     =   $general->deleteGeneral('auth\AuthGroup',$groupId);
                  break;
              default:
                  $result   =   ['message'=>'出错了','code'=>10001];
          }
          Utils::apiDisplay($result);
      }catch(\Exception $e){
          $result =   ['message'=>$e->getMessage(),'code'=>$e->getCode()];
          Utils::apiDisplay($result);
      }
  }
//    function actionTest(){
//
//    }
}
