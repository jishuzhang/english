<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use backend\controllers\PublicFunction;
use backend\controllers\BackendController;

/**
 * Member Controller
 */
class MemberController extends BackendController
{
//    public $layout = "news"; //设置使用的布局文件

    /**
     * 当前用户创建应用及分配权限列表
     *
     * @return string
     *
     */
    public function actionIndex(){
        //获取当前的应用
        $app_id = $_SESSION['app_id'];

        //当前登录用户id
        $createby_data = Yii::$app->db->createCommand('SELECT create_by FROM {{%app_member}} WHERE app_id=:app_id',['app_id'=>$app_id])->queryOne();
        $createby = $createby_data['create_by'];

        $sql1 = 'SELECT realname FROM {{%users}} WHERE users_id= :create_by';
        $createbyname = Yii::$app->db->createCommand($sql1,[':create_by'=>$createby])->queryOne();

        $sql = 'SELECT a.app_member_id , a.users_id , a.app_id , a.app_title , a.create_by , u.realname FROM {{%app_member}} AS a  LEFT JOIN  {{%users}} AS u  ON a.users_id=u.users_id WHERE a.app_id = :app_id AND a.create_by = :create_by';
        $result =Yii::$app->db->createCommand($sql,[':app_id'=>$app_id,':create_by'=>$createby])->queryAll();

        foreach($result as $key => $value ){
            if($value['create_by'] === $value['users_id']){
                unset($result[$key]);
            }
        }
        return $this->render('index',[
            'result'=>$result,
            'createby'=>$createbyname['realname'],
        ]);
    }
    public function actionMemberallow(){

        $get = Yii::$app->request->get();
        $users_id = isset($get['users_id']) ? intval($get['users_id']) : 0 ;

        $app_id = $_SESSION['app_id'];
        //获取应用title
        $app_title = Yii::$app->db->createCommand('select title from {{%application}} WHERE app_id=:app_id',[':app_id'=>$app_id])->queryOne();
        $top_menu=Yii::$app->db->createCommand('select `nodes_id`,`title`,`display`,`pid`,`path`,`controller`,`action`,`floor` from {{nodes}} WHERE `floor`=2 AND `pid` != 0')->queryAll();
        //var_dump($top_menu);exit();
        foreach($top_menu as $key => $value){
            if($value['controller'] == 'application'){
                $result['application'][] = $value;
            }
            if($value['controller'] == 'appmanager'){
                $result['apiajax'][] = $value;
            }
            if($value['controller'] == 'apiajax'){
                    $result['apiajax'][] = $value;
            }
            if($value['controller'] == 'test'){
                $result['test'][] = $value;
            }
            if($value['controller'] == 'member' || $value['controller'] == 'personal'){
                $result['member'][] = $value;
            }
            if($value['controller'] == 'code'){
                $result['code'][] = $value;
            }
        }

        //查询应用节点表
        $sql = 'SELECT `nodes_id` FROM {{%user_app_nodes}} WHERE users_id=:users_id AND app_id=:app_id';
        $nodes = Yii::$app->db->createCommand($sql, [':users_id'=>$users_id,':app_id'=>$app_id])->queryAll();
        //var_dump($nodes);exit();
        if(!empty($nodes)){
            foreach( $nodes as $value ){
                $nodes_arr[] = $value['nodes_id'];
            }
        }else{
            $nodes_arr =array();
        }

        return $this->render('memberallow',[
           'result'=>$result,
           'users_id'=>$users_id,
           'nodes_arr'=>$nodes_arr,
           'app_title'=>$app_title,
        ]);
    }
    public function actionApp_nodes_save()
    {
        $post = Yii::$app->request->post();
        $users_id = isset($post['users_id']) ? intval($post['users_id']) : 0 ;
        $nodes_id = isset($post['nodes_id']) ? intval($post['nodes_id']) : 0 ;
        $isSelected = isset($post['isSelected']) ? intval($post['isSelected']) : 9999 ;
        $app_id = $_SESSION['app_id'];

        if (!empty($post)&& !empty($users_id) && !empty($nodes_id)&&!empty($app_id) && $isSelected != 9999) {
            $isexit = Yii::$app->db->createCommand('SELECT nodes_id FROM {{%user_app_nodes}} WHERE nodes_id='.$nodes_id.' and users_id='.$users_id .' and app_id='.$app_id)->queryOne();
            if($isSelected ==1){
                if(empty($isexit)){
                    $isinsert = Yii::$app->db->createCommand()->insert('{{%user_app_nodes}}',['users_id'=>$users_id,'app_id'=>$app_id,'nodes_id'=>$nodes_id])->execute();
                    return $isinsert;
                }else{
                    return 3;//存在
                }
            }
            if($isSelected ==0){
                $isdel = Yii::$app->db->createCommand()->delete('{{%user_app_nodes}}',['nodes_id'=>$nodes_id,'users_id'=>$users_id])->execute();
                return $isdel;
            }
        } else {
            return 2;//参数错误
        }
    }

    /*
     * 批量添加成员对应的应用：一个用户可以有多个应用但不可以有重复的应用
     * */
    public function actionCreate(){
        $app_id = $_SESSION["app_id"];
        //查出对应的创建人ID
        $sql = "SELECT create_by FROM {{%app_member}} WHERE app_id = :app_id ";
        $create_by = Yii::$app->db->createCommand($sql,[":app_id"=>$app_id])->queryOne();

        $sql = "SELECT u.users_id,u.username,u.realname,r.role FROM {{%users}} u,{{%roles}} r  WHERE u.roleid = r.roles_id AND u.users_id != :users_id";
        $query = Yii::$app->db->createCommand($sql.' limit 1000',[":users_id"=>$create_by['create_by']])->queryAll();
        $count = count($query);
        $pagesize = 10;
        $pagination = new Pagination([
            'defaultPageSize'=>$pagesize,
            'totalCount' =>$count,
        ]);
        $all_pages =  ceil($count/$pagesize);
        $users = Yii::$app->db->createCommand($sql." limit ".$pagination->limit." offset ".$pagination->offset."",[":users_id"=>$create_by['create_by']])->queryAll();
        $request = Yii::$app->request;
        if( $request->isAjax) {
            $vals = $request->get("vals");
            $sql = "SELECT users_id FROM {{%app_member}} where app_id = :app_id";
            $have = Yii::$app->db->createCommand($sql,[":app_id"=>$app_id])->queryAll();
            $ids = explode(',',$vals);
            if(!empty($have)){
                //更具值取交集
                foreach($have as $key=>$val){
                    $jiaoji[] = array_intersect($val,$ids);
                }
            }else{
                return 2;
            }

            //过滤多余的空数组

            $jiaoji_num = count(array_filter($jiaoji));
            //如果有交集则获取交集内id对应的人员有哪些
                if($jiaoji_num){
                    foreach(array_filter($jiaoji) as $k=>$v){
                        $user_sql = "SELECT realname FROM {{%users}} where users_id = :users_id";
                        $realname = Yii::$app->db->createCommand($user_sql,[":users_id"=>$v["users_id"]])->queryAll();
                        foreach($realname as $name ){
                            $str = "  ";
                            $str .= $name["realname"];
                            echo $str;
                        }
                    }
                    exit;
                    //没有交集正常循环插入
                }else{

                    $sql = "SELECT title FROM {{%application}} where app_id = :app_id";
                    $title = Yii::$app->db->createCommand($sql,[":app_id"=>$app_id])->queryOne();
                    foreach ($ids as $users_id){
                        $sql = "INSERT INTO ".Yii::$app->components['db']['tablePrefix']."app_member(users_id,app_id,create_by,app_title) values(:user_id,:app_id,:create_by,:app_title)";
                        $result = Yii::$app->db->createCommand($sql,[":user_id"=>$users_id,":app_id"=>$app_id,":create_by"=>$create_by['create_by'],"app_title"=>$title['title']])->execute();
                    }
                    if ($result !== FALSE) {
                        echo "1";
                    } else {
                        echo false;
                    }
                }
            exit;
        }
        return $this->render('create',[
            'users' => $users,
            'pagination'=>$pagination,
            'all_pages' => $all_pages,
        ]);
    }
    public function actionDelete ()
    {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $app_member_id = $request->get("id");
            $sql = "DELETE FROM  ".Yii::$app->components['db']['tablePrefix']."app_member WHERE app_member_id=:app_member_id";
            $is_ok = Yii::$app->db->createCommand($sql,[":app_member_id"=>$app_member_id])->execute();
            if ($is_ok !== FALSE) {
                echo "1";
            } else {
                echo "0";
            }
        }
        exit;
    }

}