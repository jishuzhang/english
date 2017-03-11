<?php

namespace common\library;

use Yii;
use common\library\Monitor;
class Vinterfacelog
{
    /**
     * @param string $statusCode 接口返回错误码
     */
    public static function visitApi($statusCode = '')
    {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $requestRoute = Yii::$app->request->pathInfo;
            $interface = Yii::$app->db;

            // 根据接口url格式从 route 解析接口信息  $interfaceInfo[0] 模块名称  $interfaceInfo[1] 版本信息  $interfaceInfo[2] 控制器加参数信息
            $interfaceInfo = explode('/',$requestRoute,3);
        //var_dump(Yii::$app->request->pathInfo);exit;
            $apptitle=$interfaceInfo[0];
        // 获取版本信息
        $version = Monitor::getVersionIdByVersion($interfaceInfo[1]);

        if(!empty($version)){

            $appinfo = $interface->createCommand("select app_id from {{%application}} where title='".$apptitle."'")->queryOne();
            $app_id = $appinfo['app_id'];
            $filterInterRes = $interface->createCommand("SELECT interface_id,interface_type_id,interface_vision_id,`title` FROM {{%interface}} WHERE method=:method AND app_id=:app_id AND title=:title AND interface_vision_id=:interface_vision_id",['method'=>$requestMethod,'app_id'=>$app_id,'title'=>$interfaceInfo[2],'interface_vision_id'=>$version])->queryAll();
            //var_dump($filterInterRes);exit;
        }else{
            $filterInterRes = false;
        }

        if(!empty($filterInterRes)){
            // 录入接口访问日志
            self::visitapiLog($filterInterRes,$statusCode,$apptitle,$requestRoute);
        }

    }

    /**
     * @param $filterInterRes
     * @param $statusCode
     * @return bool
     * @throws \yii\db\Exception
     */
    public static function visitapiLog($filterInterRes,$statusCode,$apptitle){

            $interface = Yii::$app->db;

        if(empty($filterInterRes) || empty($statusCode)){
            return false;
        }
        foreach($filterInterRes as $v){
            $interfacevisioninfo = $interface->createCommand("select vision from {{%interface_vision}} where interface_vision_id=".$v['interface_vision_id'])->queryOne();
            $interfacevision = $interfacevisioninfo['vision'];
            $interfacetypeinfo = $interface->createCommand("select title from {{%interface_type}} where interface_type_id=".$v['interface_type_id'])->queryOne();
            $interfacetype = $interfacetypeinfo['title'];

            //  controller/action/param  ?
            $insert1 = [
                'app_title'              => isset($apptitle)?$apptitle:'数据丢失',
                'interface_vision_title' => isset($interfacevision)?$interfacevision:'数据丢失',
                'interface_title'        => isset($v['title'])?$v['title']:'数据丢失',
                'interface_type'         => isset($interfacetype)?$interfacetype:'数据丢失',
                'visit_time'             => time(),
                'visit_accesstoken'      => $statusCode,
                'visit_ip'               => $_SERVER['REMOTE_ADDR'],
                'visit_url'              => 'http://'.$_SERVER['HTTP_HOST'].'/'.Yii::$app->request->pathInfo.'?'.$_SERVER['QUERY_STRING']
            ];

            Yii::$app->db->createCommand()->insert('{{%visit_log}}',$insert1)->execute();
        }
    }

}
