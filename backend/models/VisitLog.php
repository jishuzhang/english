<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "visit_log".
 *
 * @property string $visit_log_id
 * @property string $app_title
 * @property string $interface_vision_title
 * @property string $interface_title
 * @property string $visit_ip
 * @property string $visit_url
 * @property integer $visit_time
 * @property string $visit_accesstoken
 * @property integer $users_id
 */
class VisitLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'visit_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_title', 'interface_vision_title', 'interface_title', 'visit_ip', 'visit_url', 'visit_time', 'visit_accesstoken', 'users_id'], 'required'],
            [['visit_time', 'users_id'], 'integer'],
            [['app_title', 'interface_vision_title', 'interface_title', 'visit_url', 'visit_accesstoken'], 'string', 'max' => 255],
            [['visit_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'visit_log_id' => 'Visit Log ID',
            'app_title' => 'App Title',
            'interface_vision_title' => 'Interface Vision Title',
            'interface_title' => 'Interface Title',
            'visit_ip' => 'Visit Ip',
            'visit_url' => 'Visit Url',
            'visit_time' => 'Visit Time',
            'visit_accesstoken' => 'Visit Accesstoken',
            'users_id' => 'Users ID',
        ];
    }
}
