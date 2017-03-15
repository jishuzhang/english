<?php
namespace backend\models;
use yii\db\ActiveRecord;
class Roles extends ActiveRecord
{

	public function rules()
	{	
		// 使用ajax 校验数据
		return [
				//['roleid', 'required','message'=>'角色id号不能为空'],
				['role_name','unique','message'=>'角色名已存在'],
				['role_name', 'required','message'=>'角色名号不能为空'],
				['remark', 'required', 'message'=>'描述不能为空'],
				
				
		];
	}
	
	// 第一个参数为要关联的字表模型类名称，
	//第二个参数指定 通过子表的 customer_id 去关联主表的 id 字段
	 public function getAdmin()
	{
		return $this->hasMany(Admin::className(), ['roleid' => 'id']);
	} 
	
	
}