<?php

/* @var $this yii\web\View */
use app\models\Grup;
use app\models\Scan;
use app\models\Barcodeinput;
use scotthuangzl\googlechart\GoogleChart;
$this->title = 'Sistem Barcode';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent" style="overflow-x: scroll;">
        <h1 class="display-4">Sistem Scan Barcode</h1>

        <p class="lead">Support connection barcode to </p>
 

    <?php
    //$has=Grup::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->all();
    $has=Grup::find()->all();
    $i=0;
    foreach ($has as $key => $value) {
    ?>
    <div style="margin:15px;float: left;">
    <img src="<?php echo Yii::$app->homeUrl."/images/".$value->foto?>" style="height:50px;">
   
    </div>

    <?php
    }
    ?>
    </div>
    <div class="clearfix visible-xs-block"> </div>
    <div class="col-md-12">
        
    <?php include '_searchdash.php' ?>
            
    </div>
    <div class="row">
    <div class="col-md-5">
    <div class="box box-danger">
        <div class="box-header with-border">
              <h3 class="box-title">Resi Belum Packing</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
    <div class="box-body no-padding">
    <?php

    if(isset($model->tgl_a) and isset($model->tgl_b)) {
        $total=Barcodeinput::find()->where('tanggal between "'.$model->tgl_a.'" and "'.$model->tgl_b.'" and  id_perusahaan='.Yii::$app->user->identity->id_perusahaan)->count();
        $kirim=Barcodeinput::find()->where('tanggal between "'.$model->tgl_a.'" and "'.$model->tgl_b.'" and  id_perusahaan='.Yii::$app->user->identity->id_perusahaan.' and barcode in (
            select barcode from scan where id_perusahaan='.Yii::$app->user->identity->id_perusahaan.")")->count();
        $progress=Barcodeinput::find()->where('tanggal between "'.$model->tgl_a.'" and "'.$model->tgl_b.'" and  id_perusahaan='.Yii::$app->user->identity->id_perusahaan.' and barcode not in (
            select barcode from scan where id_perusahaan='.Yii::$app->user->identity->id_perusahaan.")")->count();;
    } else {    
        $total=Barcodeinput::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->count();
        $kirim=Barcodeinput::find()->where('id_perusahaan='.Yii::$app->user->identity->id_perusahaan.' and barcode in (
            select barcode from scan where id_perusahaan='.Yii::$app->user->identity->id_perusahaan.")")->count();
        $progress=Barcodeinput::find()->where('id_perusahaan='.Yii::$app->user->identity->id_perusahaan.' and barcode not in (
            select barcode from scan where id_perusahaan='.Yii::$app->user->identity->id_perusahaan.")")->count();;
    }
   
    echo GoogleChart::widget(array('visualization' => 'PieChart',
                'data' =>  array(
                    array('Label', 'Value'),
                    //array('Input', intval($total)),
                    array('Terpacking', intval($kirim)),
                    array('Belum Terpacking', intval($progress))
                ),
                'options' => array('title' => '','height'=>350))); 
    
    //$dua=Yii::$app->db->createCommand
    ?>
    </div>
    </div>
    </div>    
    <div class="col-md-7">
    <div class="box box-info">
        <div class="box-header with-border">
              <h3 class="box-title">Resi Retur</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
    <div class="box-body no-padding">            
    <?php
    if(isset($model->tgl_a) and isset($model->tgl_b)) {

    $cekk=Yii::$app->db->createCommand("select c.nama,count(a.id) as total from barcode_retur a join grup c on a.id_grup=c.id where a.tanggal between '".$model->tgl_a."' and '".$model->tgl_b."' and a.id_perusahaan =".Yii::$app->user->identity->id_perusahaan." group by id_grup")->queryAll();
    } else {

    $cekk=Yii::$app->db->createCommand("select c.nama,count(a.id) as total from barcode_retur a join grup c on a.id_grup=c.id where  a.id_perusahaan =".Yii::$app->user->identity->id_perusahaan." group by id_grup")->queryAll();
    }
    //var_dump($cekk);
    $i=1;
    $datar[0][]='Label';
    $datar[0][]='Value';
    $datar[0][]=['role'=>'style'];
    foreach($cekk as $val){
        $datar[$i][]=$val['nama'];
        $datar[$i][]=intval($val['total']);
        $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
        $warna='#' . $rand;
        $datar[$i][]=$warna;

        $i++;
    }
    echo GoogleChart::widget(array('visualization' => 'ColumnChart',
                'data' =>   $datar,
                'options' => array('title' => '','height'=>350,'legend'=>['position'=>'none']))); 
    
    //$dua=Yii::$app->db->createCommand
    ?>
    </div>
    </div>
    </div>
    </div>

    <div class="box box-success">
        <div class="box-header with-border">
              <h3 class="box-title">Resi Terpacking</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
    <div class="box-body no-padding">
    <?php
    if(isset($model->tgl_a) and isset($model->tgl_b)) {

    $cekk=Yii::$app->db->createCommand("select b.nama,count(a.id) as total from scan a join grup b on a.id_grup=b.id where tanggal between '".$model->tgl_a."' and '".$model->tgl_b."' and  a.id_perusahaan=".Yii::$app->user->identity->id_perusahaan." group by id_grup")->queryAll();
    } else {
    $cekk=Yii::$app->db->createCommand("select b.nama,count(a.id) as total from scan a join grup b on a.id_grup=b.id where a.id_perusahaan=".Yii::$app->user->identity->id_perusahaan." group by id_grup")->queryAll();

    }
    //var_dump($cekk);
    $i=1;
    $data[0][]='Label';
    $data[0][]='Value';
    $data[0][]=['role'=>'style'];
    foreach($cekk as $val){
        $data[$i][]=$val['nama'];
        $data[$i][]=intval($val['total']);
        $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
        $warna='#' . $rand;
        $data[$i][]=$warna;

        $i++;
    }
    echo GoogleChart::widget(array('visualization' => 'ColumnChart',
                'data' =>   $data
                                ,
                'options' => array('title' => '','height'=>350,'legend'=>['position'=>'none']))); 
    
    ?>
    </div>
    </div>
    

</div>
