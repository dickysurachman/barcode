<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
$this->title = 'Register Member';
$this->params['breadcrumbs'][] = $this->title;
$user=['1','2','3','4','5','6','7','8','9','10'];
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'kota')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'jumlahuser')->dropDownList($user) ?>
                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
