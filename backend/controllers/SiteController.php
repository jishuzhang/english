<?php
namespace backend\controllers;

use backend\models\Users;
use Yii;
use common\library\MenuCache;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
//                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql' => 'SELECT COUNT(*) FROM {{%interface}}',
                ],
            ],
        ];
    }



    /*
     * 重写验证码方法
     * */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'height'=>34,
                'width'=>80,
                'maxLength' => 4,
                'minLength' => 4
            ],
        ];
    }

    /*
     * 登录后的首页
     * */
    public function actionIndex()
    {

        if(isset(Yii::$app->user->identity->users_id)) {
            $users_id = Yii::$app->user->identity->users_id;
            $user_info = Yii::$app->db->createCommand("select `roleid` from {{%users}} WHERE users_id=".$users_id)->queryOne();


            if ($user_info['roleid'] == 1) {

                $info_member = Yii::$app->db->createCommand("select * from {{%application}} WHERE isstutas=1")->queryAll();
            }else if ($user_info['roleid'] != 1){
                $info_member = Yii::$app->db->createCommand("select `app_id` from {{%app_member}} WHERE users_id=" . $users_id)->queryAll();
            }

            if (!empty($info_member)) {
                foreach ($info_member as $key => $val) {
                    $apps_id = $val['app_id'];
                    $aaa[] = Yii::$app->db->createCommand("select * from {{%application}} WHERE isstutas=1 AND app_id=" . $apps_id)->queryAll();
                    if($aaa == false){
                        $res = "";
                    }else{
                        $res = $aaa;
                    }
                }

            }else{
                $res = "";
            }
        }

        if(!empty($res)){
            $info_application = $res;
        }else{
            $info_application = "";
        }

        //判断用户验证信息
        if (isset(Yii::$app->user->identity)) {
            return $this->render('index',[
                'info_application' => $info_application,
            ]);
        }else{
            return $this->redirect(['site/login']);
        }
    }
    /*
     * 执行登录动作
     * */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //实例化登陆的表单模型
        $model = new LoginForm();
        $this->layout = false; //不使用布局
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $username = Yii::$app->user->identity->username;
            $this->after($username);
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /*
     * 退出动作
     * */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function after($username){
        $value=[];
        $value['logintime']=time();
        $logintime = yii::$app->db->createCommand()->update('{{%users}}',$value,"username='".$username."'")->execute();
        return true;
    }

}
