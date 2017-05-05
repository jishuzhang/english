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
use common\models\Score;


class ScoreController extends Controller
{
    public function actionIndex()
    {
        $data = Test::find()->where(['status'=>1])->orderBy('id DESC');

        // pageSize 数值不宜过大
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        $count = array();

        foreach($model as $evModel)
        {
            $count[$evModel->id]['all'] = $this->getUsedNum($evModel->answer_table);
            $count[$evModel->id]['member'] = $this->getMemberNum($evModel->answer_table);
            $count[$evModel->id]['deal'] = $this->getDealNum($evModel->answer_table);
        }

        return $this->render('index',[
            'model' => $model,
            'pages' => $pages,
            'count' => $count
        ]);

    }

    public function actionList($id)
    {
        $model = $this->findModel($id);
        $answers = Yii::$app->english->createCommand('SELECT * FROM {{%'.$model->answer_table.'}} ORDER BY id DESC')->queryAll();

        foreach($answers as $i=>$a)
        {
            $answers[$i]['score'] = $this->getScore($id,$a['id'],$a['uid']);
        }

        return $this->render('list',[
            'model' => $model,
            'answers' => $answers,
        ]);
    }

    public function actionViewAnswer($aid,$tid)
    {

        $model = $this->findModel($tid);
        $answers = Yii::$app->english->createCommand('SELECT * FROM {{%'.$model->answer_table.'}} WHERE id=:aid ORDER BY id DESC',[':aid' => $aid])->queryOne();
        $standardAnswer = ExamQuestions::find()->where(['tid' => $tid])->indexBy('id')->asArray()->all();
        $userAnswer = array();
        $rightAnswer = empty($answers['m_record']) ? array() : unserialize($answers['m_record']);
        $userScore = $this->getScore($tid,$aid,$answers['uid']);

        if(empty($answers)){
            Yii::$app->getSession()->setFlash('error','未检索到该用户答案');
            return $this->redirect(Yii::$app->request->getReferrer());
        }

        foreach($answers as $key => $val)
        {
            $qid = 0;
            if(preg_match('/^t[1-9]+Xq([1-9]+)$/',$key,$qid))
            {
                $userAnswer[$qid[1]] = $val;
            }

        }

        return $this->render('view_answer',[
            'model' => $model,
            'answer' => $answers,
            'standardAnswer' => $standardAnswer,
            'userAnswer' => $userAnswer,
            'rightAnswer' => $rightAnswer,
            'userScore' => $userScore,
        ]);
    }

    public function actionResetAnswer($tid,$aid)
    {
        if(Yii::$app->request->isPost)
        {
            $model = $this->findModel($tid);
            $question = ExamQuestions::find()->where(['tid'=>$tid])->indexBy('id')->asArray()->all();
            $answers = Yii::$app->english->createCommand('SELECT * FROM {{%'.$model->answer_table.'}} WHERE id=:aid ORDER BY id DESC',[':aid' => $aid])->queryOne();

            if(!empty($model) && !empty($answers))
            {
                $userScore = Score::findOne(['tid'=>$tid,'aid'=>$aid,'uid'=>$answers['uid']]);
                $post = Yii::$app->request->post();
                $scoreCount = 0;
                $scoreRecord = array();

                foreach($post as $key => $val)
                {
                    $qid = 0;
                    if(preg_match('/^qid_([1-9]+)$/',$key,$qid))
                    {
                        if($val == 1)
                        {
                            $scoreRecord[] = $qid[1];
                            $scoreCount += $question[$qid[1]]['q_score'];
                        }
                    }

                }

                //  更新分数 更新正确答案存储
                $userScore->score = $scoreCount;
                $userScore->save();

                Yii::$app->english->createCommand()
                    ->update($model->answer_table,['id'=>$aid],'m_record = :m_record',[':m_record'=>serialize($scoreRecord)])
                    ->execute();
            }
        }

        Yii::$app->getSession()->setFlash('success','更新成功');
        return $this->redirect(Yii::$app->request->getReferrer());
    }

    /**
     * @param $tid 试卷id
     * @param $aid 答案id
     * @param $uid 用户id
     * @return array|null|\yii\db\ActiveRecord
     */
    protected function getScore($tid,$aid,$uid)
    {

        $score = Score::find()->select('score')->where(['tid'=>$tid,'aid'=>$aid,'uid'=>$uid])->asArray()->one();
        return $score['score'];
    }
    protected function getUsedNum($tableName)
    {
        $num = 0;
        try{

            $num = Yii::$app->english->createCommand('SELECT COUNT(1) AS num FROM {{%'.$tableName.'}} ORDER BY id DESC')->queryOne();
            $num = $num['num'];

        }catch(Exception $e){

        }

        return $num;
    }

    protected function getMemberNum($tableName)
    {
        $num = 0;
        try{

            $num = Yii::$app->english->createCommand('SELECT COUNT(DISTINCT `uid`) AS num FROM {{%'.$tableName.'}} ORDER BY id DESC')->queryOne();
            $num = $num['num'];

        }catch(Exception $e){

        }

        return $num;
    }

    protected function getDealNum($tableName)
    {
        $num = 0;
        try{

            $num = Yii::$app->english->createCommand('SELECT COUNT(1) AS num FROM {{%'.$tableName.'}} WHERE `m_state`=0 ORDER BY id DESC')->queryOne();
            $num = $num['num'];

        }catch(Exception $e){

        }

        return $num;
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