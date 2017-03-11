<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oppration_log".
 *
 * @property string $oppration_log_id
 * @property integer $users_id
 * @property integer $m
 * @property integer $c
 * @property integer $action
 * @property integer $content
 * @property integer $oppration_time
 */
class OpprationLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oppration_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['users_id','m','c','action','content', 'oppration_time'], 'required'],
            [['users_id','oppration_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'oppration_log_id' => 'Oppration Log ID',
            'users_id' => 'Users ID',
            'm' => 'm',
            'c' => 'c',
            'content' => 'content',
            'action' => 'action',
            'oppration_time' => 'Oppration Time',
        ];
    }
}
