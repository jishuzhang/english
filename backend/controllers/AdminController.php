<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Users;
use yii\data\Pagination;
use yii\base\Security;
use backend\controllers\PublicFunction;
/**
 * Admin Controller
 */
class AdminController extends BackendController
{
    public function actionIndex(){
//        $requestMethod = $_SERVER['REQUEST_METHOD'];
//        $requestRoute = Yii::$app->requestedRoute;
//        var_dump($requestMethod);
        $Public = new PublicFunction();
        //$Public->visitlog('1','1','1','1');
        $sql='select * from {{%users}} LEFT OUTER JOIN {{%roles}} on users.roleid=roles.roles_id ORDER BY users_id ASC ';
        $query = Yii::$app->db->createCommand($sql.' limit 1000')->queryAll();
        $count = count($query);
        $pagesize = 10;
        $pagination = new Pagination([
            'defaultPageSize'=>$pagesize,
            'totalCount' =>$count,
        ]);
        //var_dump($pagination);exit;
        $all_pages =  ceil($count/$pagesize);
        $list = Yii::$app->db->createCommand($sql." limit ".$pagination->limit." offset ".$pagination->offset."")->queryAll();
        return $this->render('index',[
            'list' => $list,
            'pagination'=>$pagination,
            'all_pages' => $all_pages,
            //'query1'=>$query1
        ]);
    }
    public function actionCreate(){
        $Public = new PublicFunction();
        $post = Yii::$app->request->post();
        //var_dump($post);exit;
        $new = new Security;
        //遍历角色供添加用
        $sql = "SELECT role,roles_id FROM {{%roles}}";
        $query = Yii::$app->db->createCommand($sql)->queryAll();
        if(!empty($post)){
            $array=[];
            $array['username']=isset($post['username']) ? $post['username'] : '';
            if(empty($post['username'])){
                $content = $Public->message('error', '登录名不能为空', "index.php?r=admin/create");
                return $this->renderContent($content);
            }
            $array['roleid']=isset($post['roleid']) ? $post['roleid'] : '';
            $password = $new->generatePasswordHash($post['password']);
            $array['password']=isset($password) ? $password : '';
            if(empty($post['password'])){
                $content = $Public->message('error', '密码不能为空', "index.php?r=admin/create");
                return $this->renderContent($content);
            }
            $array['realname'] = isset($post['realname']) ? $post['realname'] : '';
            if(empty($post['realname'])){
                $content = $Public->message('error', '用户名不能为空', "index.php?r=admin/create");
                return $this->renderContent($content);
            }
            $array['email'] = isset($post['email']) ? $post['email'] : '';
            $array['mobile'] = isset($post['mobile']) ? $post['mobile'] : '';
            $array['notification'] = isset($post['notification']) ? $post['notification'] : '';
            $array['createtime'] = time();
            $array['auth_key'] = '';
            $isset = Yii::$app->db->createCommand("SELECT users_id FROM {{%users}} WHERE username='"."$post[username]'")->queryOne();
            //var_dump($array);//exit;
            if(empty($isset)){
                $isinsert = Yii::$app->db->createCommand()->insert('{{%users}}',$array)->execute();
                if($isinsert){
                    //$Public->visitlog('1','1','1','1');
                    $content = $Public->message('success', '添加成功', "index.php?r=admin/index");
                    return $this->renderContent($content);
                }else{
                    $content = $Public->message('error', '添加失败', "index.php?r=admin/index");
                    return $this->renderContent($content);
                }
            }else{
                $content = $Public->message('error', '用户名重复，不允许添加', "index.php?r=admin/index");
                return $this->renderContent($content);
            }

        }

        return $this->render('create',['query'=>$query]);
    }
    public function actionUpdate()
    {
        $post = Yii::$app->request->post();
        $new = new Security;
        $Public = new PublicFunction();
        $sql = "SELECT role,roles_id FROM {{%roles}}";
        $query = Yii::$app->db->createCommand($sql)->queryAll();
        if(!empty($post)){
            $id = Yii::$app->request->post('userid');
            $username=Yii::$app->request->post('username');
            $realname=Yii::$app->request->post('realname');
            $email=Yii::$app->request->post('email');
            $mobile=Yii::$app->request->post('mobile');
            $notification=Yii::$app->request->post('notification');

            //进行密码的修改
            $password = Yii::$app->request->post('password');
            //获取角色对应的id号
            $roleid=Yii::$app->request->post('role');
            if(empty($password)){
                $sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."users SET username=:username,roleid=:roleid,realname=:realname,email=:email,mobile=:mobile,notification=:notification WHERE users_id=:id";
                $command = Yii::$app->db->createCommand($sql,[":username"=>$username,":roleid"=>$roleid,":realname"=>$realname,":email"=>$email,":mobile"=>$mobile,":notification"=>$notification,":id"=>$id]);
                $if_ok = $command->execute();
            }else{
                $password_hash = $new->generatePasswordHash($password);
                $sql = "UPDATE ".Yii::$app->components['db']['tablePrefix']."users SET username=:username,password=:password,roleid=:roleid,realname=:realname,email=:email,mobile=:mobile,notification=:notification WHERE users_id=:id";
                $command = Yii::$app->db->createCommand($sql,[":username"=>$username,":password"=>$password_hash,":roleid"=>$roleid,":realname"=>$realname,":email"=>$email,":mobile"=>$mobile,":notification"=>$notification,":id"=>$id]);
                $if_ok = $command->execute();

            }
            if($if_ok){
                if(isset($post['refreshUrl'])){
                    $content = $Public->message('success', '更新成功', 'index.php?r='.$post['refreshUrl']);
                }else{
                    $content = $Public->message('success', '更新成功', "index.php?r=admin/index");
                }
                return $this->renderContent($content);
            }else{
                $content = $Public->message('error', '更新失败', "index.php?r=admin/index");
                return $this->renderContent($content);
            }


    }else{
            $users_id = Yii::$app->request->get('id');
            $result = Yii::$app->db->createCommand("SELECT * FROM {{%users}} WHERE users_id=".$users_id)->queryOne();
        }

        return $this->render('update',['result'=>$result,'query'=>$query]);

    }

    public function actionDelete ()
    {
        $Public = new PublicFunction();
        $roles_id = Yii::$app->request->get('id');
        if(!empty($roles_id)){
            $isdel = Yii::$app->db->createCommand()->delete('{{%users}}','users_id='.$roles_id)->execute();
            if($isdel){
                //插入数据库
                //$Public->visitlog();
                if(isset($post['refreshUrl'])){
                    $content = $Public->message('success', '删除成功', 'index.php?r='.$_GET['refreshUrl']);
                }else{
                    $content = $Public->message('success', '删除成功', "index.php?r=admin/index");
                }
                return $this->renderContent($content);
            }else{
                $content = $Public->message('error', '删除失败', "index.php?r=admin/index");
                return $this->renderContent($content);
            }

        }else{
            $content = $Public->message('error', '参数不能为空', "index.php?r=admin/index");
            return $this->renderContent($content);
        }
    }

}