<?php
/**
 *  共大家文件上传是使用的方法
 *
 * */
namespace common\library;
use yii\base\Exception;

class Images{
    /**
    定义一个文件上传函数 uploadFile(),实现文件上传
    @param array $file 文件上传后的信息
    @param string $path 指定文件上传后存放的路径
    @param array $allowType 允许上传的文件类型
    @param int $maxSize 允许上传的文件的大小 默认值为$maxSize=0,不限定文件大小
    return array $info 上传成功时返回新文件名和成功的标志，失败时返回上传失败的原因和错误的标志
     */
    public function uploadFile($file,$path,$allowType,$maxSize=0){
        $info = array(
            'error' => false,
            'message' => ''
        );
        $path = rtrim($path,'/').'/';
        if($file['error']!=0){
            switch($file['error']){
                case 1:
                    $info['message'] = '文件过大，PHP不支持！';
                    break;
                case 2:
                    $info['message'] = '文件过大，HTML不支持!';
                    break;
                case 3:
                    $info['message'] = '上传失败';
                    break;
                case 4:
                    $info['message'] = '上传失败';
                    break;
                default :
                    $info['message'] = '知道UFO吗--未知错误';
                    break;
            }
            // 返回错误信息，终止程序
            return $info;
        }
        if(empty($allowType)){
            $allowType=array('image/jpeg','image/gif','image/png');
        }
        if(!in_array($file['type'],$allowType)){
            $info['message'] = '型号不对！';
            return $info;
        }
        if($maxSize!=0&&$file['size']>$maxSize){
            $info['message'] = '文件过大';
            return $info;
        }
        if(!is_uploaded_file($file['tmp_name'])){
            $info['message'] = '非法提交！';
            return $info;
        }
        $hz = pathinfo($file['name'],PATHINFO_EXTENSION);
        do{
            $newname = date('YmdHis').rand(10000,9000).'.'.$hz;
        }while(file_exists($path.$newname));

        if(move_uploaded_file($file['tmp_name'],$path.$newname)){
            $info['error'] = true;
            $info['message'] = $newname;
            return $info;
        }else{
            $info['message'] = '移动文件失败';
            return $info;
        }
    }

    /**
    定义一个等比缩放图片函数 imageResize()
    @param string $pic 源图片
    @param tring $path 缩放后存放的路径
    @param int $w 缩放后的宽度
    @param int $h 缩放后的高度
    @param string $prefix 生成的缩放文件前缀
     */
    public function imageResize($pic,$path,$w,$h,$prefix='s_'){
        $info = getimagesize($pic);
        switch($info['mime']){
            case 'image/jpeg':
                $im = imagecreatefromjpeg($pic);
                break;

            case 'image/png':
                $im = imagecreatefrompng($pic);
                break;

            case 'image/gif':
                $im = imagecreatefromgif($pic);
                break;
        }
        $width = imagesx($im);
        $height = imagesy($im);
        if($width/$w>$height/$h){
            $h = $height*$w/$width;
        }else{
            $w = $width*$h/$height;
        }
        $dst = imagecreatetruecolor($w,$h);
        imagecopyresampled($dst,$im,0,0,0,0,$w,$h,$width,$height);
        $filename = pathinfo($pic,PATHINFO_BASENAME);
        $path = rtrim($path,'/').'/';
        imagejpeg($dst,$path.$prefix.$filename);
    }

}