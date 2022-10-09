<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Scan */
?>
<div class="scan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'barcode',
            'id_grup',
            'kode',
            'tanggal',
            'id_perusahaan',
            'status',
            'add_who',
            'add_date',
            'edit_who',
            'edit_date',
        ],
    ]) ?>

</div>
