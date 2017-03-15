<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%dirs}}".
 *
 * @property integer $id
 * @property string $project_alias
 * @property string $path
 */
class BlDirs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dirs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_alias', 'path'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_alias' => 'Project Alias',
            'path' => 'Path',
        ];
    }
}
