<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profile */
?>
<div class="profile-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'alamat:ntext',
            'telp',
            //'fax',
            //'shelter',
            //'map:ntext',
        ],
    ]) ?>

</div>
