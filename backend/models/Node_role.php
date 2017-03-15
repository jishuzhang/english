<?php
namespace backend\models;
use yii\db\ActiveRecord;
class Node_role extends ActiveRecord
{

	public static function tableName()
	{
		return '{{%node_role}}';
	}


}