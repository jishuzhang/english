<?php
return [
    'components' => [
       'db' => [
           'class' => 'yii\db\Connection',
           'dsn' => 'mysql:host=192.168.0.168;dbname=interface',
           'username' => 'admin',
           'password' => 'admin',
           'charset' => 'utf8',
           'tablePrefix' => '',
       ],
        'knowledge' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=192.168.0.168;dbname=knowledge',
                'username' => 'admin',
                'password' => 'admin',
                'charset' => 'utf8',
                'tablePrefix'=>'kw_'
            ],
        'bailitop' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.0.168;dbname=bailitop',
            'username' => 'admin',
            'password' => 'admin',
            'charset' => 'utf8',
            'tablePrefix'=>'site_'
        ],
        'bailidb' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.0.168;dbname=bailidb',
            'username' => 'admin',
            'password' => 'admin',
            'charset' => 'utf8',
            'tablePrefix'=>'bl_'
        ],

	'crm' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.0.168;dbname=crm',
            'username' => 'admin',
            'password' => 'admin',
            'charset' => 'utf8',
            'tablePrefix'=>'user_'
        ],

	'edusoho' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.0.168;dbname=edusoho',
            'username' => 'esuser',
            'password' => 'edusoho',
            'charset' => 'utf8',
            'tablePrefix'=>''
        ],

	'english' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.32.7;dbname=english',
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
                'password' => 'bailitop2016',
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
