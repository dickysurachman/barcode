<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Perusahaan */
?>
<div class="perusahaan-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'alamat',
            'telp',
            'fax',
            'email:email',
            'tax',
            'service',
             [
                'attribute' => 'logo_1',
                'value'=> Yii::$app->homeUrl.'/images/' .$model->logo_1,
                'format' => ['image',['class'=>'img-responsive']],
              ],
            //'logo_1',
            //'status',
        ],
    ]) ?>

</div>
