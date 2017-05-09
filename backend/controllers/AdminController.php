<?php
/**
 * 管理员添加控制器
 *
 * @author zhangjie
 * 
 */
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use backend\models\Roles;
use backend\models\Admin;
use backend\models\Nodes;
use yii\base\Security;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;
use yii\web\Cookie;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
class AdminController extends BackendController
{
	//管理员首页
	public function actionIndex()
	{
		//获取当前用户的userid号
		$userid = Yii::$app->user->identity->userid;
		//获取该用户对应的角色id号
		$sql = "select roleid,username from ".Yii::$app->components['db']['tablePrefix']."admin where userid = ".$userid;
		$rows =  Yii::$app->db->createCommand($sql)->queryAll();
		//$now_role_id = $rows[0]['roleid'];
		$now_role_name = $rows[0]['username'];
        $query = Admin::find()
            ->select([Yii::$app->components['db']['tablePrefix'].'admin.userid',
			Yii::$app->components['db']['tablePrefix'].'admin.username',
			Yii::$app->components['db']['tablePrefix'].'admin.roleid',
			Yii::$app->components['db']['tablePrefix'].'admin.realname',
			Yii::$app->components['db']['tablePrefix'].'roles.id',
			Yii::$app->components['db']['tablePrefix'].'roles.role_name'])
            ->innerJoinWith('roles');
            //$query = Admin::getDb()->createCommand('SELECT a.userid,a.username,a.roleid,a.realname,r.id,r.role_name FROM {{%admin}} AS a INNER JOIN {{%roles}} AS r ON a.roleid = r.id');
			$pagination = new Pagination([
				'defaultPageSize'=>10,
				'totalCount' =>$query->count(),
				]);
			$datas=$query->offset($pagination->offset)
				->limit($pagination->limit)
				->all();

			return $this->renderPartial('index',[
					'datas' => $datas,
					'pagination'=>$pagination,
					'now_role_name' => $now_role_name,
			]);
	}

    public function actionSearch(){
        //获取当前用户的userid号
        $userid = Yii::$app->user->identity->userid;
        //获取该用户对应的角色id号
        $sql = "select roleid,username from ".Yii::$app->components['db']['tablePrefix']."admin where userid = ".$userid;
        $rows =  Yii::$app->db->createCommand($sql)->queryAll();
        $now_role_name = $rows[0]['username'];

        $post = Yii::$app->request->post();
//            var_dump($post);die;
        if($post){
            $type = $post['search']['type'];
            $content = trim($post['search']['content']);
        }else{
            $get = Yii::$app->request->get();
            $type = $get['type'];
            $content = trim($get['content']);
            $page = $get['page'];
        }
        $where="";
        if($type=='管理员名'){
            $where .= ' username like "%'.$content.'%"';
        }
        if($type=='真实姓名'){
            $where .= ' realname like "%'.$content.'%"';
        }
        $tablePrefix = Yii::$app->components['db']['tablePrefix'];
        $query = Admin::find()->select([$tablePrefix.'admin.userid',$tablePrefix.'admin.username',$tablePrefix.'admin.roleid',$tablePrefix.'admin.realname',$tablePrefix.'roles.id',$tablePrefix.'roles.role_name'])->where($where)->innerJoinWith('roles');
        $pagination = new Pagination([
            'defaultPageSize'=>10,
            'totalCount' =>$query->count(),
        ]);
        $datas=$query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->renderPartial('index',[
            'datas' => $datas,
            'pagination'=>$pagination,
            'now_role_name' => $now_role_name,
            'content' => $content,
            'type' => $type,
        ]);
    }

	//进行管理员编辑页面处理
	public function  actionAdmin_edit()
	{
		if(!Yii::$app->request->post()){  
                        //获取该用户对应的id号
                        $id=Yii::$app->request->get('id');
                        //获取该角色对应的id号
                        $role_id=Yii::$app->request->get('roleid');
                        $sql="select a.userid,a.username,a.realname,r.role_name from ".Yii::$app->components['db']['tablePrefix']."admin a,".Yii::$app->components['db']['tablePrefix']."roles r where  a.userid=".$id;
                        $row =  Yii::$app->db->createCommand($sql)->queryAll();

                        $sql="select * from ".Yii::$app->components['db']['tablePrefix']."roles";
                        $rows =  Yii::$app->db->createCommand($sql)->queryAll();
                        return $this->renderPartial('admin_edit',[
                                                'row' => $row,
                                                'rows' => $rows,
                                                'role_id'=>$role_id,
     
                                ]);	
		}else{
			//密码先不修改
			$new = new Security;
			$id = Yii::$app->request->post('id');
			$username=Yii::$app->request->post('username');
			$realname=Yii::$app->request->post('realname');
			
			//进行密码的修改
			$password = Yii::$app->request->post('password_hash');
			//获取角色对应的id号
			$roleid=Yii::$app->request->post('roleid');
			if(empty($password)){
				$sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."admin SET username=:username,roleid=:roleid,realname=:realname WHERE userid=:id";
				$command = Yii::$app->db->createCommand($sql,[":username"=>$username,":roleid"=>$roleid,":realname"=>$realname,":id"=>$id]);
				$if_ok = $command->execute();
			}else{
				$password_hash = $new->generatePasswordHash($password);
				$sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."admin SET username=:username,password_hash=:password_hash,roleid=:roleid,realname=:realname WHERE userid=:id";
				$command = Yii::$app->db->createCommand($sql,[":username"=>$username,":password_hash"=>$password_hash,":roleid"=>$roleid,":realname"=>$realname,":id"=>$id]);
				$if_ok = $command->execute();
					
			}
			if($if_ok){                                     
            return $this->redirect(['admin/index']);		
			}else{
             echo "更新失败"; exit;				
			}
		}	
	}
	//进行管理员删除处理
	public function actionAdmin_delete()
	{
		 //防止误删
		if(empty(Yii::$app->user->identity)){
			 return $this->redirect(['site/login']);		 
		}
		$id=Yii::$app->request->get('id');
		$sql="delete from ".Yii::$app->components['db']['tablePrefix']."admin where userid=:id";
		$command = Yii::$app->db->createCommand($sql,[':id'=>$id]);
		$if_ok = $command->execute();
		if($if_ok){
			return $this->redirect(['admin/index']);
		}else{
			echo '删除失败'; exit;
		}
		
	}
	public function actionAdd_admin()
	{
		if(!Yii::$app->request->post()){
		$model = new Admin();
		$model2 = new Roles();
		$data = Roles::find()->all();
		//如果是post方法提交的并且验证正确的话,就进行登录  在验证正确的时候进行操作
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			return $this->renderPartial('add_admin',[
					'data' => $data,
					'model' => $model,
					'model2' => $model2,
			
			]);
			
		}else{
			return $this->renderPartial('add_admin',[
					'data' => $data,
					'model' => $model,
					'model2' => $model2,
	
			]);
		}
	 }else{
	 	$new = new Security;
	 	$model = new Admin();
	 	$model2 = new Roles();
	 	$data = Roles::find()->all();
	 	//获取的角色名称
	 	$role_name = Yii::$app->request->post('Roles')['role_name'];
	 	//管理员名称
	 	$username = Yii::$app->request->post('Admin')['username'];
	 	//管理员密码
	 	$pass = Yii::$app->request->post('Admin')['password_hash'];
	 	//$password_hash = password_hash($pass,PASSWORD_DEFAULT);
	 	$password_hash = $new->generatePasswordHash($pass);
	 	//真实姓名
	 	$realname = Yii::$app->request->post('Admin')['realname'];
	 	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
	 		$sql="insert into ".Yii::$app->components['db']['tablePrefix']."admin(username,password_hash,roleid,realname) values(:username,:password_hash,:roleid,:realname)";
	 		$command = Yii::$app->db->createCommand($sql,[":username"=>$username,":password_hash"=>$password_hash,":roleid"=>$role_name,":realname"=>$realname]);
	 		$if_ok=$command->execute();
	 		if($if_ok){
                return $this->redirect(['admin/index']);	
	 		}else{
	 			echo '添加失败';
	 		}
	 	}else{
	 		return $this->renderPartial('add_admin',[
	 				'data' => $data,
	 				'model' => $model,
	 				'model2' => $model2,
	 		
	 		]);
	 	}
	 	
	 	
	  }
	}

	
}