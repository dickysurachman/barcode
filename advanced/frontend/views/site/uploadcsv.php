<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\jui\DatePicker;
use kartik\file\FileInput;
// or 'use kartikile\FileInput' if you have only installed yii2-widget-fileinput in isolation
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userprofile-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
 <div class="col-md-12" style="margin-bottom:15px;padding-left:0px !important;">
    <label>Tanggal Scanning</label>
    <?php
    echo DatePicker::widget([
    'model'  => $model,
    'attribute'=>'tanggal',
    'language' => 'en',
    'dateFormat' => 'yyyy-MM-dd',
    'options'=>['class'=>'form-control','readonly'=>'readonly'
    //'dateFormat'=>'yy-mm-dd',
    ]]);
    ?>
    </div>
	<?= $form->field($model, 'csv')->fileInput() ?>
    <?php
		/*
    if(Yii::$app->user->identity->foto<>""){
    $images=Yii::$app->homeUrl."/images/".Yii::$app->user->identity->foto;
    echo $form->field($model, 'gambar')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
     'pluginOptions' => [
        'initialPreview'=>[
			$images
        ],
        'initialPreviewAsData'=>true,
         'maxFile'=>1,
    ]
	]);
    } else {
    	
    echo $form->field($model, 'gambar')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
     'pluginOptions' => [
        'maxFile'=>1,
    ]
    ]); 
    }*/
     ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
