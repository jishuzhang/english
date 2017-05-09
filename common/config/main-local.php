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
            ],

            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['gun@vip.163.com'=>'admin']
            ],
        ],
    ],
];
