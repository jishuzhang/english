<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%count_record}}".
 *
 * @property integer $id
 * @property integer $date
 * @property integer $time
 */
class BlCountRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%count_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'time' => 'Time',
        ];
    }
}
