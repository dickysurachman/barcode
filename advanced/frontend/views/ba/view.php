<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barcode */
?>
<div class="barcode-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'barcode',
            'tanggal',
            'add_who',
            'edit_who',
            'add_date',
            'edit_date',
        ],
    ]) ?>

</div>
