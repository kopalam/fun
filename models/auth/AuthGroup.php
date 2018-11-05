<?php

namespace app\models\auth;

use Yii;

/**
 * This is the model class for table "auth_group".
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property string $rules
 */
class AuthGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['rules'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'rules' => 'Rules',
        ];
    }
}
