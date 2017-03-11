<?php
namespace backend\controllers;

use Yii;
use backend\controllers\BackendController;

/**
 * AppmanagerController
 */
class AppmanagerController extends BackendController
{

    public function actionIndex(){

        //获取当前应用app_id;
        $appid = $_SESSION['app_id'];
        //根据应用id 得到 应用下有几个版本
        $vision = Yii::$app->db->createCommand("SELECT * FROM {{%interface_vision}} WHERE app_id=".$appid)->queryAll();
        if(!empty($vision)){
            //根据版本id去类别表查询，一对多
            $type = Yii::$app->db->createCommand("SELECT * FROM {{%interface_type}} WHERE interface_vision_id=".$vision[0]['interface_vision_id'])->queryAll();

            if(!empty($type)){
                //根据应用id，版本id,类型id，取出接口数据
                $interface = Yii::$app->db->createCommand("SELECT * FROM {{%interface}} WHERE interface_type_id=".$type[0]['interface_type_id']." and interface_vision_id=".$vision[0]['interface_vision_id']." and app_id=".$appid)->queryAll();
                if(!empty($interface)){
                    //取出一条接口数据
                    $api_info = Yii::$app->db->createCommand("SELECT * FROM {{%interface}} WHERE interface_type_id=".$type[0]['interface_type_id']." and interface_vision_id=".$vision[0]['interface_vision_id']." and app_id=".$appid)->queryOne();
                    //根据接口id取出所对应的请求参数
                    $api_request = Yii::$app->db->createCommand("SELECT * FROM {{%interface_required}} WHERE interface_id=".$api_info['interface_id'])->queryAll();

                    $api_return = Yii::$app->db->createCommand("SELECT * FROM {{%interface_return}} WHERE interface_id=".$api_info['interface_id'])->queryAll();
                    foreach($api_return as $key => $val){
                        $api_return[$key]['sample'] =  str_replace("\"","'",$val["sample"]);
                    }
                }else{

                    $api_info = $api_request = $api_return = array();
                }
            }else{

                $type = $interface = $api_info = $api_request = $api_return = array();
            }
        }else{
            $vision = $type = $interface = $api_info = $api_request = $api_return = array();
        }
        //渲染视图
        return $this->render('index',[
            'vision' => $vision,
            'v_list' => $vision,
            'type' => $type,
            'type_list' => $type,
            'interface' => $interface,
            'api_list' => $interface,
            'api_info' => $api_info,
            'api_request' => $api_request,
            'api_return' => $api_return,
        ]);

    }
    public function actionList(){

        $get = Yii::$app->request->get();
        //获取当前应用app_id;
        $appid =  $_SESSION['app_id'];
        //根据应用id，版本id,类型id，取出接口数据
        $interface = Yii::$app->db->createCommand("SELECT * FROM {{%interface}} WHERE interface_type_id=" . $get['interface_type_id'] . " and interface_vision_id=" . $get['interface_vision_id'] . " and app_id=" . $appid)->queryAll();
        //取出一条接口数据
        $api_info = Yii::$app->db->createCommand("SELECT * FROM {{%interface}} WHERE interface_type_id=" . $get['interface_type_id'] . " and interface_vision_id=" . $get['interface_vision_id']  . " and app_id=" . $appid . " and interface_id=".$get['interface_id'])->queryOne();
        //根据接口id取出所对应的请求参数111
        $api_request = Yii::$app->db->createCommand("SELECT * FROM {{%interface_required}} WHERE interface_id=" . $api_info['interface_id'])->queryAll();
        $api_return = Yii::$app->db->createCommand("SELECT * FROM {{%interface_return}} WHERE interface_id=" . $api_info['interface_id'])->queryAll();
        foreach($api_return as $key => $val){
            $api_return[$key]['sample'] =  str_replace("\"","'",$val["sample"]);
        }
        return $this->renderPartial('_form', [
            'interface' => $interface,
            'api_list' => $interface,
            'api_info' => $api_info,
            'api_request' => $api_request,
            'api_return' => $api_return,
        ]);
    }
}