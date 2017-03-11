<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/23
 * Time: 19:43
 */
namespace common\library;
use Yii;
use yii\base\Exception;
class Access{
    protected $serect;
    private $time;
    private $method;
    private $code;
    public  function  api_visit($url,$param=array(),$method='GET'){
        //通过url获取应用的秘钥
        if($this->get_server_secret($url) !== false){
            $this->serect= $this->get_server_secret($url);
        }else{
            return array(
                "code"=> "Not Found"
            );
        }
        $this->method=$method;
        //对参数进行排序
        $str='';
        if(!empty($param)){
            $param_kr=array_filter($param);
            $str.=$this->arr_str($param_kr);
        }
//        date_default_timezone_set('PRC'); //设置中国时区
        //时间戳
//        $time=strtotime(date('Y-m-d,H:i',time()));
//        $time=1463364780;
//        $this->time=$time;
        //验证字符串拼接
        $str.=$this->serect;
        $client_password=md5(md5($str));
        $param_new=http_build_query($param,'','&');
        //拼接url
        $url_new=$url.'?'.$param_new;
//        echo $url_new;
        $h=$this->curl($url_new,$client_password);
        return $h;
    }

    public function curl($url,$client_password){
        //初始化
        $ch = curl_init();
        // 设置请求头, 有时候需要,有时候不用,看请求网址是否有对应的要求
        //$user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置头部
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('clientpassword:'.$client_password));
        //不可以有下划线
//        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Client_password:'.$client_password));
        // 返回 response_header, 该选项非常重要,如果不为 true, 只会获得响应的正文
        curl_setopt($ch, CURLOPT_HEADER, 1);
        // 是否不需要响应的正文,为了节省带宽及时间,在只需要响应头的情况下可以不要正文(false是要)
        curl_setopt($ch, CURLOPT_NOBODY, false);
        // 使用上面定义的 ua
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        // 不用 POST 方式请求, 意思就是通过 GET 请求
        if($this->method=='GET'){
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }elseif($this->method=='POST'){
            curl_setopt($ch, CURLOPT_POST, true);
        }elseif($this->method=='PUT') {
            //定义请求类型，定义请求类型PUT
            curl_setopt($ch, CURLOPT_PUT, true);
        }elseif($this->method=='DELETE'){
            //定义请求类型，定义请求类型DELETE
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        //执行并获取HTML文档内容`
        $sContent = curl_exec($ch);

        // 根据头大小去获取头信息内容
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            //通过curl获取header信息字符串
            $header =  trim(substr($sContent, 0, $headerSize));
            //获取内容信息
            $sContent = trim(substr($sContent, $headerSize));
        }else{
            return array();
        }
//        echo $sContent;
        //释放curl句柄
        curl_close($ch);
        return json_decode($sContent, true);
//          return $this->get_message($sContent,$header);
    }
    public function get_message($content,$header){
        if(!empty($content) && !empty($header)){
            $code_result=$this->getCodeMessage($this->code);
            if($code_result==true) {
                $str =$content.$this->serect;
                $client_response = md5(md5($str));
                if (strpos($header,"Authenticate")) {
                    //截取字符串获取$server_password
                    $kaishi = stripos($header,"Authenticate")+strlen("Authenticate")+2;
                    $server_password = substr($header, $kaishi,32);

                    if ($server_password == $client_response) {

                        return json_decode($content, true);
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }else{
                return $code_result;
            }
        }else{
            return false;
        }
    }
    public function getCodeMessage($status){
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
            603 => 'Verification old user',  //由于系统升级，请重置密码
        );
        $result=true;
        foreach ($codes as $k=>$v){
            if(intval($status)!=200 && intval($k)==intval($status)){
                $result=$v;
            }
        }
        return $result;
//        return (isset($codes[$status])) ? $codes[$status] : '';
    }
    public function get_server_secret($url){

        $server_arr=explode('/', $url);

        $system = htmlspecialchars(trim($server_arr[3]));
        //服务器端secret ,查数据库

        $secret = Yii::$app->db->createCommand("SELECT secret FROM {{%application}} WHERE title = :title",[":title"=>$system])->queryOne();
        if($secret !== false){
            return $secret["secret"];
        }else{
            return false;
        }
    }
    protected function arr_str($param){
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


    function upload_file($url,$filename,$postname,$mimetype){
        //客户端发送client_password
        $param = $this->convertUrlQuery($url);
        $this->serect= $this->get_server_secret($url);
        $str='';
        if(!empty($param)){
            $param_kr=array_filter($param);
            $str.=$this->arr_str($param_kr);
        }
        $str.=$this->serect;
        $client_password=md5(md5($str));

        if (class_exists('\CURLFile')) {
            $cfile = new \CURLFile($filename,$mimetype,$postname);
            $data = array('avatardata' => $cfile);
        } else {
            $data = array('avatardata'=>"@".realpath($filename).";type=".$mimetype.";filename=".$postname);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('clientpassword:'.$client_password));
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (class_exists('\CURLFile')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        } else {
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_getinfo($ch);
        $return_data = curl_exec($ch);
        if (curl_errno($ch))
        {
            throw new Exception(curl_error($ch),0);
        }

        curl_close($ch);
        return $return_data;
    }

    /**
     * @coefficient  2/5
     * @author dongfengtao
     * @since 2017-1-3 19:10
     * 解析url后面参数
     * @param $query
     */
    function convertUrlQuery($url)
    {
        $param_url = explode('?',$url);
        $queryParts = explode('&', $param_url['1']);

        $params = array();
        foreach ($queryParts as $param) {
            $item = explode('=', $param);
            $params[$item[0]] = $item[1];
        }
        return $params;
    }
}