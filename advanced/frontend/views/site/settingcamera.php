<?php
use yii\helpers\Html;
//use yii\bootstrap4\ActiveForm;
use yii\widgets\ActiveForm;
$this->title=Yii::t('yii', 'Setting Printer');
/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */

    $myfile = fopen("setting2.txt", "r") or die("Unable to open file!");
        // Output one line until end-of-file
        $i=0;
        $satu=[];
        $block =1024*1024;
        while(!feof($myfile)) {
            $satu[$i]=fread($myfile,$block);
            $i++;
            echo fread($myfile,$block) . "<br>";
        }
        fclose($myfile);
        //echo $i;
        $dua=explode("\n", $satu[0]);
        //var_dump($dua);
        $model->url2=$dua[0];
        $model->port_alat=$dua[1];
        $model->key=$dua[2];
        $model->ip_alat=$dua[3];
        //$model['url1']=$satu[0];
        //var_dump($satu);

?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url2')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ip_alat')->textInput()->label('IP server Camera') ?>
    <?= $form->field($model, 'port_alat')->textInput()->label('Camera Port') ?>
    <?= $form->field($model, 'key')->textInput() ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton(Yii::t('yii', 'Update'), ['class' => 'btn btn-success']) ?>
             <?= Html::a(Yii::t('yii', 'Download Program'), ['site/getcamera'], ['class' => 'btn btn-danger']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
