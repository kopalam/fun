<?php
/**
 * Created by PhpStorm.
 * User: kopa
 * Date: 2018/11/6
 * Time: 10:32 AM
 */
namespace app\services\basic;
use app\models\auth\AuthGroup;
use app\models\auth\AuthGroupAccess;
use app\models\auth\AuthRule;
use app\models\auth\AuthUser;
use Yii;
use yii\db\Exception;

Class   UserService{
    /*
     * 新建管理员用户，并将对应的组别权限写入对应表中
     * */
    public  function createUser($telephone,$password,$username,$group){
        $res    =   AuthUser::find()->where(['or',['username'=>$username],['telephone'=>$telephone]])->asArray()->one();

        if($res)
            throw new Exception('用户已存在',20001);

        $transaction = Yii::$app->db->beginTransaction();//启用事务进行插表，确保不出错
        $user   =   new AuthUser();
        $user->telephone    =   $telephone;
        $user->password     =   $password;
        $user->username     =   $username;
        $user->avatar       =   0;
        $user->status       =   1;

        if($user->save()==false)
        {
            throw new Exception('创建用户失败',20002);
            $transaction->rollBack();
        }

        $groups  =   AuthGroup::find()->where(['id'=>$group])->asArray()->one();
        if(empty($groups))
            throw new Exception('不存在该权限组',20008);
        $rules  =   explode(',',$groups['rules']);
        $rulesCount =   count($rules);
        for($i=0;$i<$rulesCount;$i++){
            $groupSet   =   new AuthGroupAccess();
            $groupSet->uid  =   $user->id;
            $groupSet->group_id =   $rules[$i];
            if($groupSet->save()==false){
                throw new \Exception('创建权限失败',20003);
                $transaction->rollBack();
            }
        }
        $transaction->commit();
        return ['message'=>'创建成功','code'=>1];

    }

    /*
     * 修改用户权限流程
     * 删掉原有uid数据，再重新写入
     * @AuthGroup 权限组id
     * @AuthGroupAccess 写入用户所属用户组
     * @GA  groupAccess缩写
     * */
    public function editUser($uid,$password,$telephone,$username,$avatar=null,$group=null){
        $transaction    =   Yii::$app->db->beginTransaction();
        $user   =   AuthUser::findOne($uid);
        if(!$user)
            throw new Exception('不存在该用户',20004);
        $user->telephone    =   $telephone;
        $user->password     =   $password;
        $user->username     =   $username;
        $user->avatar       =   $avatar=null?$user->avatar:$avatar;
        if($user->save()==false){
            throw new Exception('修改用户信息失败',20005);
            $transaction->rollBack();
        }
        $groupAccessSet     =   AuthGroupAccess::find()->where(['uid'=>$uid])->asArray()->all();
        foreach($groupAccessSet as $key =>$val){
            $delGA  =  AuthGroupAccess::findOne(['uid'=>$val['uid']]);
            $delGA->delete();
        }
        $group  =   AuthGroup::find()->where(['id'=>$group])->asArray()->one();
        $rules  =   explode(',',$group['rules']);
        $rulesCount     =   count($rules);
        //循环插入数据
        for($i=0;$i<$rulesCount;$i++){
            $Ga =   new AuthGroupAccess();
            $Ga->uid    =   $uid;
            $Ga->group_id   =   $rules[$i];
            if($Ga->save()==false){
                throw new Exception('修改权限信息失败',20007);
                $transaction->rollBack();
            }
        }

        $transaction->commit();

        return ['message'=>'修改成功','code'=>1];
    }

    /*
     * 添加rule规则
     * */
    public function createRule($name,$title){
        $model  =   new AuthRule();
        $model->name    =   $name;
        $model->title   =   $title;
        $model->type    =   1;
        $model->status  =   1;
        if($model->insert() ==  false)
            throw new Exception('增加规则失败',20009);

        return true;
    }

    /*
     * 编辑rule规则
     * */
    public function editRule($id,$name,$title){
        $model  =  AuthRule::findOne($id);
        $model->name    =   $name;
        $model->title   =   $title;
        $model->type    =   1;
        $model->status  =   1;
        if($model->save() ==  false)
            throw new Exception('修改规则失败',20010);

        return true;
    }

    /*
     * 新增用户组
     * */
    public function createGroup($groupStuts,$groupTitle,$groupRules){
        $model  =   new AuthGroup();
        $model->title   =   $groupTitle;
        $model->rules   =   $groupRules;
        $model->status  =   $groupStuts;
        if($model->insert() ==  false)
            throw new Exception('创建用户组失败',20011);

        return true;
    }
    /*
     * 编辑用户组
     * */
    public  function editGroup($groupId,$groupStatus,$groupTitle,$groupRules){
        $model  =   AuthGroup::findOne($groupId);
        $model->title   =   $groupTitle;
        $model->rules   =   $groupRules;
        $model->status  =   $groupStatus;
        if($model->save() ==  false)
            throw new Exception('编辑用户组失败',20011);

        return true;
    }

    /*
     * 后台用户登录
     * */
    public function checkLogin($account,$password){
        $userData   =   AuthUser::find()->where(['or',['telephone'=>$account],['username'=>$account]])->asArray()->one();
        if(!$userData)
            throw new Exception('不存在该用户',20004);

        $checkPassWord  =   Yii::$app->getSecurity()->validatePassword($password,$userData['password']);
        if($checkPassWord == false)
            throw new Exception('账号\密码错误，请重新再试',30002);

        //查询用户对应的组权限Id,Ga->G
        $Ga     =   AuthGroupAccess::find()->where(['uid'=>$userData['id']])->asArray()->one();
        $Gp     =   AuthGroup::find()->where(['id'=>$Ga['group_id']])->asArray()->one();
        if(!$Gp)
            throw new Exception('不存在该权限组',20008);
        //生成Token,存入redis返回格式：['userId'=>1,'groupId'=>2','token'=>'fkdsafu128kjsad721jh9hjk4hjk']
        $res    =   new   SetRedis();
        $token    =   $res->createToken();
        $res->createResdis($token,json_encode(['userId'=>$userData['id'],'groupId'=>$Ga['group_id']]),172800);
        $result     = ['userId'=>$userData['id'],'groupId'=>$Ga['group_id'],'userName'=>$userData['username'],'telephone'=>$userData['telephone'],'token'=>$token];

        return $result ;
    }
}