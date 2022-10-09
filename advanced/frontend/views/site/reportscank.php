<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use app\models\Grup;
use yii\helpers\ArrayHelper;
$provinsi=Grup::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->orderBy(['nama' => SORT_ASC])->all();
$kprovinsi=ArrayHelper::map($provinsi,'id','nama');
/* @var $this yii\web\View */
/* @var $searchModel app\models\ScanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Kompilasi';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$kolom=[
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
        'attribute'=>'status',
        'header'=>'Status Input',
        'filter'=>false,
        'value'=>function ($model, $key, $index, $widget) { 
                return isset($model->input)?$model->input->add_date:'NO ENTRY / NO DATA';
        },
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'header'=>'Status Packing',
        'filter'=>false,
        'value'=>function ($model, $key, $index, $widget) { 
                return isset($model->add_date)?$model->add_date:'NOT PACKED';
        },
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'status',
        'header'=>'Status Delivery',
        'filter'=>false,
        'value'=>function ($model, $key, $index, $widget) { 
                return isset($model->retur)?'RETUR '.$model->retur->tanggal:'SENT';
        },
     ],
   
];
?>
<?php  echo $this->render('_searchd', ['model' => $searchModel]); ?>
<div class="scan-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'responsiveWrap'=>false,
            'pjax'=>true,
            'columns' => $kolom,
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Report Kompilasi',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>'<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
