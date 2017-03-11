<?php

namespace common\library;
use Yii;

/*
 * 接收参数（modelid、countryid、title）、$client_password
 * 通过接口地址找到对应应用的服务器上保存的secret，$server_secret
 * （ksort(modelid,countryid,title) + $server_secret)md5 = $server_password
 * $client_password  对比 $server_password
 * 如果对比成功了就给客户端返回数据，如果不成功就告诉他访问失败
 */
/**
 * 验证参数加密类
 */
class Verification
{
    public function verify_parameter(){
        //接收到参数数组使用 krsort($param)排序
        $param_str=$this->arr_str($_REQUEST);
        //传递客户端密钥
        //调用get_server_secret获取服务器secret
        $server_secret = $this->get_server_secret();
        //设置一分钟过期时间
//        date_default_timezone_set('PRC'); //设置中国时区
//        $expire  = strtotime(date('Y-m-d,H:i',time()));
        $client_password = isset($_SERVER['HTTP_CLIENTPASSWORD']) ? $_SERVER['HTTP_CLIENTPASSWORD'] : '' ;
        $server_password = md5(md5($param_str.$server_secret));
        //先根据当前时间戳进行判断
        if($client_password == $server_password){
            return TRUE;
        }else{
            //在根据前后5分钟进行判断
//            for($i = 1;$i < 6; $i++){
//                $left_expires  = $expire + $i*-60;
//                $right_expires = $expire + $i* 60;
//                $left_server_password = md5(md5($param_str.$server_secret.$left_expires));
//                $right_server_password = md5(md5($param_str.$server_secret.$right_expires));
//                if($client_password == $left_server_password || $client_password == $right_server_password ){
//                    return TRUE;
//                }
//            }

            return false;
        }



    }

    public function get_contents($data){
        isset($data['status']) && Monitor::monitorApi($data['status']);
        isset($data['status']) && Vinterfacelog::visitApi($data['status']);
        if(!empty($data)){
            //md5加密字符串
            $resource = json_encode($data);
//			//设置一分钟过期时间
            date_default_timezone_set('PRC'); //设置中国时区
            $expire  = strtotime(date('Y-m-d,H:i',time()));
//            $expire = 1463364780;

            $urlArray =  explode('/',$_SERVER['REQUEST_URI']);

            if($urlArray['2'] == 'v2' && $urlArray['1']== 'appsite'){
                $server_response = md5(md5($resource.$this->get_server_secret().$expire));
                $this->setHeader(200,$server_response);
                if(isset($_GET['jsoncallback'])){
                    $jsoncallback = $_GET['jsoncallback'];
                    echo  $jsoncallback."(".$resource.")";
                }else{
                    echo $resource;
                }
                exit;
            }

            $server_response = md5(md5($resource.$this->get_server_secret()));
            $this->setHeader(200,$server_response);

            if(isset($_GET['jsoncallback'])){
                $jsoncallback = $_GET['jsoncallback'];
                echo  $jsoncallback."(".$resource.")";
            }else{
                echo $resource;
            }
        }else{
            $this->setHeader(403);
        }
    }
    public function setHeader($status,$server_response=''){
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";
        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "xiangying");
        header('Authenticate: ' . $server_response);

    }
    public function _getStatusCodeMessage($status){
        $codes = Array(
            200 => 'OK',//成功
            400 => 'Bad Request',//错误请求
            401 => 'Unauthorized',//未经授权
            402 => 'Payment Required',//需要付费
            403 => 'Forbidden',//禁止访问
            404 => 'Not Found',//没有找到
            500 => 'Internal Server Error',//内部服务器错误
            501 => 'Not Implemented',//未执行
            601 => 'Verification code expires', //验证码过期
            602 => 'Verification code error', //验证码错误
            603 => 'issue',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function get_server_secret(){
        $url='http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
        //截取所属系统
        $server_arr=explode('/', $url);
        //服务器端secret ,查数据库
        $system = htmlspecialchars(trim($server_arr[3]));
        $secret = Yii::$app->db->createCommand("SELECT secret FROM {{%application}} WHERE title = :title",[":title"=>$system])->queryOne();
        if($secret !== false) {
            return $secret["secret"];
        }else{
            return false;
        }
    }
    
    protected function arr_str($param){
        //递归对参数进行排序
        $str='';
        krsort($param);
        foreach ($param as $key=>$item){
            if(is_array($item)){
                krsort($item);
                foreach ($item as $k=>$val){
                    if(is_array($val)){
                        $this->arr_str($val);
                    }else{
                        $str.=$k;
                    }
                }
            }else{
                $str.=$key;
            }
        }
        return $str;
    }
}