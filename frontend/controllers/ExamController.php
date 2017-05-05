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
        $data = Test::find()->where(['status'=>1])->orderBy('id DESC');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('list',[
            'model' => $model,
            'pages' => $pages
        ]);
    }

    public function actionShow($id)
    {
        $examId = $id;

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
            Yii::$app->getSession()->setFlash('error', '该试卷未投入使用,敬请期待');
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
//        Yii::$app->session->open();
//        $tid = Yii::$app->session->get('exam_id');
//        Yii::$app->session->remove('exam_id');
        $tid = 11;
        if(empty($tid))
        {
            return $this->redirect('exam/list');//throw new yii\web\BadRequestHttpException('参数缺失');
        }

        $answers = Yii::$app->request->post('exam');

        if(Yii::$app->request->isPost && !empty($tid))
        {
            $questions = ExamQuestions::find()->where(['tid'=>$tid])->orderBy('id')->indexBy('id')->asArray()->all();
            $test = Test::findOne(['id' => $tid]);
            $tableName = $test->answer_table;
            $columns = array();
            $isRight = array();
            $scoreCount = 0;

            foreach($answers as $i => $v) {

                preg_match('/\d+/',$i,$r);
                $columnName = ExamQuestions::genColumnName($tid,$r[0]);
                $columns[$columnName] = $v;

                // 打分
                if(ExamQuestions::generateIndexCode($v) == $questions[$r[0]]['q_answer_code']){
                    $scoreCount += $questions[$r[0]]['q_score'];
                    $isRight[] = $r[0];
                }

            }

            // 存储答案
            $user = User::findIdentity($uid);
            $commonCol['uid'] = $uid;
            $commonCol['username'] = $user->username;
            $commonCol['submit_time'] = time();

            // 汉译英 立即判卷 试卷状态、阅卷时间 可立即得出
            $commonCol['mark_time'] = $test->time_lock == 1 ? time() : 0 ;
            $commonCol['m_state'] = $test->time_lock == 1 ? 1 : 0 ;
            $commonCol['m_record'] = empty($isRight) ? array() : serialize($isRight);

            $inserts = array_merge($columns,$commonCol);
            $answerRecord = Yii::$app->english->createCommand()
                ->insert($tableName,$inserts)
                ->execute();
            $aid = Yii::$app->english->getLastInsertID();

            // 记录分数
            if($answerRecord)
            {
                // 汉译英立即判卷 显示分数
                if($test->time_lock == 1)
                {
                    $scoreModel = new Score();

                    $scoreModel->tid = $tid;
                    $scoreModel->uid = $uid;
                    $scoreModel->score = $scoreCount;
                    $scoreModel->aid = $aid;

                    if($scoreModel->save())
                    {
                        Yii::$app->getSession()->setFlash('success','您的客观题成绩为'.$scoreCount.'分');
                        return $this->redirect(['exam/list']);
                    }
                    else
                    {
                        Yii::$app->getSession()->setFlash('error','答案保存失败,请重新提交答案 101');
                        return $this->redirect(['exam/list']);
                    }
                }
                else
                {
                    // 英译汉 存档待手动判卷
                    Yii::$app->getSession()->setFlash('success','试卷提交成功');
                    return $this->redirect(['exam/list']);
                }

            }
            else
            {
                Yii::$app->getSession()->setFlash('error','答案保存失败,请重新提交答案 102');
                return $this->redirect(['exam/list']);
            }


        }
        else
        {
            Yii::$app->getSession()->setFlash('error','未获取到提交信息,请重新考试');
            return $this->redirect(['exam/list']);
        }

        // show mark
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
}

