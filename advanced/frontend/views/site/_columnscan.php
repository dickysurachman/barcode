<?php
use yii\helpers\Url;
use app\models\Grup;
use yii\helpers\ArrayHelper;
$provinsi=Grup::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->orderBy(['nama' => SORT_ASC])->all();
$kprovinsi=ArrayHelper::map($provinsi,'id','nama');
return [
  
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'barcode',
    ],
      [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_grup',
        'value'=>function ($model, $key, $index, $widget) { 
                return isset($model->grup)?$model->grup->nama:'';
        },
        'filter'=>$kprovinsi,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kode',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tanggal',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'status',
    // ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'add_who',
         'value'=>function ($model, $key, $index, $widget) { 
                return isset($model->add)?$model->add->nama:'';
        },
    ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'add_date',
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'edit_who',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'edit_date',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
		'template'=>'{delete}',
        'vAlign'=>'middle',
		'urlCreator' => function($action, $model, $key, $index) { 
                if($action=="delete"){
                    return Url::to(["scan/delete",'id'=>$key]);
                }       
        },
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