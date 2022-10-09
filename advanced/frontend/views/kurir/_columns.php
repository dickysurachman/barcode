<?php
use app\models\Grup;
use yii\helpers\ArrayHelper;
$provinsi=Grup::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->orderBy(['nama' => SORT_ASC])->all();
$kprovinsi=ArrayHelper::map($provinsi,'id','nama');
use yii\helpers\Url;
$st=['Active','Non Active'];

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
        'attribute'=>'nama',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cari1',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cari2',
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
        'attribute'=>'status',
        'value'=>'sat',
        'filter'=>$st,
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'add_who',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'add_date',
    // ],
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
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
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