<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2017-3-18
 * Time: 16:43
 */
namespace backend\controllers;

use backend\models\DialogueForm;
use common\models\ExamQuestions;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Test;
use yii\web\NotFoundHttpException;


class ExamController extends Controller
{
    public function actionIndex()
    {
        $data = Test::find()->orderBy('id DESC');

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index',[
            'model' => $model,
            'pages' => $pages
        ]);

    }


    public function actionCreate()
    {
        $model = new Test();

        if($model->load(Yii::$app->request->post()) && $model->validate()){

            $model->recordTest();

            Yii::$app->getSession()->setFlash('success','添加考卷成功');
            return $this->redirect(['exam/update','id' => $model->id]);
        }
        else
        {
            return $this->render('create',[
                'model' => $model,
                'isNew' => isset($model->id) ? true : false ,
            ]);
        }



    }


    public function actionActivate($id)
    {
        $tid = $id;

        // 查询该调查的配置信息
        $test = Test::findOne($tid);

        if(empty($test) || $test->status == 1){
            Yii::$app->getSession()->setFlash('error','该试卷不存在或者已经被启用');
            $this->redirect(Yii::$app->request->getReferrer());
        }

        // 查询该调查中包含的问题
        $questionList = ExamQuestions ::find()->where(['tid' => $tid])->indexBy('id')->asArray()->all();

        if(empty($questionList)){
            Yii::$app->getSession()->setFlash('error','您还没有为该试卷添加考题,请编辑该试卷,添加考题后启用');
            $this->redirect(Yii::$app->request->getReferrer());
        }

        // 先更新该调查启用状态 禁止其它与该表相关的操作 预防并发
        $answer_table = 'answer_'.$tid;
        $test->status = 1;
        $test->answer_table = $answer_table;
        $test->save();

        $tableName = $this->addTablePrefix($answer_table);

        $sql = 'CREATE TABLE IF NOT EXISTS '.$tableName.'(';

        // 添加常规字段
        foreach($this->getCommonField() as $commonFieldName => $typeDescription){
            $sql .= $commonFieldName.' '.$typeDescription.',';
        }

        foreach($questionList as $evQuestion){
            // $fieldName = '`'.$tid.'X'.$evQuestion['gid'].'X'.$evQuestion['id'].'`';  添加问题分组的时候可以使用
            $fieldName = '`t'.$tid.'Xq'.$evQuestion['id'].'`';
            $sql .= $fieldName.' VARCHAR(255) NULL DEFAULT NULL,';
        }

        // 去除最后一行多余的 逗号
        $sql = rtrim($sql,',');
        $sql .= ") COLLATE='utf8_general_ci' ENGINE=MyISAM;";

        try{
            Yii::$app->get('english')->createCommand($sql)->execute();
        }catch(\Exception $e){
            throw new \Exception('答案表无法创建,请联系技术人员');
        }

        Yii::$app->getSession()->setFlash('success','启用试卷成功,该试卷已投入使用');
        $this->redirect(Yii::$app->request->getReferrer());
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $question = ExamQuestions::find()->where(['tid'=>$id])->orderBy('q_number DESC')->all();
        $order = 0;

        foreach($question as $q)
        {
            $order = $order <= $q->q_number ? $q->q_number : $order;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //

        } else {


            return $this->render('update', [
                'model' => $model,
                'question' => $question,
                'next_number' => $order,
            ]);

        }

    }

    public function actionAddQuestion()
    {
        $model = new ExamQuestions();
        $post = Yii::$app->request->post();

        $tModel = $this->findModel($post['tid']);

        $model->tid = $post['tid'];
        $model->q_number = $post['number'];
        $model->q_score =$post['score'];
        $model->q_name = $post['name'];
        $model->q_answer = $post['answer'];

        // 汉译英 生成答案索引码
        if($tModel->time_lock == 1)
        {
            $model->q_answer_code = ExamQuestions::generateIndexCode($model->q_answer);
        }

        if($model->save())
        {
            Yii::$app->getSession()->setFlash('success','添加成功');
        }
        else
        {
            $error = $model->getFirstErrors();
            Yii::$app->getSession()->setFlash('error',current($error));
        };

        $this->redirect(Yii::$app->request->getReferrer());

    }
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}