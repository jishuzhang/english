<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%nodes}}".
 *
 * @property integer $nodeid
 * @property string $title
 * @property integer $pid
 * @property string $controller
 * @property string $application
 * @property integer $listorder
 * @property integer $modelid
 * @property integer $display
 * @property string $group
 * @property integer $model_id
 * @property string $model_name
 * @property string $catalog
 */
class Nodes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nodes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'c', 'a'], 'required'],
            [['pid', 'listorder', 'display',], 'integer'],
            [['title', 'm', 'c', 'a', 'data', 'img_icon',], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nodeid' => '菜单ID',
            'title' => '菜单名称',
            'pid' => '父级ID',
            'path' => '菜单路径',
            'm' => '模块',
            'c' => '控制器',
            'a' => '方法',
            'listorder' => '排序',
            'display' => '是否显示',
            'data' => '附加参数',
            'img_icon' => '菜单图标',
        ];
    }
}
