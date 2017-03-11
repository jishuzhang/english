<?php
/**
 * Created by PhpStorm.
 * User: sujianhui
 * Date: 2016-7-9
 * Time: 18:14
 */
namespace common\library;

use Yii;

class Process
{
    /**
     * 查询该进程是否已存在
     * @param $uniqueKey
     * @return bool|mixed|string
     */
    public static function isLocked($uniqueKey)
    {
        return Process::_status('get', $uniqueKey);
    }

    /**
     * @param $uniqueKey
     */
    public static function unLock($uniqueKey)
    {
        Process::_status('rm', $uniqueKey);
    }

    /**
     * @param $uniqueKey
     * @param int $survivalTime 存活时间
     */
    public static function lock($uniqueKey, $survivalTime = 0)
    {
        // 默认加锁时间为 10 秒
        $survivalTime = $survivalTime < 1 ? 10 : intval($survivalTime);
        Process::_status('set', $uniqueKey, $survivalTime);

    }

    /**
     * @param $action 增 删 查
     * @param $uniqueKey
     * @param int $survivalTime
     * @return bool|mixed|string
     */
    private static function _status($action, $uniqueKey, $survivalTime = 0)
    {
        $ret = '';
        switch ($action) {
            case 'set' :
                $ret = Yii::$app->cache->set('process_lock_'.$uniqueKey, time(), $survivalTime);
                break;
            case 'get' :
                $ret = Yii::$app->cache->get('process_lock_'.$uniqueKey);
                break;
            case 'rm' :
                $ret = Yii::$app->cache->delete('process_lock_'.$uniqueKey);
        }

        return $ret;
    }

}
