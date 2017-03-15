<?php

namespace backend\controllers;

use backend\models\Admin;
use Yii;
use backend\models\Logs;
use backend\models\LogsSearch;
use backend\models\Logintime;
use backend\models\Editor_log;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BackendController;
use yii\data\Pagination;
/**
 * LogsController implements the CRUD actions for Logs model.
 */
class LogsController extends BackendController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
	
	
    public function actionCindex()
    {

        $sql='select * from bl_logs LEFT OUTER JOIN bl_admin on bl_logs.uid=bl_admin.userid ORDER BY id DESC';
        $query = Yii::$app->db->createCommand($sql.' limit 1000');
        $d=$query->queryAll();
		$pages = new Pagination([
        'totalCount' =>count($d),
		'pageSize' => 20,
		]);
        $data =Yii::$app->db->createCommand($sql . " limit " . $pages->limit . " offset " . $pages->offset . "")->queryAll();
        return $this->renderPartial('cindex', [
            'data' => $data,
			'pages' => $pages,
        ]);
    }
	
	
	public function actionLoginindex()
    {
        $sql='select * from bl_logintime LEFT OUTER JOIN bl_admin on bl_logintime.uid=bl_admin.userid ORDER BY id DESC';
        $query = Yii::$app->db->createCommand($sql);
        $d=$query->queryAll();

		$pages = new Pagination(['totalCount' =>count($d), 'pageSize' => '20']);
        $data =Yii::$app->db->createCommand($sql . " limit " . $pages->limit . " offset " . $pages->offset . "")->queryAll();
        return $this->renderPartial('loginindex', [
            'data' => $data,
			'pages' => $pages,
        ]);
    }


    public function actionEditor()
    {


       $d = Editor_log::find();
        $countD = clone  $d;
        $pages = new Pagination([
            'totalCount' => $countD->count(),
           'pageSize' => 20,
       ]);
       $data = $d->offset($pages->offset)->limit($pages->limit)->all();
       return $this->renderPartial('editor', [
            'data' => $data,
            'pages' => $pages,
        ]);
    }



}
