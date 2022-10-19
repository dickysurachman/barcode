<style>
.keterangan {
	font-size:15pt;
}
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Inputan;
use app\models\Scan;
use app\models\Usergrup;
use app\models\Kurir;
use app\models\Perusahaan;

$timerr=Perusahaan::findOne(['id'=>Yii::$app->user->identity->id_perusahaan]);
$this->title="Monitoring Scanning";
$cc=Inputan::findOne(['status'=>0,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
if(isset($cc)){
$sac=substr($cc->barcode,0,2);
            if($sac <>"88" and $sac <>"89" and $sac <>"90"){  
            $h=Usergrup::find()->where(['id_user'=>Yii::$app->user->identity->id])->all();
            foreach($h as $key2){
                $k=Kurir::find()->where(['id_grup'=>$key2->id_grup])->all();
                foreach($k as $key){
				if($key->cari3==0) {
                $cek1=strpos(" ".$cc->barcode,$key->cari1);
                //$cek1=strpos(" ".$model->barcode,$key->cari1);
				} else {
				$jml=strlen($key->cari1);
				$awal=substr($cc->barcode,0,$jml);
				$ch=$key->cari1;
				//echo $model->barcode."/". $awal."/".$ch."/".$jml.$key->nama;
				//die();
				if($ch==$awal){
					$cek1=5;
				} else {
					$cek1=0;
				}
				}	
				$h=strlen($cc->barcode);
                $hasil=true;
                if($key->cari1=="0"){
                    $hh=is_numeric($cc->barcode);
                    if($h==$key->cari2 and $hh==1){
                        $hasil=true;
                    } else {
                        $hasil=false;
                    }

                }
                if($cek1>0 and $h==$key->cari2 and $hasil==true){
                        $nama=$key->nama;
                        $nama2=$key->grup->nama;
                        $nama3=$key->grup->id;
                        $nama4=$key->grup->foto;
						$cc->id_group=$nama3;
						$cc->foto=$nama4;
						$cc->nama=$nama2;
                        break;
                }
                    
                }
            }
            if(isset($nama)){
            $cekcok=Scan::findOne(['barcode'=>$cc->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
            if(isset($cekcok)){
            Yii::$app->session->setFlash('danger', $cc->barcode.' Data barcode sudah pernah diinput ');

            }   else {

            Yii::$app->session->setFlash('success', $cc->barcode.' Data sudah tersimpan dengan kurir '.$nama .'<br/>
            <img src="'.Yii::$app->homeUrl.'/images/'.$nama4.'" style="height:80px;">');
            $model = new Scan();
            $model->barcode=$cc->barcode;
            $model->id_grup=$nama3;
            $model->save();
            }             
            } else {
            
            Yii::$app->session->setFlash('danger', $cc->barcode.' Data barcode tidak ditemukan ');
            }
        }
        $cc->status=1;
        $cc->save();
    }
$ap='<audio autoplay="autoplay" controls="false" loop="true">  
   <source src="new_user.mp3" />  
            </audio>';
$hihi=Yii::$app->session->getFlash('danger');
$huhu=Yii::$app->session->getFlash('success');
if(isset($hihi)){
?>
<audio autoplay="autoplay" controls="false" loop="true">  
   <source src="<?php echo Yii::$app->homeUrl ?>/new_user.mp3" />  
</audio>
  <script>
  audioElement.play();
</script>


<?php } 
if(isset($huhu)){
?>
<audio autoplay="autoplay" controls="false" loop="false">  
   <source src="<?php echo Yii::$app->homeUrl ?>/doorbell.mp3" />  
</audio>
  <script>
  audioElement.play();
</script>
    <?php
}
?>
<div class="scan-create">

<?php

/* @var $this yii\web\View */
/* @var $model app\models\Scan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scan-form">
    <h3>Monitoring Scanning</h3>

   
    
</div>

<h4>5 Record Terakhir Validasi Antrian </h4>
<?php 
$command = (new \yii\db\Query())
    ->select(['barcode','id_group','foto','nama'])
    ->from('inputan')
    ->where(['status' =>1,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])
	 ->orderBy(['id' => SORT_DESC])
	 ->limit(5)
	->createCommand()->queryAll();
if(isset($command)){
echo "<ul>";
foreach($command as $value){
	if($value['id_group']==null){
		echo "<li class='keterangan'>Barcode ".$value['barcode']." gagal validasi (kode sudah pernah diinput atau barcode belum terdaftar di group)</li>";
	} else {
		echo "<li class='keterangan'>Barcode ".$value['barcode']."
		Data sudah tersimpan dengan kurir ".$value['nama'] ."<br/>
            <img src='".Yii::$app->homeUrl."/images/".$value['foto']."' style='height:80px;'>";
	}
}
echo "</ul>";
}


?>

<h4>List Validasi Antrian </h4>
<?php 
$antri=Inputan::find()->where(['status'=>0,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->All();
if(isset($antri)){
echo "<ul>";
foreach($antri as $value){
	
	echo "<li>Barcode ".$value['barcode']."</li>";
	
}
echo "</ul>";
}

?>



</div>
<?php 
if(isset($timerr)){
?>	
<script language="javascript">
setTimeout(function(){
   window.location.reload(1);
}, <?php echo $timerr->timer2?>);
</script>

<?php 	
} else { ?>

<script language="javascript">
setTimeout(function(){
   window.location.reload(1);
}, 3000);
</script>

<?php } ?>