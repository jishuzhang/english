<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-3-13
 * Time: 18:13
 */
namespace frontend\controllers;

use common\models\ExamQuestions;
use common\models\Score;
use common\models\Test;
use yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\Pagination;
use common\models\Translate;
use common\library\LCS;
use yii\web\Response;
use frontend\models\User;

class ExamController extends Controller
{
    public $layout = "main";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];

    }

    public function beforeAction($action)
    {
        parent::beforeAction($action);

        if (in_array($this->action->id, array('show', 'mark-paper', 'signup'))) {
            if(Yii::$app->user->isGuest)
            {
                return $this->redirect(['site/login']);
            }
        }

        return true;
    }

    public function actionList()
    {
        $data = Test::find()->orderBy('id DESC');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('list',[
            'model' => $model,
            'pages' => $pages
        ]);
    }

    public function actionShow()
    {
        $examId = Yii::$app->request->get('tid');

        if(empty($examId))
        {
            Yii::$app->getSession()->setFlash('error', '未检索到该试卷的相关信息');
            return $this->redirect(Yii::$app->request->getReferrer());
        }

        Yii::$app->session->open();
        Yii::$app->session->set('exam_id',$examId);
        $test = Test::findOne(['id'=>$examId,'status' => 1]);
        $questions = ExamQuestions::find()->where(['tid'=>$examId])->orderBy('id')->asArray()->all();

        if(empty($test))
        {
            return $this->redirect(Yii::$app->request->getReferrer());
        }

        return $this->renderPartial('show',[
            'question' => $questions,
            'examId' => $examId,
            'test' => $test
        ]);
    }


    public function actionMarkPaper()
    {

        if(Yii::$app->user->isGuest){
            return $this->redirect('site/login');
        }

        $uid = Yii::$app->user->id;
        Yii::$app->session->open();
        $tid = Yii::$app->session->get('exam_id');
        Yii::$app->session->remove('exam_id');

        if(empty($tid))
        {
            throw new yii\web\BadRequestHttpException('参数缺失');
        }

        $answers = Yii::$app->request->post('exam');

        if(Yii::$app->request->isPost && !empty($tid))
        {
            $questions = ExamQuestions::find()->where(['tid'=>$tid])->orderBy('id')->indexBy('id')->asArray()->all();
            $test = Test::findOne(['id' => $tid]);
            $tableName = $test->answer_table;
            $columns = array();
            $scoreCount = 0;

            foreach($answers as $i => $v) {

                preg_match('/\d+/',$i,$r);
                $columnName = ExamQuestions::genColumnName($tid,$r[0]);
                $columns[$columnName] = $v;

                // 打分
                $scoreCount += (ExamQuestions::generateIndexCode($v) == $questions[$r[0]]['q_answer_code']) ? $questions[$r[0]]['q_score'] : 0 ;

            }

            // 存储答案
            $user = User::findIdentity($uid);
            $commonCol['uid'] = $uid;
            $commonCol['username'] = $user->username;
            $commonCol['submit_time'] = time();
            $commonCol['mark_time'] = time();
            $commonCol['m_state'] = 1;

            $inserts = array_merge($columns,$commonCol);
            $valueName = implode(',',array_keys($inserts));
            $values = array_values($inserts);

            $valueStr = '';
            foreach($values as $v)
            {
                $valueStr .= "'".$v."',";
            }

            $valueStr = trim($valueStr,',');

            $answerRecord = Yii::$app->english->createCommand('INSERT INTO '.$this->addTablePrefix($tableName).' ('.$valueName.') VALUES('.$valueStr.')')->execute();
            $aid = Yii::$app->english->getLastInsertID();
            // 记录分数
            if($answerRecord)
            {
                $scoreModel = new Score();

                $scoreModel->tid = $tid;
                $scoreModel->uid = $uid;
                $scoreModel->score = $scoreCount;
                $scoreModel->aid = $aid;

                $scoreModel->save();
            }

        }
        else
        {
            return $this->redirect(['exam/list']);
        }

        // show mark
    }


    /**
     * 启用调查
     * @param int $id
     * @throws \yii\db\Exception
     */
    public function actionActivate($id)
    {
        $tid = $id;

        // 查询该调查的配置信息
        $test = Test::findOne($tid);

        if(empty($test) || $test->status == 1){
            $this->returnPromptInfo(1);
        }

        // 查询该调查中包含的问题
        $questionList = ExamQuestions ::find()->where(['tid' => $tid])->indexBy('id')->asArray()->all();

        if(empty($questionList)){
            $this->returnPromptInfo(3);
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
        }catch(yii\db\Exception $e){
            throw new yii\db\Exception('答案表无法创建,请联系技术人员');
        }

        // 启用成功
        $this->returnPromptInfo(0);
    }

    public function actionDealsurvey()
    {
        $surveyId = Yii::$app->request->post("sid");
        $isActivate = Yii::$app->request->post("activate");

        if($isActivate  == 1){
            $this->actionActivate($surveyId);
        } elseif($isActivate  == 0) {
            $this->actionDeactivate($surveyId);
        }
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
        ];

        //        $lcs = new LCS();
//        echo $lcs->getLCS("hello word","hello china word"); //返回最长公共子序列
//        echo $lcs->getSimilar("吉林禽业公司火灾已致112人遇难","吉林宝源丰禽业公司火灾已致112人遇难"); //返回相似度
    }

    /**
     * 禁止调查
     */
    public function actionDeactivate($id = 0)
    {
        $surveyId = $id;

        // 查询该调查的配置信息
        $surveyConfig = Surveys::findOne($surveyId);


        if(empty($surveyConfig) || $surveyConfig->survey_status == 0){
            $this->returnPromptInfo(4);
        }

        // 检查该调查是否为多项调查
        if($surveyConfig->more_surveys == 1){
            $subSurvey = Surveystype::find()->where(['sid' => $surveyId])->asArray()->all();
        }else{
            $subSurvey = array();
        }

        // 先更新该调查的启用状态 禁止其它与该调查相关的操作
        Yii::$app->db->createCommand()->update('{{%surveys}}', ['survey_status' => 0], 'sid = '.$surveyId)->execute();


        $dataSuffixes = date('YmdHis',time());

        if(!empty($subSurvey)){

            foreach($subSurvey as $evSubSurvey){

                // 为多项调查的子调查表进行单独存档
                $oldTableName = 'survey_'.$surveyId.'_'.$evSubSurvey['stid'];
                $newTableName = 'old_'.$oldTableName.'_'.$dataSuffixes;
                $res = $this->renameTable($this->addTablePrefix($oldTableName),$this->addTablePrefix($newTableName));
                $this->recordEndUsing($oldTableName,$newTableName);
            }

        }else{

            $oldTableName = 'survey_'.$surveyId;
            $newTableName = 'old_'.$oldTableName.'_'.$dataSuffixes;
            $res = $this->renameTable($this->addTablePrefix($oldTableName),$this->addTablePrefix($newTableName));
            $this->recordEndUsing($oldTableName,$newTableName);
        }


        if($res){
            $this->returnPromptInfo(0);
        } else {
            $this->returnPromptInfo(5);
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
            $sql = 'RENAME TABLE '.$old.' TO '.$new;
            Yii::$app->db->createCommand($sql)->execute();
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

    public function returnPromptInfo($num = 0)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $infoArr = [
            '更新成功',
            '调查不存在或者已启用',
            '已禁止',
            '该调查下还未添加问题,无法启用',
            '该调查不存在或者已被禁止',
            '发生未知错误,请联系管理员'
        ];

        $message = [
            'errorCode' => $num,
            'errorMessage' => $infoArr[$num]
        ];

        var_dump($message);exit;
    }

    public function recordStartUsing($surveyId,$stid = '')
    {
        $recordModel = new Survey_Model();

        $tableName = 'survey_'.$surveyId;
        $tableName .= empty($stid) ? '' : '_'.$stid;

        $recordModel->sid = $surveyId;
        $recordModel->stid = $stid;
        $recordModel->starttablename = $tableName;
        $recordModel->endtablename = '';
        $recordModel->starttime = time();
        $recordModel->endtime = 0;
        $recordModel->userid = Yii::$app->user->identity->userid;
        $recordModel->username = Yii::$app->user->identity->username;

        $recordModel->save();
    }

    public function recordEndUsing($oldName,$newName)
    {
        //  以最新启用 调查 为更新对象
        $recordModel = Survey_Model::find()->where("starttablename='$oldName'")->andWhere("endtablename=0")->andWhere("endtime=0")->orderby('id DESC')->one();

        $recordModel->endtablename = $newName;
        $recordModel->endtime = time();
        $recordModel->userid = Yii::$app->user->identity->userid;
        $recordModel->username = Yii::$app->user->identity->username;
        $recordModel->update();
    }
}

