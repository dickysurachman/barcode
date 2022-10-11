<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Login</b>Program</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= Html::submitButton('Send', ['class' => 'btn btn-danger btn-block btn-flat']) ?>

            <?php ActiveForm::end(); ?>
            <br/>
         <?= Html::a('Login', ['site/login'],['class'=>'btn btn-success btn-block btn-flat']) ?>.
            <br/>
         <?= Html::a('Register', ['site/register'],['class'=>'btn btn-info btn-block btn-flat']) ?>.
        <br>
        

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->

