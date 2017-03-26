<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-3-13
 * Time: 18:13
 */
namespace frontend\controllers;

use yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Movies;
use yii\data\Pagination;

class PlayerController extends Controller
{
    public $layout = "main";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];

    }

    public function actionScreen()
    {
        $videoId = Yii::$app->request->get('videoid');
        if(empty($videoId)){
           $this->redirect(Yii::$app->request->getReferrer());
        }

        $model = Movies::findOne(['id' => $videoId]);

        return $this->render('screen',[
            'model' => $model,
        ]);
    }

    public function actionList()
    {
        $data =Movies::find()->orderBy('ctime DESC');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('list',[
            'model' => $model,
            'pages' => $pages
        ]);
    }


}

