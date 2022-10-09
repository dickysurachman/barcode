<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Perusahaan */
/* @var $form yii\widgets\ActiveForm */
$tipe=['Aktif','Tidak Aktif'];
?>

<div class="perusahaan-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="col-md-6">
    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'kodebon')->textInput(['maxlength' => true]) ?>
    </div>
 
    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
    <div class="col-md-2">
    <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-2">
    <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
    </div><div class="col-md-2">
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div><div class="col-md-6">
    <?= $form->field($model, 'status')->dropDownList($tipe) ?>
    </div>

    <?php
   if(trim($model->logo_1)<>""){
    $images="images/".$model->logo_1;
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
    
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
