<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\controllers\BackendController;

class CommonController extends BackendController
{

    public function actions() {  
        return [
            'ajax' => [
                    'class' => 'frontend\controllers\common\AjaxAction',
            ], 
        ];  
    }
	
}