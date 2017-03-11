<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-7-11
 * Time: 15:26
 */
namespace common\library;

use Yii;
use yii\log\FileTarget;

class Debug
{
    /**
     * @param mixed $content 监控内容
     * @param string $readKey 标示关键字
     * @throws \yii\base\InvalidConfigException
     */
    public static function runLog($content = 'undefined',$readKey = 'application')
    {
            $log = new FileTarget();
            $log->logFile = Yii::$app->getRuntimePath() . '/logs/customDebug.log'; //文件名自定义
            $log->messages[] = [$content,2,$readKey,time()];  // 1 error  2 warning
            $log->export();
    }
}