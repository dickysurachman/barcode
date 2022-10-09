<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barcoderetur */
?>
<div class="barcoderetur-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status',
            'alasan',
            'id_perusahaan',
            'barcode',
            'tanggal',
            'add_who',
            'edit_who',
            'add_date',
            'edit_date',
        ],
    ]) ?>

</div>
