<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use backend\controllers\PublicFunction;
use common\models\User;
use yii\filters\VerbFilter;
use backend\models\OpprationLog;
use common\library\MenuCache;

class BackendController extends Controller
{
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $Public = new PublicFunction();
        $this->url_opp();
        //return true;
        $interface = Yii::$app->db;
        //对url增加参数

        // ACL 只控制应用外部节点 floor  =  1 或者 0
        $allControlLists = $interface->createCommand('SELECT `controller`,`action` FROM {{%nodes}}')->queryAll();
        foreach($allControlLists as $evController){
            $accessControlLists[$evController['controller']][] = $evController['action'];
        }


        //如果我当前访问的url在floor等于2的结果集中，有就走应用的权限
        $app_nodes_res = Yii::$app->db->createCommand('SELECT `nodes_id` FROM {{%nodes}} WHERE `floor`=2 and `pid` != 0')->queryAll();

        //当前控制器，方法
        $controllerID = Yii::$app->controller->id;
        $actionID = Yii::$app->controller->action->id;

        //单个id
        $nodes_data = Yii::$app->db->createCommand('SELECT `nodes_id` FROM {{%nodes}} WHERE `controller`= :c AND `action`=:a and( `floor`=2 and `pid` != 0)',[':c'=>$controllerID,':a'=>$actionID])->queryOne();

        $app_id = Yii::$app->request->get('app_id');

        //把应用  app_id 存入session
        if(!empty($app_id)){
            $_SESSION['app_id'] = Yii::$app->request->get('app_id');
        }

        // 对需要进行访问控制的资源进行权限判断  超级管理员除外
        if(!empty(Yii::$app->user->identity->roleid)){
            if(Yii::$app->user->identity->roleid == 1 || empty(Yii::$app->user->identity->roleid)){
                return true;
            }else{
                if(array_key_exists($action->controller->id,$accessControlLists) && in_array($action->id,$accessControlLists[$action->controller->id])){
                    if($this->checkPermission(Yii::$app->user->identity->roleid,$action->controller->id,$action->id)){
                        return true;
                    }else if($this->App_permission($controllerID,$nodes_data)){
                        return true;
                    }else{
                        $content = $Public->message('error', '禁止访问');
                        echo $content;
                    }
                }
            }
        }else{
            return $this->redirect(['site/login']);
        }
        //$this->redirect([''.Yii::$app->requestedRoute.'','top'=>$p_param['pid'],'path'=>$p_param['path']]);


    }

    final protected function checkPermission($roleId = 0,$routeController = '',$routeAction = '')
    {
        if(empty($roleId)){
            return false;
        }

        $interface = Yii::$app->db;
        $accessGroup = $this->getUserAccessNodes($roleId);

        // 根据 route 解析出 controller action
        if(empty($routeController) && empty($routeAction)){
            list($routeController,$routeAction) = explode('/',trim($_GET['r']));
        }

        // 根据路由取得当前访问节点 id
        $routeNode = $interface->createCommand('SELECT `nodes_id` FROM {{%nodes}} WHERE `controller`=:controller AND `action`=:action and (`floor`=1 OR `floor`=0)',['controller'=>$routeController,'action'=>$routeAction])->queryOne();
        $routeNode = $routeNode['nodes_id'];

        return in_array($routeNode,$accessGroup) ? true : false ;
    }

    final protected function getUserAccessNodes($roleId = 0)
    {
        if(empty($roleId)){
            return array();
        }

        $interface = Yii::$app->db;

        // 获取用户所属角色可访问节点列表
        $accessNodes = $interface->createCommand('SELECT DISTINCT `nodes_id` FROM {{%nodes_roles}} WHERE roles_id=:roles_id',['roles_id'=>$roleId])->queryAll();
        $accessGroup = $this->ArrayColumn($accessNodes,'nodes_id');

        return $accessGroup;
    }
    //处理url
    private function url_opp() {
        $session = Yii::$app->session;
        //获取对应的栏目id号
        $refferroute = Yii::$app->request->referrer;
        $_referrer = parse_url($refferroute);//?
        $route = Yii::$app->requestedRoute;//c+a
        if(!empty(Yii::$app->user->identity)){
            $this->logs();
            return true;
        } else{
            return $this->redirect(['site/login']);
        }
    }

    /**
     * 写入管理员日志,并判权限
     * @return
     */
    final private function logs() {

        $model = new OpprationLog();
        $session = Yii::$app->session;
        $mc = $this->CheckUrl();
        //var_dump($mc);
        $str = Yii::$app->request->queryParams;//c+a
        $mc1 = implode("/",$str);
        //var_dump($str);//exit;
        $model->users_id = Yii::$app->user->identity->users_id;
        $model->m = $mc[0];
        $model->c= $mc[1];
        date_default_timezone_set('PRC'); // 中国时区
        $model->action =$mc1;
        //$model->content =$mc1;
        $model->content ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
        $model->oppration_time =time();
        $model->insert();
    }

    /**
     * 拆分url
     * @return string
     */
    public function CheckUrl(){
        $str = Yii::$app->requestedRoute;//c+a
        $mc = explode("/",$str);
        return  $mc;

    }

    /**
     *  应用权限控制，获取当前url中控制器，方法的值，到nodes 节点表中查询
     */

    public function App_permission($controllerID,$nodes_data){

        header("Content-type: text/html; charset=utf-8");
        $Public = new PublicFunction();

        $app_id = $_SESSION['app_id'];

        $nodes_id = $nodes_data['nodes_id'];

        //当前用户id
        $users_id = yii::$app->user->identity->id;

        //查询有没有这个应用的权限  ,,如果是create_by 有全部权限
        $sql2 = 'SELECT * FROM {{%app_member}} WHERE app_id=:app_id ORDER BY create_by DESC';
        $app_member = Yii::$app->db->createCommand($sql2,[':app_id'=>$app_id])->queryAll();

        if(!empty($app_member)){

            //创建者拥有所有权限
            foreach($app_member as $value){
                if($value['create_by'] === $users_id && $value['users_id'] === $users_id){
                    return true;
                }else{

                    //用户组
                    foreach($app_member as $value){
                        $users[] = $value['users_id'];
                    }
                    //当前用户在用户组中
                    if(in_array($users_id,$users) !== false){

                        //查询user_app_nodes取出其权限id ,当前用户，当前应用
                        $sql3 = 'SELECT nodes_id FROM {{%user_app_nodes}} WHERE users_id=:users_id AND app_id=:app_id';
                        $node_data = Yii::$app->db->createCommand($sql3,['users_id'=>$users_id,'app_id'=>$app_id])->queryAll();

                        //记录2层节点
                        $node_data=$this->ArrayColumn($node_data,'nodes_id');


                        if($node_data && in_array($nodes_id,$node_data)){
                            return true;
                        }else{
                            if($controllerID == 'apiajax'){
                                echo 4;exit();
                            }
                           return false;
                        }
                    }else{
                        if($controllerID == 'apiajax'){
                            echo 4;exit();
                        }
                        return false;
                    }
                }
            }

        }else{
            if($controllerID == 'apiajax'){
                 echo 4;exit();
            }
            return false;
        }
    }



    /**
     * 二维数组-》一维数组
     * @param $array array() 二维数组
     * @param $keyword string 需要的value值
     * @param $key   string  根据key值作为一维数组的索引 可不写
     * @return array() 一维数组
     */

    function ArrayColumn($array,$keyword,$key=''){
        foreach($array as $k=>$v){
            if($key){
                $array[$v[$key]]=$v[$keyword];
                unset($array[$k]);
            }else{
                $array[$k]=$v[$keyword];
            }
        }
        return $array;
    }
}