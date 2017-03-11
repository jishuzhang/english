<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\controllers\BackendController;
use common\library\visit;

class ApiajaxController extends BackendController{

    public $enableCsrfValidation = false;
    /**
     * 接口版本添加
     * $app_id  应用id    int
     * $vision 版本名称   string
     * return  列表        json       error(错误)       exist(存在)
     **/
    public function actionAddvision()
    {
        $post = Yii::$app->request->post();
        $app_id = $_SESSION['app_id'];
        $vision = isset($post['vision'])?trim($post['vision']):'';//版本名称
        $isexist = Yii::$app->db->createCommand("SELECT interface_vision_id FROM {{%interface_vision}} WHERE vision='"."$vision' AND app_id=$app_id")->queryOne();
        if(empty($isexist) && !empty($app_id) && !empty($vision)) {
            $isinsert = Yii::$app->db->createCommand()->insert('{{%interface_vision}}', ['app_id' => $app_id, 'vision' => "$vision"])->execute();
            if($isinsert){
                $vision = Yii::$app->db->createCommand("SELECT * FROM {{%interface_vision}} WHERE app_id=".$app_id)->queryAll();
                echo json_encode($vision);
            }else{
                return 2;//插入错误
            }
        } else{
            return 3;     //存在或者参数错误
        }
    }
    /**
     * 接口版本删除
     * $app_id                   应用id    int
     * $interface_vision_id      版本id    int
     * return                    列表      json      2(错误)   3（参数不正确）
     **/
    public function actionDelvision(){
        $post = Yii::$app->request->post();
        $visionid = isset($post['interface_vision_id'])?(int)$post['interface_vision_id']:'';//版本id
        if(!empty($visionid)){
            $transaction= Yii::$app->db->beginTransaction();//创建事务
            $vision = Yii::$app->db->createCommand("DELETE FROM {{%interface_vision}} WHERE interface_vision_id=:interface_vision_id",[":interface_vision_id"=>$visionid])->execute();
            $interface = Yii::$app->db->createCommand("DELETE FROM {{%interface_type}} WHERE interface_vision_id=:interface_vision_id",[":interface_vision_id"=>$visionid])->execute();
            //先查询
            $interface_id = Yii::$app->db->createCommand("SELECT `interface_id` FROM {{%interface}} WHERE interface_vision_id = :interface_vision_id",[":interface_vision_id" =>$visionid])->queryAll();
            //再删除
            $interface_type = Yii::$app->db->createCommand("DELETE FROM {{%interface}} WHERE interface_vision_id=:interface_vision_id",[":interface_vision_id"=>$visionid])->execute();
            if($vision !== false && $interface !== false && $interface_type !== false ){
                foreach($interface_id as $val){
                    $interface= Yii::$app->db->createCommand("DELETE FROM {{%interface}} WHERE interface_id=:interface_id",[":interface_id"=>$val['interface_id']])->execute();
                    $interface_required = Yii::$app->db->createCommand("DELETE FROM {{%interface_required}} WHERE interface_id=:interface_id",[":interface_id"=>$val['interface_id']])->execute();
                    $interface_return = Yii::$app->db->createCommand("DELETE FROM {{%interface_return}} WHERE interface_id=:interface_id",[":interface_id"=>$val['interface_id']])->execute();
                }
                if($interface !== false && $interface_required !== false && $interface_return !== false){
                    $transaction->commit();//提交事务
                    return 1;   //正确
                }else{
                    $transaction->rollback();//回滚事务
                    return 2;   //错误
                }

            }else{
                $transaction->rollback();//回滚事务
                return 2;   //错误
            }

        }else{
            return 3;   //参数错误
        }
    }
    /**
     * 接口版本编辑
     * $app_id                   应用id    int
     * $interface_vision_id      版本id    int
     * $vision                   版本名称  string
     * return                    列表      json        2(错误)   3（参数不正确）
     **/
    public function actionUpdvision(){
        $post = Yii::$app->request->post();
        $app_id = $_SESSION['app_id'];
        $interface_vision_id = isset($post['interface_vision_id'])?(int)$post['interface_vision_id']:'';//版本
        $vision = isset($post['vision'])?trim($post['vision']):'';
        if(!empty($interface_vision_id)&&!empty($vision)){
            //查看标题是否重复
            $isexist = Yii::$app->db->createCommand("SELECT interface_vision_id FROM {{%interface_vision}} WHERE vision='"."$vision' AND interface_vision_id=".$interface_vision_id)->queryOne();
            if(empty($isexist)){
                //更新
                $isupd = Yii::$app->db->createCommand("update {{%interface_vision}} SET vision='"."$vision'"." WHERE interface_vision_id='".$interface_vision_id."' and app_id=".$app_id)->execute();
                $code = $isupd==true ? 1:2;//1、正确//2、错误
                return $code;
            }else{
                return 2;
            }
        }else{
            return 3;//参数错误
        }
    }
    /**
     * 接口类型添加
     * $app_id                   应用id    int
     * $interface_vision_id      版本id    int
     * $type                    类别名称  string
     * return                    列表      json    error(错误)       exist(存在)
     **/
    public function actionAddtype(){

        $post = Yii::$app->request->post();
        $app_id = $_SESSION['app_id'];
        $interface_vision_id = isset($post['interface_vision_id'])?(int)$post['interface_vision_id']:'';//默认添加接口版本id
        $type = isset($post['type'])?trim($post['type']):'';//类别名称
        $isexist = Yii::$app->db->createCommand("SELECT interface_vision_id FROM {{%interface_type}} WHERE title='"."$type' and interface_vision_id=".$interface_vision_id)->queryOne();
        if(empty($isexist) && !empty($interface_vision_id) && !empty($app_id) && !empty($type)) {
            $isinsert = Yii::$app->db->createCommand()->insert('{{%interface_type}}', ['app_id' => $app_id, 'title' => "$type",'interface_vision_id'=>$interface_vision_id])->execute();
            if($isinsert){
                $type = Yii::$app->db->createCommand("SELECT * FROM {{%interface_type}} WHERE app_id=$app_id and interface_vision_id=$interface_vision_id")->queryAll();
                echo json_encode($type);
            }else{
                return 2;//插入错误
            }
        }else{
            return 3;//参数错误，或存在
        }
    }

    /**
     * 接口类型删除
     * $app_id                   应用id    int
     * $interface_vision_id      版本id    int
     * $interface_type_id        类型id    int
     * return                    列表      json        2(错误)   3（参数不正确）
     **/
    public function actionDeltype(){
        $post = Yii::$app->request->post();
        $interface_type_id = isset($post['interface_type_id'])?(int)$post['interface_type_id']:'';//类别id

        $app_id = $_SESSION['app_id'];
        if(!empty($interface_type_id)&&!empty($app_id)){
            $transaction= Yii::$app->db->beginTransaction();//创建事务
            $interface_id = Yii::$app->db->createCommand("SELECT `interface_id` FROM {{%interface}} WHERE interface_type_id=:interface_type_id",[":interface_type_id" =>$interface_type_id])->queryAll();

            $interface_type = Yii::$app->db->createCommand("DELETE FROM {{%interface_type}} WHERE interface_type_id=:interface_type_id",[":interface_type_id" =>$interface_type_id])->execute();

            if($interface_type !== false){

                 if(!empty($interface_id)){
                        foreach($interface_id as $val){
                            $interface = Yii::$app->db->createCommand("DELETE FROM {{%interface}} WHERE interface_id=:interface_id",[":interface_id"=>$val['interface_id']])->execute();
                            $interface_required = Yii::$app->db->createCommand("DELETE FROM {{%interface_required}} WHERE interface_id=:interface_id",[":interface_id"=>$val['interface_id']])->execute();
                            $interface_return = Yii::$app->db->createCommand("DELETE FROM {{%interface_return}} WHERE interface_id=:interface_id",[":interface_id"=>$val['interface_id']])->execute();
                        }
                        if($interface !== false && $interface_required !== false && $interface_return !== false){
                            $transaction->commit();//提交事务
                            return 1;   //正确
                        }else{
                            $transaction->rollback();//回滚事务
                            return 2;   //错误
                        }
                    }else{
                         $transaction->commit();//提交事务
                         return 1;   //正确
                    }
              }else{
                  $transaction->rollback();//回滚事务
                  return 2;   //错误
              }
        }else{
            return '3';//参数错误
        }
    }
    /**
     * 接口类型更新
     * $app_id                   应用id    int
     * $interface_vision_id      版本id    int
     * $interface_type_id        类型id    int
     * $title                   类型标题   string
     * return                    列表      json        2(错误)   3（参数不正确）
     **/
    public function actionUpdtype(){
        $post = Yii::$app->request->post();
        $app_id = $_SESSION['app_id'];
        $interface_vision_id = isset($post['interface_vision_id'])?(int)$post['interface_vision_id']:'';//版本id
        $interface_type_id = isset($post['interface_type_id'])?(int)$post['interface_type_id']:'';//类型id
        $title = isset($post['title'])?trim($post['title']):'';
        if(!empty($interface_vision_id)&&!empty($interface_type_id)&&!empty($title)){
            //查看标题是否重复
            $isexist = Yii::$app->db->createCommand("SELECT interface_type_id FROM {{%interface_type}} WHERE title='"."$title' AND interface_type_id=$interface_type_id")->queryOne();
            if(empty($isexist)){
                //更新
                $isupd = Yii::$app->db->createCommand("UPDATE {{%interface_type}} SET title='"."$title'"." WHERE interface_type_id=$interface_type_id AND interface_vision_id=$interface_vision_id AND app_id=$app_id")->execute();
                if($isupd !== false){return 1;}else{return 2;}
            }else{
                return 2;
            }
        }else{
            return 3;
        }
    }
    /**
     * 接口名称添加
     * $app_id                   应用id    int
     * $interface_vision_id      版本id    int
     * $interface_type_id        类型id    int
     * 根据三个id 取到对应的接口信息
     * $title                   类型标题   string
     * return                    列表      json        2(错误)   3（参数不正确）
     **/
    public function actionAddapi(){

        $post = Yii::$app->request->post();
        $app_id = $_SESSION['app_id'];
        $interface_vision_id = isset($post['interface_vision_id'])?(int)$post['interface_vision_id']:'';//默认添加接口版本id
        $interface_type_id = isset($post['interface_type_id'])?(int)$post['interface_type_id']:'';//默认添加接口类别id
        $api_title = isset($post['api_title'])?trim($post['api_title']):'';//类别名称
        //$isexist = Yii::$app->db->createCommand("SELECT interface_id FROM {{%interface}} WHERE title='"."$api_title' and interface_type_id=".$interface_type_id)->queryOne();
        if(!empty($interface_vision_id)&&!empty($app_id)&&!empty($api_title)) {
            $isinsert = Yii::$app->db->createCommand()->insert('{{%interface}}', ['app_id' => $app_id, 'title' => "$api_title",'interface_vision_id'=>$interface_vision_id,'interface_type_id'=>$interface_type_id,'method'=>'GET','pam_type'=>'JSON'])->execute();
            if($isinsert){
                $interface = Yii::$app->db->createCommand("SELECT * FROM {{%interface}} WHERE app_id=$app_id and interface_vision_id=$interface_vision_id and interface_type_id=$interface_type_id")->queryAll();
                echo json_encode($interface);
            }else{
                return 2;//插入错误
            }
        }else{
            return 3;//参数错误或存在
        }
    }
    /**
     * 接口名称更新
     * $app_id                   应用id    int
     * $interface_vision_id      版本id    int
     * $interface_type_id        类型id    int
     * $title                   类型标题   string
     * return                    列表      json        2(错误)   3（参数不正确）
     **/
    public function actionUpdapi(){
        $post = Yii::$app->request->post();
        $app_id = $_SESSION['app_id'];
        $interface_vision_id = isset($post['interface_vision_id'])?(int)$post['interface_vision_id']:'';//版本id
        $interface_type_id = isset($post['interface_type_id'])?(int)$post['interface_type_id']:'';//类型id
        $interface_id = isset($post['interface_id'])?(int)$post['interface_id']:'';//类型id
        $title = isset($post['title'])?trim($post['title']):'';
        if(!empty($interface_vision_id)&&!empty($interface_type_id)&&!empty($title)){
            //查看标题是否重复
            $isexist = Yii::$app->db->createCommand("SELECT interface_type_id FROM {{%interface_type}} WHERE title='"."$title' AND interface_type_id=$interface_type_id AND interface_vision_id=$interface_vision_id AND app_id=$app_id")->queryOne();
            if(empty($isexist)){
                //更新
                $isupd = Yii::$app->db->createCommand("UPDATE {{%interface}} SET title='"."$title'"." WHERE interface_id=$interface_id")->execute();
                if($isupd !== false){return 1;}else{return 2;}
            }else{
                return 2;
            }
        }else{
            return 3;
        }
    }
    /**
     * 接口名称删除
     * $app_id                   应用id    int
     * $interface_vision_id      版本id    int
     * $interface_type_id        类型id    int
     * $title                   类型标题   string
     * return                    列表      json        2(错误)   3（参数不正确）
     **/
    public function actionDelapi(){
        $post = Yii::$app->request->post();
        $interface_type_id = isset($post['interface_type_id'])?(int)$post['interface_type_id']:'';//类别id
        $interface_id = isset($post['interface_id'])?(int)$post['interface_id']:'';//接口id
        $app_id = $_SESSION['app_id'];
        if(!empty($interface_type_id)&&!empty($app_id)){
            $transaction= Yii::$app->db->beginTransaction();//创建事务
            $interface = Yii::$app->db->createCommand("DELETE FROM {{%interface}} WHERE interface_id=:interface_id",[":interface_id"=>$interface_id])->execute();
            $interface_required = Yii::$app->db->createCommand("DELETE FROM {{%interface_required}} WHERE interface_id=:interface_id",[":interface_id"=>$interface_id])->execute();
            $interface_return = Yii::$app->db->createCommand("DELETE FROM {{%interface_return}} WHERE interface_id=:interface_id",[":interface_id"=>$interface_id])->execute();

            if($interface !== false && $interface_required !== false && $interface_return !== false){
                $transaction->commit();//提交事务
                return 1;   //正确
            }else{
                $transaction->rollback();//回滚事务
                return 2;   //错误
            }
        }else{
            return 3;
        }
    }
    /**
     * 接口请求参数添加
     * $default                     默认值          satring
     * $format                      格式化传输      int
     * $parameter                  参数            string
     * $type                       类型            int
     * $sample                     示例            json
     * $mandatory                  是否必填         int
     **/
    public function actionRequired(){
        $post = Yii::$app->request->post();
        if(!empty($post) && !empty($post['default'])){
            $default = isset($post['default'])?trim($post['default']):''; //默认值
            $format = isset($post['format'])?(int)$post['format']:'';  //格式化传输
            $parameter = isset($post['parameter'])?trim($post['parameter']):'';//参数
            $type = isset($post['type'])?trim($post['type']):'';//类型
            $sample = isset($post['sample'])?trim($post['sample']):''; //示例
            $mandatory = isset($post['mandatory'])?(int)$post['mandatory']:'';//是否必填
            $interface_id = isset($post['interface_id'])?(int)$post['interface_id']:'';//接口id
            if(!empty($interface_id)&&!empty($parameter)){
                //拼装到一个数组中
                $parameters = array(
                    'interface_id'=>$interface_id,
                    'default'=>$default,
                    'format'=>$format,
                    'parameter'=>$parameter,
                    'type'=>$type,
                    'sample'=>$sample,
                    'mandatory'=>$mandatory,
                );
                $isinsert = Yii::$app->db->createCommand()->insert('{{%interface_required}}',$parameters)->execute();
                if($isinsert){
                    $data = $this->Req_res($interface_id);
                    return $data;
                }
            }else{
                return 1;//参数不正确
            }
        }else{
            return 1;//参数不正确
        }
    }
    /**
     *     接口请求参数共同使用返回数据
     *
     *     $interface_id   接口id
     **/

    public function Req_res($interface_id)
    {
        //查询请求参数表所对应接口id的数据
        $request = Yii::$app->db->createCommand("SELECT * FROM {{%interface_required}} WHERE interface_id=$interface_id")->queryAll();
        $str = '';
        foreach($request as $key => $value){
            $str .= "<tr val='".$value['required_id']."'><td><input type='text'class='cs' name='parameter' value='".$value['parameter']."'></td><td><select name='type'class='cs'id='type'><option  value='string'";
            if($value['type']==='string'){
                $str .= 'selected = "selected"';
            }
            $str .= ">string</option><option  value='double'";
            if($value['type']==='double'){
                $str .= 'selected = "selected"';
            }
            $str .= ">double</option><option  value='int'";
            if($value['type']==='int'){
                $str .= 'selected = "selected"';
            }
            $str .= ">int</option><option  value='boolean'";
            if($value['type']==='boolean'){
                $str .= 'selected = "selected"';
            }
            $str .= ">boolean</option><option  value='float'";
            if($value['type']==='float'){
                $str .= 'selected = "selected"';
            }
            $str .= ">float</option><option  value='long'";
            if($value['type']==='long'){
                $str .= 'selected = "selected"';
            }
            $str .= ">long</option></select></td><td><input name='mandatory' type='checkbox'";
            if($value['mandatory']=='1'){
                $str.= 'checked = "checked"';
            }
            $str .= "value='".$value['mandatory']."'></td><td><input name='format' type='checkbox'";
            if($value['format']=='1'){
                $str.= 'checked = "checked"';
            }
            $str .= "value='".$value['format']."'></td><td><input name='sample' value='".$value['sample']."' type='text' class='cs'></td><td><input name='default' value='".$value['default']."'type='text' class='cs'><div class='edt'><a><span class='glyphicon  glyphicon-trash' onclick='Delrequest(".$value['required_id'].")'></span></a></div></td></tr>";
        }
        return  stripslashes($str);
    }
    /**
     *   接口请求参数修改
     *   required_id       参数id
     *   par               参数值
     *   type              参数类型
     */
    public function actionUpdatereq(){
        $post = Yii::$app->request->post();
        if(!empty($post['required_id'])&& isset($post['par'])&&!empty($post['type'])&&!empty($post['interface_id'])) {
            if(($post['type']== 'mandatory' && $post['par'] == 0) || ($post['type']== 'format' && $post['par'] == 0)){
                $par = 1;
            }else if(($post['type']== 'mandatory' && $post['par'] == 1) || ($post['type']== 'format' && $post['par'] == 1)){
                $par = 0;
            }else{
                $par = $post['par'];
            }
            $isupd = Yii::$app->db->createCommand("UPDATE {{%interface_required}} SET ".$post['type']."= '".$par ."' WHERE interface_id=".$post['interface_id']." AND required_id=".$post['required_id'])->execute();
            if($isupd !== false ){
                $data = $this->Req_res($post['interface_id']);
                return $data;
                exit;
            }else{
                return 2;
            }
        }else{
            return 1;//参数不正确

        }
    }

    /**
     * 接口请求参数删除
     * required_id                    请求参数id     int
     * interface_id                   接口id         int
     **/
    public function actionDelrequest(){
        $post = Yii::$app->request->post();
        if(!empty($post['required_id'])&& !empty($post['interface_id'])){
            $isdel = Yii::$app->db->createCommand("DELETE FROM {{%interface_required}} WHERE required_id=".$post['required_id']." and interface_id=".$post['interface_id'])->execute();
            if($isdel){
                $data = $this->Req_res($post['interface_id']);
                return $data;
                exit;
            }else{
                return 2;
            }
        }else{
            return 1;//参数错误
        }
    }
    /**
     * 接口返回参数添加
     * $parameter               参数             string
     * $type                    类型              id
     * $sample                   示例             string
     * $description            描述              string
     * $interface_id           接口id            int
     **/
    public function actionBack(){
        $post = Yii::$app->request->post();
        if(!empty($post)) {
            $parameter = isset($post['parameter']) ? trim($post['parameter']) : '';//参数
            $type = isset($post['type']) ? trim($post['type']) : '';//类型
            $sample = isset($post['sample']) ? trim($post['sample']) : ''; //示例
            $description = isset($post['description']) ? trim($post['description']) : '';//描述
            $interface_id = isset($post['interface_id']) ? (int)$post['interface_id'] : '';//接口id
            $sample =  str_replace("'",'"',$sample);

            if (!empty($interface_id) && !empty($parameter)) {
                //拼装到一个数组中
                $parameters = array(
                    'interface_id' => $interface_id,
                    'parameter' => $parameter,
                    'type' => $type,
                    'sample' => $sample,
                    'description' => $description,
                );
                $isinsert = Yii::$app->db->createCommand()->insert('{{%interface_return}}', $parameters)->execute();
                if ($isinsert) {
                    $data = $this->Get_backlist($interface_id);
                    return $data;
                    exit;
                }
            }else{
                return 2;
            }
        }else{
            return 1;//参数错误
        }
    }

    /**
     * 接口返回修改
     * back_id              返回参数id            int
     * $interface_id       接口id            int
     **/
    public function actionUpdateback()
    {
        $post = Yii::$app->request->post();
        if(!empty($post['back_id'])&& isset($post['par']) && !empty($post['type'])&&!empty($post['interface_id'])) {

            $par = $post['par'];
            $par =  str_replace("'",'"',$par);

            $isupd = Yii::$app->db->createCommand("UPDATE {{%interface_return}} SET ".$post['type']."= '".$par ."' WHERE interface_id=".$post['interface_id']." AND back_id=".$post['back_id'])->execute();
            if($isupd !== false){
                $data = $this->Get_backlist($post['interface_id']);
                return $data;
                exit;
            }else{
                return 2;
            }
        }else{
            return 1;//参数不正确

        }
    }

    /**
     * 接口返回参数清空
     * back_id              返回参数id            int
     * $interface_id       接口id            int
     **/
    public function actionDelback(){
        $post = Yii::$app->request->post();
        $back_id = isset($post['back_id'])?(int)$post['back_id']:'';
        $interface_id = isset($post['interface_id'])?(int)$post['interface_id']:'';
        if(!empty($interface_id)){
            if(!empty($back_id)){
                $isdel = Yii::$app->db->createCommand("DELETE FROM {{%interface_return}} WHERE interface_id=$interface_id and back_id=$back_id ORDER BY back_id DESC")->execute();
            }else{
                $isdel = Yii::$app->db->createCommand("DELETE FROM {{%interface_return}} WHERE interface_id=$interface_id ORDER BY back_id DESC")->execute();
            }
            if($isdel){
                $data = $this->Get_backlist($interface_id);
                return $data;
                exit;
            }else{
                return 2;
            }
        }else{
            return 1;//参数错误
        }
    }

    /**
     *  返回参数共用部分
     *  $interface_id    接口id
     *
     * */
    public function Get_backlist($interface_id)
    {
        //查询请求参数表所对应接口id的数据
        $request = Yii::$app->db->createCommand("SELECT * FROM {{%interface_return}} WHERE interface_id=" .$interface_id)->queryAll();
        $str = '';
        foreach ($request as $key => $value) {
            $str .= "<tr val='".$value['back_id']."'><td><input type='text'class='cs' name='parameter' value='".$value['parameter']."'></td><td><input type='text'class='cs' name='type' value='".$value['type']."'></td><td><input type='text'class='cs' name='description' value='".$value['description']."'></td><td><input type='text' class='cs' name='sample' value='".$value['sample']."'><div class='edt'><a><span class='glyphicon  glyphicon-trash' onclick='Delback(".$value['back_id'].")'></span></a></div></td></tr>";
        }
        return  stripslashes($str);

    }


    /*
     * 递归循环数组进行赋值
     * */
    public function arr_foreach($data,$arr){
        if(is_array($arr)){
            foreach($arr as $k=>$v){
                $data[] = array(
                    "parameter" => is_array($k) ? gettype($k) : $k,
                    "type" => gettype($v),
                    "sample" => is_array($v) ? gettype($v) : $v
                );
                if(is_array($v)){
                    $data = $this->arr_foreach($data,$v);
                }
            }
            return $data;
        }
    }
    /***************************************************导入json********************************************************/
    /*导入json实现，添加的json  有可能只返回 一个信息或者说是参数，有可能是多条信息或参数*/

    /**
     *   $importjson        导入的 json 格式的字符串数据           string
     *
     * */
    public function actionImportjson(){
        $post = Yii::$app->request->post();
        $interface_id = isset($post['interface_id'])?(int)$post['interface_id']:'';
        $importjson = isset($post['importjson'])?trim($post['importjson']):'';
        if($interface_id == false){
            return 3;//参数错误
        }
        if(!empty($importjson)&&!empty($interface_id)){
            $import_arr = json_decode($importjson,true);
            if($import_arr){
                $info =  $this->arr_foreach(array(),$import_arr);
            }else{
                return 1;//参数错误
            }
            if(!empty($info)){
                foreach($info as $key=>$value){
                    $sql = "INSERT INTO ".Yii::$app->components['db']['tablePrefix']."interface_return(interface_id,parameter,type,sample) values(:interface_id,:parameter,:type,:sample)";
                    $is_ok = Yii::$app->db->createCommand($sql,[":interface_id"=>$interface_id,":parameter"=>$value["parameter"],":type"=>$value["type"],":sample"=>$value["sample"]])->execute();
                }
                if($is_ok){
                    //查询请求参数表所对应接口id的数据
                    $request = Yii::$app->db->createCommand("SELECT * FROM {{%interface_return}} WHERE interface_id=" . $interface_id)->queryAll();

                    $str = '';
                    foreach ($request as $key => $value) {
                        $str .= "<tr><td><input type='text'class='cs' name='parameter' value='".$value['parameter']."'></td><td><input type='text'class='cs' name='type' value='".$value['type']."'></td><td><input type='text'class='cs' name='description' value='".$value['description']."'></td><td><input type='text' class='cs' name='sample' value='".$value['sample']."'><div class='edt'><a><span class='glyphicon  glyphicon-trash' onclick='Delback(".$value['back_id'].")'></span></a></div></td></tr>";
                    }
                    return  stripslashes($str);
                }else{
                    return 2;//插入数据错误
                }
            }else{
                return 1;//参数错误
            }
        }else{
            return 1;//参数错误
        }
    }

    /**
     * @param           interface_id            选中接口id
     * @param           description             接口描述
     * @param           return_sample           接口返回示例
     * @param           method                  接口请求方式
     * @param           pam_type                接口数据类型，json,xml
     * @param           title                   接口名称
     * @return          int
     */
    public function actionInterface(){
        $post = Yii::$app->request->post();
        $title = isset($post['title']) ? trim($post['title']) : '';//接口名称
        $pam_type = isset($post['pam_type']) ? trim($post['pam_type']) : '';//接口数据类型
        $method = isset($post['method']) ? trim($post['method']) : ''; //接口请求方式
        $return_sample = isset($post['return_sample']) ? trim($post['return_sample']) : '';//接口返回示例
        $description = isset($post['description']) ? trim($post['description']) : '';//描述
        $interface_id = isset($post['interface_id']) ? (int)$post['interface_id'] : '';//接口id

        if(!empty($title)&&!empty($pam_type)&&!empty($method)&&!empty($interface_id)){
            $param = array(
                'title'  => $title,
                'pam_type'  => $pam_type,
                'method'  => $method,
                'return_sample'  => $return_sample,
                'description'  => $description,
            );

            $isinsert = Yii::$app->db->createCommand()->update("{{%interface}}",$param,"interface_id=$interface_id")->execute();
            if($isinsert){
                $msg = Yii::$app->db->createCommand("SELECT * FROM {{%interface}} WHERE interface_id=$interface_id")->queryOne();
                echo json_encode($msg);//成功
            }else{
                return 2;//更新失败
            }
        }else{
            return 3;//参数不正确
        }

    }

    /**
     * @param           type                         来自哪个搜索
     * @param           condition                    选中的内容
     * @param           app_id                       应用id
     * @param           interface_vision_id          版本id
     * @param           interface_type_id            分类id
     * @param           interface_id                 接口id
     * @return          string                       错误提示
     */
    public function actionSearch()
    {
        $post = Yii::$app->request->post();
        $type = isset($post['type']) ? trim($post['type']):'';
        $condition = isset($post['condition']) ? trim($post['condition']):'';
        $app_id = $_SESSION['app_id'];

        $interface_vision_id = isset($post['interface_vision_id']) ? intval($post['interface_vision_id']):'';
        $interface_type_id = isset($post['interface_type_id']) ? intval($post['interface_type_id']):'';
        $condition = $condition != '全部' ? $condition:'';
        if(!empty($type)){
            /*版本*/
            if($type == 'banben' && !empty($app_id)){
                if($condition != ''){
                    $vision = Yii::$app->db->createCommand("SELECT * FROM {{%interface_vision}} WHERE app_id=".$app_id ." and vision='".$condition."'")->queryOne();
                    echo json_encode($vision);
                }else{
                    $vision = Yii::$app->db->createCommand("SELECT * FROM {{%interface_vision}} WHERE app_id=".$app_id )->queryAll();
                    echo json_encode($vision);
                }
            }
            /*类别*/
            else if($type == 'user' && !empty($interface_vision_id) && !empty($app_id)){
                if($condition != '') {
                    $types = Yii::$app->db->createCommand("SELECT * FROM {{%interface_type}} WHERE interface_vision_id=" . $interface_vision_id . " and title='".$condition."'")->queryOne();
                    echo json_encode($types);
                }else{
                    $types = Yii::$app->db->createCommand("SELECT * FROM {{%interface_type}} WHERE interface_vision_id=" . $interface_vision_id )->queryAll();
                    echo json_encode($types);
                }
            }
            /*接口*/
            else if($type == 'jkname' && !empty($interface_vision_id) && !empty($app_id) && !empty($interface_type_id)){
                if($condition != '') {
                    $interface = Yii::$app->db->createCommand("SELECT * FROM {{%interface}} WHERE interface_type_id=".$interface_type_id." and interface_vision_id=".$interface_vision_id." and app_id=".$app_id . " and title='".$condition."'")->queryOne();
                    echo json_encode($interface);
                }else{
                    $interface = Yii::$app->db->createCommand("SELECT * FROM {{%interface}} WHERE interface_type_id=".$interface_type_id." and interface_vision_id=".$interface_vision_id." and app_id=".$app_id)->queryAll();
                    echo json_encode($interface);
                }
            }else{
                return '参数错误';
            }
        }else{
            return '参数错误';
        }
    }


    /**
     * 添加返回示例
     */
    public function actionReturn_example(){

        $get = Yii::$app->request->get();
        $app_id = $_SESSION['app_id'];
        $interface_vision_id = isset($get['interface_vision_id']) ? intval($get['interface_vision_id']):'';
        $interface_id = isset($get['interface_id']) ? intval($get['interface_id']):'';

        //取出接口跟地址
        $interface_addr = Yii::$app->db->createCommand('SELECT interface_address FROM {{%application}} WHERE app_id=:app_id',[':app_id'=>$app_id])->queryOne();

        //取出版本id
        $vision_title = Yii::$app->db->createCommand('SELECT `vision` FROM {{%interface_vision}} WHERE interface_vision_id=:interface_vision_id',[':interface_vision_id'=>$interface_vision_id])->queryOne();

        //取出接口title
        $interface_title = Yii::$app->db->createCommand('SELECT `title`,`method` FROM {{%interface}} WHERE interface_id=:interface_id',[':interface_id'=>$interface_id])->queryOne();
        $host = $interface_addr['interface_address'];
        //根据接口id去请求参数表取出响应参数
        $parameter = Yii::$app->db->createCommand('SELECT `parameter`,`default` FROM {{%interface_required}} WHERE interface_id=:interface_id',[':interface_id'=>$interface_id])->queryAll();

        if(!empty($parameter)) {
            foreach ($parameter as $key => $value) {
                $pardata["$value[parameter]"] = $value['default'];
            }
            //转换为url参数类型
            $par_str = http_build_query($pardata);

            $url = $host . '/' . $vision_title['vision'] . '/' . $interface_title['title'] . '?' . $par_str;
        }else{
            $url = $host . '/' . $vision_title['vision'] . '/' . $interface_title['title'] ;
        }

        $api_visit = new visit();
        //路径，请求方式
        $res = @$api_visit->curl($url,$interface_title['method']);
        if($res){
            echo $res;exit;
        }else{
          $error = array ('status' => '500', 'message' => 'Internal Server Error');
            echo json_encode($error,true);
        }

    }


}