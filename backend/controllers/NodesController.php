<?php

namespace backend\controllers;

use Yii;
use backend\models\Nodes;
use backend\models\NodesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\assets\Tree;
use backend\controllers\PublicFunction;
use backend\controllers\BackendController;

/**
 * NodesController implements the CRUD actions for Nodes model.
 * 
 * @author mengbaoqing
 */
class NodesController extends BackendController
{
    /**
     * Lists all Nodes models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new NodesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if(Yii::$app->request->get('pid')){
            $pid = Yii::$app->request->get('pid');
        }else{
            $pid = 0;
        }
       
        $nodesdatas = Nodes::find()->where(['pid' => $pid])->orderBy('listorder ASC, nodeid ASC')->all();
        return $this->renderPartial('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'nodesdatas' => $nodesdatas,
        ]);
    }

    /**
     * Displays a single Nodes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Nodes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Nodes();
        $model->display = 1;
        $model->listorder = 0;
        
        $datas=$this->actionGetcates();

        if ($model->load(Yii::$app->request->post())) {
            if($model->pid!=0){
                $pdata = Nodes::findOne($model->pid);
                $model->path = $pdata->path."_".$model->pid;
            }
            if($model->save()){
//            return $this->redirect(['index', 'pid' => $model->pid]);
                $Function = new PublicFunction();  
                $view = $Function->message('success', '添加成功', 'index.php?r=nodes/index&pid='.$model->pid);  //获取提示信息
                $layoutFile = $this->findLayoutFile($this->getView());                         //查找布局文件
                return $this->getView()->renderFile($layoutFile, ['content' => $view], $this); //提示信息并跳转到视图页面index
            }
        } else {
            return $this->renderPartial('create', [
                'model' => $model,
                'datas' =>$datas,
            ]);
        }
    }

    /**
     * Updates an existing Nodes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $datas=$this->actionGetcates();

        if ($model->load(Yii::$app->request->post())) {
            if($model->pid!=0){
                $pdata = Nodes::findOne($model->pid);
                $model->path = $pdata->path."_".$model->pid;
            }
            if($model->save()){
//            return $this->redirect(['index', 'pid' => $model->pid]);
                $Function = new PublicFunction();  
                $view = $Function->message('success', '修改成功', 'index.php?r=nodes/index&pid='.$model->pid);  //获取提示信息
                $layoutFile = $this->findLayoutFile($this->getView());                         //查找布局文件
                return $this->getView()->renderFile($layoutFile, ['content' => $view], $this); //提示信息并跳转到视图页面index
            }
        } else {
            return $this->renderPartial('update', [
                'model' => $model,
                'datas' =>$datas,
            ]);
        }
    }

    /**
     * Deletes an existing Nodes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {   //防止误删
		if(empty(Yii::$app->user->identity)){
			 return $this->redirect(['site/login']);		 
		}
        $model = $this->findModel($id);
        $pid = $model->pid;
        $model->delete();

        return $this->redirect(['index', 'pid'=>$pid]);
    }

    /**
     * Finds the Nodes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nodes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nodes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGetcates($pid=0){
        $cates = Nodes::find()->where(['pid' => $pid])->all();
        if(empty($cates)){
                return;
        }
        //遍历分类
        foreach($cates as $key=>$value){
                $temp['nodeid'] = $value['nodeid'];
                $c = count(explode('_',$value['path']));
                $temp['title'] = str_repeat('　　',$c-1).$value['title'];
                $temp['pid'] = $value['pid'];
                $temp['path'] = $value['path'];
                $temp['sub'] = $this->actionGetcates($temp['nodeid']);
                $arr[]=$temp;
        }
        return $arr;
    }
    
    /**
     * 排序
     */
    public function actionListorder(){
        $model = new Nodes;
        $array =  Yii::$app->request->post();
        $pid = $array['pid'];
        $listorders = $array['listorder'];
        foreach($listorders as $key=>$value){
            $node_model = $this->findModel($key);
            $node_model->listorder = $value;
            $node_model->save();
        }
//        return $this->redirect(['index', 'pid'=>$pid]);
        $Function = new PublicFunction();  
        $view = $Function->message('success', '排序成功', 'index.php?r=nodes/index&pid='.$pid);  //获取提示信息
        $layoutFile = $this->findLayoutFile($this->getView());                         //查找布局文件
        return $this->getView()->renderFile($layoutFile, ['content' => $view], $this); //提示信息并跳转到视图页面index
     }
}
