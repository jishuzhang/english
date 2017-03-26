<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%movies}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $src
 * @property integer $ctime
 * @property string $description
 * @property integer $mtime
 * @property string $poster
 */
class Movies extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%movies}}';
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
            [['ctime', 'mtime'], 'integer'],
            [['title'], 'string', 'max' => 32],
            [['src', 'description', 'poster'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'src' => 'Src',
            'ctime' => 'Ctime',
            'description' => 'Description',
            'mtime' => 'Mtime',
            'poster' => 'Poster',
        ];
    }
}
