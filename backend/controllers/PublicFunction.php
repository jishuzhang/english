<?php

namespace backend\controllers;

/**
 * 公共类
 * 
 * @author mengbaoqing
 */

class PublicFunction{
	
    /**
     * 用于无限级分类
     * $pid:父级ID; $id:ID; $name:名称;$model:需查询的模型名称(如:Attr对应的数据表是univ_attr)
     * $path:路径(如：0_1_13)
     * 
     * @author: mengbaoqing
     */
    public function getCates($pid=0, $id='id', $name='name', $model){
        //子集分类
        $cates = $model::find()->where(['pid' => $pid])->all();
        if(empty($cates)){
                return;
        }
        //遍历分类
        foreach($cates as $key=>$value){
                $temp[$id] = $value[$id];
                $c = count(explode('_',$value['path']));
                $temp[$name] = str_repeat('　　',$c-1).$value[$name];
                $temp['pid'] = $value['pid'];
                $temp['path'] = $value['path'];
                $temp['sub'] = $this->getCates($temp[$id],$id,$name,$model);
                $arr[]=$temp;
        }
        return $arr;
    }
    
    /**
     * 用于无限级分类视图(该例为4级)
     * 树状下拉框
     * $datas:待遍历数组；$model:待遍历数据的所在模型；$id:待将值存入模型的字段名称；$name:待显示名称的字段名称；$Amodel,$amodel:将要存入的模型类；$field:整个下拉框的字段名称
     * 
     * @author: mengbaoqing
     */
    public function getFloorView($datas, $model, $id, $name, $pid='pid', $Amodel='Attr', $amodel='attr', $mup='上级分类', $mtop='顶级分类', $field='pid', $getid='id', $labelwidth=''){
        $str = '';
        if($amodel!='category'){
        $str .= '<label class="control-label col-sm-1" for="'.$amodel.'-'.$field.'" style="width:'.$labelwidth.'px;">'.$mup.'</label>
        <select style="width:300px;margin-bottom:10px;" name="'.$Amodel.'['.$field.']" class="form-control" id="'.$amodel.'-'.$field.'">';
            if($mtop)$str .= '<option value="0">'.$mtop.'</option>';
        }
            foreach ($datas as $data):
                $str .= '<option value="'.$data[$id].'" ';if($model->$pid==$data[$id]||$getid==$data[$id]){ $str .= ' selected';}  $str .= '>'.$data[$name].'</option>';
                if(!empty($data['sub']) && is_array($data['sub'])){
                    foreach ($data['sub'] as $value):
                        $str .= '<option value="'.$value[$id].'" ';if($model->$pid==$value[$id]||$getid==$value[$id]){ $str .= ' selected';}  $str .= '>'.$value[$name].'</option>';
                        if(!empty($value['sub']) && is_array($value['sub'])){
                            foreach ($value['sub'] as $val):
                                $str .= '<option value="'.$val[$id].'" ';if($model->$pid==$val[$id]||$getid==$val[$id]){ $str .= ' selected';}  $str .= '>'.$val[$name].'</option>';     
                                if(!empty($val['sub']) && is_array($val['sub'])){   
                                    foreach ($val['sub'] as $v):
                                        $str .= '<option value="'.$v[$id].'" ';if($model->$pid==$v[$id]||$getid==$v[$id]){ $str .= ' selected';}  $str .= '>'.$v[$name].'</option>';
                                     endforeach;
                                }
                            endforeach;
                        }
                    endforeach;	
                }
            endforeach;
        if($amodel!='category'){
        $str .= '</select>';
        }
        return $str;
    }

    /**
	 * 页面提示信息
	 * @param string $action
	 * @param string $content
	 * @param string $redirect
	 * @param number $timeout
	 * @param string $stop
	 */
	public function message( $action = 'success', $content = '', $redirect = 'javascript:history.back(-1);', $is_close=false, $timeout = 3 , $stop=false) {
	
		switch ( $action ) {
			case 'success':
				$titler = '操作完成';
				$class = 'message_success';
				$images = 'message_success.png';
				break;
			case 'error':
				$titler = '操作未完成';
				$class = 'message_error';
				$images = 'message_error.png';
				break;
			case 'errorBack':
				$titler = '操作未完成';
				$class = 'message_error';
				$images = 'message_error.png';
				break;
			case 'redirect':
				header( "Location:$redirect" );
				break;
			case 'script':
				if ( empty( $redirect ) ) {
					exit( '<script type="text/javascript">alert("' . $content . '");window.history.back(-1)</script>' );
				} else {
					exit( '<script type="text/javascript">alert("' . $content . '");window.location=" ' . $redirect . '   "</script>' );
				}
				break;
		}
	
		// 信息头部
		$header = '<!DOCTYPE>
                    <html>
                    <head>
                    <meta charset=utf-8"/>
                    <title>操作提示</title>
                    <style type="text/css">
                    body{font:12px/1.7 "\5b8b\4f53",Tahoma;}
                    html,body,div,p,a,h3{margin:0;padding:0;}
                    .tips_wrap{ background:#F7FBFE;border:1px solid #DEEDF6;width:540px;padding:50px;margin:50px auto 0;}
                    .tips_inner{zoom:1;}
                    .tips_inner:after{visibility:hidden;display:block;font-size:0;content:" ";clear:both;height:0;}
                    .tips_inner .tips_img{width:80px;float:left;}
                    .tips_info{float:left;line-height:35px;width:350px}
                    .tips_info h3{font-weight:bold;color:#1A90C1;font-size:16px;}
                    .tips_info p{font-size:14px;color:#999;}
                    .tips_info p.message_error{font-weight:bold;color:#F00;font-size:16px; line-height:22px}
                    .tips_info p.message_success{font-weight:bold;color:#1a90c1;font-size:16px; line-height:22px}
                    .tips_info p.return{font-size:12px}
                    .tips_info .time{color:#f00; font-size:14px; font-weight:bold}
                    .tips_info p a{color:#1A90C1;text-decoration:none;}
                    </style>
                    </head>

                    <body>';
		// 信息底部
		$footer = '</body></html>';	    
		$body = '<script type="text/javascript">
                        function delayURL(url) {
                        var delay = document.getElementById("time").innerHTML;
                        //alert(delay);
                        if(delay > 0){
                                delay--;
                                document.getElementById("time").innerHTML = delay;
                                        setTimeout("delayURL(\'" + url + "\')", 1000);
                            } else {	
                                window.location.href = url;
                            }

                    }
                    </script><div class="tips_wrap">
                    <div class="tips_inner">
                        <div class="tips_img">
                            <img src="res/images/' . $images . '"/>
                        </div>
                        <div class="tips_info">

                            <p class="' . $class . '">' . $content . '</p>
                            <p class="return">系统自动跳转在  <span class="time" id="time">' . $timeout . ' </span>  秒后，如果不想等待，<a href="' . $redirect . '">点击这里跳转</a></p>
                        </div>
                    </div>
                </div>';
                if($is_close==true){
                    $body .= '<script type="text/javascript">
                    setTimeout("window.close()", 1200);
                    </script>';
                }else{
                    $body .= '<script type="text/javascript">
                    delayURL("' . $redirect . '");
                    </script>';
                }
                            $body2 = '<div class="tips_wrap">
                    <div class="tips_inner">
                        <div class="tips_img">
                            <img src="images/' . $images . '"/>
                        </div>
                        <div class="tips_info">

                            <p class="' . $class . '">' . $content . '</p>    
                            <p class="return"><a href="' . $redirect . '">点击这里返回</a></p>        
                        </div>
                    </div>
                </div>';
	    if(!$stop){
                return $header . $body . $footer;
//		exit( $header . $body . $footer );
	    }else{
                return $header . $body2 . $footer;
//	    	exit( $header . $body2 . $footer );
	    }
	}
	
	
	
	/**
 * 获取客户端ip
 * @return string 
 */
   public function get_ip() {
	static $ip = null;
	if (! $ip) {
		if (isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ) && $_SERVER ['HTTP_X_FORWARDED_FOR'] && $_SERVER ['REMOTE_ADDR']) {
			if (strstr ( $_SERVER ['HTTP_X_FORWARDED_FOR'], ',' )) {
				$x = explode ( ',', $_SERVER ['HTTP_X_FORWARDED_FOR'] );
				$_SERVER ['HTTP_X_FORWARDED_FOR'] = trim ( end ( $x ) );
			}
			if (preg_match ( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_X_FORWARDED_FOR'] )) {
				$ip = $_SERVER ['HTTP_X_FORWARDED_FOR'];
			}
		} elseif (isset ( $_SERVER ['HTTP_CLIENT_IP'] ) && $_SERVER ['HTTP_CLIENT_IP'] && preg_match ( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['HTTP_CLIENT_IP'] )) {
			$ip = $_SERVER ['HTTP_CLIENT_IP'];
		}
		if (! $ip && preg_match ( '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER ['REMOTE_ADDR'] )) {
			$ip = $_SERVER ['REMOTE_ADDR'];
		}
		! $ip && $ip = 'Unknown';
	}
	return $ip;
}

	/**
	 * 查找数组中是否存在某项，并返回指定的字符串，可用于检查复选，单选等
	 * @param $id
	 * @param $ids
	 * @param string $returnstr
	 * @return string
	 */
	public function check_in($id,$ids,$returnstr = 'checked') {
		if(in_array($id,$ids)) return $returnstr;
	}
}