<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Profile;
use yii\helpers\ArrayHelper;
use app\models\Grup;
use app\models\Usergrup;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\user */
/* @var $form yii\widgets\ActiveForm */
$negara=ArrayHelper::map(Profile::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->orderBy('nama')->all(),'id','nama');
//$tipe=['Administrator','BPTU HPT','BIB','BET']
$hapus=['Enable','Disable'];
$tipe=['Administrator','FO Scan'];
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?php 
	//$has=Grup::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->all();
	$has=Grup::find()->all();
	$i=0;
	foreach ($has as $key => $value) {
	?>
	<img src="<?php echo Yii::$app->homeUrl."/images/".$value->foto?>" style="height:50px;">
	<?php 
		$has=Usergrup::findOne(['id_user'=>$id,'id_grup'=>$value->id]);
		if(isset($has)){
	?>
	<?= $form->field($model, 'id_grup['.$value->id.']')->checkbox(['label'=>$value->nama,'checked'=>'checked']); ?>
	<?php } else { ?>
	<?= $form->field($model, 'id_grup['.$value->id.']')->checkbox(['label'=>$value->nama]); ?>
	<?php
	}
	}
	?>
	

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
