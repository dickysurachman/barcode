<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Scan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_grup')->textInput() ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'id_perusahaan')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'add_who')->textInput() ?>

    <?= $form->field($model, 'add_date')->textInput() ?>

    <?= $form->field($model, 'edit_who')->textInput() ?>

    <?= $form->field($model, 'edit_date')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
