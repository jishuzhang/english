<?php
return [
    'components' => [

        'db'=>[
            'class'=>'yii\db\Connection',
            'dsn'=>'mysql:host=localhost;dbname=func_count',// 注释提取数据库
            'username'=>'root',
            'password'=>'aaaaaa',
            'charset'=>'utf8',
            'tablePrefix' => 'bl_',
            ],

        'english' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhost;dbname=english',
                'username' => 'root',
                'password' => 'aaaaaa',
                'charset' => 'utf8',
                'tablePrefix'=>''
            ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',

            //这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'useFileTransport' =>false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.vip.163.com',  //每种邮箱的host配置不一样
                'username' => 'bailitop@vip.163.com',
                'password' => '',
                'port' => '994',
                'encryption' => 'ssl',
            ],

            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['bailitop@vip.163.com'=>'admin']
            ],
        ],
    ],
];
