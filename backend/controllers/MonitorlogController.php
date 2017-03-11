<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\library\Monitor;

/**
 * Monitorlog Controller
 */
class MonitorlogController extends BackendController
{
    public function actionIndex(){

        $filterItems = Yii::$app->request->get();

        // 对post 接收值进行处理
        $timeSt = isset($filterItems['timeSt']) && !empty($filterItems['timeSt']) ? strtotime($filterItems['timeSt']) : 0 ;
        $timeEnd = isset($filterItems['timeEnd']) && !empty($filterItems['timeEnd'])? strtotime($filterItems['timeEnd']) : time() ;
        $userId = isset($filterItems['userId']) ? intval($filterItems['userId']) : 0 ;
        $interfaceId = isset($filterItems['interfaceId']) ? intval($filterItems['interfaceId']) : 0 ;
        $messageType = isset($filterItems['messageType']) ? intval($filterItems['messageType']) : 1 ;

        // 组合查询条件
        $filterSql = '';

        $timeField = $messageType == 1 ? '`phone_sendtime`' : '`email_sendtime`';

        $filterSql .= 'WHERE '. $timeField.' BETWEEN '.$timeSt.' AND '.$timeEnd;

        if(!empty($userId)){
            $filterSql .= ' AND `uid`='.$userId;
        }

        if(!empty($interfaceId)){
            $filterSql .= ' AND `interface_id`='.$interfaceId;
        }

        $countRes = Yii::$app->db->createCommand('SELECT COUNT(*) AS `count` FROM {{%monitor_log}} '.$filterSql.' ORDER BY `logid` DESC')->queryOne();

        $pageClass = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $countRes['count']
        ]);

        $monitorLogList = Yii::$app->db->createCommand('SELECT * FROM {{%monitor_log}} '.$filterSql.' ORDER BY `logid` DESC LIMIT '.$pageClass->limit." offset ".$pageClass->offset)->queryAll();

        // 查询 应用、类型、接口 信息 用于模板中下拉框筛选

        $interfaceFilterList = Yii::$app->db->createCommand('SELECT `interface_id`,`title` FROM  {{%interface}}')->queryAll();

        // 获取监控联系人用户列表
        $monitorUser = Monitor::getMonitorer();

        $realName = $interfaceInfoSet = [];

        // 重新组合数组 组合成为 id => title 格式 便于模板中直接使用

        foreach($interfaceFilterList as $evInterface){
            $interfaceInfoSet[$evInterface['interface_id']] = $evInterface['title'];
        }

        foreach($monitorUser as $evMonitorUser){
            $realName[$evMonitorUser['users_id']] = $evMonitorUser['realname'];
        }


        return $this->render(
            'index',
            [
                'monitorLogList' => $monitorLogList,
                'pagination' => $pageClass,
                'realName' => $realName,
                'interfaceInfoSet' => $interfaceInfoSet,
                'filterItems' => $filterItems
            ]
        );
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
    public function actionSearch ()
    {

    }

}