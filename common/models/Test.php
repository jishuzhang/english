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
            'name' => '试卷标题',
            'full_score' => '试卷满分',
            'answer_table' => '答案表名',
            'status' => '试卷状态',
            'minute_time' => '考试时长',
            'author' => 'Author',
            'last_modfiy_time' => '最后修改时间',
            'time_lock' => '试卷类型',
            'introduce' => '试卷介绍',
        ];
    }

    public function recordTest()
    {
        $user = Admin::findOne(['userid'=>Yii::$app->user->id]);
        $this->author = $user->username;

        $this->time_lock = empty($this->time_lock) ? 0 : $this->time_lock  ;
        $this->status = 0;
        $this->last_modfiy_time = time();

        return $this->save() ? $this : false ;
    }
}
