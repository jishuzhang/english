<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/6
 * Time: 18:40
 */
namespace common\library;

class visit {
    public function curl($url,$method='GET'){
        //初始化
        $ch = curl_init();
        // 设置请求头, 有时候需要,有时候不用,看请求网址是否有对应的要求
//            $header[] = "message: qqqq";
        //$user_agent = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36";
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置头部
//            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        // 返回 response_header, 该选项非常重要,如果不为 true, 只会获得响应的正文
        curl_setopt($ch, CURLOPT_HEADER, false);
        // 是否不需要响应的正文,为了节省带宽及时间,在只需要响应头的情况下可以不要正文(false是要)
        curl_setopt($ch, CURLOPT_NOBODY, false);
        // 使用上面定义的 ua
        /*curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);*/
        //把CRUL获取的内容赋值到变量
        //$array=[];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        // 不用 POST 方式请求, 意思就是通过 GET 请求
        if($method=='GET'){
            curl_setopt($ch, CURLOPT_POST, false);
        }else{
            curl_setopt($ch, CURLOPT_POST, true);
        }

        //执行并获取HTML文档内容`
        $sContent = curl_exec($ch);
        //设置超时
        /* curl_setopt($ch, CURLOPT_TIMEOUT,2);   //只需要设置一个秒的数量就可以
         curl_setopt($ch, CURLOPT_NOSIGNAL,1);    //注意，毫秒超时一定要设置这个
         curl_setopt($ch, CURLOPT_TIMEOUT_MS,10);  //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
         $curl_errno = curl_errno($ch);
         $curl_error = curl_error($ch);*/
        // 获得响应结果里的：头大小
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        // 根据头大小去获取头信息内容
        //$header = substr($sContent, 0, $headerSize);
        $header=get_headers($url,1);
        $httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        //释放curl句柄
        curl_close($ch);

        return $sContent;
    }

    public function simpleCurl($url,$params='',$method='GET'){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        switch ($method){
            case "GET" : curl_setopt($ch, CURLOPT_HTTPGET, true);break;
            case "POST": curl_setopt($ch, CURLOPT_POST,true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$params);break;
            case "PUT" : curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS,$params);break;
            case "DELETE":curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS,$params);break;
        }

        $sContent = curl_exec($ch);
        curl_close($ch);

        return $sContent;
    }
}