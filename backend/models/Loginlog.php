<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "oppration_log".
 *
 * @property string $login_log_id
 * @property integer $users_id
 * @property integer $login_time
 * @property integer $login_ip
 */
class Loginlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login_log_id','users_id','login_time','login_ip'], 'required'],
            [['login_log_id','login_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login_log_id' => 'Oppration Log ID',
            'users_id' => 'Users ID',
            'login_time' => 'Oppration Time',
            'login_ip' => 'Login IP',
        ];
    }
}
