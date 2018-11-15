<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "site_set".
 *
 * @property string $site_title 网站标题
 * @property string $site_logo 网站logo
 * @property string $telephone 联系电话
 * @property string $site_description 网站描述
 * @property string $site_keyword 网站关键字
 * @property string $copyright_all 版权所有
 * @property string $site_icp 备案号
 * @property string $visit_code 统计代码
 * @property string $baidu_push 百度推送
 */
class SiteSet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_set';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_code'], 'string'],
            [['site_title'], 'string', 'max' => 50],
            [['site_logo', 'site_description', 'site_keyword', 'baidu_push'], 'string', 'max' => 130],
            [['telephone'], 'string', 'max' => 20],
            [['copyright_all'], 'string', 'max' => 40],
            [['site_icp'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'site_title' => 'Site Title',
            'site_logo' => 'Site Logo',
            'telephone' => 'Telephone',
            'site_description' => 'Site Description',
            'site_keyword' => 'Site Keyword',
            'copyright_all' => 'Copyright All',
            'site_icp' => 'Site Icp',
            'visit_code' => 'Visit Code',
            'baidu_push' => 'Baidu Push',
        ];
    }
}
