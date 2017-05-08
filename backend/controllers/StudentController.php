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
use frontend\models\User;


class StudentController extends Controller
{
    public function actionIndex()
    {
        $data = User::find()->orderBy('id DESC');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('index',[
            'model' => $model,
            'pages' => $pages
        ]);

    }

    public function actionUpdate($uid)
    {
        if(Yii::$app->request->isPost)
        {
            $post = Yii::$app->request->post('User');
            $user = User::findOne(['id'=>$uid]);

            $newPwd = $post['password'];
            $email = $post['email'];
            $username = $post['username'];

            $user->email = $email;
            $user->username = $username;

            if(!empty($newPwd)){
                $user->setPassword($newPwd);
            }

            if($user->save())
            {
                Yii::$app->getSession()->setFlash('success','修改成功');
            }
            else
            {
                Yii::$app->getSession()->setFlash('error','修改失败');
            }
            return $this->redirect(['student/update','uid' => $uid]);
        }
        else
        {
            $model = User::findOne(['id' => $uid]);
            return $this->render('update',[
                'model' => $model,
            ]);
        }



    }
    protected function getTestName($tid)
    {
        return Test::find()->where(['id'=>$tid])->asArray()->one();
    }

    public function actionView($uid)
    {
        $user = User::findOne(['id' => $uid]);
        $data = Score::find()->where(['uid' => $uid])->asArray()->orderBy('id DESC,aid DESC');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '2']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        $test = array();

        foreach($model as $e){

            if(!isset($test[$e['tid']])){
                $test[$e['tid']] = $this->getTestName($e['tid']);
            }

        }

        return $this->render('view',[
            'model' => $model,
            'pages' => $pages,
            'test' => $test,
            'user' => $user,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}