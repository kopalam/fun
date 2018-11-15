<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wechat_set".
 *
 * @property string $wechat_account 公众号账号
 * @property string $wechat_id 原始ID
 * @property string $wechat_rank 订阅号/服务号
 * @property string $wechat_appid APPID
 * @property string $wechat_secret APPsecret
 * @property string $wechat_token access_token
 * @property string $wechat_encoding 加密方式
 * @property string $wechat_qrcode 二维码图片
 * @property int    $uid 用户uid
 */
class WechatSet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wechat_set';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wechat_account', 'wechat_id'], 'string', 'max' => 60],
            [['wechat_rank'], 'string', 'max' => 20],
            [['wechat_appid'], 'string', 'max' => 30],
            [['wechat_secret'], 'string', 'max' => 80],
            [['wechat_token', 'wechat_encoding'], 'string', 'max' => 250],
            [['wechat_qrcode'], 'string', 'max' => 120],
            [['uid'],'integer','max'=>11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid'=>'Uid',
            'wechat_account' => 'Wechat Account',
            'wechat_id' => 'Wechat ID',
            'wechat_rank' => 'Wechat Rank',
            'wechat_appid' => 'Wechat Appid',
            'wechat_secret' => 'Wechat Secret',
            'wechat_token' => 'Wechat Token',
            'wechat_encoding' => 'Wechat Encoding',
            'wechat_qrcode' => 'Wechat Qrcode',
        ];
    }
}
