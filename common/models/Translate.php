<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%translate}}".
 *
 * @property integer $tid
 * @property integer $vid
 * @property string $en_content
 * @property string $zn_content
 * @property integer $ctime
 * @property integer $utime
 */
class Translate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%translate}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('english');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vid', 'en_content', 'zn_content'], 'required'],
            [['vid', 'ctime', 'utime'], 'integer'],
            [['en_content', 'zn_content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tid' => 'Tid',
            'vid' => 'Vid',
            'en_content' => 'En Content',
            'zn_content' => 'Zn Content',
            'ctime' => 'Ctime',
            'utime' => 'Utime',
        ];
    }
}
