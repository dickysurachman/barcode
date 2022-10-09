<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please scan qrcode:</p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username',['inputOptions' => ['autocomplete' => 'off', ]])->textInput(['autofocus' => true])->label('QR Code') ?>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>
            <?= Html::a('Login using User & Password', ['site/login'],['class'=>'btn btn-success btn-block btn-flat']) ?>.
            <?php ActiveForm::end(); ?>
</div>