<style>
    .skin-blue-light .wrapper, .skin-blue-light .main-sidebar, .skin-blue-light .left-side {
    background-color: white !important;
    }
</style>

<?php
use app\models\Perusahaan;
use yii\helpers\Html;
$ha=Perusahaan::findOne($model->id_perusahaan);

	 $PNG_TEMP_DIR = 'temp'.DIRECTORY_SEPARATOR;
     require(__DIR__ . '/../../../vendor/phpqrcode/qrlib.php');  
     require(__DIR__ . '/../../../vendor/phpbarcode/barcode.php');  
      
	$PNG_WEB_DIR = 'temp/';

	 $data=$model->nik;
	 $errorCorrectionLevel = 'M';   $matrixPointSize = 7;

	 if (!file_exists($PNG_TEMP_DIR)){
		mkdir($PNG_TEMP_DIR);
		}
		$filename = $PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png(md5($data), $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		//echo '<img src="'.Yii::$app->homeUrl.'/'.$filename.'" />';  
		  $jpg_image = imagecreatefromjpeg('images/green8.jpg');
		  
		  //foto profil		  
		  $usrimg=Yii::$app->user->identity->foto;
		  $jpg_image2 = imagecreatefromjpeg('images/'.$usrimg);
		  $jpg_image3 = imagecreatefrompng($filename);
		  $jpg_image4 = imagecreatefromjpeg('temp/'.$data.'.jpg');
		  
		  // Allocate A Color For The Text
		//  $white = imagecolorallocate($jpg_image, 255, 255, 255);
		$white = imagecolorallocate($jpg_image, 109, 110, 113);
		$font_path = 'font/din.ttf';
		$font_path = 'C:\test1\din.ttf';
		$text=Yii::$app->user->identity->nama;
		$cut = imagecreatetruecolor(204, 204);
		$image_properties = getimagesize('images/'.$usrimg);
		$image_width = $image_properties[0];
		$image_height = $image_properties[1];
		$temp_image2 = imagecreatetruecolor(204, 204);
		imagecopyresampled($temp_image2, $jpg_image2, 0, 0, 0, 0, 204, 204, $image_width, $image_height);
		imagecopymerge($jpg_image,$temp_image2, 400, 100, 0, 0, 204, 204, 100);
		imagecopymerge($jpg_image,$jpg_image3, 700, 80, 0, 0, 232, 232, 75);
		$temp_image = imagecreatetruecolor(380, 60);
		  // Print Text On Image
		imagettftext($jpg_image, 30, 0, 75, 390, $white, $font_path, $text);
		$text=$model->nik;
		//$text = substr($member,0,2)." ". substr($member,2,3)." ".substr($member,5,3);
		//$current_date_variable=$model->created_at;
		//$text = date('m/Y', $current_date_variable);//"05-2016";
		//imagettftext($jpg_image, 14, 0, 685, 450, $white, $font_path, $text);
		$text = $model->jabatan;//"05-2016";
		imagettftext($jpg_image, 30, 0, 710, 390, $white, $font_path, $text);
		$nama="kartu/".$model->nik;
		if(file_exists($nama.".jpg")){
		  unlink($nama.".jpg");
		}
		//var_dump($jpg_image);
//		die();
		imagejpeg($jpg_image,"kartu/".$model->nik.".jpg");
		imagedestroy($jpg_image);
		echo '<img src="'.Yii::$app->homeUrl.'/kartu/'.$model->nik.'.jpg" />';  
 
?>



