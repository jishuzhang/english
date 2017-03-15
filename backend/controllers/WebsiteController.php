<?php

namespace backend\controllers;

use Yii;
use backend\models\Website;
use backend\models\WebsiteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\PublicFunction;
use backend\controllers\BackendController;

/**
 * WebsiteController implements the CRUD actions for Website model.
 * 
 * @author mengbaoqing
 */
class WebsiteController extends BackendController
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

    /**
     * 站点基本设置
     */
    public function actionIndex()
    {
        $id = 1;
        $model = $this->findModel(1);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {  
            $Function = new PublicFunction();
            $content = $Function->message('success', '提交成功', 'index.php?r=website/index');  //获取提示信息
            return $this->renderContent($content);//提示信息并跳转到视图页面index
        } else {
            return $this->renderPartial('index', ['model' => $model]);
        }
    }

    /**
     * Finds the Website model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Website the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Website::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
