<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Perusahaan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perusahaan-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <h4>Serial Key : <?=$model->serialkey?></h4>
    <div class="col-md-6">
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'kodebon')->textInput(['maxlength' => true]) ?>
    </div>
     <div class="col-md-9">
    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
    </div><div class="col-md-3">
    <?= $form->field($model, 'kota')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-2">
    <?= $form->field($model, 'timer1')->textInput(['maxlength' => true]) ?>
    </div><div class="col-md-2">
    <?= $form->field($model, 'timer2')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-2">
    <?= $form->field($model, 'batas')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-2">
    <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>
    </div>
	<div class="col-md-1">
    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
    </div><div class="col-md-3">
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="row">
    <div class="col-md-4">
    <?php
   if(trim($model->logo_1)<>""){
    $images=Yii::$app->homeUrl."/images/".$model->logo_1;
    echo $form->field($model, 'logo_1')->widget(FileInput::classname(), [
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
    echo $form->field($model, 'logo_1')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
     'pluginOptions' => [
        'maxFile'=>1,
    ]
    ]); 
    }
     ?>
    </div>
    <div class="col-md-4">
    <?php
   if(trim($model->logo_3)<>""){
    $images=Yii::$app->homeUrl."/images/".$model->logo_3;
    echo $form->field($model, 'logo_3')->widget(FileInput::classname(), [
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
    echo $form->field($model, 'logo_3')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
     'pluginOptions' => [
        'maxFile'=>1,
    ]
    ]); 
    }
     ?>
    </div>
    <div class="col-md-4">
    <?php
   if(trim($model->logo_2)<>""){
    $images=Yii::$app->homeUrl."/images/".$model->logo_2;
    echo $form->field($model, 'logo_2')->widget(FileInput::classname(), [
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
    echo $form->field($model, 'logo_2')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
     'pluginOptions' => [
        'maxFile'=>1,
    ]
    ]); 
    }
     ?>
    </div>
   </div>
     
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
