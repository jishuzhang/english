<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%test}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $full_score
 * @property string $answer_table
 * @property integer $status
 * @property integer $minute_time
 * @property string $author
 * @property integer $last_modfiy_time
 * @property integer $time_lock
 * @property string $introduce
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%test}}';
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
            [['full_score', 'status', 'minute_time', 'last_modfiy_time', 'time_lock'], 'integer'],
            [['name', 'introduce'], 'string', 'max' => 255],
            [['answer_table', 'author'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'full_score' => 'Full Score',
            'answer_table' => 'Answer Table',
            'status' => 'Status',
            'minute_time' => 'Minute Time',
            'author' => 'Author',
            'last_modfiy_time' => 'Last Modfiy Time',
            'time_lock' => 'Time Lock',
            'introduce' => 'Introduce',
        ];
    }
}
