<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-3-18
 * Time: 16:43
 */
namespace backend\controllers;

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
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('vid');
        $v = true;

        if($id){

            if(Movies::deleteAll(['id' => $id])){
                $v = 1;
            }
        }

        return ['code'=>$v,'message'=>''];
    }

    public function actionEdit()
    {
        $id = Yii::$app->request->post('vid');

        $model = new Movies();
        $edit = Movies::findOne(['id'=>$id]);

        return $this->render('edit',[
            'model' => $model,
            'default-value' => empty($edit) ? '' : $edit,
        ]);
    }

}