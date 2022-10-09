<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Grup */
/* @var $form yii\widgets\ActiveForm */
$st=['Active','Non Active'];
?>

<div class="grup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
	 <?= $form->field($model, 'status')->dropDownList($st,['prompt'=>'Please Choose']); ?>
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
