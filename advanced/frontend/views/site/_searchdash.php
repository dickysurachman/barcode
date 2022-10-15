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

/* @var $this yii\web\View */
/* @var $model app\models\ReservasiSearch */
/* @var $form yii\widgets\ActiveForm */
$cityDesc =empty($model->add_who) ? '' : User::findOne($model->add_who)->nama;
?>

<div class="row">

    <?php $form = ActiveForm::begin([
        //'action' => ['site/report'],
        //'method' => 'get',
    ]); ?>
    <div class="row">
    <div class="col-md-6" >
    <label><?php echo \Yii::t('yii', 'Date From')?></label>
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
    <div class="col-md-6" >
        <label><?php echo \Yii::t('yii', 'Until')?></label>
    <?php 
    echo DatePicker::widget([
    'model'  => $model,
    'attribute'=>'tgl_b',
    'language' => 'en',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>['class'=>'form-control','readonly'=>'readonly'
    ]]);
    ?></div>
    
    

    </div>
    <div class="form-group" style="margin-top:15px">
        <?= Html::submitButton(\Yii::t('yii', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php //= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
