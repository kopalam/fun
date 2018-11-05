<?php

namespace app\controllers\basic;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\commands\BaseController;
use app\services\basic\AuthService;

class UserController extends BaseController
{
  function actionUserMiddle()
  {
    echo 'halo';
  }
}
