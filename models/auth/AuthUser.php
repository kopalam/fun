<?php

namespace app\models\auth;

use Yii;

/**
 * This is the model class for table "auth_user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property int $age
 * @property string $telephone
 * @property string $email 邮箱
 * @property string $avatar 头像
 * @property int $status
 */
class AuthUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_user';
    }

    /**
     * {@inheritdoc}
     */
//    public function rules()
//    {
//        return [
//            [['id', 'password', 'avatar'], 'required'],
//            [['id', 'status'], 'integer'],
//            [['username'], 'string', 'max' => 30],
//            [['password'], 'string', 'max' => 120],
//            [['telephone'], 'string', 'max' => 20],
//            [['avatar'], 'string', 'max' => 130],
//            [['id'], 'unique'],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'telephone' => 'Telephone',
            'avatar' => 'Avatar',
            'status' => 'Status',
        ];
    }
}
