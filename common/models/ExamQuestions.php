<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%exam_questions}}".
 *
 * @property integer $id
 * @property integer $tid
 * @property integer $q_type
 * @property integer $q_number
 * @property integer $q_score
 * @property string $q_name
 * @property string $q_answer
 * @property string $q_answer_code
 */
class ExamQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%exam_questions}}';
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
            [['tid', 'q_type', 'q_number', 'q_score'], 'integer'],
            [['q_name', 'q_answer', 'q_answer_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tid' => 'Tid',
            'q_type' => 'Q Type',
            'q_number' => 'Q Number',
            'q_score' => 'Q Score',
            'q_name' => 'Q Name',
            'q_answer' => 'Q Answer',
            'q_answer_code' => '答案标识码',
        ];
    }

    /**
     * 使用占位符替代 空格、约等于号 等 短语之间间隔  生成唯一标识码
     * @param $str
     * @return string
     */
    public static function generateIndexCode($str)
    {
        $nStr = '';
        if(!empty($str))
        {
            preg_match_all('/\w+/',$str,$r);

            $nStr = implode('_',$r[0]);
        }

        return $nStr;
    }

    public static function genColumnName($tid,$qid)
    {
        if(empty($tid) || empty($qid))
        {
            return '';
        }
        else
        {
            return 't'.$tid.'Xq'.$qid;
        }

    }
}
