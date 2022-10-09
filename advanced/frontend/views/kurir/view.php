<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kurir */
?>
<div class="kurir-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'nama',
            'cari1',
            'cari2',
            //'id_perusahaan',
            [
                'attribute'=>'status',
                'value'=>'sat'
            ],
            [
                'attribute'=>'id_grup',
                'value'=> isset($model->grup)?$model->grup->nama:'',
            ],
            [
                'attribute'=>'add_who',
                'value'=> isset($model->add)?$model->add->nama:'',
            ],
            //'status',
  //          'add_who',
            'add_date',
            [
                'attribute'=>'edit_who',
                'value'=> isset($model->edit)?$model->edit->nama:'',
            ],
//            'edit_who',
            'edit_date',
        ],
    ]) ?>

</div>
