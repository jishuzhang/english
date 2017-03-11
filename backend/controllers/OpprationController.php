<?php
namespace backend\controllers;

use Yii;
use yii\data\Pagination;

/**
 * OpprationController
 */
class OpprationController extends BackendController
{
    public function actionIndex(){

        $sql='select * from {{%oppration_log}} LEFT OUTER JOIN {{%users}} on oppration_log.users_id=users.users_id ORDER BY oppration_log_id DESC';
        $query = Yii::$app->db->createCommand($sql.' limit 1000')->queryAll();
        //var_dump($query);//exit;
        $count = count($query);
        $pagesize = 20;
        $pagination = new Pagination([
            'defaultPageSize'=>$pagesize,
            'totalCount' =>$count,
        ]);
        //var_dump($pagination);exit;
        $all_pages =  ceil($count/$pagesize);
        $list = Yii::$app->db->createCommand($sql." limit ".$pagination->limit." offset ".$pagination->offset."")->queryAll();
        //foreach($list as $q){}

        //var_dump($oppinfo['title']); exit;

        return $this->render('index',['query'=>$query,
            'list' => $list,
            'pagination'=>$pagination,
            'all_pages' => $all_pages,
           ]);
    }
}
