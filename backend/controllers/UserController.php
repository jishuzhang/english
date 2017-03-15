<?php
/**
 * 个人信息页面控制器
 *
 * @author zhangjie
 */
namespace backend\controllers;

use Yii;
use yii\imagine\Image;
use yii\web\Controller;
use yii\data\Pagination;
use backend\models\Roles;
use backend\models\Nodes;
use backend\models\Admin;
use yii\web\UploadedFile;
use yii\base\Security;
use backend\controllers\BackendController;

class UserController extends BackendController{
	
	//个人信息首页
	public function actionIndex(){
		if(!Yii::$app->request->post()){
		$model = new Admin();
		$model2 = new Roles();
	
		$session = Yii::$app->session;
		$user = $session->get('user');
		//在进行退出操作的时候,默认所有的session都会清除
		if(!$session->isActive){
			// 开启session
			$session->open();
		}
		//获取访问者的用户名 
		$username = Yii::$app->user->identity->username;
		$sql = "select userid,username,roleid,realname,department,portrait from ".Yii::$app->components['db']['tablePrefix']."admin where username='{$username}'";
		$arr_user =  Yii::$app->db->createCommand($sql)->queryAll();
		//获取对应的角色id号
		$roleid = $arr_user[0]['roleid'];
		//进行角色的查询
		$sql = "select role_name from ".Yii::$app->components['db']['tablePrefix']."roles where id=".$roleid;
		$arr_role =  Yii::$app->db->createCommand($sql)->queryAll();
		return $this->renderPartial('index',[
					'model' => $model,
					'model2' => $model2,
					'arr_user' => $arr_user,
					'arr_role'=>$arr_role,
			]);
		}else{
			$new = new Security;
			//$salt = $new->generatePasswordHash('1234567890');
			$model = new Admin();
			//管理员账户名
			$username=Yii::$app->request->post('Admin')['username'];
			//获取管理员的id号
			$userid=Yii::$app->request->post('Admin')['userid'];
			//密码
			$password_hash = Yii::$app->request->post('Admin')['password_hash'];
			
			//真实姓名
			$realname = Yii::$app->request->post('Admin')['realname'];
			
			//所属部门
			$department = Yii::$app->request->post('Admin')['department'];
			//上传头像
			$portrait = Yii::$app->request->post('portrait');
				//进行数据库的更新
				if(empty($password_hash)){
					$sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."admin SET realname=:realname,department=:department,portrait=:portrait WHERE userid=:userid";
					$command = Yii::$app->db->createCommand($sql,[":realname"=>$realname,":department"=>$department,":portrait"=>$portrait,":userid"=>$userid]);
					$if_ok = $command->execute();
				}else{
						
					//$password_hash = password_hash($password_hash,PASSWORD_DEFAULT);
					$password_hash = $new->generatePasswordHash($password_hash);
					$sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."admin SET password_hash=:password_hash,realname=:realname,department=:department,portrait=:portrait WHERE userid=:userid";
					$command = Yii::$app->db->createCommand($sql,[":password_hash"=>$password_hash,":realname"=>$realname,":department"=>$department,":portrait"=>$portrait,":userid"=>$userid]);
					$if_ok = $command->execute();
				}
			
				if($if_ok){
						
					$model = new Admin();
					$model2 = new Roles();
					$session = Yii::$app->session;
					$user = $session->get('user');
					//在进行退出操作的时候,默认所有的session都会清楚
					if(!$session->isActive){
						// 开启session
						$session->open();
					}
					//获取访问者的用户名
					$username = Yii::$app->user->identity->username;
					$sql = "select userid,username,roleid,realname,department,portrait from ".Yii::$app->components['db']['tablePrefix']."admin where username='{$username}'";
                                        $arr_user =  Yii::$app->db->createCommand($sql)->queryAll();
                                       
					//获取对应的角色id号
					$roleid = $arr_user[0]['roleid'];
					//进行角色的查询
					$sql = "select id,role_name from ".Yii::$app->components['db']['tablePrefix']."roles where id=".$roleid;
					$arr_role =  Yii::$app->db->createCommand($sql)->queryAll();
					return $this->renderPartial('index',[
							'model' => $model,
							'model2' => $model2,
							'arr_user' => $arr_user,
							'arr_role'=>$arr_role,
					]);
				}else{
					//echo '更新失败';
					return $this->renderPartial('error');
				}
			}
		}







}