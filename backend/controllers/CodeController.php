<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\controllers\BackendController;
use yii\data\Pagination;

/**
 * Code Controller
 */
class CodeController extends BackendController
{
    public function actionIndex(){
        if(empty($_SESSION['app_id'])){
            $Function = new PublicFunction();
                $content = $Function->message('error', '请先选择应用', 'index.php?r=site/index');
                return $this->renderContent($content);
        }else{
            $app_id = $_SESSION['app_id'];
        }
        //var_dump($app_id);exit;
        $sql="select * from {{%return_codes}} where app_id = $app_id ORDER by orders DESC ";
        $info = Yii::$app->db->createCommand($sql.' limit 1000')->queryAll();
        return $this->render('index',[
            'info' => $info,
        ]);
    }


    public function actionCreate(){
        $app_id = $_SESSION['app_id'];
        //var_dump($app_id);exit;
        $post = Yii::$app->request->post();
        $Function = new PublicFunction();
        foreach($post as $key=>$value){
            //var_dump($post);exit;
            if(is_array($value)){
                foreach($value as $k=>$v){
                    $cre[$k][$key] = $v;
                }
            }
        }
        if(!empty($cre)){
            foreach($cre as $key =>$value){
                //var_dump($value);exit;
                if($value['code'] && $value['description']){
                    if(empty($value['return_codes_id']) ){
                        if(empty($value['orders'])){
                            $value['orders'] = 0;
                        };
                        $value['app_id']=$app_id;
                        $isinsert = Yii::$app->db->createCommand()->insert("{{%return_codes}}",$value)->execute();
                    }else{
                        //$value['sort']=$key;
                       //var_dump($value);exit;
                        //$value['orders']=isset($value['orders'])?$value['orders']:0;
                        $isinsert = Yii::$app->db->createCommand()->update('{{%return_codes}}',$value,'return_codes_id='.$value['return_codes_id'])->execute();
                    }
                }else{
                    $content = $Function->message('error', '返回码或者描述不能为空', 'index.php?r=code/index');
                    return $this->renderContent($content);
                }
            }

            if(!empty($isinsert)){
                if(isset($post['submit'])){$local_href = 'index.php?r=code/index';}else{$local_href = 'index.php?r=code/index';}
                $content = $Function->message('success', '操作成功', $local_href);
                return $this->renderContent($content);
            }else{
                $content = $Function->message('success', '操作成功', 'index.php?r=code/index');
                return $this->renderContent($content);
            }
        }
        $content = $Function->message('error', '请先添加数据或者导入数据再进行此操作！！！', 'index.php?r=code/index');
        return $this->renderContent($content);
    }

    /*
     * 返回码excel导入
     * */
    public function actionInexcel()    {

        $app_id = $_SESSION['app_id'];
        $Function = new PublicFunction();
        if (!empty($_FILES['upload_file']['name']))        {
            $tmp_file = $_FILES ['upload_file'] ['tmp_name'];
            $file_types = explode ( ".", $_FILES ['upload_file'] ['name'] );
            $file_type = $file_types [count ( $file_types ) - 1];
            //var_dump($file_type);exit;
            if($_FILES['upload_file']['size'] >131072 ){
                $content = $Function->message('error', '文件过大，请重新上传', "index.php?r=code/index");
                return $this->renderContent($content);
            }
            /*判别是不是.xls文件，判别是不是excel文件*/
//            if (strtolower ( $file_type ) != "xls" && strtolower ( $file_type ) != "xlsx")            {
//                $content = $Function->message('error', '不是Excel文件，重新上传', "index.php?r=code/index");
//                return $this->renderContent($content);
//            }
            /*设置上传路径*/
            $savePath = 'res/upload/portrait/';
            /*以时间来命名上传的文件*/
            $str = date ( 'Ymdhis' );
            $file_name = $str . "." . $file_type;
            /*是否上传成功*/
            if (! copy ( $tmp_file, $savePath . $file_name ))
            {
                $content = $Function->message('error', '上传失败', "index.php?r=code/index");
                return $this->renderContent($content);

            }
            /*
               *对上传的Excel数据进行处理生成编程数据,这个函数会在下面第三步的ExcelToArray类中
              注意：这里调用执行了第三步类里面的read函数，把Excel转化为数组并返回给$res,再进行数据库写入
            */

            $objExcel1 = \PHPExcel_IOFactory::load($savePath . $file_name);
            $sheetcount = $objExcel1->getSheetCount();
            //var_dump($sheetcount);exit;
//            for($i = 0;$i < $sheetcount;$i++){
//                $highestRow = $objExcel1->getSheet(0)->getHighestRow(); // 取得总行数
//                if($highestRow >= 2){
//                    $data = $objExcel1->getSheet(0)->toArray();
//                }
//                //var_dump($data);
//            }
            $highestRow = $objExcel1->getSheet(0)->getHighestRow(); // 取得总行数
            if($highestRow >= 2){
                $data = $objExcel1->getSheet(0)->toArray();
            }
            if(empty($data)){
                $content = $Function->message('error', 'Excel文件sheet1中无数据，请将要导入的数据放在最左边的sheet中，否则将为你导入其他非指定数据', "index.php?r=code/index");
                return $this->renderContent($content);
            }else{
                foreach ($data as $k => $v) {
                    //var_dump(count($v[$k-1]));//exit;
                    if($v[1]!=null && $v[2]!=null){
                        if ($k != 0) {
                            $data_arr = array();
                            $data_arr['code'] = $v[1];
                            $data_arr['description'] = $v[2];
                            $data_arr['caption'] =isset($v[3]) ? $v[3]: '';
                            $data_arr['app_id'] = $app_id;
                            $data_arr['level'] = isset($v[5]) ? $v[5]: 2;
                            //$data_arr['sort'] = $sort+1;
                            $isinsert = Yii::$app->db->createCommand()->insert("{{%return_codes}}", $data_arr)->execute();
                        }
                    }

                }
                //var_dump($k);exit;
                    $content = $Function->message('success', '导入完成', "index.php?r=code/index");
                    return $this->renderContent($content);
            }
        //return $this->redirect(['code/index']);
        }else{
            $content = $Function->message('error', '请先选择文件再导入！！！', "index.php?r=code/index");
            return $this->renderContent($content);
        }

    }
/*
 * 返回码导出
 * */
    public function actionOutexcel(){
            $app_id = $_SESSION['app_id'];
            $sql = "select * from {{%return_codes}} where app_id = $app_id ORDER by orders DESC ";
            $info = Yii::$app->db->createCommand($sql . ' limit 1000')->queryAll();
            $dir = dirname(__FILE__);
            $objExcel = new \PHPExcel();//var_dump($objExcel);exit;
            $objExcel->createSheet(0);
            $objExcel->setActiveSheetIndex(0);
            $objsheet = $objExcel->getActiveSheet();
            $objsheet->setCellValue('A1','序号')->setCellValue('B1','返回码')->setCellValue('C1','描述')->setCellValue('D1','说明')->setCellValue('E1','应用')->setCellValue('F1','等级');

            $j = 2;
            foreach($info as $k=>$v){
                $sql = "select title from {{%application}} where app_id =" .$v['app_id'];
                $appinfos = Yii::$app->db->createCommand($sql . ' limit 1000')->queryOne();
                $title = $appinfos['title'];
                $objsheet->setCellValue('A'.$j,$k+1)->setCellValue('B'.$j,$v['code'])->setCellValue('C'.$j,$v['description'])->setCellValue('D'.$j,$v['caption'])->setCellValue('E'.$j,$title)->setCellValue('F'.$j,$v['level']);
                $j++;
            }
            $objwritte = \PHPExcel_IOFactory::createWriter($objExcel,'Excel5');
            //$objwritte->save($dir.".$app_id.xls");
            $outputFileName = "测试.xls";
            header("Content-Type: application/force-download");//标头您的浏览器并告诉它下载，而不是在浏览器中运行的文件
            header("Content-Type: application/octet-stream");//文件流
            header("Content-Type: application/download"); //下载文件
            header("Content-Disposition:attachment;filename=".iconv("UTF-8", "GB2312",date('Y-m-d',time())."返回码").".xls");
            //header('Content-Disposition:attachment;filename="返回码.xls');  //到文件
            header("Content-Transfer-Encoding: binary");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");//上一次修改时间
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: no-cache"); //不缓存页面
            //$objWriter->save('php://output');
            $objwritte->save('php://output'); //到浏览器
            //exit;
        return $this->redirect(['code/index']);
    }

    public function  actionDelete(){

        $post = Yii::$app->request->get();

        $res = Yii::$app->db->createCommand()->delete('return_codes','return_codes_id='.$post['id'])->execute();
        if($res == 1){
            $Function = new PublicFunction();
            $content = $Function->message('success', '删除成功', 'index.php?r=code/index');
            return $this->renderContent($content);
        }else{
            throw new NotFoundHttpException('删除失败!');
        }

    }


}