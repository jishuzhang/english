<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%recommend}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $url
 */
class Recommend extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recommend}}';
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
            [['description'], 'string'],
            [['name', 'url'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'url' => 'Url',
        ];
    }

    public function getTableColumnInfo()
    {
        return [
            'id' => [
                'name' => 'id',
                'allowNull' => false,
                'defaultValue' => '',
                'enumValues' => null,
                'isPrimaryKey' => true,
                'phpType' => 'integer',
                'precision' => '20',
                'scale' => '',
                'size' => '11',
                'type' => 'int',
                'unsigned' => true,
                'label' => '推荐位ID',
                'inputType' => 'hidden',
                'isEdit' => false,
                'isSearch' => true,
                'isDisplay' => true,
                'isSort' => true,
            ],
            'name' => [
                'name' => 'name',
                'allowNull' => false,
                'defaultValue' => '',
                'enumValues' => null,
                'isPrimaryKey' => false,
                'phpType' => 'string',
                'precision' => '',
                'scale' => '',
                'size' => '500',
                'type' => 'char',
                'unsigned' => true,
                'label' => '推荐位名称',
                'inputType' => 'text',
                'isEdit' => true,
                'isSearch' => true,
                'isDisplay' => true,
                'isSort' => false,
            ],
            'description' => [
                'name' => 'description',
                'allowNull' => false,
                'defaultValue' => 0,
                'enumValues' => null,
                'isPrimaryKey' => false,
                'phpType' => 'string',
                'precision' => '',
                'scale' => '',
                'size' => '500',
                'type' => 'text',
                'unsigned' => true,
                'label' => '单词',
                'inputType' => 'textarea',
                'isEdit' => true,
                'isSearch' => false,
                'isDisplay' => true,
                'isSort' => false,
            ],
            'url' => [
                'name' => 'url',
                'allowNull' => false,
                'defaultValue' => 0,
                'enumValues' => null,
                'isPrimaryKey' => false,
                'phpType' => 'string',
                'precision' => '',
                'scale' => '',
                'size' => '255',
                'type' => 'char',
                'unsigned' => true,
                'label' => '推荐位链接',
                'inputType' => 'text',
                'isEdit' => true,
                'isSearch' => false,
                'isDisplay' => true,
                'isSort' => false,
            ],
        ];
    }
}
