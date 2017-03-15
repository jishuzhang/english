<?php
namespace backend\controllers;

use Yii;
use backend\models\Logs;
use backend\models\Admin;
use backend\models\LogsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Base controller
 */
class BaseController extends Controller
{
	
/**
 * 记录行为日志，并执行该行为的规则
 * @param string $action 行为标识--方法
 * @param string $model 触发行为的模型名
 * @param int $record_id 触发行为的记录id
 * @param int $user_name 执行行为的用户user_name
 * @return boolean
 * @author huajie <banhuajie@163.com>
 */	
	public function actionRizhi($action = null, $models = null, $record_id = null){
    $model = new Logs();
	$user_name = Yii::$app->user->identity->username;
	$user_id = Yii::$app->user->identity->userid;
    //参数检查
    if(empty($action) || empty($models) || empty($record_id)){
       return '参数不能为空';
    }
    //if(empty($user_name)){
     //   return $this->redirect(['user/login']);
    //}

    //插入行为日志
    $model->action  =   $action;
    $model->user_name   =   $user_name;
	$model->user_id   =   $user_id;
    $model->action_ip  =   $_SERVER["REMOTE_ADDR"];
    $model->model      =   $models;
    $model->record_id  =   $record_id;
    $model->create_time =   time();
    //记录操作url
    $model->remark    =   '操作url：'.$_SERVER['REQUEST_URI'];
    $model->save();
}

    
	
	


}


