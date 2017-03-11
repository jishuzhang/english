<?php

namespace common\library;

use Yii;

/**
 * 发送报警邮件 主要由三个原因
 * 1 $this->criticalityWarnCode  根据返回码报警等级决定是否发送 邮件 与 短信  没有记录在表中的返回码是不会进行报警的
 * 2 $this->isOpenMessageNotification / $this->isOpenEmailNotification  全局控制短信 、邮件发送开关
 * 3 用户的个人选择通知方式  users 表下的 notification  字段 ：0  不通知  1 短信通知  2 邮件通知 3 全部通知
 * 4 联系人添加了 相应的联系方式
 * Class Monitor
 * @package common\library
 */
class Monitor
{

    public $isMessage = 0;
    public $isMail = 0;
    public $interfaceInfo = null;
    public $criticalityWarnCode = 1; // 报警等级
    public $isSendPromptByWarnLevel = 0; // 根据返回码报警等级决定是否发送 邮件 与 短信  0 不发送  1 发送
    public $statusCode = 404;   // 接口错误码
    public $insertMonitorId = 0;   // 新增监控ID
    public $interfaceName = '';
    public $isMonitorUser = 0;   // 根据通知方式 判断是否为监控管理人  0  不通知  1 短信通知  2 邮件通知 3 全部通知
    public $isOpenMessageNotification = 1; // 是否开启报警短信通知功能  1 开启 0 关闭
    public $isOpenEmailNotification = 1;  // 是否开启报警邮件通知功能   1 开启 0 关闭

    /**
     * interface 表中 title 字段需要为  plot/index 格式  注意：有两个传参数的 api 需要调试
     * @param string $statusCode 接口返回错误码
     * @return bool
     */
    public static function monitorApi($statusCode = '',$result_message ='')
    {
        if($statusCode != 200){

            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $requestRoute = Yii::$app->request->pathInfo;  // 未解析后的 pathInfo  解析后的为 Yii::$app->requestedRoute;
            $interface = Yii::$app->db;

            // 根据接口url格式从 route 解析接口信息  $interfaceInfo[0] 模块名称  $interfaceInfo[1] 版本信息  $interfaceInfo[2] 控制器加参数信息
            $interfaceInfo = explode('/',$requestRoute,3);

            // 获取版本信息
            $version = self::getVersionIdByVersion($interfaceInfo[1]);

            if(!empty($version)){
                $filterInterRes = $interface->createCommand("SELECT interface_id,app_id,interface_type_id,interface_vision_id,title FROM {{%interface}} WHERE method=:method AND title=:title AND interface_vision_id=:interface_vision_id",['method'=>$requestMethod,'title'=>$interfaceInfo[2],'interface_vision_id'=>$version])->queryOne();
            }else{
                $filterInterRes = false;
            }

            if(!empty($filterInterRes)){

                $MonitorObj = new self();

                // 录入监控日志
                $MonitorObj->interfaceInfo = $filterInterRes;
                $MonitorObj->statusCode = $statusCode;

                // 根据返回码等级决定 是否发送报警信息
                if($MonitorObj->setLogDependReturnCode()){
                    $MonitorObj->isSendPromptByWarnLevel = 1;
                }

                $MonitorObj->setMonitorLog($result_message);

            }

        }

    }

    public static function getVersionNameById($versionId)
    {
        if(empty($versionId)){
            return false;
        }

        $versionInfo = Yii::$app->db->createCommand("SELECT `vision` FROM {{%interface_vision}} WHERE `interface_vision_id`=:interface_vision_id",['interface_vision_id'=>$versionId])->queryOne();

        if(empty($versionInfo)){
            return false;
        }else{
            return $versionInfo['vision'];
        }
    }

    /**
     * 根据版本名称获取 版本 ID
     * @param $version
     * @return bool
     */
    public static function getVersionIdByVersion($version)
    {
        if(empty($version)){
            return false;
        }

        $versionInfo = Yii::$app->db->createCommand("SELECT `interface_vision_id` FROM {{%interface_vision}} WHERE `vision`=:vision",['vision'=>$version])->queryOne();

        if(empty($versionInfo)){
            return false;
        }else{
            return $versionInfo['interface_vision_id'];
        }
    }

    /**
     * 根据返回码报警等级决定是否录入监控日志
     * @return bool
     */
    public function setLogDependReturnCode(){
        $returnCodeRes = Yii::$app->db->createCommand("SELECT `code`,`level` FROM {{%return_codes}} WHERE `app_id`=:app_id AND `code`=:code",['app_id'=>$this->interfaceInfo['app_id'],'code'=>$this->statusCode])->queryOne();

        // 如果没有获取到相应的返回码信息 则记录不发送
        if($returnCodeRes['level'] <= $this->criticalityWarnCode){
            return true;
        }else{
            return false;
        }

    }
    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function setMonitorLog($data){

        if(empty($this->interfaceInfo) || empty($this->statusCode)){
            return false;
        }

        //  controller/action/param  ?

        $insert = [
            'app_id'              => $this->interfaceInfo['app_id'],
            'interface_type_id'   => $this->interfaceInfo['interface_type_id'],
            'interface_vision_id' => $this->interfaceInfo['interface_vision_id'],
            'interface_id'        => $this->interfaceInfo['interface_id'],
            'monitor_time'        => time(),
            'result'              => $this->statusCode,
            'message'             =>  0,  // 是否已经发送短信
            'email'               =>  0,  // 是否已经发送邮件
            'ip'                  => $_SERVER['REMOTE_ADDR'],
            'url'                 => 'http://'.$_SERVER['HTTP_HOST'].'/'.Yii::$app->request->pathInfo.'?'.$_SERVER['QUERY_STRING'],
            'data'                 => $data
        ];

        Yii::$app->db->createCommand()->insert('{{%monitor}}',$insert)->execute();
        $this->insertMonitorId = Yii::$app->db->getLastInsertID();

        // $this->interfaceName = $this->getInterfaceTitleById();
        $this->interfaceName = Yii::$app->requestedRoute;

        if(!empty($this->interfaceName)){
            $message = '警报:'.$this->interfaceName.'接口出现了'.$this->statusCode.'错误';
        }else{
            return;
        }

        $this->sendNotification($message);

        // 根据发送通知结果更新 该条日志的短信 邮件发送状态
        Yii::$app->db->createCommand()->update(
            '{{%monitor}}',
            [
                'message'=>$this->isMessage,
                'email'=>$this->isMail
            ],
            'monitor_id=:monitor_id',
            [
                'monitor_id'=>$this->insertMonitorId
            ]
        )->execute();


    }

    public function getInterfaceTitleById()
    {
        if(empty($this->interfaceInfo['interface_id'])){
            return false;
        }

        $interfaceName = Yii::$app->db->createCommand("SELECT title FROM {{%interface}} WHERE `interface_id`=:interface_id",['interface_id'=>$this->interfaceInfo['interface_id']])->queryOne();
        if(!empty($interfaceName)){
            return $interfaceName['title'];
        }else{
            return false;
        }

    }

    public function sendNotification($message = 'undefined')
    {
        $monitorList = self::getMonitorer();

        foreach($monitorList as $evMonitorer){
            
            $tmpPromptInfo = array();

            // 全不通知  或者 报警等级不够
            if($evMonitorer['notification'] == 0 || $this->isSendPromptByWarnLevel == 0){
                $mailPromptRes = 0;
                $messagePromptRes = 0;
                continue;

                // 短信通知
            } else if($evMonitorer['notification'] == 1 ) {
                $mailPromptRes = 0;
                $messagePromptRes = $this->sendMessage($evMonitorer['mobile'],$message) ? 1: 0; // 短信通知结果

                // 邮件通知
            } else if($evMonitorer['notification'] == 2){

                $mailPromptRes = $this->sendEmail($evMonitorer['email'],$message) ? 1 : 0 ;  // 邮件通知结果
                $messagePromptRes = 0;

                // 全部通知
            } else if($evMonitorer['notification'] == 3){

                $mailPromptRes = $this->sendEmail($evMonitorer['email'],$message) ? 1 : 0 ;  // 邮件通知结果
                $messagePromptRes = $this->sendMessage($evMonitorer['mobile'],$message) ? 1: 0; // 短信通知结果

            }else{
                $mailPromptRes = $messagePromptRes = 0;
            }

            $tmpPromptInfo['email']['res'] = $mailPromptRes;
            $tmpPromptInfo['email']['message'] = $message;
            $tmpPromptInfo['mobile']['res'] = $messagePromptRes;
            $tmpPromptInfo['mobile']['message'] = $message;

            // 因为需要记录每一位用户的的发送记录 所以不能拆分出去
            $this->setUserMonitor($evMonitorer,$tmpPromptInfo);
        }

    }

    /**
     * monitor_log 数据表数据录入
     * @param array $userInfo 用户信息
     * @param array $tmpPromptInfo 发送通知结果集
     */
    public function setUserMonitor($userInfo,$tmpPromptInfo)
    {
        // 只要通知一位监控联系人成功即更新监控内容表数据
        if($tmpPromptInfo['email']['res']){
            $this->isMail = 1;
        }

        if($tmpPromptInfo['mobile']['res']){
            $this->isMessage = 1;
        }

        $insert = [
            'uid' => $userInfo['users_id'],
            'monitor_id' => $this->insertMonitorId,
            'interface_id' => $this->interfaceInfo['interface_id'],
            'phone_sendtime' => time(),
            'email_message' => $tmpPromptInfo['email']['message'],
            'phone_message' => $tmpPromptInfo['mobile']['message'],
            'require_email' => $tmpPromptInfo['email']['res'],
            'require_phone' => $tmpPromptInfo['mobile']['res'],
            'email_sendtime' => time()
        ];

        Yii::$app->db->createCommand()->insert('{{%monitor_log}}',$insert)->execute();


    }

    /**
     * @param int $mobile
     * @param string $message
     * @return bool
     */
    public function sendMessage($mobile ,$message = 'undefined')
    {

        if(empty($mobile) || empty($this->isOpenMessageNotification)){
            return false;
        }

        $interfaceInfo = explode('/',$this->interfaceName);

        global $c;
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("demo");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName('百利天下留学');
        $req->setSmsParam("{\"app\": \"".$interfaceInfo[0]."\",\"vision\": \"".$interfaceInfo[1]."\",\"interface\": \"".$interfaceInfo[2]."\",\"detail\": \"".isset($interfaceInfo[3]) ? $interfaceInfo[3]: ''."\",\"code\": \"".$this->statusCode."\"}");
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode('SMS_13630001');
        $resp = $c->execute($req);

        if(isset($resp->result->success)){
           return true;
        }else{
            return false;
        }

    }

    public function sendEmail($email = 0, $message = 'undefined')
    {
        if(empty($email) || empty($this->isOpenEmailNotification)){
            return false;
        }

        $mail= Yii::$app->mailer->compose();
        $mail->setTo($email);
        $mail->setSubject("接口报警");
        $mail->setHtmlBody($message);
        return $mail->send();

    }

    /**
     * 监控联系人列表
     */
    public static function getMonitorer()
    {
        $monitorList = Yii::$app->db->createCommand('SELECT `users_id`,`roleid`,`username`,`realname`,`mobile`,`email`,`notification` FROM {{%users}} WHERE `notification`>:notification ORDER BY `users_id`',['notification'=> self::getMonitorSwitchCondition()])->queryAll();
        return $monitorList;
    }

    public static function getMonitorSwitchCondition()
    {
        $tmpObj = new self;
        return $tmpObj->isMonitorUser;
    }
}
