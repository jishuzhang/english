<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%words}}".
 *
 * @property integer $wid
 * @property integer $tid
 * @property string $word
 * @property string $explain
 * @property integer $ctime
 * @property integer $mtime
 */
class Words extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%words}}';
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
            [['tid', 'ctime', 'mtime'], 'integer'],
            [['word'], 'string', 'max' => 50],
            [['explain'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wid' => 'Wid',
            'tid' => 'Tid',
            'word' => 'Word',
            'explain' => 'Explain',
            'ctime' => 'Ctime',
            'mtime' => 'Mtime',
        ];
    }
}
