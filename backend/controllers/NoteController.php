<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-11-10
 * Time: 15:51
 */
namespace backend\controllers;

use backend\models\FuncCountInfo;
use backend\models\BlCreateMethods;
use backend\models\BlModifyMethods;
use backend\models\BlCountRecord;
use backend\models\BlDirs;
use backend\models\Admin;
use yii\data\Pagination;
use Yii;


class NoteController extends BackendController
{

    /**
     * 1 按照用户名来统计用户完成函数
     * 2 可以按照文件创建时间、修改时间进行筛选
     * 3 自动执行
     * 4 只会对 脚本执行当天修改过的文件进行分析
     * @author sujianhui
     * @since 2016-11-15 02:10
     */
    public function actionCron()
    {
        // 确保一天执行一次
        if($this->hasExecuted()){

            echo 'has executed';
            return;
        }

        date_default_timezone_set("PRC");
        $config = BlDirs::find()->select('*')->asArray()->all();

        foreach($config as $projectPath)
        {
            $dirList = $this->getFileTree($projectPath['path']);
            $projectAlias = trim($projectPath['project_alias']);

            // 匹配 函数名、类 名
            $funcPattern = '/\/\*\*\s*\*[\s\S]*\*\/[\s\S]*(?:function[\s\S]*\(|class \w+ )/Ui';
            $classPattern = '/\/\*\*\s*\*[\s\S]*\*\/[\s\S]*class (\w+) /Ui';

            // 操作单个文件
            foreach($dirList as $fileName){

                if(!$this->filterFile($fileName))
                {
                    continue;
                }

                $classInfo = file_get_contents($fileName);
                $batchInserts = array();

                preg_match_all($funcPattern,$classInfo,$funcRes);
                preg_match($classPattern,$classInfo,$classRes);

                $className = isset($classRes[1]) ? trim($classRes[1]) : '';

                // 操作单个注释 单独匹配可以确保数据的准确性 及防止内存溢出
                foreach($funcRes[0] as $evNote)
                {
                    $methodName = $this->getFuncName($evNote);

                    // 排除 类注释以及其它异常注释
                    if(empty($methodName))
                    {
                        continue;
                    }

                    // 返回函数编写时间信息
                    $mTime = $this->getModifyTime($evNote);
                    $userName = $this->getAuthorName($evNote);
                    $userId = $this->getAuthorIdByName($userName);
                    $coefficient = $this->getCoefficientName($evNote);
                    $description = $this->getFuncDescription($evNote);


                    // 赋值顺序必须保持与 $insertFields 变量中字段顺序一致
                    $_model = array();
                    $_model[] = $userId;
                    $_model[] = $methodName;
                    $_model[] = $className;
                    $_model[] = str_replace('\\','/',$fileName);  //  win 系统下 与 linux 系统下 目录分割符号 不一样  防止录入数据库后 无法查询出来                $_model[] = $mTime;
                    $_model[] = $mTime;
                    $_model[] = time();  // exec_time
                    $_model[] = $coefficient;  // 系数
                    $_model[] = $projectAlias;  // 项目别名
                    $_model[] = $description;  // 函数描述

                    if($this->isModifyMethod(
                        [
                            'uid'=>$_model[0],
                            'method_name' => $_model[1],
                            'class_name'=>$_model[2],
                            'file_name'=>$_model[3],
                            'mtime'=>$_model[4],
                            'last_exec_time' => $_model[5],
                            'coefficient' => $_model[6],
                            'project_alias' => $_model[7],
                            'description' => $_model[8],
                        ]
                    )){
                        continue;
                    }

                    if(!empty($fileName) && !empty($mTime) && !empty($userId))
                    {
                        $batchInserts[] = $_model;
                    }

                }

                $insertFields = ['uid','method_name','class_name','file_name','mtime','last_exec_time','coefficient','project_alias','description'];

                !empty($batchInserts) && BlCreateMethods::getDb()->createCommand()->batchInsert(
                    BlCreateMethods::tableName(),
                    $insertFields,
                    $batchInserts
                )->execute();

            }
        }

        // 录入统计信息
        $this->actionTotal();

        // 记录今天已经执行完成
        $cronRecord = new BlCountRecord();
        $cronRecord->date = date('Ymd',time());
        $cronRecord->time = time();
        $cronRecord->save();
        echo 'execute success';

    }

    public function hasExecuted()
    {

        $execRes = BlCountRecord::find()->where('date = '.date("Ymd",time()))->one();

        return empty($execRes) ? false : true;
    }

    /**
     * @author zhangpanlong
     * @since 2016-11-15 09:10
     * @param $methodInfo
     * @return array
     */
    public function isModifyMethod(array $methodInfo)
    {

        $methodModel = BlCreateMethods::find()->where('method_name = "'.$methodInfo['method_name'].'"')->andWhere('file_name="'.$methodInfo['file_name'].'"')->orderBy('id')->one();

        if(empty($methodModel))
        {
            return false;
        }
        else
        {
            $lastModInfo = BlModifyMethods::find()->where(['method_name' => $methodInfo['method_name'],'file_name'=>$methodInfo['file_name']])->orderBy('id DESC')->one();

            // 比对函数 本次 与上次修改时间
            if(empty($lastModInfo) || (!empty($lastModInfo) && $lastModInfo->mtime < $methodInfo['mtime'])){
                BlModifyMethods::getDb()->createCommand()->insert(BlModifyMethods::tableName(),$methodInfo)->execute();
            }

        }

        return true;

    }

    /**
     * @author sujianhui
     * @since 2016-12-5 17:16
     * @description 获取函数描述
     * @coefficient 2/2
     * @return string
     */
    public function getFuncDescription($str)
    {
        $strPattern = '/@description\s*(\S+)\s*\*/U';
        preg_match($strPattern,$str,$matchRes);

        return isset($matchRes[1]) ? trim($matchRes[1]) : '未描述';
    }

    /**
     * @author sujianhui
     * @since 2016-11-15 09:13
     * @return array
     */
    public function getFuncName($str)
    {
        $strPattern = '/function (\w+)\(/U';
        preg_match($strPattern,$str,$matchRes);

        return isset($matchRes[1]) ? trim($matchRes[1]) : '';
    }

    /**
     * 获取难度系数
     * @author sujianhui
     * @since 2016-11-15 09:13
     * @return array
     */
    public function getCoefficientName($str)
    {
        $strPattern = '/@coefficient\s*(\S+)\s*\*/U';
        preg_match($strPattern,$str,$matchRes);

        return isset($matchRes[1]) ? trim($matchRes[1]) : '1/1';
    }

    /**
     * @description 根据传递的目录路径获取目录树
     * @author sujianhui
     * @param $path
     * @return array
     */
    public function getFileTree($path){

        $tree = array();

        foreach(glob($path.'/*') as $single){

            if(is_dir($single)){
                $tree = array_merge($tree,$this->getFileTree($single));
            }
            else{
                $tree[] = $single;
            }
        }

        return $tree;

    }

    /**
     * @author sujianhui
     * @since 2016-11-15 09:17
     * @return array
     */
    public function getAuthorName($str)
    {
        $strPattern = '/\*\s*@author (\w+)\s*\*/U';
        preg_match($strPattern,$str,$matchRes);

        return isset($matchRes[1]) ? trim($matchRes[1]) : '';

    }

    /**
     * @description 根据用户名返回 用户ID 未匹配到UID 的用户 建议记录到log日志中 便于垃圾数据查找
     * @coefficient  5/5
     * @author zhangpanlong
     * @since 2016-11-15 09:10
     * @param $userName
     * @return mixed|string
     */
    public function getAuthorIdByName($userName)
    {
        $userId = Admin::find()->select(['userid'])->where('username ="'.$userName.'"')->asArray()->one();

        return isset($userId['userid']) ? (int)$userId['userid'] : '';
    }

    public function getModifyTime($str)
    {
        $strPattern = '/@since ([\s\S]*)\*/U';
        preg_match($strPattern,$str,$matchRes);

        return isset($matchRes[1]) ? strtotime(trim($matchRes[1])) : '';
    }

    /**
     * @description 判定文件是否进行统计
     * @param $path
     * @return bool
     */
    public function filterFile($path)
    {
        // 今日零点时间戳
        $timeStamp = Yii::$app->request->get('timestamp');
        $timeStamp = empty($timeStamp) ? strtotime(date('Y-m-d',time())) : strtotime($timeStamp);
        $fileModifyTime = filemtime($path);

        if($fileModifyTime > $timeStamp)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    /**
     * @author zhangpanlong
     * @since 2016-11-16 10:40
     * @return string
     */
    public function actionTotal()
    {
        $today = strtotime(date('Y-m-d',time()));
        //$tomorrow = strtotime(date('Y-m-d',strtotime('+1 day')));
        $yesterday = strtotime(date('Y-m-d',strtotime('-1 day')));

        //添加
        $cMethods_sql = "SELECT a.userid,a.username,a.realname,cr.* FROM {{%admin}} as a LEFT JOIN {{%create_methods}} as cr ON a.userid = cr.uid and last_exec_time BETWEEN $yesterday AND $today";
        $cMethods = Yii::$app->db->createCommand($cMethods_sql)->queryAll();

        //修改
        $mMethods_sql = "SELECT a.userid,a.username,a.realname,m.* FROM {{%admin}} as a LEFT JOIN {{%modify_methods}} as m ON a.userid = m.uid and last_exec_time BETWEEN $yesterday AND $today";
        $mMethods = Yii::$app->db->createCommand($mMethods_sql)->queryAll();

        foreach( $cMethods as $c_method ){

            $userTotal[$c_method['userid']]['day_add'][] = !empty($c_method['method_name']) ? $c_method : '';
        }
        foreach( $mMethods as $m_method ){

            $userTotal[$m_method['userid']]['day_modify'][] = !empty($m_method['method_name']) ? $m_method : '';
        }

        foreach($userTotal as $key => $value){

            $total[$key]['uid'] = $key;
            $total[$key]['exec_time'] = time();
            $total[$key]['day_add'] = !empty($value['day_add'][0]) ? count($value['day_add']) : 0;
            $total[$key]['day_modify'] = !empty($value['day_modify'][0]) ? count($value['day_modify']) : 0;
        }

        //INSERT 一次插入多行
        $par = ['uid', 'exec_time', 'day_add', 'day_modify'];
        !empty($total) && FuncCountInfo::getDb()->createCommand()->batchInsert( FuncCountInfo::tableName(), $par, $total)->execute();

    }

    /**
     * @author zhangpanlong
     * @since 2016-11-18 14:40
     * @return string
     */
    public function actionCountinfo(){

        $uid = Yii::$app->request->get('uid');
        $stTime = Yii::$app->request->get('st',date('Y-m-d',time()));
        $endTime = Yii::$app->request->get('end',date('Y-m-d',strtotime('+1 day')));
        $isExport = Yii::$app->request->get('isExport',0);

        $st = (int)strtotime( $stTime);
        $end = (int)strtotime( $endTime);

        $andwhere = ' exec_time BETWEEN '.$st.' AND '.$end;
        if(!empty($st) && !empty($end) && !empty($uid)){
            $query = FuncCountInfo::find()
                ->select('*')
                ->join('LEFT JOIN','bl_admin','bl_admin.userid = bl_count_info.uid')
                ->andWhere('bl_count_info.uid = '.$uid)
                ->andWhere($andwhere);

        }elseif(!empty($uid)){
            $query = FuncCountInfo::find()->select('*')
                ->join('LEFT JOIN','bl_admin','bl_admin.userid = bl_count_info.uid')
                ->andWhere('bl_count_info.uid = '.$uid);

        }else{
            $query = FuncCountInfo::find()
                ->select('*')
                ->join('LEFT JOIN','bl_admin','bl_admin.userid = bl_count_info.uid')
                ->andWhere($andwhere);
        }

        // 执行 倒出 代替查询
        if($isExport)
        {
            $exportRes = $query->orderBy('exec_time DESC')->asArray()->all();
            $this->excelExport($exportRes);
            exit;
        }

        $allUsers = Admin::find()->select(['username','userid','realname'])->indexBy('userid')->asArray()->all();

        $counts=$query->count();
        $all_pages = ceil($counts/10);
        $pagination = new Pagination(['totalCount' => $query->count(),'defaultPageSize' => 10,]);
        $Countinfo = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->renderPartial('countinfo',[
            'pagination' => $pagination,
            'Countinfo'=>$Countinfo,
            'counts' => $counts,
            'all_pages'=>$all_pages,
            'allUsers' => $allUsers,
            'uid' => $uid,
            'stTime' => $stTime,
            'endTime' => $endTime,
        ]);
    }

    /**
     * @author zhangpanlong
     * @since 2016-11-16 11:40
     * @param $model
     * @return string
     */
    public function excelExport(array $model){

        $exportFileName = "函数总览";
        $objExcel = new \PHPExcel();
        $objExcel->createSheet(0);
        $objExcel->setActiveSheetIndex(0);
        $objSheet = $objExcel->getActiveSheet();

        $objSheet->setCellValue('A1','用户名称')
            ->setCellValue('B1','每日添加数')
            ->setCellValue('C1','每日修改数')
            ->setCellValue('D1','最后执行时间');

        $initRow = 2;
        foreach($model as $v){

            $objSheet->setCellValue('A'.$initRow,$v['realname'])
                ->setCellValue('B'.$initRow,$v['day_add'])
                ->setCellValue('C'.$initRow,$v['day_modify'])
                ->setCellValue('D'.$initRow,date('Y-m-d H:i',$v['exec_time']));
            $initRow++;
        }

        $objWrite = \PHPExcel_IOFactory::createWriter($objExcel,'Excel5');

        //标头您的浏览器并告诉它下载，而不是在浏览器中运行的文件
        header("Content-Type: application/force-download");

        //文件流
        header("Content-Type: application/octet-stream");

        //下载文件
        header("Content-Type: application/download");

        header("Content-Disposition:attachment;filename=".iconv("UTF-8", "GB2312",$exportFileName).".xls");
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");//上一次修改时间
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

        //不缓存页面
        header("Pragma: no-cache");
        $objWrite->save('php://output'); //到浏览器

        return $this->redirect(['note/countinfo']);

    }

    public function actionList()
    {
        $model = BlCountRecord::find()->select('*');
        $pages = new Pagination(['totalCount' =>$model->count(), 'pageSize' => '20']);
        $execList = $model->orderBy('id DESC')->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->renderPartial('cronlist', [
            'pages' => $pages,
            'execList' => $execList
        ]);
    }

    public function actionPath()
    {
        $model = BlDirs::find()->select('*');
        $pages = new Pagination(['totalCount' =>$model->count(), 'pageSize' => '50']);
        $execList = $model->orderBy('id DESC')->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        return $this->renderPartial('path', [
            'pages' => $pages,
            'execList' => $execList
        ]);
    }

    public function actionAdd()
    {
        $post = Yii::$app->request->post();

        if(!empty($post)){
            $model = new BlDirs();
            $model->project_alias = str_replace('\\','/',$post['project_alias']);
            $model->path = str_replace('\\','/',$post['path']);
            $model->save();

            $this->redirect(['note/path']);
        }

        return $this->renderPartial('dir_add', []);
    }

    public function actionEdit()
    {

        $id = Yii::$app->request->get('id');

        $model = BlDirs::find()->where(['id' => $id])->orderBy('id DESC')->one();

        $post = Yii::$app->request->post();

        if (!empty($post)) {
            $model = BlDirs::findOne($post['id']);
            $model->project_alias = str_replace('\\', '/', $post['project_alias']);
            $model->path = str_replace('\\', '/', $post['path']);
            $model->save();

            $this->redirect(['note/path']);
        }

        return $this->renderPartial('edit', [
            'model' => $model,
        ]);
    }
    public function actionRemove()
    {
        $ids = Yii::$app->request->post('ids',array());
        $idStr = implode(',',$ids);

        BlDirs::getDb()->createCommand('DELETE FROM '.BlDirs::tableName().' WHERE id IN ('.$idStr.')')->execute();
        $this->redirect(['note/path']);

    }

    /**
     * @description
     * @author sujianhui
     * @since 2016-11-22 14:00
     * @coefficient 3/5
     */
    public function testCodenote()
    {
        // 测试代码统计系统是否正常
    }

    /**
     * @description
     * @author sujianhui
     * @since 2016-11-22 16:00
     * @coefficient 3/5
     */
    public function testCodenote1()
    {
        // 测试代码统计系统是否正常
    }


}