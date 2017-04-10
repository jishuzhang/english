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
            [['tid'], 'integer'],
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
        ];
    }

    public function getTableColumnInfo()
    {
        return [
            'wid' => [
                'name' => 'wid',
                'allowNull' => false,
                'defaultValue' => '',
                'enumValues' => null,
                'isPrimaryKey' => true,
                'phpType' => 'integer',
                'precision' => '20',
                'scale' => '',
                'size' => '20',
                'type' => 'int',
                'unsigned' => true,
                'label' => '单词ID',
                'inputType' => 'hidden',
                'isEdit' => false,
                'isSearch' => true,
                'isDisplay' => true,
                'isSort' => true,
            ],
            'tid' => [
                'name' => 'tid',
                'allowNull' => false,
                'defaultValue' => '',
                'enumValues' => null,
                'isPrimaryKey' => false,
                'phpType' => 'integer',
                'precision' => '20',
                'scale' => '',
                'size' => '20',
                'type' => 'int',
                'unsigned' => true,
                'label' => '该单词对应的台词ID',
                'inputType' => 'text',
                'isEdit' => true,
                'isSearch' => true,
                'isDisplay' => true,
                'isSort' => false,
            ],
            'word' => [
                'name' => 'word',
                'allowNull' => false,
                'defaultValue' => 0,
                'enumValues' => null,
                'isPrimaryKey' => false,
                'phpType' => 'string',
                'precision' => '20',
                'scale' => '',
                'size' => '255',
                'type' => 'char',
                'unsigned' => true,
                'label' => '单词',
                'inputType' => 'text',
                'isEdit' => true,
                'isSearch' => true,
                'isDisplay' => true,
                'isSort' => false,
            ],
            'explain' => [
                'name' => 'word',
                'allowNull' => false,
                'defaultValue' => 0,
                'enumValues' => null,
                'isPrimaryKey' => false,
                'phpType' => 'string',
                'precision' => '20',
                'scale' => '',
                'size' => '255',
                'type' => 'char',
                'unsigned' => true,
                'label' => '单词释义',
                'inputType' => 'text',
                'isEdit' => true,
                'isSearch' => false,
                'isDisplay' => true,
                'isSort' => false,
            ],
        ];
    }
}
