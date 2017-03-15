<?php
/**
 * 附件上传
 */
class index {

    //ueditor百度编辑器 上传
    public function upload()
    {
        $action = remove_xss($GLOBALS['action']);
        $ueditor = load_class('ueditor',M);
        switch($action)
        {
            case 'config':
                $config = $ueditor->config();
                $result = $config;
                break;

            case 'uploadimage':/* 上传图片 */
            case 'uploadscrawl':/* 上传涂鸦 */
            case 'uploadvideo':/* 上传视频 */
            case 'uploadfile':/* 上传文件 */
                $result = $ueditor->upload($action);
                break;


            case 'listimage':/* 列出图片 */
            case 'listfile':/* 列出文件 */
                $result = $ueditor->lists($action);
                break;

            case 'catchimage':/* 抓取远程文件 */
                $result = $ueditor->saveRemote();
                break;

            default:
                $result = json_encode(array(
                    'state'=> '请求地址出错'
                ));
                break;
        }
        exit( json_encode($result) );
    }
    //html5 上传
    public function h5upload() {

        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // 5 minutes execution time
        @set_time_limit(5 * 60);
       $up_root = 'http://admin.bailitop.com/Uploads/';
       $fileurl = createdir();
       $target_dir = $up_root.$fileurl;
	  

        // Get a file name
        if (isset($GLOBALS["name"])) {
            $fileName = $GLOBALS["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $insert = array();
        $insert['name'] = iconv('utf-8',CHARSET,$fileName);

        $fileName = filename($fileName);
        //不允许上传的文件扩展
        if($fileName==FALSE) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 105, "message": "Ban file name."}, "id" : "id"}');
        }
        $filePath = $target_dir .'/'. $fileName;

        // Chunking might be enabled
        $chunk = isset($GLOBALS["chunk"]) ? intval($GLOBALS["chunk"]) : 0;
        $chunks = isset($GLOBALS["chunks"]) ? intval($GLOBALS["chunks"]) : 0;


        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            $stream_input = false;
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            $stream_input = true;
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }
        if($stream_input) {
            $image = load_class('image');
            $image->set_image($filePath);
            $image->createImageFromFile();
            $image->water_mark(WWW_ROOT.'res/images/watermark.png',9);
            $image->save();
        }

        $insert['path'] = $fileurl.$fileName;
        $insert['addtime'] = SYS_TIME;
        $insert['filesize'] = $_FILES['file']['size'] ? $_FILES['file']['size'] : filesize($filePath);
        $insert['ip'] = get_ip();
        $insert['userid'] = get_cookie('_uid');;
        $attachment = load_class('attachment',M);
        $id = $attachment->insert($insert);

        // Return Success JSON-RPC response
        $info = pathinfo($insert['name']);
        $file_name =  basename($insert['name'], '.'.$info['extension']);
        die('{"jsonrpc" : "2.0", "exttype" : "img", "result" : "'.ATTACHMENT_URL.$fileurl.$fileName.'", "id" : "'.$id.'", "filename" : "'.$file_name.'" }');
    }
    //上传弹窗调用
    public function upload_dialog()
    {
        upload_url_safe();
        $callback = isset($GLOBALS['callback']) ? remove_xss($GLOBALS['callback']) : 'callback_thumb_dialog';
        $htmlid = isset($GLOBALS['htmlid']) ? remove_xss($GLOBALS['htmlid']) : 'file';
        $limit = isset($GLOBALS['limit']) ? intval($GLOBALS['limit']) : '1';
        $GLOBALS['is_thumb'] = isset($GLOBALS['is_thumb']) ? intval($GLOBALS['is_thumb']) : '0';
        $GLOBALS['htmlname'] = isset($GLOBALS['htmlname']) ? remove_xss($GLOBALS['htmlname']) : '';
        $ext = $GLOBALS['ext'];
        $token = $GLOBALS['token'];
        if($ext=='' || md5($ext._KEY)!=$token) {
            MSG('参数错误！');
        }
        $extimg = array('gif','bmp','jpg','jpeg','png');
        $extzip = array('zip','7z','rar','gz','tar');
        $extpdf = 'pdf';
        $extword = array('doc','docx','xls','xlsx','ppt','pptx');
        $exts = explode('|',$ext);

        $extother = array_diff($exts,$extimg,$extword,$extzip);
        if($extother) {
            $extother = implode(',',$extother);
        } else {
            $extother = '';
        }

        $extimg = array_intersect($extimg,$exts);
        if($extimg) {
            $extimg = implode(',',$extimg);
        } else {
            $extimg = '';
        }
        $extzip = array_intersect($extzip,$exts);
        if($extzip) {
            $extzip = implode(',',$extzip);
        } else {
            $extzip = '';
        }

        $extword = array_intersect($extword,$exts);
        if($extword) {
            $extword = implode(',',$extword);
        } else {
            $extword = '';
        }
        if(!in_array($extpdf,$exts)) {
            $extpdf = '';
        }
        include T('attachment','upload_dialog');
    }
	
	
	

// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: tuzwu <tuzwu@qq.com>
// +----------------------------------------------------------------------

function filesize_format($bytes, $decimals = 2)
{
	$sz = array('B','K','M','G','T','P');
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).$sz[$factor];
}

function fileext($file)
{
	return pathinfo($file,PATHINFO_EXTENSION);
}

function strpos_array($haystack, $needles) 
{
    if ( is_array($needles) ) 
	{
        foreach ($needles as $str) 
		{
            if ( is_array($str) ) {
                $pos = strpos_array($haystack, $str);
            } else {
                $pos = strpos($haystack, $str);
            }
            if ($pos !== FALSE) {
                return $pos;
            }
        }
    }
	else 
	{
        return strpos($haystack, $needles);
    }
	return false;
}

	//创建目录，格式：/dirname/2014/07/07/
	function createdir($dirname = '') {
		$dirname = empty($dirname) ? '' : $dirname.'/';
		$up_root = 'http://admin.bailitop.com/Uploads/'; 
		$target_dir = $dirname.date('Y/m/d').'/';
		if (!file_exists($up_root.$target_dir)) {
			mkdir($up_root.$target_dir,0777,1);
		}
		return $target_dir;
	}

		//生成文件名
	function filename($name) 
	{
		$_exts =  array('php','asp','jsp','html','htm','aspx','asa','cs','cgi','js','dhtml','xhtml','vb','exe','shell','bat','php4');
		$ext = strtolower(pathinfo($name,PATHINFO_EXTENSION));
		if(in_array($ext, $_exts)) {
			return FALSE;
		}
		$files = date('YmdHis').mt_rand(1000,9999).'.'.$ext;
		return $files;
	}

/**
 * 上传的url访问安全认证
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
function upload_url_safe()
{
	if(empty($_SERVER['HTTP_REFERER'])) MSG( L('operation_failure'), '', 3000);//上传弹窗必然由上级页面加载
}

/**
 * 上传的文件扩展名安全认证,黑白名单机制
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
function upload_ext_safe()
{
	
}

}
?>