<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Profile;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\user */
/* @var $form yii\widgets\ActiveForm */
$negara=ArrayHelper::map(Profile::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->orderBy('nama')->all(),'id','nama');
//$tipe=['Administrator','BPTU HPT','BIB','BET']
$hapus=['Enable','Disable'];
$tipe=['Administrator','Operator Scan'];
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'password_hash')->textInput() ?>
    <?= $form->field($model, 'nama')->textInput() ?>
    <?= $form->field($model, 'nik')->textInput() ?>
    <?= $form->field($model, 'jabatan')->textInput() ?>

    <?php //= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'tipe_user')->dropDownList($tipe,array('prompt'=>'Silahkan Pilih'))  ?>
    <?= $form->field($model, 'delete')->dropDownList($hapus,array('prompt'=>'Silahkan Pilih'))  ?>
    <?php
    
    if($model->foto<>""){
    $images=Yii::$app->homeUrl."/images/".$model->foto;
    echo $form->field($model, 'foto')->widget(FileInput::classname(), [
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
        
    echo $form->field($model, 'foto')->widget(FileInput::classname(), [
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
