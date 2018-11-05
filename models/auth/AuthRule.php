<?php

namespace app\models\auth;

use Yii;

/**
 * This is the model class for table "auth_rule".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property int $type
 * @property int $status
 * @property string $condition
 */
class AuthRule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_rule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'status'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['title'], 'string', 'max' => 20],
            [['condition'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'title' => 'Title',
            'type' => 'Type',
            'status' => 'Status',
            'condition' => 'Condition',
        ];
    }
}
