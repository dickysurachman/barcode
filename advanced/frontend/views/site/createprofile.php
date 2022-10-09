<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */

$this->title = 'Update Profile';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userprofile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formprofile', [
        'model' => $model,
		
    ]) ?>

</div>
