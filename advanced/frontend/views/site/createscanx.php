<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//url=Url;
/*
$this->registerJs(
   '$(document).ready(function() {
	  update();	  
	  setInterval(update,6000);
	});
	function update() {
		$.ajax({
		type: "POST",
		url: "time.php",
		success: function(data) {
		  $("#servertime").html(data); 
		  
		}
	  });
	}'
);*/

$ap='<audio autoplay="autoplay" controls="false" loop="true">  
   <source src="new_user.mp3" />  
            </audio>';
/*$hihi=Yii::$app->session->getFlash('danger');
$huhu=Yii::$app->session->getFlash('success');
if(isset($hihi)){
?>
<audio autoplay="autoplay" controls="false" loop="false">  
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
}*/
?>
<div class="scan-create">

<?php

/* @var $this yii\web\View */
/* @var $model app\models\Scan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scan-form">

    <?php $form = ActiveForm::begin(['id'=>'barcodemass']); ?>

    <?= $form->field($model, 'barcode')->textarea(['rows' => '10']) ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
</div>
<?php 
if(isset($data)){
	foreach($data as $value =>$val){
		//var_dump($val);
		//echo $val['tipe'];
		//var_dump($value);
		echo "<div class='alert-".$val['tipe']." alert fade in'>".$val['data']."</div>";
	}
	
}

?>
<script>
  document.getElementById("scan-barcode").focus();
</script>