<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\library\Images;
use yii\base\Security;
use backend\controllers\PublicFunction;
use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;
/**
 * PersonalController
 */
class PersonalController extends BackendController
{
//    public $layout = "news"; //设置使用的布局文件
    public function actionIndex(){


        return $this->render('index');
    }
    public function actionCreate(){

        return $this->render('create');
    }
    /*
   * 应用设置的方法
   * */
    public function actionUpdate()
    {
        if(!isset(Yii::$app->user->identity->id)){
            return $this->redirect(['site/login']);
        }
        $id = Yii::$app->user->identity->id;
        $sql = "SELECT u.username,u.realname,u.portrait,r.role FROM {{%users}} u,{{%roles}} r  where u.users_id = :id and u.roleid = r.roles_id";
        $users = Yii::$app->db->createCommand($sql,[":id"=>$id])->queryOne();
        //处理post提交来的数据
        $request =Yii::$app->request;
        $Function = new PublicFunction();
        if ($request->isPost) {
            $id = Yii::$app->user->identity->id;
            $sql = "SELECT portrait FROM {{%users}} where users_id = :id";
            $picname = Yii::$app->db->createCommand($sql,[":id"=>$id])->queryOne();
            $new = new Security;
            if(!empty($_FILES) && $_FILES['upload_file']['error']!=4){
                $file = $_FILES['upload_file'];
                $path = 'res/upload/portrait/';
                $allowType = array('image/jpeg','image/png','image/jpg','image/gif');
                //调用文件上传的函数
                $upload =  new Images();
                $info =  $upload->uploadFile($file,$path,$allowType,$maxSize=2048000);
                if ($info['error']){
                    //生产略缩图
                    $filename = $info['message'];
                    $name = explode(".",$filename);
                    $names  = array_shift($name);
                    $type = pathinfo($filename, PATHINFO_EXTENSION);

                    //生产略缩图
                    Image::thumbnail($path.$filename,500,500,ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($path."s_".$names.".".$type,['quality' => 9]);
                    // $upload->imageResize($path.$filename,$path,120,120,'s_');
                    unlink($path."/".$filename);
                    $portrait = "http://".$_SERVER['SERVER_NAME']."/res/upload/portrait/s_".$filename;
                    $arr = parse_url($picname["portrait"]);
                    $str = substr(array_pop($arr),1);
                    //删除原图
                    @unlink($str);
                }else{
                    //有错则返回错误信息
                    $content = $Function->message('error',$info['message'], 'index.php?r=personal/update');
                    return $this->renderContent($content);
                }
            }else{
                $portrait = $picname["portrait"];
            }
            $username =  htmlspecialchars(trim($request->post("username")));
            $realname =  htmlspecialchars(trim($request->post("realname")));
            $password = Yii::$app->request->post('password');
            //没有密码就不改密码
            if($password == "@^()^@"){
                $sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."users SET username=:username,realname=:realname,portrait=:portrait WHERE users_id=:id";
                $result = Yii::$app->db->createCommand($sql,[":username"=>$username,":realname"=>$realname,":portrait"=>$portrait,":id"=>$id])->execute();
            }else{
                //有密码则改密码
                $password = $new->generatePasswordHash($request->post("password"));
                $sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."users SET username=:username,realname=:realname,portrait=:portrait,password=:password WHERE users_id=:id";
                $result = Yii::$app->db->createCommand($sql,[":username"=>$username,":realname"=>$realname,":portrait"=>$portrait,":password"=>$password,":id"=>$id])->execute();
            }

            if($result!== false){
                $content = $Function->message('success', '添加成功',"index.php?r=personal/update");
                return $this->renderContent($content);
            }else{
                $content = $Function->message('error', '添加失败', 'index.php?r=personal/update');
                return $this->renderContent($content);
            }
        }
        return $this->render('update',array('users'=>$users));
    }

    public function actionDelete ()
    {

    }

}