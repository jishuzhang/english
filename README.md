安装步骤

配置 host

前台入口
    frontend/web/index.php
后台入口
   backend/web/index.php

更新配置文件
    english\common\config\main-local.php
        数据库配置

    english\common\config\params.php
    域名配置


运行环境
    php 5.6.22
    mysql 5.6.17

    nginx 重写

    ################ Yii framework rule #################

        location / {
            try_files $uri $uri/ /index.php?$args;
        }

        location ~ /(protected|framework|nbproject|themes/\w+/views|index-test\.php) {
            deny all;
            # for production
            internal;
            log_not_found off;
            access_log off;
        }

        ################ for Yii framework end #################
