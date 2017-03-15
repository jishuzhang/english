<?php
namespace backend111\models;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Admin extends ActiveRecord
{

	public function rules()
	{	
		// 使用ajax 校验数据
		return [
				['username', 'required','message'=>'管理员名不能为空'],
				['username','unique','message'=>'管理员名已存在'],
				//['password_hash', 'required','message'=>'密码不能为空'],
				['portrait', 'file'],
				
		];
	}
	// 第一个参数为要关联的字表模型类名称，
	//第二个参数指定 通过子表的 customer_id 去关联主表的 id 字段
	public function getRoles()
	{
		return $this->hasMany(Roles::className(), ['id' => 'roleid']);
	}
	
	
}