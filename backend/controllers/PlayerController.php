<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-3-18
 * Time: 16:43
 */
namespace backend\controllers;

use backend\models\VideoForm;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use backend\models\Movies;
use yii\helpers\Json;
use yii\web\Response;

class PlayerController extends Controller
{
    public function actionManage()
    {
        $data =Movies::find();

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('manage',[
            'model' => $model,
            'pages' => $pages
        ]);
    }

    public function actionDelete()
    {

        $id = Yii::$app->request->get('id');
        $v = false;

        if($id){

            if(Movies::deleteAll(['id' => $id])){
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

    public function actionEdit()
    {
        $model = new VideoForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            if($model->updateVideo()){

                Yii::$app->getSession()->setFlash('success', '编辑成功');
                $this->redirect(Yii::$app->request->getReferrer());
            }else{

                $error = current($model->getFirstErrors());
                Yii::$app->getSession()->setFlash('error', $error);
                $this->redirect(Yii::$app->request->getReferrer());
            }

        }else{

            $id = Yii::$app->request->get('id');
            $edit = Movies::findOne(['id'=>$id]);

            return $this->render('edit',[
                'model' => $model,
                'default_value' => empty($edit) ? '' : $edit,
            ]);
        }

    }

    public function actionCreate()
    {
        $model = new VideoForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            if($model->createVideo()){

                Yii::$app->getSession()->setFlash('success', '添加成功');
                $this->redirect(Yii::$app->request->getReferrer());

            }else{

                $error = current($model->getFirstErrors());
                Yii::$app->getSession()->setFlash('error', $error);
                $this->redirect(Yii::$app->request->getReferrer());
            }

        }else{

            return $this->render('create',[
                'model' => $model,
            ]);
        }
    }

}