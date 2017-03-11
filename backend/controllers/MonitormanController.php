<?php
namespace backend\controllers;

use Yii;
use backend\models\Users;
use yii\data\Pagination;
use common\library\Monitor;
use backend\controllers\PublicFunction;

/**
 * Monitorman Controller
 */
class MonitormanController extends BackendController
{
    public function actionIndex(){

        $interface = Yii::$app->db;
        $notificationCode = 0; // 根据通知方式 判断是否为监控管理人  0  不通知  1 短信通知  2 邮件通知 3 全部通知

        $countRes = $interface->createCommand('SELECT count(*) AS `count` FROM {{%users}} WHERE `notification`>:notification',['notification'=> $notificationCode])->queryOne();

        $pageClass = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $countRes['count']
        ]);

        $userList = $interface->createCommand('SELECT * FROM {{%users}} WHERE `notification`>:notification ORDER BY `users_id` LIMIT '.$pageClass->limit." offset ".$pageClass->offset,['notification'=> $notificationCode])->queryAll();

        return $this->render('index',['userList' => $userList,'pagination'=>$pageClass,]);
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