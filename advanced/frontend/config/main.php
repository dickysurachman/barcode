<?php
use kartik\mpdf\Pdf;
date_default_timezone_set("Asia/Bangkok");
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);


/*use yii\web\AssetBundle;
class AdminLtePluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $js = [
        'datatables/dataTables.bootstrap.min.js',
        // more plugin Js here
    ];
    public $css = [
        'datatables/dataTables.bootstrap.css',
        // more plugin CSS here
    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}
*/
return [
    'id' => 'barcode-application',
    'name'=>"Sistem Scan Barcode",
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
                'gridview' =>  [
                    'class' => '\kartik\grid\Module'
                ]       
            ],
    
    'components' => [
        'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],
        'formatter' => [
                            'class' => 'yii\i18n\Formatter',
                            'thousandSeparator' => ',',
                            'decimalSeparator' => '.',
                            'currencyCode' => 'IDR',
                        ],
         'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                    ],
                ],
            ],
        
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    //'host' => 'smtp.gmail.com',
 'host' => 'mail.amoypreneur.com',
            'username' => 'barcode@amoypreneur.com',
            'password' => 'qcV&VcSMvj?*',
            'port' => '465',
            'encryption' => 'ssl',
                    ],
        ], 

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_barcode-sys', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
         //'class' => 'yii\web\View',
         'theme' => [
         /*      'class' => 'yii\base\Theme',
               'pathMap' => ['@app/views' => 'themes/metro'],
               'baseUrl'   => 'themes/metro'

         */
             'pathMap' => [
                '@app/views' => ['@app/themes/metro']
             ],
         ],
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
             'suffix'=>'.html',
            'rules' => [
            ],
        ],
        
    ],
    'controllerMap' => [
                    'migration' => [
                        'class' => 'bizley\migration\controllers\MigrationController',
                    ],
                ],
    'params' => $params,
    'params' => [
        'adminEmail' => 'sukasno.jami86@gmail.com',
        'supportEmail' => 'sukasno.jami86@gmail.com',
        'user.passwordResetTokenExpire' => 3600,
                'maskMoneyOptions' => [
                    'prefix' => 'Rp. ',
                    'suffix' => ' ',
                    'affixesStay' => false,
                    'thousands' => ',',
                    'decimal' => '.',
                    'precision' => 0, 
                    'allowZero' => false,
                    'allowNegative' => false,
                ],
                'googleMapsUrlOptions' => [
                    'key' => 'AIzaSyC9dg-3ggoP6Hy6phhTBeho6yfkP-eBlpE',
                    'language' => 'id',
                    'version' => '3.1.18',
                 ],
                'googleMapsOptions' => [
                    'mapTypeId' => 'roadmap',
                    'tilt' => 45,
                    'zoom' => 10,
                    ],
                ],
];
