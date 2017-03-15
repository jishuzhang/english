<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-11-15
 * Time: 11:17
 */
namespace backend\controllers;

use backend\models\FuncConuntInfo;
use backend\models\BlCreateMethods;
use backend\models\BlModifyMethods;
use backend\models\Admin;
use yii\data\Pagination;
use Yii;


class ExportController extends BackendController
{
    /**
     * @author sujianhui
     * @since 2016-11-15 08:10
     * @return string
     */
    public function actionIndex()
    {
        $init['uid'] = Yii::$app->request->get('uid',Yii::$app->user->id);
        $init['stTime'] = Yii::$app->request->get('st',date('Y-m-d',strtotime('-1 day')));
        $init['endTime'] = Yii::$app->request->get('end',date('Y-m-d',time()));
        $isExport = Yii::$app->request->get('isExport',0);
        $getType = Yii::$app->request->get('type',1);

        $st = (int)strtotime( $init['stTime']);
        $end = (int)strtotime( $init['endTime']);

        if( $getType == 2 )
        {
            $model = BlModifyMethods::find()->select('*')->where('uid = '.$init['uid'])->andWhere('mtime BETWEEN '.$st.' AND '.$end);
        }
        else
        {
            $model = BlCreateMethods::find()->select('*')->where('uid = '.$init['uid'])->andWhere('mtime BETWEEN '.$st.' AND '.$end);
        }


        // 执行 倒出 代替查询
        if($isExport)
        {
            $exportRes = $model->orderBy('mtime DESC')->asArray()->all();
            $this->excelExport($exportRes);
            exit;
        }

        $pages = new Pagination(['totalCount' =>$model->count(), 'pageSize' => '20']);
        $methodsRes = $model->orderBy('mtime DESC')->offset($pages->offset)->limit($pages->limit)->asArray()->all();

        $allUsers = Admin::find()->select(['username','userid','realname'])->indexBy('userid')->asArray()->all();

        return $this->renderPartial('index', [
            'pages' => $pages,
            'userMethods' => $methodsRes,
            'allUsers' => $allUsers,
            'uid' => $init['uid'],
            'filterItems' => $init,
        ]);
    }

    public function excelExport(array $model){

        $exportFileName = "绩效";
        $objExcel = new \PHPExcel();
        $objExcel->createSheet(0);
        $objExcel->setActiveSheetIndex(0);
        $objSheet = $objExcel->getActiveSheet();

        $objSheet->setCellValue('A1','方法名称')
            ->setCellValue('B1','类名')
            ->setCellValue('C1','时间')
            ->setCellValue('D1','难度系数')
            ->setCellValue('E1','应用范围')
            ->setCellValue('F1','BUG数')
            ->setCellValue('F1','功能描述');

        $initRow = 2;
        foreach($model as $v){

            if(empty($v['coefficient']))
            {
                $dNum = $aNum = 1;
            }
            else
            {
                list($dNum,$aNum) = explode('/',$v['coefficient']);
            }


            $objSheet->setCellValue('A'.$initRow,$v['method_name'])
                ->setCellValue('B'.$initRow,$v['class_name'])
                ->setCellValue('C'.$initRow,date('Y-m-d H:i',$v['mtime']))
                ->setCellValue('D'.$initRow,$dNum)
                ->setCellValue('E'.$initRow,$aNum)
                ->setCellValue('F'.$initRow,'0')
                ->setCellValue('F'.$initRow,$v['description']);
            $initRow++;
        }

        $objWrite = \PHPExcel_IOFactory::createWriter($objExcel,'Excel5');


        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition:attachment;filename=".iconv("UTF-8", "GB2312",$exportFileName).".xls");
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");

        $objWrite->save('php://output'); //到浏览器

        return $this->redirect(['export/index']);
    }

}