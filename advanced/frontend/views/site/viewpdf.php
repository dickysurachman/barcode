<style>
 .wrapper{
    background-color: white !important;
    }
</style>

<?php
use app\models\Perusahaan;
use yii\helpers\Html;
$ha=Perusahaan::findOne($model->id_perusahaan);
function Terbilang($nilai) {
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        if($nilai==0){
            //return "Kosong";
        }elseif ($nilai < 12&$nilai!=0) {
            return "" . $huruf[$nilai];
        } elseif ($nilai < 20) {
            return Terbilang($nilai - 10) . " Belas ";
        } elseif ($nilai < 100) {
            return Terbilang($nilai / 10) . " Puluh " . Terbilang($nilai % 10);
        } elseif ($nilai < 200) {
            return " Seratus " . Terbilang($nilai - 100);
        } elseif ($nilai < 1000) {
            return Terbilang($nilai / 100) . " Ratus " . Terbilang($nilai % 100);
        } elseif ($nilai < 2000) {
            return " Seribu " . Terbilang($nilai - 1000);
        } elseif ($nilai < 1000000) {
            return Terbilang($nilai / 1000) . " Ribu " . Terbilang($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            return Terbilang($nilai / 1000000) . " Juta " . Terbilang($nilai % 1000000);
        }elseif ($nilai < 1000000000000) {
            return Terbilang($nilai / 1000000000) . " Milyar " . Terbilang($nilai % 1000000000);
        }elseif ($nilai < 100000000000000) {
            return Terbilang($nilai / 1000000000000) . " Trilyun " . Terbilang($nilai % 1000000000000);
        }elseif ($nilai <= 100000000000000) {
            return "Maaf Tidak Dapat di Prose Karena Jumlah nilai Terlalu Besar ";
        }
    }
?>
<div class="col-xs-8 col-md-2" style="border: black solid 1px;min-height: 250px !important;padding-top: 20px;margin-top: 15px;">

    <div class="col-xs-4 col-md-2">
        <img alt="testing" src="<?php echo Yii::$app->homeUrl ?>/barcode.php?size=25&text=<?php echo $model->nik?>"
		style="transform: rotate(90deg);margin-left: -80px;margin-top: 90px;">
    </div>

    <div class="col-xs-8 col-md-8" align="center">
         <img src="<?php echo Yii::$app->homeUrl."/images/".$ha->logo_1?>" class="" style="width:70px;">
       
        <h5><?php //echo $ha->nama ?></h5>
        <img src="<?php echo Yii::$app->homeUrl."/images/".$model->foto?>" style="width:100px;">
        <h6><?php echo $model->nama ?></h6>
        <h6><?php echo $model->jabatan ?></h6>


    </div>



</div>


