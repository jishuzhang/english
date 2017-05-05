<?php
/**
 * Created by PhpStorm.
 * User: su
 * Date: 2017-3-18
 * Time: 16:43
 */
namespace backend\controllers;

use common\models\Admin;
use common\models\ExamQuestions;
use Yii;
use yii\db\Exception;
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

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view',[
            'model' => $model,
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
                'model' => $model
            ]);
        }

    }

    public function actionDelete($id)
    {
        $tid = $id;

        Test::deleteAll(['id'=>$tid]);
        Yii::$app->getSession()->setFlash('success','删除成功');
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionActivate($id)
    {
        $tid = $id;

        // 查询该调查的配置信息
        $test = Test::findOne($tid);

        if(empty($test) || $test->status == 1){
            Yii::$app->getSession()->setFlash('error','该试卷不存在或者已经被启用');
            return $this->redirect(Yii::$app->request->getReferrer());
        }

        // 查询该调查中包含的问题
        $questionList = ExamQuestions ::find()->where(['tid' => $tid])->indexBy('id')->asArray()->all();

        if(empty($questionList)){
            Yii::$app->getSession()->setFlash('error','您还没有为该试卷添加考题,请编辑该试卷,添加考题后启用');
            return  $this->redirect(Yii::$app->request->getReferrer());
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
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function actionDeactivate($id)
    {
        $surveyId = $id;

        // 查询该调查的配置信息
        $surveyConfig = Test::findOne($surveyId);

        if(empty($surveyConfig) || $surveyConfig->status == 0){
            Yii::$app->getSession()->setFlash('error','该试卷不存在或者已经被禁用');
            return $this->redirect(Yii::$app->request->getReferrer());
        }

        // 先更新该调查的启用状态 禁止其它与该调查相关的操作
        $surveyConfig->status = 0;
        $surveyConfig->save();


        $dataSuffixes = date('YmdHis',time());

        $oldTableName = $surveyConfig->answer_table;
        $newTableName = 'old_'.$oldTableName.'_'.$dataSuffixes;
        $this->renameTable($this->addTablePrefix($oldTableName),$this->addTablePrefix($newTableName));

        Yii::$app->getSession()->setFlash('success','试卷禁止成功');
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    public function getCommonField()
    {
        return [
            'id' => 'INT UNSIGNED AUTO_INCREMENT PRIMARY KEY',//  新建表后 主键id 都是从新增长
            'uid' => 'INT UNSIGNED DEFAULT 0',
            'username' => 'CHAR(64) NULL DEFAULT NULL',
            'submit_time' => 'INT(11) NULL DEFAULT NULL', // 提交时间
            'mark_time' => 'INT(11) NULL DEFAULT NULL', // 判卷时间
            'm_state' => 'TINYINT UNSIGNED NULL DEFAULT 0', // 答卷审核状态  0 未审核 1 已审核
            'm_record' => 'TEXT', // 序列化存储 题目正确记录
        ];

        //        $lcs = new LCS();
//        echo $lcs->getLCS("hello word","hello china word"); //返回最长公共子序列
//        echo $lcs->getSimilar("吉林禽业公司火灾已致112人遇难","吉林宝源丰禽业公司火灾已致112人遇难"); //返回相似度
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

        if ($model->load(Yii::$app->request->post())) {

            $user = Admin::findOne(['userid'=>Yii::$app->user->id]);
            $model->author = $user->username;
            $model->time_lock = empty($model->time_lock) ? 0 : $model->time_lock ;
            $model->last_modfiy_time = time();

            if($model->save()){
                Yii::$app->getSession()->setFlash('success','更新成功');
            }else{
                Yii::$app->getSession()->setFlash('success','更新失败');
            }


            return $this->redirect(Yii::$app->request->getReferrer());
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

        return $this->redirect(Yii::$app->request->getReferrer());

    }

    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 为表名添加前缀
     * @param int $tableName
     * @return string
     */
    public function addTablePrefix($tableName = 0)
    {
        if(empty($tableName)){
            return '';
        }

        return "{{%$tableName}}";
    }

    /**
     * 重命名表
     * @param $old 现有表名
     * @param $new 需要更新成为的表名
     * @return bool
     * @throws \yii\db\Exception
     */
    public function renameTable($old,$new)
    {
        if(empty($old) || empty($new)){
            return false;
        } else {
            try{

                $sql = 'RENAME TABLE '.$old.' TO '.$new;
                Yii::$app->english->createCommand($sql)->execute();
            }catch(\Exception $e){
                throw new Exception('无法重命名答案表,请联系技术人员查看数据库');
            }

        }

        return true;
    }

    /**
     * 问题类型 与 建表语句映射关系表
     * @return array
     */
    public function getQuestionTypeList()
    {
        return [
            // 整型
            'tinyint' => ' TINYINT UNSIGNED   DEFAULT 0',
            'smallint' => ' SMALLINT UNSIGNED   DEFAULT 0',
            'mediumint' => ' MEDIUMINT UNSIGNED   DEFAULT 0',
            'int'=> ' INT UNSIGNED   DEFAULT 0',
            'bigint' => ' BIGINT UNSIGNED   DEFAULT 0',

            // 浮点型
            'float'=> 'FLOAT   DEFAULT 0.00',
            'decimal'=> 'DECIMAL(10,2)   DEFAULT 0.00',

            // 字符型
            'char' => 'CHAR(255)   DEFAULT 0',
            'varchar' => 'CHAR(50)   DEFAULT 0',
            'text'=> 'TEXT  ',
        ];
    }
}