<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%count_info}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $exec_time
 * @property integer $day_add
 * @property integer $day_modify
 */
class FuncCountInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%count_info}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'exec_time', 'day_add', 'day_modify'], 'integer']
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
            'exec_time' => 'Exec Time',
            'day_add' => 'Day Add',
            'day_modify' => 'Day Modify',
        ];
    }
}
