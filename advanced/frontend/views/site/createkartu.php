<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
Use app\models\User;
use yii\web\JsExpression;
$url = \yii\helpers\Url::to(['site/guest']);
?>
<div class="scan-create">

<?php

/* @var $this yii\web\View */
/* @var $model app\models\Scan */
/* @var $form yii\widgets\ActiveForm */
$cityDesc =empty($model->id) ? '' : User::findOne($model->id)->nama;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin( ['options'=>['target'=>'_blank']]); ?>

    
	<?php 
    echo $form->field($model, 'username')->widget(Select2::classname(), [
        //'initValueText' => $cityDesc, 
        'options' => ['placeholder' => 'Search for Karyawam ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(username) { return username.text; }'),
            'templateSelection' => new JsExpression('function (username) { return username.text; }'),
        ],
    ])->label('Nama Karyawan');
    ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Cetak Kartu' : 'Cetak Kartu', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
			]) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
</div>
