<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-3-18
 * Time: 16:43
 */
namespace backend\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use backend\models\Movies;

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


}