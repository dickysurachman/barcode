<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\user */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'tipeuser',
            'profile',
            //'status',
            //'created_at',
            //'updated_at',
            //'tipe_user',
            //'id_profile',
        ],
    ]) ?>

</div>
