<?php
/**
 * 列表页控制器
 
 */
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use backend\models\Roles;
use backend\models\Node_role;
use backend\models\Nodes;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;
use backend\controllers\Tree;
use yii\web\Cookie;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
class RolesController extends BackendController
{
public $enableCsrfValidation = false;
	public function actionIndex()
	{
	}
	//角色管理控制器  
	public function actionRole_manage()
	{	
		// 获取roles 表的的所有内容
		$query = Roles::find();
		
		//进行分页操作
		$pagination = new Pagination([
				'defaultPageSize'=>10,
				'totalCount' =>$query->count(),
				]);
		$roles=$query->offset($pagination->offset)
				->limit($pagination->limit)
				->all();
		return $this->renderPartial('role_manage',[
				'roles'=>$roles,
				'pagination'=>$pagination,
			]);			
	}
	
	//角色添加控制器
	public function actionRole_add()
	{
		$model = new Roles();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$ifok=$model->save();
			if($ifok){
              return $this->redirect(['roles/role_manage']);		
			}				
		} else {
             return $this->renderPartial('role_add',[
				'model' => $model,		
			]);	
		}
			
	}
	
	
	//角色管理控制器 
	public function actionRole_delete()
	{
		 //防止误删
		if(empty(Yii::$app->user->identity)){
			 return $this->redirect(['site/login']);		 
		}
		$id = Yii::$app->request->get('id');
		$sql="DELETE ".Yii::$app->components['db']['tablePrefix']."roles,".Yii::$app->components['db']['tablePrefix']."node_role from ".Yii::$app->components['db']['tablePrefix']."roles LEFT JOIN ".Yii::$app->components['db']['tablePrefix']."node_role ON ".Yii::$app->components['db']['tablePrefix']."roles.id=".Yii::$app->components['db']['tablePrefix']."node_role.roleid WHERE ".Yii::$app->components['db']['tablePrefix']."roles.id=:id;";
		$command = Yii::$app->db->createCommand($sql,[":id"=>$id]);
		$if_ok=$command->execute();
		if($if_ok){
            return $this->redirect(['roles/role_manage']);
		}else{
            echo "删除失败";exit;
		}
		
	}

	//进行角色的修改
	public function actionRole_update()
	{
		if(Yii::$app->request->post()) {
		//获取角色对应的id号
		$id= Yii::$app->request->post('id');
		//获取用户的roleid号
		$roleid= Yii::$app->request->post('roleid');
		//获取权限描述
		$remark = Yii::$app->request->post('remark');
		//获取提交过来的名字
		$name= Yii::$app->request->post('name');
		$sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."roles SET role_name=:name,remark=:remark WHERE  id=:id";
		$command = Yii::$app->db->createCommand($sql,[":id"=>$id,":name"=>$name,":remark"=>$remark]);
		$if_ok = $command->execute();
		if($if_ok){			
			 return $this->redirect(['roles/role_manage']);		
		}else{
			echo "更新失败"; exit;
		}		
	    }else{
		
		//获取角色对应的id号
		$id= Yii::$app->request->get('id');
		if(!empty($id)){
			$sql = "select id,role_name,remark from ".Yii::$app->components['db']['tablePrefix']."roles where id=".$id;
			$rows = Yii::$app->db->createCommand($sql)->queryAll();
				
			return $this->renderPartial('role_update',[
					'rows' => $rows,
			]);
		}
	    }
	}
	
	//权限设置控制器   by sasa
	public function  actionRole_set(){
		//获取角色对应的id号
		$roleid = Yii::$app->request->get('role');
		$role = Yii::$app->request->get('id');
		$nodeid = Yii::$app->request->get('nid');
		
		if(isset($nodeid)) {
            $chk = intval(Yii::$app->request->get('chk'));
            $mc = Nodes::find()->where(['nodeid'=>$nodeid])->one();
            $r = Node_role::find()->where(['nodeid'=>$nodeid,'roleid'=>$roleid])->one();
            $keyid = substr(md5($roleid.$mc['c'].$mc['a']),0,16);
            if($r) {
                $r->chk=$chk;
				$r->keyid=$keyid;
				$r->save();
            } else {
				$r= new Node_role();
				$r->nodeid=$nodeid;
				$r->roleid=$roleid;
				$r->chk=$chk;
				$r->keyid=$keyid;
				$r->save();
            }
            exit('1');
        } else {
            $r_role =  Roles::find()->where(['id'=>$role])->one();
            $parent_top = Nodes::find()->where(['pid'=>0])->all();

            $result = Nodes::find()->all();
            $privates_rs = Node_role::find()->where(['roleid'=>$role,'chk'=>1])->all();
            $privates = array();
            foreach($privates_rs as $rs) {
               if($rs['chk']) $privates[] = $rs['nodeid'];
            }
			return $this->renderPartial('role_set',[
					'r_role' => $r_role,
					'parent_top'=>$parent_top,
					'result'=>$result,
					'privates_rs'=>$privates_rs,
					'privates'=>$privates,

			]);

        }
	}
	
	
}
	
	
