<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2017-3-18
 * Time: 16:43
 */
namespace backend\controllers;

use backend\models\DialogueForm;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Movies;
use common\models\Translate;


class WordController extends Controller
{
    public function actionIndex()
    {
        $data = Translate::find()->orderBy('ctime DESC');

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index',[
            'model' => $model,
            'pages' => $pages
        ]);

    }


    public function actionCreate()
    {
        $model = new DialogueForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            if($model->translate()){
                Yii::$app->getSession()->setFlash('success', '操作成功');
            }else{

                $error = current($model->getFirstErrors());
                Yii::$app->getSession()->setFlash('error', $error);

            }

            $this->redirect(Yii::$app->request->getReferrer());

        }else{

            return $this->render('create',[
                'model' => $model,
            ]);
        }


    }

    public function actionEdit()
    {
        $model = new DialogueForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            if($model->updateTranslate()){
                Yii::$app->getSession()->setFlash('success', '操作成功');
            }else{

                $error = current($model->getFirstErrors());
                Yii::$app->getSession()->setFlash('error', $error);

            }

            $this->redirect(Yii::$app->request->getReferrer());

        }else{

            $tid = Yii::$app->request->get('tid');
            $default_value = Translate::findOne(['tid' => $tid]);

            return $this->render('edit',[
                'model' => $model,
                'default_value' => $default_value,
            ]);
        }


    }

    public function actionDelete()
    {

        $id = Yii::$app->request->get('tid');
        $v = false;

        if($id){

            if(Translate::deleteAll(['tid' => $id])){
                $v = true;
            }
        }

        if($v){
            Yii::$app->getSession()->setFlash('success', '操作成功');
        }else{
            Yii::$app->getSession()->setFlash('error', '操作失败');
        }

        $this->redirect(Yii::$app->request->getReferrer());
    }

}