<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJs(
'$("#formSubmit").on("submit",function(e){
        var formData = new FormData(this);
        var formURL = $("#formSubmit").attr("action");
        $.ajax(
        {
            url : formURL,
            type: "POST",
            data : formData,
            contentType: false,
            processData: false,
            success: function(res){
               $("#room_type").html(res);
               $("#inputan-barcode").val("");

            },
            error: function(res){
                $("#room_type").text("Error!");
                
            }
        });
        e.preventDefault();
       
    });'
);
?>
<div class="scan-create">

<?php

/* @var $this yii\web\View */
/* @var $model app\models\Scan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scan-form">

    <?php $form = ActiveForm::begin(['id'=>'formSubmit']); ?>

    <?= $form->field($model, 'barcode')->textInput(['maxlength' => true,'autocomplete' => 'off']) ?>
   
  
    

    <?php ActiveForm::end(); ?>
    <div id="room_type" class="alert-success alert">Notifikasi</div>
</div>
</div>
<script>
  document.getElementById("inputan-barcode").focus();
</script>