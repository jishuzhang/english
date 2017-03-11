<?php
namespace backend\controllers;

use Yii;
use common\library\visit;
use common\library\Monitor;
use yii\web\Controller;
use yii\data\Pagination;

/**
 * Monitor Controller
 */
class MonitorController extends BackendController
{
    public function actionContent(){

        $filterItems = Yii::$app->request->get();

        // 对post 接收值进行处理
        $timeSt = isset($filterItems['timeSt']) && !empty($filterItems['timeSt']) ? strtotime($filterItems['timeSt']) : 0 ;
        $timeEnd = isset($filterItems['timeEnd']) && !empty($filterItems['timeEnd'])? strtotime($filterItems['timeEnd']) : time() ;
        $appId = isset($filterItems['appId']) ? intval($filterItems['appId']) : 0 ;
        $interfaceId = isset($filterItems['interfaceId']) ? intval($filterItems['interfaceId']) : 0 ;
        $interfaceVersion = isset($filterItems['interfaceVersion']) ? intval($filterItems['interfaceVersion']) : 0 ;
        $monitorStatus = isset($filterItems['monitorStatus']) ? intval($filterItems['monitorStatus']) : 0 ;

        // 组合查询条件
        $filterSql = '';

        $filterSql .= 'WHERE `monitor_time` BETWEEN '.$timeSt.' AND '.$timeEnd;

        if(!empty($appId)){
            $filterSql .= ' AND `app_id`='.$appId;
        }

        if(!empty($interfaceVersion)){
            $filterSql .= ' AND `interface_vision_id`='.$interfaceVersion;
        }

        if(!empty($interfaceId)){
            $filterSql .= ' AND `interface_id`='.$interfaceId;
        }

        if(!empty($monitorStatus)){
            $filterSql .= ' AND `result`='.$monitorStatus;
        }


        $countRes = Yii::$app->db->createCommand('SELECT COUNT(*) AS `count` FROM {{%monitor}} '.$filterSql.' ORDER BY `monitor_id` DESC')->queryOne();
        $pageClass = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $countRes['count']
        ]);


        $interfaceList = Yii::$app->db->createCommand('SELECT * FROM {{%monitor}} '.$filterSql.' ORDER BY `monitor_id` DESC LIMIT '.$pageClass->limit." offset ".$pageClass->offset)->queryAll();

        // 查询黑名单IP
        $ipList = $ipInfoSet = array();
        foreach($interfaceList as $evInterface){
            $ipList[] =  $evInterface['ip'];
        }

        $blackIpList = Yii::$app->db->createCommand("SELECT DISTINCT `black_ip` FROM {{%black}} WHERE  `black_ip` IN('".implode(',',array_unique($ipList))."') ORDER BY `black_id` DESC")->queryAll();

        foreach($blackIpList as $evBlackIp){
            $ipInfoSet[] = $evBlackIp['black_ip'];
        }

        // 查询 应用、类型、接口 信息 用于模板中下拉框筛选
        $appFilterList = Yii::$app->db->createCommand('SELECT `app_id`,`title` FROM  {{%application}}')->queryAll();
        $interfaceTypeFilterList = Yii::$app->db->createCommand('SELECT `interface_type_id`,`title` FROM  {{%interface_type}}')->queryAll();
        $interfaceFilterList = Yii::$app->db->createCommand('SELECT `interface_id`,`title` FROM  {{%interface}}')->queryAll();
        $interfaceVersionList = Yii::$app->db->createCommand('SELECT `interface_vision_id`,`vision` FROM  {{%interface_vision}}')->queryAll();

        $appInfoSet = $interfaceTypeInfoSet = $interfaceInfoSet = $interfaceVersionInfoSet = $monitorStatusList =[];

        // 重新组合数组 组合成为 id => title 格式 便于模板中直接使用
        foreach($interfaceVersionList as $evVersion){
            $interfaceVersionInfoSet[$evVersion['interface_vision_id']] = $evVersion['vision'];
        }

        foreach($appFilterList as $evApp){
            $appInfoSet[$evApp['app_id']] = $evApp['title'];
        }

        foreach($interfaceTypeFilterList as $evInterfaceType){
            $interfaceTypeInfoSet[$evInterfaceType['interface_type_id']] = $evInterfaceType['title'];
        }

        foreach($interfaceFilterList as $evInterface){
            $interfaceInfoSet[$evInterface['interface_id']] = $evInterface['title'];
        }

        $codes = Yii::$app->db->createCommand('SELECT `code` FROM {{%return_codes}}')->queryAll();
        foreach($codes as $evStatusCode){
            $monitorStatusList[] =  $evStatusCode['code'];
        }

        return $this->render(
            'content',
            [
                'interfaceList' => $interfaceList,
                'pagination'=>$pageClass,
                'appInfoSet' => $appInfoSet,
                'interfaceTypeInfoSet' => $interfaceTypeInfoSet,
                'interfaceInfoSet' => $interfaceInfoSet,
                'monitorStatusList' => $monitorStatusList,
                'interfaceVersionInfoSet' => $interfaceVersionInfoSet,
                'filterItems' => $filterItems,
                'ipInfoSet' => $ipInfoSet
            ]
        );

    }

    /**
     * 此举耗资源  haimeishenmeyong shenzhong
     */
    public function actionSimulation()
    {

        $interfaceList = Yii::$app->db->createCommand("SELECT * FROM {{%interface}}")->queryAll();
        $curlObj = new visit();

        $interfaceAddressList = array();
        foreach($interfaceList as $evInterface){

            if(in_array($evInterface['app_id'],$interfaceAddressList)){

                $urlInfo = $interfaceAddressList[$evInterface['app_id']];

            }else{

                $tmpHostInfo = $this->getHostInfoByAppId($evInterface['app_id']);
                $urlInfo = $tmpHostInfo['interface_address'];

                // 如果没有查询到该地址
                if(empty($urlInfo)){
                    continue;
                }

                $interfaceAddressList[$evInterface['app_id']] = $tmpHostInfo['interface_address'];
            }

            $versionName = Monitor::getVersionNameById($evInterface['interface_vision_id']);
            $requestParamJson=$this->getRequestParamsById($evInterface['interface_id']);
            $param_new=http_build_query($requestParamJson,'','&');

            $host = $urlInfo.'/'.$versionName.'/'.$evInterface['title'].'?'.$param_new;

            $requestParamsJson=json_encode($requestParamJson);
            // 简单验证 $host 为有效的url
            if(in_array($evInterface['method'],['GET','POST','PUT','DELETE','HEAD']) && preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$host) == 1){
                $curlObj->simpleCurl($host,$requestParamsJson,$evInterface['method']);
            }

        }

        echo '1';

    }

    /**
     * 根据appId获取启用的应用的信息
     * @param $appId
     * @return array|bool
     */
    public function getHostInfoByAppId($appId)
    {
        if(empty($appId)){
            return false;
        }else{
            $moduleInfo = Yii::$app->db->createCommand("SELECT `title`,`interface_address` FROM {{%application}} WHERE `app_id`=:app_id AND `isstutas`=1",['app_id'=>$appId])->queryOne();
        }

        return empty($moduleInfo) ? false : $moduleInfo;

    }

    public  function  getRequestParamsById($id){

        $requestParams=Yii::$app->db->createCommand("select * from {{%interface_required}} WHERE interface_id=:id",['id'=>$id])->queryAll();
        $requestParamsJson=array();
        if($requestParams){
            foreach ($requestParams as $value){
                $requestParamsJson[$value['parameter']]=$value['default'];
            }
        }
        return $requestParamsJson;
    }
}