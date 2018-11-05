<?php

namespace app\models\auth;

use Yii;

/**
 * This is the model class for table "auth_group_access".
 *
 * @property int $uid
 * @property int $group_id
 */
class AuthGroupAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_group_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'group_id'], 'required'],
            [['uid', 'group_id'], 'integer'],
            [['uid', 'group_id'], 'unique', 'targetAttribute' => ['uid', 'group_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'group_id' => 'Group ID',
        ];
    }
}
