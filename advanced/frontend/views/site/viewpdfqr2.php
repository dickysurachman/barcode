
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

	 $data=md5($model->username."daud313313");
	 $errorCorrectionLevel = 'M';   $matrixPointSize = 7;

	 if (!file_exists($PNG_TEMP_DIR)){
		mkdir($PNG_TEMP_DIR);
		}
		$filename = $PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
		//echo '<img src="'.Yii::$app->homeUrl.'/'.$filename.'" />';  
		  $jpg_image = imagecreatefromjpeg('images/'.$ha->logo_3);
		  
		  //foto profil		  
		  $usrimg=$model->foto;
		  $jpg_image2 = imagecreatefromjpeg('images/'.$usrimg);
		  $jpg_image3 = imagecreatefrompng($filename);
		$cut1 = imagecreatetruecolor(500, 500);
		$image_properties1 = getimagesize($filename);
		$image_width1 = $image_properties1[0];
		$image_height1 = $image_properties1[1];
		$temp_image21 = imagecreatetruecolor(500, 500);
		$temp_image2x1 = imagecreatetruecolor(500, 500);
		imagecopyresampled($temp_image21, $jpg_image3, 0, 0, 0, 0, 500, 500, $image_width1, $image_height1);
		imagecopyresampled($temp_image2x1, $jpg_image3, 0, 0, 0, 0, 500, 500, $image_width1, $image_height1);



		  // Allocate A Color For The Text
		//  $white = imagecolorallocate($jpg_image, 255, 255, 255);
		$white = imagecolorallocate($jpg_image, 109, 110, 113);
		$red = imagecolorallocate($jpg_image, 193, 36, 3);
		$font_path = 'font/din.ttf';
		//$font_path = 'C:\test1\din.ttf';
		$text=$model->nama;
		$cut = imagecreatetruecolor(300, 300);
		$image_properties = getimagesize('images/'.$usrimg);
		$image_propertiesx = getimagesize('images/'.$ha->logo_3);
		$image_widthxx = $image_propertiesx[0];
		$image_width = $image_properties[0];
		$image_height = $image_properties[1];
		$temp_image2 = imagecreatetruecolor(300, 300);
		$temp_image2x = imagecreatetruecolor(300, 300);
		imagecopyresampled($temp_image2, $jpg_image2, 0, 0, 0, 0, 300, 300, $image_width, $image_height);
		imagecopyresampled($temp_image2x, $jpg_image2, 0, 0, 0, 0, 300, 300, $image_width, $image_height);
//
			$mask = imagecreatetruecolor(300, 300);
	        $maskTransparent = imagecolorallocate($mask, 255, 0, 255);
	        imagecolortransparent($mask, $maskTransparent);
	        imagefilledellipse($mask, 300 / 2, 300 / 2, 300, 300, $maskTransparent);
	        
	        imagecopymerge($temp_image2x, $mask, 0, 0, 0, 0, 300, 300, 100);

	        $dstTransparent = imagecolorallocate($temp_image2x, 255, 0, 255);
	        imagefill($temp_image2x, 0, 0, $dstTransparent);
	        imagefill($temp_image2x,  300- 1, 0, $dstTransparent);
	        imagefill($temp_image2x, 0,300 - 1, $dstTransparent);
	        imagefill($temp_image2x,  300 - 1, $image_height - 1, $dstTransparent);
	        imagecolortransparent($temp_image2x, $dstTransparent);

//
		//imagecopymerge($jpg_image,$temp_image2, 500, 140, 0, 0, 300, 300, 100);
		imagecopymerge($jpg_image,$temp_image2x, 390, 140, 0, 0, 300, 300, 100);
		imagecopymerge($jpg_image,$temp_image2x1, 270, 820, 0, 0, 500, 500, 75);
		$temp_image = imagecreatetruecolor(380, 60);
		  // Print Text On Image
		imagettftext($jpg_image, 50, 0, ($image_widthxx/2)-((strlen($text)/2)*40), 500, $red, $font_path, $text);
		/*if(strlen($text)>12){
			imagettftext($jpg_image, 30, 0, 350, 450, $red, $font_path, $text);
		} else {
			imagettftext($jpg_image, 30, 0, 500, 450, $red, $font_path, $text);
		}*/
		$text=$model->nik;
		$text = $model->jabatan;//"05-2016";
		imagettftext($jpg_image, 30, 0, ($image_widthxx/2)-((strlen($text)/2)*17), 560, $white, $font_path, $text);
		/*if(strlen($text)>12){
		imagettftext($jpg_image, 30, 0, 390, 510, $white, $font_path, $text);
		} else {
		imagettftext($jpg_image, 30, 0, 440, 510, $white, $font_path, $text);

		}*/
		$nama="kartu/".$model->nik;
		if(file_exists($nama.".jpg")){
		  unlink($nama.".jpg");
		}
		//var_dump($jpg_image);
//		die();
		imagejpeg($jpg_image,"kartu/".$model->nik.".jpg");
		imagedestroy($jpg_image);
		echo '<img src="'.Yii::$app->homeUrl.'/kartu/'.$model->nik.'.jpg" style="width:300px" />';  
 
		echo '<img src="'.Yii::$app->homeUrl.'/images/'.$ha->logo_2.'" style="margin-left:50px;width:300px" />';
	
?>



