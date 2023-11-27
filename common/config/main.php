<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@backend/views' => '@vendor/hail812/yii2-adminlte3/src/views'
                ],
            ],
        ],
    ],
];
