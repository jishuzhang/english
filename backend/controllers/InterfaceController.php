<?php
namespace backend\controllers;

use Yii;
use yii\data\Pagination;

/**
 * InterfaceController
 */
class InterfaceController extends BackendController
{
    public function actionIndex()
    {
        $sql = "SELECT * FROM {{%visit_log}} ORDER BY visit_time DESC";
        $query = Yii::$app->db->createCommand($sql)->queryAll();
        $count = count($query);
        $pagesize = 20;
        $pagination = new Pagination([
            'defaultPageSize'=>$pagesize,
            'totalCount' =>$count,
        ]);
        //var_dump($pagination);exit;
        $all_pages =  ceil($count/$pagesize);
        $list = Yii::$app->db->createCommand($sql." limit ".$pagination->limit." offset ".$pagination->offset."")->queryAll();

        return $this->render('index',['query'=>$query,
            'list' => $list,
            'pagination'=>$pagination,
            'all_pages' => $all_pages,]);
    }
}
