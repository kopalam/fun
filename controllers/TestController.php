<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\services\basic\AuthService;

class TestController extends Controller
{
   function actionGet()
   {
       $request     =   Yii::$app->request;
       $uid     =    $request->post('uid');
       $service     =   new AuthService;
       $res     =   $service->check(['Home/index','Home/add'],1,1);

       echo $res;
   }
}
