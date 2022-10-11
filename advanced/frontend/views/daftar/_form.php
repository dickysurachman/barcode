<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Perusahaan;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\user */
/* @var $form yii\widgets\ActiveForm */
$negara=ArrayHelper::map(Perusahaan::find()->orderBy('nama')->all(),'id','nama');
//$tipe=['Administrator','BPTU HPT','BIB','BET']
$hapus=['Enable','Disable'];
$tipe=['Admin Company','Superadmin'];

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'password_hash')->textInput() ?>

    <?php //= $form->field($model, 'updated_at')->textInput() ?>

   
    <?= $form->field($model, 'tipe_user2')->dropDownList($tipe,array('prompt'=>'Silahkan Pilih'))  ?>

    <?= $form->field($model, 'id_perusahaan')->dropDownList($negara,array('prompt'=>'Silahkan Pilih')) ?>
    
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
