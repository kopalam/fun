<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "third_party".
 *
 * @property int $id
 * @property string $app_id appid
 * @property string $app_secret appsecret
 * @property int $type 1微信 2微博 3QQ 登录
 */
class ThirdParty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'third_party';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'app_secret', 'type'], 'required'],
            [['type'], 'integer'],
            [['app_id'], 'string', 'max' => 30],
            [['app_secret'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'app_secret' => 'App Secret',
            'type' => 'Type',
        ];
    }
}
