<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */
?>
<div class="contact-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'tanggal',
            'email:email',
            'subjek',
            'isi:ntext',
            'id_perusahaan',
        ],
    ]) ?>

</div>
