<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Structure Controller
 */
class StructureController extends BackendController
{
    public $layout = "news"; //设置使用的布局文件
    public function actionIndex(){

        return $this->render('index');
    }
    public function actionCreate(){

        return $this->render('create');
    }
    public function actionUpdate()
    {
        return $this->render('update');
    }
    public function actionDelete ()
    {

    }

}