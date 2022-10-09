<?php

use yii\helpers\Url;
use yii\helpers\Html;
$coba=['Administrator','FO Scan','Cetak Barcode','FO Leader'];
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'username',
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'auth_key',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'password_hash',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'password_reset_token',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nama',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nik',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'jabatan',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tipe_user',
        'value'=>'tipeuser',  
        'filter'=>$coba,      
    ],
   [
                'header'=>'ID Card',
                'attribute' => 'img',
                'format' => 'raw',
                'label' => 'Print Id Card',
                'value'=>function ($data) {
                                return 
								Html::a('<span class="glyphicon glyphicon-print" style="font-size:14pt;" title="Print"></span>',['site/invoice', 'id' => md5($data->username)],
                                    ['target'=>'_blank', 'data-pjax'=>"0",'class' => 'linksWithTarget'])." ".
								Html::a('<span class="glyphicon glyphicon-qrcode" style="font-size:14pt;" title="Print"></span>',['site/invoiceqr', 'id' => md5($data->username)],
                                    ['target'=>'_blank', 'data-pjax'=>"0",'class' => 'linksWithTarget']);
                                },
    ],    
    /*[
        //'class' => 'yii\grid\ActionColumn',
        'header'=>'User Scan',
        'attribute' => 'img',
        'format' => 'raw',
        'label' => 'Status',
        'value'=>function ($data) {
                        return Html::a('<span class="glyphicon glyphicon-open" style="font-size:14pt;" title="pickup"></span>',['viewp', 'id' => $data->id],
                        ['data-pjax'=>"0",'class' => 'linksWithTarget']);
                            //['role'=>'modal-remote','title'=>'Update Password','data-toggle'=>'tooltip']);
                            //['data-pjax'=>"0",'class' => 'linksWithTarget']);
                        },
    ], */
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'status',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tipe_user',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id_profile',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
		'header'=>'User Scan',
        'vAlign'=>'middle',
        'template'=>'{password}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
            'password' => function ($url, $model, $key) {
                return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-file"></span>', ['updatescan', 'id'=>$model->id],['data-pjax' => "1",'role'=>'modal-remote','title'=>'Update Password','data-toggle'=>'tooltip']);
            },
        ],
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'template'=>'{view}{update}{delete}{password}',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons' => [
            'password' => function ($url, $model, $key) {
                return Html::a('&nbsp;&nbsp;<span class="glyphicon glyphicon-flash"></span>', ['updatep', 'id'=>$model->id],['data-pjax' => "1",'role'=>'modal-remote','title'=>'Update Password','data-toggle'=>'tooltip']);
            },
        ],
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   