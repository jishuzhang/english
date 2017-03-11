<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/16
 * Time: 11:44
 */
namespace common\library;
use yii\caching\ChainedDependency;
use yii\caching\DbDependency;
use Yii;

class MenuCache{

     function  SetTopmenuCache(){
        $cache=Yii::$app->cache;
        $top_key='top_menu';
        $ul_menu_key='ul_menu';
        $top_cache=$cache->get($top_key);
         $nodes_dependency = new DbDependency([
             'sql' => 'select sort,COUNT(*) from {{%nodes}}',
         ]);
        if($top_cache==false){
            $top_menu=Yii::$app->db->createCommand('select `nodes_id`,`title`,`pid`,`path`,`controller`,`action`,`floor` from {{%nodes}} WHERE display=:display ORDER BY sort DESC ',['display'=>1])->queryAll();
            $cache->set($top_key,$top_menu,0,$nodes_dependency);
            $ul_menu=array();
            foreach($top_menu as $value){
                $ul_menu[]=$value['pid'];
                $ul_menu=array_unique($ul_menu);
            }
            $cache->set($ul_menu_key,$ul_menu,0,$nodes_dependency);
        }
    }
      function  SetMenuStatusCache($route=array(0=>'site',1=>'index')){
        $cache=Yii::$app->cache;
        $url_param_key=$route[0].'_'.$route[1];
        $url_param_cache=$cache->get($url_param_key);
          $nodes_dependency = new DbDependency([
              'sql' => 'select sort,COUNT(*) from {{%nodes}}',
          ]);
        if($url_param_cache==false){
            if($route[0]=='site'){
                $where='';
            }else{
                $where=' and pid!=0';
            }
            $p_param = Yii::$app->db->createCommand('SELECT `nodes_id`,`pid`,`path`,`floor`,`controller`,`action` FROM {{%nodes}} WHERE controller=:controller and `action`=:ac '.$where .' ORDER BY sort DESC ',['controller'=>$route[0],'ac'=>$route[1]])->queryOne();
            $cache->set($url_param_key,$p_param,0,$nodes_dependency);
        }
    }



}