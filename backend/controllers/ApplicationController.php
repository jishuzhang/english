<?php
namespace backend\controllers;
use yii\web\Controller;
use Yii;
use common\library\Images;
use backend\controllers\PublicFunction;
use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;
/**
 * Applyset Controller
 */
class ApplicationController extends BackendController
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }
    /*
     * 添加应用的方法
     * */
    public function actionCreate()
    {
        if(!isset(Yii::$app->user->identity->id)){
            return $this->redirect(['site/login']);
        }
        $userid = Yii::$app->user->identity->id;
        //找到超级管理员的roleid
        $sql = "SELECT roleid FROM {{%users}}  where users_id = :users_id";
        $role = Yii::$app->db->createCommand($sql,[":users_id"=>$userid])->queryOne();
        $Function = new PublicFunction();
        $request = Yii::$app->request;
        if($request->isAjax){
            if(Yii::$app->request->post()){
                $array = Yii::$app->request->post();
                $title = htmlspecialchars(trim($array['title']));
                $res = Yii::$app->db->createCommand('SELECT title,isstutas FROM {{%application}} WHERE  title = :title',[':title'=>$title])->queryOne();
                if ($res && $res['isstutas'] ==0){
                    return 3; //状态为0
                } elseif($res) {
                    return 1;   //仅仅是存在
                }else{
                    return 2;   //不存在提交
                }
            }else{
                $title = Yii::$app->request->get();
                $sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."application SET isstutas=1 WHERE title=:title";
                $isstatus = Yii::$app->db->createCommand($sql,[":title"=>$title['title']])->execute();
                if($isstatus !== false){
                    return 1;   //成功
                }else{
                    return 2;   //失败
                }
            }

        }
        if (Yii::$app->request->post()) {
            if (!empty($_FILES) && $_FILES['upload_file']['error'] != 4) {
                $file = $_FILES['upload_file'];
                $path = 'res/upload/portrait/';
                $allowType = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');
                $upload = new Images();
                //调用上传文件的方法
                $info = $upload->uploadFile($file, $path, $allowType,$maxSize=2048000);
                //成功则生成略缩图
                if ($info['error']) {
                    $filename = $info['message'];
                    //生产略缩图
                    $name = explode(".",$filename);
                    $names  = array_shift($name);
                    $type = pathinfo($filename, PATHINFO_EXTENSION);
                    //生产略缩图
                    Image::thumbnail($path.$filename,500,500,ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($path."s_".$names.".".$type,['quality' => 9]);
                    //删除大图
                    unlink($path . "/" . $filename);
                    $image_url = "http://" . $_SERVER['SERVER_NAME'] . "/res/upload/portrait/s_" . $filename;
                }else{
                    //有错则返回错误信息
                    $content = $Function->message('error',$info['message'], 'index.php?r=application/create');
                    return $this->renderContent($content);
                }
            }else{
                $image_url = "";
            }
            $post = Yii::$app->request->post();
            $title = htmlspecialchars(trim($post['form']['title']));
            $description = htmlspecialchars(trim($post['form']['description']));
            $app_address = htmlspecialchars(trim($post['form']['app_address']));
            $interface_address = "http://".Yii::$app->params['appsite_url']."/".htmlspecialchars(trim($post['form']['interface_address']));
            if(in_array($role,Yii::$app->params)){
                //如果登陆用户是超级用户跳过权限验证
                $interface_address = "http://".Yii::$app->params['appsite_url']."/".htmlspecialchars(trim($post['form']['interface_address']));
            }
            $sql = "INSERT INTO ".Yii::$app->components['db']['tablePrefix']."application(title,description,app_address,interface_address,image_url) values(:title,:description,:app_address,:interface_address,:image_url)";
            $is_ok = Yii::$app->db->createCommand($sql,[":title"=>$title,":description"=>$description,":app_address"=>$app_address,":interface_address"=>$interface_address,":image_url"=>$image_url])->execute();
            $app_id = Yii::$app->db->getLastInsertId();
            if($is_ok !== false){
                $users_id = Yii::$app->user->id;
                $sql = "INSERT INTO ".Yii::$app->components['db']['tablePrefix']."app_member(users_id,app_id,app_title,create_by) values(:users_id,:app_id,:app_title,:create_by)";
                $app_member = Yii::$app->db->createCommand($sql,[":users_id"=>$users_id,":app_id"=>$app_id,":app_title"=>$title,":create_by"=>$users_id])->execute();
                if($app_member !== false){
                    //if(isset($post['submit'])){$local_href = 'index.php?r=site/index';}else{$local_href = 'index.php?r=application/create';}
                    $content = $Function->message('success', '添加成功', 'index.php?r=site/index');
                    return $this->renderContent($content);
                }else{
                    $content = $Function->message('error', '添加失败', 'index.php?r=application/create');
                    return $this->renderContent($content);
                }
            }else{
                $content = $Function->message('error',"数据有误请重试", 'index.php?r=application/create');
                return $this->renderContent($content);
            }
        }
        return $this->render('create',array('role'=>$role));
    }
    /*
    * 应用设置的修改方法
    * */
    public function actionUpdate()
    {
        if(!isset(Yii::$app->user->identity->id)){
            //echo 222;
            return $this->redirect(['site/login']);
        }
        $userid = Yii::$app->user->identity->id;
        //找到超级管理员的roleid
        $sql = "SELECT roleid FROM {{%users}}  where users_id = :users_id";
        $role = Yii::$app->db->createCommand($sql,[":users_id"=>$userid])->queryOne();
        !empty($_SESSION["app_id"]) ? $app_id = $_SESSION["app_id"] : $app_id = 102 ;
        $sql = "SELECT app_id,image_url,title,description,app_address,interface_address FROM {{%application}}  where app_id = :app_id";
        $apps = Yii::$app->db->createCommand($sql,[":app_id"=>$app_id])->queryOne();
        $sql = "SELECT create_by FROM {{%app_member}}  where app_id = :app_id";
        $create_by = Yii::$app->db->createCommand($sql,[":app_id"=>$app_id])->queryOne();
        $pase_url = parse_url($apps["interface_address"]);
        $del_last_arr = array_pop($pase_url);
        $interface_address = substr($del_last_arr, 1);
        //如果登陆用户是超级用户跳过权限验证
        if(in_array($role,Yii::$app->params)){
            $interface_address = $apps["interface_address"];
        }
        $request = Yii::$app->request;
        //处理ajax过来的数据
        if( $request->isAjax){
            $title = $request->get("title");
            $sql = "SELECT title FROM {{%application}}  where title = :title";
            $title = Yii::$app->db->createCommand($sql,[":title"=>$title])->queryOne();
            if($title){
                echo 1 ;
            }
            exit;
        }
        $Function = new PublicFunction();
        //处理提Post交来的数据
        if ($request->isPost) {
            $id = $app_id;
            //获取原图
            $sql = "SELECT image_url FROM {{%application}} where app_id = :id";
            $picname = Yii::$app->db->createCommand($sql,[":id"=>$id])->queryOne();
            if (!empty($_FILES) && $_FILES['upload_file']['error'] != 4) {
                $file = $_FILES['upload_file'];
                $path = 'res/upload/portrait/';
                $allowType = array('image/jpeg', 'image/png', 'image/jpg', 'image/gif');
                $upload = new Images();
                //调用上传文件的方法
                $info = $upload->uploadFile($file, $path, $allowType,$maxSize=2048000);
                //成功则生成略缩图
                if ($info['error']) {
                    $filename = $info['message'];
                    $name = explode(".",$filename);
                    $names  = array_shift($name);
                    $type = pathinfo($filename, PATHINFO_EXTENSION);
                    //生产略缩图
                    Image::thumbnail($path.$filename,500,500,ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($path."s_".$names.".".$type,['quality' => 9]);
                    //删除大图
                    @unlink($path . "/" . $filename);
                    $image_url = "http://" . $_SERVER['SERVER_NAME'] . "/res/upload/portrait/s_" . $filename;
                    $arr = parse_url($picname["image_url"]);
                    $str = substr(array_pop($arr), 1);
                    //删除原图
                    @unlink($str);
                }else{
                    //有错则返回错误信息
                    $content = $Function->message('error',$info['message'], 'index.php?r=application/update');
                    return $this->renderContent($content);
                }
            } else {
                $image_url = $picname["image_url"];
            }
            //处理提交来的数据
            $title = htmlspecialchars(trim($request->post("title")));
            $description = htmlspecialchars(trim($request->post("description")));
            $app_address = htmlspecialchars(trim($request->post("app_address")));
            $interface_address = "http://".$pase_url['host']."/".htmlspecialchars(trim($request->post("interface_address")));
            //如果存在则为超级管理员
            if(in_array($role,Yii::$app->params)){
                //如果登陆用户是超级用户跳过权限验证
                $interface_address = htmlspecialchars(trim($request->post("interface_address")));
            }
            //执行更改
            $sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."application SET title=:title,description=:description,app_address=:app_address,interface_address=:interface_address,image_url=:image_url WHERE app_id=:app_id";
            $result = Yii::$app->db->createCommand($sql,[":title"=>$title,":description"=>$description,":app_address"=>$app_address,":interface_address"=>$interface_address,":image_url"=>$image_url,":app_id"=>$app_id])->execute();

            if ($result!== false) {
                $content = $Function->message('success', '添加成功', "index.php?r=application/update");
                return $this->renderContent($content);
            } else {
                $content = $Function->message('error', '添加失败', 'index.php?r=application/update');
                return $this->renderContent($content);
            }
        }

        return $this->render('update',
            array(
                'apps'=>$apps,
                "interface_address"=>$interface_address,
                'role'=>$role,
                "pase_url"=>$pase_url['host'],
                @"create_by"=>$create_by['create_by'],
                "userid"=>$userid,
            )
        );
    }



    public function actionDelete()
    {

        $app_id = $_SESSION["app_id"];
        $request = Yii::$app->request;
        if($request->isAjax) {
            $app_id = $request->get("app_id");
            $sql = "UPDATE  ".Yii::$app->components['db']['tablePrefix']."application SET isstutas=:isstutas WHERE app_id=:app_id";
            $is_ok = Yii::$app->db->createCommand($sql,[":app_id"=>$app_id,":isstutas"=> 0])->execute();
            if ($is_ok !== FALSE) {
                echo "1";
            } else {
                echo "0";
            }
            exit;
        }
        return $this->render('delete',array("app_id"=>$app_id));

    }

}