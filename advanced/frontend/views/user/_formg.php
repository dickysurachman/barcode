<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Grup;
use yii\helpers\ArrayHelper;
$provinsi=Grup::find()->orderBy(['nama' => SORT_ASC])->all();
$kprovinsi=ArrayHelper::map($provinsi,'id','nama');
/* @var $this yii\web\View */
/* @var $model app\models\Grup */
/* @var $form yii\widgets\ActiveForm */
$st=['Active','Non Active'];
?>

<div class="grup-form">

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'id_grup')->dropDownList($kprovinsi,['prompt'=>'Please Choose',  
    ]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
