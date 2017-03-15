<?php

namespace backend\models;

use Yii;


class Logintime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%logintime}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'uid', 'status', 'logintime'], 'integer'],
            [['ip'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'ip' => '操作人ip',
            'status' => '状态',
            'logintime' => '登陆时间',
        ];
    }
}
