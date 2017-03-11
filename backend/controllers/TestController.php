<?php
namespace backend\controllers;

use Yii;
use backend\controllers\PublicFunction;
use yii\web\Controller;
use yii\data\Pagination;
use backend\models\OpprationLog;
use backend\controllers\BackendController;

/**
 * Admin Controller
 */
class TestController extends BackendController
{
    public $enableCsrfValidation = false;
    public function actionIndex(){
        if(!isset(Yii::$app->user->identity->id)){
            return $this->redirect(['site/login']);
        }
        $user_id = yii::$app->user->identity->id;
        $get = Yii::$app->request->get('r');
        $app_id = $_SESSION['app_id'];
        $get_arr = explode("/", $get); 

        $get_all = Yii::$app->request->get();
        if(!empty($get_all['interface_vision_id']))
        {
            $vision_arr = Yii::$app->db->createCommand("SELECT * FROM interface_vision WHERE app_id =".$app_id." AND interface_vision_id !=".$get_all['interface_vision_id'])->queryAll();//版本

        }  else {
            $vision_arr = Yii::$app->db->createCommand("SELECT * FROM interface_vision WHERE app_id =".$app_id)->queryAll();//版本
        }
        
        
        $sql = 'SELECT a.createtime,a.url_pam,a.test_history_id,a.test_id,b.realname FROM test_history as a INNER JOIN users as b ON a.users_id = b.users_id WHERE a.users_id = '.$user_id.' ORDER BY a.createtime DESC';
        $log_arr = Yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('index',[
            'vision_arr'=>$vision_arr,
            'log_arr'=>$log_arr,
        ]);
    }
    
    public function actionTestajax(){
        
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
//                var_dump($post);
            $vision_id = $post['vision_id'];
            $app_id = $post['app_id'];
            $query_vision = Yii::$app->db->createCommand('SELECT * FROM interface_vision WHERE app_id  ="'.$app_id.'" AND interface_vision_id ="'.$vision_id.'"')->queryAll();
            if($query_vision){
                $content_html = ' ';
                foreach ($query_vision as $val){
                    $query_type = Yii::$app->db->createCommand('SELECT * FROM interface_type WHERE app_id = "'.$val["app_id"].'" AND interface_vision_id = "'.$val["interface_vision_id"].'"')->queryAll();
                    if(!empty($query_type))
                    {
                        $content_html.= '<option value="" selected="selected" onclick="Ajax_url()"> 请选择</option>';
                        foreach ($query_type as $val_type){
                            $content_html.= '<option value="'.$val_type["interface_type_id"].'">'.$val_type["title"].'</option>';
                        }
                    }else if(empty ($query_type)){
                            $content_html.= '<option value="" selected="selected"> 请选择</option>';
                    }
                }
                return $content_html;
            }
        }
            
    }
    
    public function actionTypeajax(){
        
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $api_type = $post['api_type'];
            $api_vision = $post['api_vision'];
            $app_id = $post['app_id'];

            $query_title = Yii::$app->db->createCommand('SELECT * FROM interface WHERE app_id  ="'.$app_id.'" AND interface_vision_id ="'.$api_vision.'" AND interface_type_id = "'.$api_type.'"')->queryAll();
            if($query_title){
                $content_html = ' ';
                    if(!empty($query_title))
                    {
                        $content_html.= '<option value="" selected="selected" onclick="Ajax_url()">请选择</option>';
                        foreach ($query_title as $val_type){
                            $content_html.= '<option value="'.$val_type["interface_id"].'"  onclick="Ajax_url()">'.$val_type["title"].'</option>';
                        }
                    }
                return $content_html;
            }
        }
            
    }
    
    public function actionTitleajax(){
        
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $api_title = $post['api_title'];
            $title = $post['title'];//
            $app_id = $post['app_id'];
            $query_title = Yii::$app->db->createCommand('SELECT * FROM interface_required WHERE interface_id = "'.$api_title.'"')->queryAll();

            if($query_title && $app_id){
                $content_html = ' ';
                    if(!empty($query_title)  && $app_id)
                    {
                            $content_html.= '<tr>
                                                <td>参数名称</td>
                                                <td>参数值</td>
                                            </tr>';
                        foreach ($query_title as $val){
                            $content_html .='
                                            <tr id="can1">
                                                <td>'.$val['parameter'].'</td>
                                                <td><input id="title" class="form-control" type="text" value="'.$val['default'].'" maxlength="20" name="info[title]"></td>
                                            </tr>';
                        }
                    } else {
                        $content_html.= '<tr>
                                                <td>参数名称</td>
                                                <td>参数值</td>
                                            </tr>';
                    }
                return $content_html;
            }
        }
            
    }
    
    public function actionUrlajax(){
        
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $title = $post['title'];
            $app_id = $post['app_id'];
            $api_type = $post['api_type'];
            
            $url_arr = Yii::$app->db->createCommand('SELECT * FROM application WHERE app_id = "'.$app_id.'"')->queryAll();//
            if($url_arr && $api_type){
                $content_html = '';
//                    $content_html.= '<option value="" selected="selected">请选择1</option>';
                    if(!empty($url_arr) && $api_type && $title)
                    {
                        foreach ($url_arr as $val_url){
                            $content_html.= '<option value="'.$val_url["title"].'">'.$val_url["interface_address"].'</option>';
                        }
                    }
                return $content_html;
            }
        }
            
    }
    
    public function actionJumpajax(){
        
        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();
            $api_title = $post['api_title'];
            $query_title = Yii::$app->db->createCommand('SELECT parameter,`default` FROM interface_required WHERE interface_id = "'.$api_title.'"')->queryAll();
            echo json_encode($query_title);
        }
            
    }

    public function actionCreateajax()
    {
       if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
//            $from = array();
            $from['interface_address'] = trim($post['title']);//跟地址
            $from['interface_id'] = $post['api_title'];//接口名称ID
            $url_text = $post['url_text'];//应用名称
            $from['interface_vision_id'] = $post['api_vision_id'];//版本ID
            $from['interface_type_id'] = $post['api_type_id'];//类型ID
            $api_title_text = $post['api_title_text'];//接口名称
            $from['app_id'] = $post['app_id'];//应用ID
            date_default_timezone_set('PRC'); // 中国时区
            $hist['createtime']  = time();
            $user_id = $post['user_id'];//用户id
            $hist['url_can'] = $post['url_can'];//url参数
            
            $res = Yii::$app->db->createCommand()->insert('{{%test}}', $from)->execute();//test add
            $test_id = Yii::$app->db->getLastInsertID();

            $test_hist = Yii::$app->db->createCommand()->insert('{{%test_history}}', ['test_id'=>$test_id, 'createtime'=>$hist['createtime'], 'users_id'=>$user_id, 'url_pam'=>$hist['url_can']])->execute();//hist add
            $query_title = Yii::$app->db->createCommand('SELECT * FROM interface_required WHERE interface_id = "'.$post['api_title'].'"')->queryAll();
            
            $return_data = Yii::$app->db->createCommand('SELECT b.interface_id,b.description FROM test as a INNER JOIN interface_return as b ON a.interface_id = b.interface_id WHERE a.test_id="'.$test_id.'" AND b.interface_id ="'.$post['api_title'].'"')->queryOne();
//            var_dump($return_data['description']);
            if(!empty($query_title))
                {
                    foreach ($query_title as $val){
                        $test_par = Yii::$app->db->createCommand()->insert('{{%test_parameter}}', ['test_id'=>$test_id, 'parameter'=>$val['parameter'], 'pam_value'=>$val['default']])->execute();//parameter add
                    }
                }
            $url  = trim($hist['url_can']);
            if($test_hist){
            $interface_one = Yii::$app->db->createCommand('SELECT pam_type FROM interface WHERE app_id = "'.$from['app_id'].'" AND interface_id = "'.$from['interface_id'].'" AND interface_type_id = "'.$from['interface_type_id'].'"')->queryOne();//取出当前的接口类别是否是json    
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $contents = curl_exec($ch);
            curl_close($ch);

            $return_data['description'] = $return_data['description'] ? $return_data['description'] : 0;
            $return_header = get_headers($url, 1);
            $text = implode(" ;<br>", $return_header);
            $header_text = implode("  ", $return_header);
            $test_return = Yii::$app->db->createCommand()->insert('{{%test_return}}', ['test_id'=>$test_id,'response_header'=>$header_text, 'response_body'=>$contents, 'data_type'=>$return_header['Content-Type'], 'data_annotation'=>$return_data['description']])->execute();//parameter add
          
            $output_array = json_decode($contents,true);  
            foreach ($output_array as $val){
                $str =serialize ($val);
            }
//            echo $str;
            if(strstr($contents,'"status":404'))
            {
                $return_html = '<ul>
                                        <li class="tanchu01">response header</li>
                                        <div class="xianshi01">
                                            响应头部信息<br>
                                            '.$text.'<br>
                                        </div>
                                        <li class="tanchu02">response body</li>
                                        <div class="xianshi02" >
                                            页面返回信息<br>
                                           '.$contents.' <br>
                                        </div>

                                    </ul>';
            }else{
                $return_html = '<ul>
                                        <li class="tanchu01">response header</li>
                                        <div class="xianshi01">
                                            响应头部信息<br>
                                            '.$text.'<br>
                                        </div>
                                        <li class="tanchu02">response body</li>
                                        <div class="xianshi02" >
                                            页面返回信息<br>
                                           '.$str.' <br>
                                        </div>

                                    </ul>';
            }
                    
                
            }
            return $return_html;
        }
        
    }
   
    public function actionAjax_log()
    {
        if (Yii::$app->request->post()) 
        {
            $post = Yii::$app->request->post();
            $userid = $post['userid'];
            $sql = 'SELECT a.createtime,a.url_pam,a.test_history_id,a.test_id,b.realname FROM test_history as a INNER JOIN users as b ON a.users_id = b.users_id WHERE a.users_id = '.$userid.' ORDER BY a.createtime DESC';
            $log_arr = Yii::$app->db->createCommand($sql)->queryAll();
            if($log_arr){
                $html = ' ';
                foreach ($log_arr as $val){
                    $html .= '<tr>
			<td><input type="checkbox" name="ids[]" value="'.$val['test_history_id'].'"></td>
			<td>'.date('Y-m-d',$val['createtime']).'</td>
			<td>'.$val['realname'].'</td>
			<td>'.$val['url_pam'].'</td>
		</tr>';
                }
            }
            return $html;
        }
        
    }
    
    
    public function actionSearchajax(){
        if (Yii::$app->request->post()) 
        {
            $post = Yii::$app->request->post();
            $content = $post['test_con'];
            $get = Yii::$app->request->get('r');
            $get_arr = explode("/", $get);
            if(!isset(Yii::$app->user->identity->id)){
                return $this->redirect(['site/login']);
            }
            $user_id = yii::$app->user->identity->id;
            $search_type = $post['search_type'];
            $sql = 'SELECT a.createtime,a.url_pam,a.test_history_id,a.test_id,b.realname FROM test_history as a INNER JOIN users as b ON a.users_id = b.users_id WHERE a.users_id = '.$user_id;
            
            if($content && $search_type=="内容"){
                $sql .=' AND a.url_pam LIKE "%'.$content.'%"';
            }elseif ($content && $search_type=="用户") {
                $sql .=' AND b.realname LIKE "%'.$content.'%"';
            }
            $sql .=' ORDER BY a.createtime DESC';
            $log_arr = Yii::$app->db->createCommand($sql)->queryAll();
//            echo json_encode($log_arr);
            if($log_arr){
                $html = '';
                foreach ($log_arr as $val)
                    {
                        $html .= '<tr>
                                    <td width="10%"><input type="checkbox" name="ids[]" value="'.$val['test_history_id'].'"></td>
                                    <td width="10%">'.date('Y-m-d',$val['createtime']).'</td>
                                    <td width="20%">'.$val['realname'].'</td>
                                    <td width="60%">'.$val['url_pam'].'</td>
                                </tr>  ';
                    }
                return $html;
            }
        }
        
    }
    
    public function actionDelete()
    {
        $get_array = Yii::$app->request->post();
        if (!empty($get_array['test_history_id'])) {
            $id = $get_array['test_history_id'];
            foreach($id as $k=>$v) {
               $del = Yii::$app->db->createCommand()->delete('{{%test_history}}', 'test_history_id='.$v)->execute();
            }
            if($del=='1') {
                return 1;
            }else{
                return 0;
            }
        }
        
    }
    
    public function actionAll_delete()
    {
        $get_array = Yii::$app->request->post();
        if (!empty($get_array['test_history_id'])) {
            $id = $get_array['test_history_id'];
            foreach($id as $k=>$v) {
               $del = Yii::$app->db->createCommand()->delete('{{%test_history}}', 'test_history_id='.$v)->execute();
            }
            if($del=='1') {
                return 1;
            }else{
                return 0;
            }
        }
        
    }
    
    

}