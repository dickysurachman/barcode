<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\web\View;
use app\models\User;
use kartik\select2\Select2;
use yii\web\JsExpression;
$url = \yii\helpers\Url::to(['site/guest']);
$script = <<< JS
$("#scansearch-tgl_a").datepicker({
    changeMonth: true, 
    changeYear: true, 
    dateFormat:'yy-mm-dd',
}); 
$("#scansearch-tgl_b").datepicker({
    changeMonth: true, 
    changeYear: true, 
    dateFormat:'yy-mm-dd',
}); 
JS;
$position= View::POS_END;
$this->registerJs($script,$position);
$cityDesc =empty($model->add_who) ? '' : User::findOne($model->add_who)->nama;
/* @var $this yii\web\View */
/* @var $model app\models\ReservasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservasi-search">
    <h2>Export Data to CSV</h2>
    <?php $form = ActiveForm::begin([]); ?>
    <div class="col-md-6" style="margin-bottom:15px;padding-left:0px !important;">
    <label>Dari Tanggal</label>
    <?php
    echo DatePicker::widget([
    'model'  => $model,
    'attribute'=>'tgl_a',
    'language' => 'en',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>['class'=>'form-control','readonly'=>'readonly'
    //'dateFormat'=>'yy-mm-dd',
    ]]);
    ?>
    </div>
    <div class="col-md-6" style="margin-bottom:15px;padding-right:0px !important;">
        <label>Sampai</label>
    <?php 
    echo DatePicker::widget([
    'model'  => $model,
    'attribute'=>'tgl_b',
    'language' => 'en',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>['class'=>'form-control','readonly'=>'readonly'
    ]]);
    ?></div>

     <?php 
    if(Yii::$app->user->identity->tipe_user<>1){
        ?>

    <?php 
    echo $form->field($model, 'add_who')->widget(Select2::classname(), [
       // 'initValueText' => $cityDesc, 
        'options' => ['placeholder' => 'Search for Karyawam ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(add_who) { return add_who.text; }'),
            'templateSelection' => new JsExpression('function (add_who) { return add_who.text; }'),
        ],
    ])->label('Nama Karyawan');
    ?>
    <?php 
    }
    ?>

    
    <div class="form-group">
        <?= Html::submitButton('Export', ['class' => 'btn btn-primary']) ?>
        <?php //= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
