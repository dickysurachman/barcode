<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;




if(isset(Yii::$app->session['lang'])){
    Yii::$app->language=Yii::$app->session['lang'];
}
$this->title = \Yii::t('yii', 'Change Password');//'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-passsword">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-password']); ?>

                <?= $form->field($model, 'password')->passwordInput()->label(\Yii::t('yii', 'New Password')) ?>

                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('yii', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
				
				
            <?php ActiveForm::end(); ?>
        </div>
    </div>
	
</div>