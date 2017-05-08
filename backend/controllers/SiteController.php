<?php
namespace backend\controllers;

use common\models\Movies;
use Yii;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use backend\models\Admin;
use backend\models\Logintime;
use yii\filters\VerbFilter;
use yii\widgets\InputWidget;
use backend\models\Website;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        	'captcha' => [
        		'class' => 'yii\captcha\CaptchaAction',
        		'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'height'=>40,
                'width'=>80,
        		'maxLength' => 4,
        		'minLength' => 4
        		],
        ];
    }



    public function actionIndex()
    {
        Yii::$app->session->open();
          if (isset(Yii::$app->user->identity)) {
            $sql = "select portrait from ".Yii::$app->components['db']['tablePrefix']."admin where userid=".Yii::$app->user->identity->userid;
            $arr_portrait =  Yii::$app->db->createCommand($sql)->queryOne();
            $model = Website::findOne(1);

    		return $this->renderPartial('index',[
                'arr_portrait'=>$arr_portrait,
                'model'=>$model
            ]);
    	}else{
              return $this->redirect(['site/login']);
          }
    }


	
	
    public function actionSiteindex()
    {
		//防止误删
		if(empty(Yii::$app->user->identity)){
			 return $this->redirect(['site/login']);		 
		}

        return $this->renderPartial('siteindex');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

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


    public function actionLogout()
    {
        Yii::$app->user->logout();

         return $this->goHome();
    }
	public function after($username){
        $user = Admin::findByUsername($username);
		$session = Yii::$app->getSession();
        $ip  = Yii::$app->getRequest()->getUserIP();
		$session['u'] = [
         'uid' => $user->userid,
         'uname' => $user->username,
		 'role' => $user->roleid,
		 'ip' => $ip,
        ];
		//写入用户登陆
		$lmodel = new Logintime();
		$lmodel->uid = $user->userid;
		$lmodel->status  = 1;
        date_default_timezone_set('PRC'); // 中国时区
		$lmodel->logintime  = time();
		$lmodel->ip  = $ip ;
		$lmodel->insert();
		return true;
	}


}