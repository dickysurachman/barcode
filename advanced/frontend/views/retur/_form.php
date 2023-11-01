<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Barcoderetur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barcoderetur-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row"> 
    <div class="col-md-4">
    <label>Date</label>
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
    <div class="col-md-4">
    <?= $form->field($model, 'pesanan')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>
    </div>
    </div>

    <?= $form->field($model, 'alasan')->textInput(['maxlength' => true]) ?>




  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('yii', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
