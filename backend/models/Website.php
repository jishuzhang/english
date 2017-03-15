<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%site}}".
 *
 * @property integer $siteid
 * @property string $name
 * @property string $url
 * @property string $site_title
 * @property string $keywords
 * @property string $description
 * @property string $copyright
 * @property string $stat
 */
class Website extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stat', 'description'], 'string'],
            [['name'], 'string', 'max' => 30],
            [['url', 'title', 'keywords', 'copyright'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '系统ID',
            'name' => '系统名称',
            'url' => '系统URL',
            'title' => 'SEO标题',
            'keywords' => 'SEO关键词',
            'description' => 'SEO描述',
            'copyright' => '版权信息',
            'stat' => '访问统计代码',
        ];
    }
}
