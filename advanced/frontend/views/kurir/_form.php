<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Grup;
use yii\helpers\ArrayHelper;
$provinsi=Grup::find()->orderBy(['nama' => SORT_ASC])->all();
$kprovinsi=ArrayHelper::map($provinsi,'id','nama');
/* @var $this yii\web\View */
/* @var $model app\models\Kurir */
/* @var $form yii\widgets\ActiveForm */
$hapus=['Active','Non Active'];
$carix=['Mengandung','Diawali'];
?>

<div class="kurir-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'id_grup')->dropDownList($kprovinsi,['prompt'=>'Please Choose',  
    ]) ?>
	<?= $form->field($model, 'cari3')->dropDownList($carix,['prompt'=>'Please Choose',  
    ]) ?>
    <?= $form->field($model, 'cari1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cari2')->textInput() ?>


   <?= $form->field($model, 'status')->dropDownList($hapus,array('prompt'=>'Silahkan Pilih'))  ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
