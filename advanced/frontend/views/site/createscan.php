<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$ap='<audio autoplay="autoplay" controls="false" loop="true">  
   <source src="new_user.mp3" />  
            </audio>';
$hihi=Yii::$app->session->getFlash('danger');
$huhu=Yii::$app->session->getFlash('success');
if(isset($hihi)){
?>
<audio autoplay="autoplay" controls="false" loop="true">  
   <source src="<?php echo Yii::$app->homeUrl ?>/new_user.mp3" />  
</audio>
  <script>
  audioElement.play();
</script>


<?php } 
if(isset($huhu)){
?>
<audio autoplay="autoplay" controls="false" loop="false">  
   <source src="<?php echo Yii::$app->homeUrl ?>/doorbell.mp3" />  
</audio>
  <script>
  audioElement.play();
</script>
    <?php
}
?>
<div class="scan-create">

<?php

/* @var $this yii\web\View */
/* @var $model app\models\Scan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
</div>
<script>
  document.getElementById("scan-barcode").focus();
</script>