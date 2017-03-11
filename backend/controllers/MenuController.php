<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use backend\controllers\PublicFunction;

/**
 * Menu   Controller
 */
class MenuController extends BackendController
{
    public function actionIndex(){
        $id=isset($_GET['id'])?$_GET['id']:0;
        $where = 'where pid='.$id;
        $sql = "SELECT * FROM {{%nodes}}  ".$where." ORDER BY sort desc,floor asc,display desc,path asc";
        $query =  Yii::$app->db->createCommand($sql)->queryAll();

        $count = count($query);
        $pagesize = 10;

        $pagination = new Pagination([
            'defaultPageSize'=>$pagesize,
            'totalCount' =>$count,
        ]);
        $all_pages =  ceil($count/$pagesize);
        $list = Yii::$app->db->createCommand($sql." limit ".$pagination->limit." offset ".$pagination->offset."")->queryAll();
        return $this->render('index',[
            'list' => $list,
            'pagination'=>$pagination,
            'all_pages' => $all_pages,
        ]);
    }
    public function actionCreate(){
        $Public = new PublicFunction();
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();
        $titles = Yii::$app->db->createCommand("SELECT title,nodes_id,path FROM {{%nodes}} ORDER BY path ASC")->queryAll();

        if(!empty($post)) {
            $data['title'] = isset($post['title']) ? $post['title'] : '';
            $data['pid'] = isset($post['pid']) ? $post['pid'] : '';  //需要判断是否选择了pid
            $data['controller'] = isset($post['controller']) ? $post['controller'] : '';
            $data['action'] = isset($post['action']) ? $post['action'] : '';
            $data['floor'] = isset($post['floor']) ? $post['floor'] : '';
            $data['display'] = isset($post['display']) ? $post['display'] : '1';
            if (isset($data['controller']) && isset($data['action']) && isset($data['pid'])) {
                //查询是否有此菜单，或者说避免重复插入
                $isset = Yii::$app->db->createCommand("SELECT nodes_id FROM {{%nodes}} WHERE title='"."$data[title]'")->queryOne();
                if(empty($isset)){
                    //插入一条数据
                    $isinsert = Yii::$app->db->createCommand()->insert('{{%nodes}}',$data)->execute();
                    //新添加菜单的id
                    $nodesid = Yii::$app->db->getLastInsertID();

                    if($data['pid'] == 0){
                        $data['path'] = $nodesid;
                    }else{
                        //根据选择的上级id 取出一条数据，根据上级path 拼接当前新添加菜单的path
                        $menu = Yii::$app->db->createCommand("SELECT path FROM {{%nodes}} WHERE nodes_id=".$data['pid'])->queryOne();
                        $data['path'] = $menu['path'].'-'.$nodesid;
                    }
                    //根据最后一条插入数据更新path
                    $isupdate = Yii::$app->db->createCommand("update {{%nodes}} SET path='"."$data[path]'"." WHERE nodes_id=".$nodesid)->execute();
                    if($isupdate){
                        $content = $Public->message('success', '添加成功', "index.php?r=menu/index");
                        return $this->renderContent($content);

                    }else{
                        $content = $Public->message('error', '添加失败', "index.php?r=menu/index");
                        return $this->renderContent($content);
                    }
                }else{
                    $content = $Public->message('error', '添加菜单重命名', "index.php?r=menu/index");
                    return $this->renderContent($content);
                }
            } else {
                $content = $Public->message('error', '参数不正确', "index.php?r=menu/index");
                return $this->renderContent($content);
            }
        }elseif(!empty($get['id'])){
            //添加子菜单,父级默认选中
            $nodes_id = $get['id'];
            $data = array('titles'=>$titles,'nodes_id'=>$nodes_id);
        }else{
            $data = array('titles'=>$titles);
        }
        return $this->render('create',$data);
    }


    public function actionUpdate()
    {
        $Public = new PublicFunction();
        $get = Yii::$app->request->get();
        $post = Yii::$app->request->post();
        //保存数据
        if(!empty($post)){
            //var_dump($post);exit;
            $nodes_id = isset($post['nodes_id']) ?  intval($post['nodes_id']) : '';
            $data['title'] = isset($post['title']) ? rtrim($post['title']) : '';
            $data['pid'] = isset($post['pid']) ?  intval($post['pid']) : '';  //需要判断是否选择了pid
            $data['controller'] = isset($post['controller']) ? rtrim($post['controller']) : '';
            $data['action'] = isset($post['action']) ? rtrim($post['action']) : '';
            $data['floor'] = isset($post['floor']) ? $post['floor'] : '';
            $data['display'] = isset($post['display']) ? $post['display'] : '1';

            if($data['pid'] == 0){
                $data['path'] = $nodes_id;
            }else{
                //根据选择的上级id 取出一条数据，根据上级path 拼接当前新添加菜单的path
                $menu = Yii::$app->db->createCommand("SELECT path FROM {{%nodes}} WHERE nodes_id=".$data['pid'])->queryOne();
                $data['path'] = $menu['path'].'-'.$nodes_id;
            }

            $isupdate = Yii::$app->db->createCommand()->update('{{%nodes}}',$data,"nodes_id=".$nodes_id)->execute();
            if($isupdate){
                $content = $Public->message('success', '更新成功', "index.php?r=menu/index");
                return $this->renderContent($content);
            }else{
                $content = $Public->message('error', '更新失败', "index.php?r=menu/index");
                return $this->renderContent($content);
            }
        }elseif(!empty($get)) {  //显示数据
            $nodes_id = isset($get['id']) ? trim($get['id']) : '';
            $data = Yii::$app->db->createCommand("SELECT * FROM {{%nodes}} WHERE nodes_id=".$nodes_id)->queryOne();
            $titles = Yii::$app->db->createCommand("SELECT title,nodes_id,path FROM {{%nodes}} ORDER BY path ASC")->queryAll();
        }
        return $this->render('update',[
            'titles' => $titles,
            'data' => $data,
        ]);
    }
    public function actionDelete ()
    {
        $Public = new PublicFunction();

        //删除，首先要判断一下是否在此菜单下有没有子菜单。有子菜单的话。必须删除后才能删除
        $nodes_id = Yii::$app->request->get('id');
        if(!empty($nodes_id)){
            //去数据库查有没有父pid 等于 $nodes_id的
            $isok = Yii::$app->db->createCommand("SELECT nodes_id FROM {{%nodes}} WHERE pid=".$nodes_id)->queryOne();
            if($isok){
                $content = $Public->message('error', '该菜单下有子菜单,请先删除子菜单', "index.php?r=menu/index");
                return $this->renderContent($content);
            }else{
                $isdel = Yii::$app->db->createCommand()->delete('{{%nodes}}','nodes_id='.$nodes_id)->execute();
                if($isdel){
                    $content = $Public->message('success', '删除成功', "index.php?r=menu/index");
                    return $this->renderContent($content);
                }else{
                    $content = $Public->message('error', '删除失败', "index.php?r=menu/index");
                    return $this->renderContent($content);
                }
            }
        }else{
            $content = $Public->message('error', '参数不能为空', "index.php?r=menu/index");
            return $this->renderContent($content);
        }
    }

    public function actionSort(){
        $Public = new PublicFunction();

        $sort=Yii::$app->request->post('sort');
        $status=0;
        foreach($sort as $key =>$value){
            $update_sort=Yii::$app->db->createCommand('update {{%nodes}} set `sort`='.$value.' where `nodes_id`='.$key)->execute();
            if($update_sort){
                $status=1;
            }
        }

        if($status==0){
            $content = $Public->message('error', '排序失败', Yii::$app->request->referrer);
            return $this->renderContent($content);
        }else{
            $content = $Public->message('success', '排序成功', Yii::$app->request->referrer);
            return $this->renderContent($content);
        }
    }

}