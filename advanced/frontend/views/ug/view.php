<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usergrup */
?>
<div class="usergrup-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_user',
            'id_grup',
            'id_perusahaan',
        ],
    ]) ?>

</div>
