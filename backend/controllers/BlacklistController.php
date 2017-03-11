<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;

/**
 * Blacklist  Controller
 */
class BlacklistController extends BackendController
{

    /**
     * 黑名单展示
     * @return string
     */
    public function actionIndex(){

        $getParam = Yii::$app->request->get();
        $blackIp = isset($getParam['blackIp']) && !empty($getParam['blackIp']) ? $getParam['blackIp'] : 0;

        if(!empty($blackIp)){
            $filterSql = "WHERE `black_ip`='".$blackIp."'";
        }else{
            $filterSql = '';
        }

        $countRes = Yii::$app->db->createCommand('SELECT COUNT(*) AS `count` FROM {{%black}} '.$filterSql.' ORDER BY `black_id` DESC')->queryOne();

        $pageClass = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $countRes['count']
        ]);


        $info_black = Yii::$app->db->createCommand('SELECT * FROM {{%black}} '.$filterSql.' ORDER BY `black_id` DESC LIMIT '.$pageClass->limit." offset ".$pageClass->offset)->queryAll();

        return $this->render(
            'index',
            [
                'info_black' => $info_black,
                'pagination'=>$pageClass,
            ]
        );

    }

    public function actionCreate(){

        $getParam = Yii::$app->request->post();

        if($this->checkIpFormat($getParam['blackIp'])){
            $insert = [
                'black_ip' => $getParam['blackIp'],
                'add_time' => time(),
                'duration' => $getParam['timeLineCode'],
             ];

            $insertRes = Yii::$app->db->createCommand()->insert('{{%black}}',$insert)->execute();

            if($insertRes > 0){
                echo 1; // 成功
            }else{
                echo 2;  // 数据库错误
            }

        }else{
            echo 3; // ip 格式不正确
        }
        exit;
    }


    public function actionDelete(){

        $getParam = Yii::$app->request->post();

        // 更新与 删除的顺序不能变 更新必须在删除之前
        if(!empty($getParam['blackIp']) && isset($getParam['timeLineCode']) && $getParam['delete'] == 0){
            Yii::$app->db->createCommand()->update('{{%black}}',['duration'=>$getParam['timeLineCode']],'black_ip=:black_ip',['black_ip'=>$getParam['blackIp']])->execute();
            echo 1;exit;
        }


        if(!empty($getParam['blackIp']) && $getParam['delete'] == 1){
            Yii::$app->db->createCommand()->delete('{{%black}}',"black_ip='".$getParam['blackIp']."'")->execute();
            echo 2;exit;
        }

        echo 3;exit;

    }

    /**
     * 检测ip格式是否正确
     * @param string $ip
     * @return boolean
     */
    public function checkIpFormat($ip = '')
    {
        $preg = '/^((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))$/';
        return preg_match($preg,$ip) ? true : false ;
    }
}