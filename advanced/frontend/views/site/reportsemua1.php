<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Perusahaan;
use app\models\User;
use app\models\Grup;
use scotthuangzl\googlechart\GoogleChart;
$user=User::findOne(Yii::$app->user->identity->id);
$this->title=$user->kompeni->nama;
$nmm=$user->kompeni->nama;
echo "<h3>".$nmm."</h3><h3>Report Summary from ".date('d-m-Y',strtotime($tgl_a))." until ".date('d-m-Y',strtotime($tgl_b))." </h3>";
?>

<h4>Grup Summary</h4>
<table class="table table-striped table-hover">
        <tr>
            <th style="text-align:center;">Nomor</th>
            <th style="text-align:center;">Grup Kurir</th>
            <th style="text-align:center;">Qty Retur</th>
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
			<td style="text-align:center;"><?php echo $nama->nama ?></td>
			<td style="text-align:center;"><?php echo $key['jml'] ?></td>
		</tr>

	<?php 
		$jumlah=$jumlah+$key['jml'];
		}
		?>
		<tr>
			<td colspan="2" style="text-align:center;">Jumlah Total Retur</td>
			<td style="text-align:center;"><?php echo number_format($jumlah,0)?></td>
		</tr>



</table>
<h4>User Summary</h4>
<table class="table table-striped table-hover">
        <tr>
            <th style="text-align:center;">Nomor</th>
            <th style="text-align:center;">User Name</th>
            <th style="text-align:center;">Qty Retur</th>
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
			<td style="text-align:center;"><?php echo $nama->nama ?></td>
			<td style="text-align:center;"><?php echo $key['jml'] ?></td>
		</tr>

	<?php 
		$jumlah=$jumlah+$key['jml'];
		}
		?>
		<tr>
			<td colspan="2" style="text-align:center;">Jumlah Total Retur</td>
			<td style="text-align:center;"><?php echo number_format($jumlah,0)?></td>
		</tr>
</table>

    <div class="box box-info">
        <div class="box-header with-border">
              <h3 class="box-title">Scan Retur</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
    <div class="box-body no-padding">            
    <?php
    $cekk=Yii::$app->db->createCommand("select c.nama,count(a.id) as total from barcode_retur a join scan b on a.barcode=b.barcode join grup c on b.id_grup=c.id where a.tanggal between '".$tgl_a."' and '".$tgl_b."' and b.id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and a.id_perusahaan =".Yii::$app->user->identity->id_perusahaan." group by id_grup")->queryAll();
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

<script type="text/javascript">
        
        window.print();
    </script>