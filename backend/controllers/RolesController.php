<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use backend\controllers\PublicFunction;

/**
 * Roles Controller
 */
class RolesController extends BackendController
{
    public function actionIndex(){
        $sql = "SELECT * FROM {{%roles}} ORDER BY roles_id";
        $query =  Yii::$app->db->createCommand($sql)->queryAll();

        $count = count($query);
        $pagesize = 5;
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
        //var_dump($post['role_name']);exit;
        if(!empty($post)){
            $array=[];
            $array['role']=isset($post['role_name']) ? $post['role_name'] : '';
            $array['description']=isset($post['role_description']) ? $post['role_description'] : '';
            if(empty($post['role_name']) && empty($post['description'])){
                $content = $Public->message('error', '参数为空，不允许添加', "index.php?r=roles/create");
                return $this->renderContent($content);
            }
//            if(empty($post['role_name'])){
//                $content = $Public->message('error', '角色名不能为空', "index.php?r=roles/create");
//                return $this->renderContent($content);
//            }
//            if(empty($post['description'])){
//                $content = $Public->message('error', '角色描述不能为空', "index.php?r=roles/create");
//                return $this->renderContent($content);
//            }
            $array['create_time'] = time();
//            查询数据库中是否已有此角色
            $isset = Yii::$app->db->createCommand("SELECT roles_id FROM {{%roles}} WHERE role='"."$post[role_name]'")->queryOne();
            //var_dump($array);//exit;
            if(empty($isset)){
                $isinsert = Yii::$app->db->createCommand()->insert('{{%roles}}',$array)->execute();
                if($isinsert){
                    $content = $Public->message('success', '添加成功', "index.php?r=roles/index");
                    return $this->renderContent($content);
                }else{
                    $content = $Public->message('error', '添加失败', "index.php?r=roles/index");
                    return $this->renderContent($content);
                }
            }else{
                $content = $Public->message('error', '角色名重复，不允许添加', "index.php?r=roles/index");
                return $this->renderContent($content);
            }

        }
        return $this->render('create');
    }
    public function actionUpdate()
    {
        $Public = new PublicFunction();
        $post = Yii::$app->request->post();
        //var_dump($post);//exit;
        if(!empty($post)){
            $array=[];
            $array['role']=isset($post['role_name']) ? $post['role_name'] : '';
            $array['description']=isset($post['role_description']) ? $post['role_description'] : '';
            $array['create_time'] = time();
            //查询数据库中是否已有此角色
            //$isset = Yii::$app->db->createCommand("SELECT roles_id FROM {{%roles}} WHERE role=".$post['role_name'])->queryOne();
            $isset = Yii::$app->db->createCommand("SELECT roles_id FROM {{%roles}} WHERE role='"."$post[role_name]'")->queryOne();
            //var_dump($array);//exit;
            if(empty($isset)){
                //var_dump($roles_id);exit;
                $isupdate = Yii::$app->db->createCommand()->update('{{%roles}}',$array,"roles_id=".$post['rolesid'])->execute();
                if($isupdate){
                    $content = $Public->message('success', '修改成功', "index.php?r=roles/index");
                    return $this->renderContent($content);
                }else{
                    $content = $Public->message('error', '修改失败', "index.php?r=roles/index");
                    return $this->renderContent($content);
                }
            }else{
                $content = $Public->message('error', '角色名重复，不允许修改', "index.php?r=roles/index");
                return $this->renderContent($content);
            }
        }else{
            $roles_id = Yii::$app->request->get('id');
            //var_dump($roles_id);//exit;
            if(isset($roles_id)){
                $result = Yii::$app->db->createCommand("SELECT * FROM {{%roles}} WHERE roles_id=".$roles_id)->queryOne();
            }

        }

        return $this->render('update',['result'=>$result]);
    }
    public function actionDelete ()
    {
        $Public = new PublicFunction();
        $roles_id = Yii::$app->request->get('id');
        if(!empty($roles_id)){
            $isdel = Yii::$app->db->createCommand()->delete('{{%roles}}','roles_id='.$roles_id)->execute();
            if($isdel){
                $content = $Public->message('success', '删除成功', "index.php?r=roles/index");
                return $this->renderContent($content);
            }else{
                $content = $Public->message('error', '删除失败', "index.php?r=roles/index");
                return $this->renderContent($content);
            }

        }else{
            $content = $Public->message('error', '参数不能为空', "index.php?r=roles/index");
            return $this->renderContent($content);
        }
    }

    public function actionRole_set()
    {

        $roleId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $Public = new PublicFunction();

        if(empty($roleId)){
            $content = $Public->message('error', '未获取到角色ID', "index.php?r=roles/index");
            return $this->renderContent($content);
        }

        $bailitop = Yii::$app->db;
        $roleInfo = $bailitop->createCommand('SELECT * FROM {{%roles}} WHERE `roles_id`=:roles_id',['roles_id'=>$roleId])->queryOne();

        if(empty($roleInfo)){

            $content = $Public->message('error', '角色不存在', "index.php?r=roles/index");
            return $this->renderContent($content);
        }

        $nodesInfo = $bailitop->createCommand('SELECT * FROM {{%nodes}} WHERE `floor`=1 OR  `floor` = 0')->queryAll();
        $sortNodesRes = $this->recursionSortNodes($nodesInfo);
        $accessNodes = $this->getUserAccessNodes($roleId);

        return $this->render('role_set',['nodes' => $sortNodesRes,'roleinfo' => $roleInfo,'accessNodes' => $accessNodes]);
    }


    public function actionRole_save()
    {
        /*
         * 根据需求 点击父节点不统一改变其子节点的访问权限
         * */
        $interface = Yii::$app->db;
        $nodeId = isset($_POST['nodeid']) ? intval($_POST['nodeid']) : 0 ;
        $roleId = isset($_POST['roleid']) ? intval($_POST['roleid']) : 0 ;
        $isSelected = isset($_POST['isSelected']) ? intval($_POST['isSelected']) : 9999 ;
        $errorCode = 0;

        if(!empty($nodeId) || !empty($roleId) || $isSelected !== 9999){

            $filerData = [
                'roles_id'=> $roleId,
                'nodes_id' => $nodeId
            ];
            $isExist = $interface->createCommand('SELECT COUNT(1) AS `count` FROM {{%nodes_roles}} WHERE `roles_id`=:roles_id AND `nodes_id`=:nodes_id',$filerData)->queryOne();

            if($isSelected == 1){

                if(empty($isExist['count'])){

                    $isInsert = $interface->createCommand()->insert('{{%nodes_roles}}',$filerData)->execute();
                }

            } elseif($isSelected == 0) {

                $isdel = $interface->createCommand()->delete('{{%nodes_roles}}',$filerData)->execute();
            }

        }

        echo $errorCode;
        exit;
    }

    /**
     * @param array $data  需要进行分类排序的数组
     * @param int $pid 需要寻找子集的父id
     * @return array
     */
    public function recursionSortNodes($data, $pid = 0)
    {

        $arr = $tem = array();

        foreach ($data as $v) {
            if ($v['pid'] == $pid) {
                $tem = $this->recursionSortNodes($data, $v['nodes_id']);

                // 判断是否存在子数组
                $tem && $v['submenu'] = $tem;
                $arr[] = $v;
            }
        }

        return $arr;
    }

}