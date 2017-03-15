<?php
namespace backend\controllers;
use backend\controllers\content\CreateAction;
use backend\controllers\content\UpdateAction;
use backend\models\Category;
use backend\models\Editor_log;
use backend\models\News;
use Yii;
use yii\web\Controller;
use yii\web\Cookie;
use yii\web\Session;
use backend\models\Node_role;
use yii\filters\VerbFilter;
use backend\models\Logs;
use common\models\LoginForm;
use backend\controllers\PublicFunction;
/******
By sasa 公共继承类
******/

class BackendController extends Controller
{
	
	public function beforeAction($action)
	{

       $this->quanxian_check();
		return true;
	}
	
	    /**
     * 检查内容管理权限
     */
    private function quanxian_check() {
	    $session = Yii::$app->session;
		//获取对应的栏目id号
		$refferroute = Yii::$app->request->referrer;
		$_referrer = parse_url($refferroute);//?
		$route = Yii::$app->requestedRoute;//c+a
         if(!empty(Yii::$app->user->identity)){
			 $this->logs();
				return true;
			 
		 } else{	
				
				return $this->redirect(['site/login']);
		 }
    }
	
	public function afterAction($action,$result)
	{
		parent::afterAction($action,$result);
		return $result;
	}

	/**
	 * 写入管理员日志,并判权限
	 * @return  
	 */		
	final private function logs() {
		$model = new logs();
        $session = Yii::$app->session;
		$mc = $this->CheckUrl();
        //权限检查
		$roleid = Yii::$app->user->identity->roleid;
        if($roleid!==1) {
            $keyid = substr(md5($roleid.$mc[0].$mc[1]),0,16);
            $r = Node_role::find()->where(['keyid' => $keyid])->one();
            if(!$r || $r['chk']==0) {
              echo '没有 - 权限';
              exit;
            }
        }
        $model->uid = Yii::$app->user->identity->userid;
        $model->m = $mc[0];
        $model->c= $mc[1];
        date_default_timezone_set('PRC'); // 中国时区
        $model->addtime =time();
        $model->ip = Yii::$app->getRequest()->getUserIP();
		$newdata ='1111';
        $model->data = $newdata;
		$model->insert();
    }

	/**
	 * 拆分url
	 * @return string 
	 */
	public function CheckUrl(){
		$str = Yii::$app->requestedRoute;//c+a
		$mc = explode("/",$str);
		return  $mc;
		
	}


	
	/**
	 * 强制刷新菜单
	 * @return \yii\web\Response
	 */
	public function actionReflushmenu()
	{
		Yii::$app->session->setFlash('reflush');
		return $this->goHome();
	}


        //$newdata = '';
		/**
        foreach($session['u'] as $key=>$value) {
            if(in_array($key,array('m','c','_menuid','_submenuid','_su'))) continue;
            if($key=='page' && $value==0) continue;
            if(is_string($value)) {
                if(strlen($value) > 100) $value = '-MAX100-';
            } elseif(is_array($value)) {
                $value = '-array()-';
            }
            if($key=='password') $value = '***';
            $newdata .= $key.'='.$value."\r\n";
        }
		**/

}