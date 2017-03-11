<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/29
 * Time: 9:43
 */

namespace common\library;

use yii\caching\DbDependency;
use yii\web\BadRequestHttpException;
use Yii;

class ApiFileCache {

    /**
     * 设置缓存目标
     * 1 为文章页面缓存，表为site_app
     * 2 为活动页面缓存，表为site_active
     */
    public $setCacheAim;

    /**
     * soft by $setCacheAim to different function to execute
     * return resources
     */
    public function SortByCacheAim(){

        $setCacheAim=$this->setCacheAim;

        switch ($setCacheAim){
            case 1:
                self::ExecutionCache_App();
                break;
            case 2:
                self::ExecutionCache_Active();
                break;
            default:
                throw new BadRequestHttpException;
                break;
        }

    }

    public function ExecutionCache_App(){
        $cache=\Yii::$app->cache;
        $cache->keyPrefix='app';
        $Field = 'posids';
        $num = '856';
        $key=$Field.'_'.$num;
        $bool=$cache->get($key);
        $where = 'where a.status="99" and "a.'.$Field.'"="'.$num.'"';
            $dependency = new DbDependency([
                'sql' => 'select COUNT(*) from {{%app}} '.$where,
            ]);
        if($bool==false){

            $sql = 'select a.id,a.title,a.inputtime,a.url,a.countryid,a.degreeid,a.keypointid,a.channelid,a.planid,b.content from {{%app}} as a LEFT JOIN {{%app_data}} as b on a.id=b.id ' . $where;
            $bailitop = Yii::$app->bailitop;
            $query = $bailitop->createCommand($sql)->queryAll();
            $cache->set($key,$query,0,$dependency);
        }


    }

    public function ExecutionCache_Active(){

    }

}