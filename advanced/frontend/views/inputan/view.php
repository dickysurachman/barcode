<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barcodeinput */
?>
<div class="barcodeinput-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama_file',
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
