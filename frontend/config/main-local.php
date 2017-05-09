<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'IGfsVYPocR3bLDrxnm5E-Q_3kqgRcQHo',
        ],
    ],
];

if (!YII_ENV_TEST) {
//    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] =[
//        'class' => 'yii\debug\Module',
//        'allowedIPs'=>array('192.168.32.100','::1','127.0.0.1'),
//    ];
//
//    $config['bootstrap'][] = 'gii';
//    // $config['modules']['gii'] = 'yii\gii\Module';
//    $config['modules']['gii'] = [
//            'class' => 'yii\gii\Module',
//            'allowedIPs'=>array('192.168.32.100','::1','127.0.0.1'),
//        ];


}

return $config;
