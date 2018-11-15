<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wechat_share_set".
 *
 * @property string $wechat_share_title 分享标题
 * @property string $wechat_share_details 分享描述
 * @property string $wechat_share_cover 分享图片
 * @property string $wechat_share_url 对应网址
 */
class WechatShareSet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wechat_share_set';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wechat_share_title', 'wechat_share_details', 'wechat_share_cover'], 'string', 'max' => 120],
            [['wechat_share_url'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wechat_share_title' => 'Wechat Share Title',
            'wechat_share_details' => 'Wechat Share Details',
            'wechat_share_cover' => 'Wechat Share Cover',
            'wechat_share_url' => 'Wechat Share Url',
        ];
    }
}
