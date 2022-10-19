<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Perusahaan;

$timerr=Perusahaan::findOne(['id'=>Yii::$app->user->identity->id_perusahaan]);
$batas=11;
if(isset($timerr)){
	$durasi =$timerr->timer1;
	$batas=$timerr->batas - 1;
} else {
	$durasi=5000;
}

$this->registerJs(
'
var formURL = $("#formSubmit").attr("action");
var pertama=setInterval(
function cekdata(){ 
	clearInterval(pertama);
	var msg=$("#inputan-barcode").val();	
	if((msg.length>'.$batas.')){
        var check =0;
		var hit=0;
		$.each(msg.split("\n"), function(e, element) {
			hit=hit+1;
			if((element.length==0)) {
				check=1;
			} else {
				check=0;				
			}
          });
		  if((check==1)&&(hit>1)){
			 var formData = new FormData();
			 var message = $("#inputan-barcode").val();
			 formData.append( "Inputan[barcode]", message);
             $.ajax({
					url : formURL,
					type: "POST",
					data : formData,
					contentType: false,
					processData: false,
					success: function(res){
						$("#room_type").html(res);
					   $("#inputan-barcode").val("");
					   $("#inputan-barcode").focus();
					},
					error: function(res){
						$("#room_type").text("Error!");					
					}
                });
        
            setTimeout(function(){}, '.$durasi.');
			var pertama=setInterval(cekdata,'.$durasi.');
			clearInterval(pertama);
			}
	}},'.$durasi.');'
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

     <?= $form->field($model, 'barcode')->textarea(['rows' => '10']) ?>
   
		
    

    <?php ActiveForm::end(); ?>
    <div id="room_type" class="alert-success alert">Notifikasi</div>
</div>
</div>
<script>
  document.getElementById("inputan-barcode").focus();
</script>