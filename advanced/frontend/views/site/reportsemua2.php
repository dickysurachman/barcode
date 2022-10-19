<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Perusahaan;
use app\models\User;
use app\models\Grup;
use app\models\Barcodeinput;
use scotthuangzl\googlechart\GoogleChart;
$userx=User::findOne(Yii::$app->user->identity->id);
$this->title=$userx->kompeni->nama;
$nmm=$userx->kompeni->nama;
//echo "<h3>".$nmm."</h3><h3> Packing Not Done Report Summary from ".date('d-m-Y',strtotime($tgl_a))." until ".date('d-m-Y',strtotime($tgl_b))." </h3>";
echo "<h3>".$nmm."</h3><h3>Laporan Resi Belum Terpacking Periode ".date('d-m-Y',strtotime($tgl_a))." sampai ".date('d-m-Y',strtotime($tgl_b))." </h3>";
?>

<h4>Grup Summary</h4>
<table class="table table-striped table-hover">
        <tr>
            <th style="text-align:center;">Nomor</th>
            <th style="text-align:center;">Grup Kurir</th>
            <th style="text-align:center;">Qty Input</th>
        </tr>

<?php 
	$i=0;
	$jumlah=0;
	foreach($grup as $key){
		$nama=Grup::findOne($key['id']);
		$i++;
		?>
		<tr>
			<td style="text-align:center;"><?php echo $i ?></td>
			<td style="text-align:center;"><?php echo (isset($nama->nama)?$nama->nama:'')?></td>
			<td style="text-align:center;"><?php echo $key['jml'] ?></td>
		</tr>

	<?php 
		$jumlah=$jumlah+$key['jml'];
		}
		?>
		<tr>
			<td colspan="2" style="text-align:center;">Jumlah Total Kirim</td>
			<td style="text-align:center;"><?php echo number_format($jumlah,0)?></td>
		</tr>



</table>
<h4>Total Akun User</h4>
<table class="table table-striped table-hover">
        <tr>
            <th style="text-align:center;">Nomor</th>
            <th style="text-align:center;">User Name</th>
            <th style="text-align:center;">Qty Input</th>
        </tr>

<?php 
	$i=0;
	$jumlah=0;
	foreach($user as $key){
		$nama=User::findOne($key['id']);
		$i++;
		?>
		<tr>
			<td style="text-align:center;"><?php echo $i ?></td>
			<td style="text-align:center;"><?php echo (isset($nama->nama)?$nama->nama:'') ?></td>
			<td style="text-align:center;"><?php echo $key['jml'] ?></td>
		</tr>

	<?php 
		$jumlah=$jumlah+$key['jml'];
		}
		?>
		<tr>
			<td colspan="2" style="text-align:center;">Jumlah Total Kirim</td>
			<td style="text-align:center;"><?php echo number_format($jumlah,0)?></td>
		</tr>
</table>


<h4>Input belum terkirim</h4>
<table class="table table-striped table-hover">
        <tr>
            <th style="text-align:center;">Nomor</th>
            <th style="text-align:center;">Tanggal</th>
            <th style="text-align:center;">Barcode</th>
        </tr>

<?php 
	$i=0;
	$jumlah=0;
	foreach($gagal as $key){
		//$nama=Grup::findOne($key['id']);
		$i++;
		?>
		<tr>
			<td style="text-align:center;"><?php echo $i ?></td>
			<td style="text-align:center;"><?php echo $key['tanggal']?></td>
			<td style="text-align:center;"><?php echo $key['barcode'] ?></td>
		</tr>

	<?php 
		//$jumlah=$jumlah+$key['jml'];
		}
		?>
		<tr>
			<td colspan="2" style="text-align:center;">Jumlah Total Belum Terpacking</td>
			<td style="text-align:center;"><?php echo number_format($i,0)?></td>
		</tr>




</table>

 <div class="row">
    <div class="box box-danger">
        <div class="box-header with-border">
              <h3 class="box-title">Resi Input Vs Resi Packing</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
    <div class="box-body no-padding">
    <?php
    $total=Barcodeinput::find()->where('id_perusahaan='.Yii::$app->user->identity->id_perusahaan.' and tanggal between "'.
    		$tgl_a.'" and "'.$tgl_b.'"')->count();
    $kirim=Barcodeinput::find()->where('id_perusahaan='.Yii::$app->user->identity->id_perusahaan.'  and tanggal between "'.
    		$tgl_a.'" and "'.$tgl_b.'" and barcode in (
        select barcode from scan where id_perusahaan='.Yii::$app->user->identity->id_perusahaan.")")->count();
    $progress=Barcodeinput::find()->where('id_perusahaan='.Yii::$app->user->identity->id_perusahaan.'  and tanggal between "'.
    		$tgl_a.'" and "'.$tgl_b.'" and barcode not in (
        select barcode from scan where id_perusahaan='.Yii::$app->user->identity->id_perusahaan.")")->count();;
   
    echo GoogleChart::widget(array('visualization' => 'PieChart',
                'data' =>  array(
                    array('Label', 'Value'),
                    //array('Input', intval($total)),
                    array('Terpacking', intval($kirim)),
                    array('On Progress', intval($progress))
                ),
                'options' => array('title' => '','height'=>350,'legend'=>['position'=>'none']))); 
    
    //$dua=Yii::$app->db->createCommand
    ?>
    </div>
    </div>
    </div>   

<script type="text/javascript">
        
        window.print();
    </script>