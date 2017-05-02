<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%score}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $tid
 * @property integer $score
 * @property integer $aid
 */
class Score extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%score}}';
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
            [['uid', 'tid', 'score', 'aid'], 'integer'],
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
            'tid' => 'Tid',
            'score' => 'Score',
            'aid' => 'Aid',
        ];
    }
}
