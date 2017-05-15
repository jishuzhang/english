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
use common\models\Translate;
use common\models\Words;
use yii\data\Pagination;
use yii\web\Response;

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

    public function beforeAction($action)
    {
        parent::beforeAction($action);

        if (in_array($this->action->id, array('show', 'screen', 'signup'))) {
            if(Yii::$app->user->isGuest)
            {
                return $this->redirect(['site/login']);
            }
        }

        return true;
    }

    public function actionScreen()
    {
        $videoId = Yii::$app->request->get('videoid');
        if(empty($videoId)){
           $this->redirect(Yii::$app->request->getReferrer());
        }

        $model = Movies::findOne(['id' => $videoId]);
        $translate = Translate::find()->select('*')->where(['vid' => $videoId])->orderBy('tid DESC')->one();

        return $this->render('screen',[
            'model' => $model,
            'translate' => $translate,
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

    public function actionSearch()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $str = Yii::$app->request->get('str','ok');
        $tid = Yii::$app->request->get('tid',0);

        // $dSearchRes = Words::find()->select('wid,tid,word,explain')->where(['like','word',$str])->andWhere(['tid'=>0])->asArray()->one();
        $dSearchRes = Words::find()->select('wid,tid,word,explain')->where(['word' => $str])->andWhere(['tid'=>$tid])->asArray()->one();

        return [
            'success' => empty($dSearchRes) ? 0 : 1,
            'data' => $dSearchRes
        ];

    }
}

