<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%modify_methods}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $method_name
 * @property string $class_name
 * @property string $file_name
 * @property string $last_exec_time
 * @property string $mtime
 * @property string $coefficient
 * @property string $project_alias
 * @property string $description
 */
class BlModifyMethods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%modify_methods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
            [['method_name', 'class_name', 'file_name', 'last_exec_time', 'mtime', 'project_alias', 'description'], 'string', 'max' => 255],
            [['coefficient'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'method_name' => 'Method Name',
            'class_name' => 'Class Name',
            'file_name' => 'File Name',
            'last_exec_time' => 'Last Exec Time',
            'mtime' => 'Mtime',
            'coefficient' => 'Coefficient',
            'project_alias' => 'Project Alias',
            'description' => 'Description',
        ];
    }
}
