<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarcodereturSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yii', 'Barcode Retur');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
$kolom=[
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
        'attribute'=>'tanggal',
    ],   
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'barcode',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'barcode',
        'header'=>'Expedition',
        'filter'=>false,
        'value'=>function ($model, $key, $index, $widget) { 
                return isset($model->scann)?$model->scann->grup->nama:'';
        },
        //'filter'=>$kprovinsi,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'alasan',
    ],    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'add_date',
    ],    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'add_who',
        'filter'=>false,
        'value'=>function ($model, $key, $index, $widget) { 
                return isset($model->add)?$model->add->nama:'';
        },
    ],
];

?>
<div class="barcoderetur-index">
    <?php  echo $this->render('_searchd', ['model' => $searchModel]); ?>

    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
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
            'responsiveWrap' => false,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Barcode Retur listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>               
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
