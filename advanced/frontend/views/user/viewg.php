<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Grup */
?>
<div class="grup-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            //'status',
            //'id_perusahaan',
        ],
    ]) ?>

</div>
