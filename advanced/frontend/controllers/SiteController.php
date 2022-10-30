<?php
namespace frontend\controllers;

use Yii;
//use app\models\User;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\UploadedFile;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\helpers\Html;
use frontend\models\Books;
use frontend\models\Register;
use frontend\models\Csv;
use app\models\User;
use app\models\Scan;
use app\models\ScanSearch;
use app\models\Kurir;
use app\models\Usergrup;
use app\models\Grup;
use app\models\Inputan;
use kartik\mpdf\Pdf;
use app\models\Perusahaan;
use app\models\Barcodeinput;
use app\models\BarcodeinputSearch;
use app\models\Barcoderetur;
use app\models\BarcodereturSearch;
use app\models\Barcode;
use app\models\BarcodeSearch;
use app\models\ContactSearch;
use ZipArchive;
use frontend\models\Setting;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['actionReportsumcsv','report','reportsum','scanmama','scanm','scan','scanx','scaninputan','logout','userx','updatescan', 'index','profile','mauupdate','update','signup','contact','lists','list3','password','userprofile','reportinput','reportretur','reportsumretur','reportsuminput','exx'],
                'rules' => [
                    
                    [
                        'actions' => ['actionReportsumcsv','report','reportsum','scanmama','scanm','scanx','scan','scaninputan','logout','userx','updatescan','index','profile','mauupdate','update','signup','contact','lists','password','userprofile','reportinput','reportretur','reportsumretur','reportsuminput','exx'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    

    /**
     * @inheritdoc
     */
   
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionContactdata()
    {    
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->searchmember(Yii::$app->request->queryParams);

        return $this->render('kontak', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionExx() {
        $inputtt=Barcodeinput::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->all();
        $i=0;
        foreach ($inputtt as $vall) {
            $cek=Barcode::findOne(['barcode'=>$vall->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
                if(!$cek){
                    $simpan=new Barcode();
                    $simpan->barcode = $vall->barcode;
                    $simpan->save();
                    $i++;
                }
        }
        echo $i .' berhasil diimport <br>';
        $i=0;
        $inputtt2=Scan::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->all();
        foreach ($inputtt2 as $vall2) {
            $cek=Barcode::findOne(['barcode'=>$vall2->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
                if(!$cek){
                    $simpan=new Barcode();
                    $simpan->barcode = $vall2->barcode;
                    $simpan->save();
                    $i++;
                }
        }
        echo $i .' berhasil diimport <br>';
    }

        

    public function actionReport() {
    $searchModel = new ScanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('reportscan', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }    
    public function actionReportk() {
    $searchModel = new BarcodeSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('reportscank2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }   
	public function actionUploadcsv()
    {
        $model= new Csv();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->csv = UploadedFile::getInstance($model, 'csv');
            if(isset($model->csv)){
                $namafile=rand(1000, 99999999);
                $file1= $namafile . '.' . $model->csv->extension;
                $model->csv->saveAs('images/' . $namafile . '.' . $model->csv->extension,TRUE);
				$csvFilePath = "images/".$file1;
				$file = fopen($csvFilePath, "r");
				while (($row = fgetcsv($file)) !== FALSE) {
					var_dump($row);
				}
              } 
        }

        return $this->render('uploadcsv', [
        'model' => $model,
        ]);

    }

    public function actionReportinput(){
        $searchModel = new BarcodeinputSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexinput', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionReportretur(){
        $searchModel = new BarcodereturSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexretur', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }   //http://localhost/barcode/barcode/user.html
    public function actionReportsumretur(){
        $model = new ScanSearch();
        if ($model->load(Yii::$app->request->post())) {
            if(is_null($model->add_who) or $model->add_who=="") {
            $grup=Yii::$app->db->createCommand("select id_grup as id,count(id) as jml from barcode_retur 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and  tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."'
                group by id_grup")->queryAll();
            $user=Yii::$app->db->createCommand("select add_who as id,count(id) as jml from barcode_retur 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."'
                group by add_who")->queryAll();
            } else {
            $grup=Yii::$app->db->createCommand("select id_grup as id,count(id) as jml from barcode_retur 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."'
                and add_who=".$model->add_who."
                group by id_grup")->queryAll();
            $user=Yii::$app->db->createCommand("select add_who as id,count(id) as jml from barcode_retur 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and  tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' 
                and add_who=".$model->add_who."
                group by add_who")->queryAll();
            }
            return $this->render('reportsemua1', [
            'grup' => $grup,'user'=>$user,'tgl_a'=>$model->tgl_a,'tgl_b'=>$model->tgl_b
            ]);
        }    
        return $this->render('reportsum', [
        'model' => $model,
        ]);
    }

     public function actionReportsuminput(){
        $model = new ScanSearch();
        if ($model->load(Yii::$app->request->post())) {
            if(is_null($model->add_who) or $model->add_who=="") {
            $grup=Yii::$app->db->createCommand("select id_grup as id,count(id) as jml from scan 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and barcode in (select barcode from barcode_input where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."') 
                group by id_grup")->queryAll();
            $user=Yii::$app->db->createCommand("select add_who as id,count(id) as jml from scan 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and barcode in (select barcode from  barcode_input where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."') 
                group by add_who")->queryAll();  
            $gagal=Yii::$app->db->createCommand("select tanggal,barcode from barcode_input 
                where tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' and id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and barcode not in (select barcode from scan where id_perusahaan=".Yii::$app->user->identity->id_perusahaan.")" 
                )->queryAll();
            } else {
            $grup=Yii::$app->db->createCommand("select id_grup as id,count(id) as jml from scan 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and barcode in (select barcode from  barcode_input where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."'
                and add_who=".$model->add_who.")
                group by id_grup")->queryAll();
            $user=Yii::$app->db->createCommand("select add_who as id,count(id) as jml from scan 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and barcode in (select barcode from  barcode_input where tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' 
                and add_who=".$model->add_who." and id_perusahaan=".Yii::$app->user->identity->id_perusahaan.
                " group by add_who")->queryAll(); 
            $gagal=Yii::$app->db->createCommand("select tanggal,barcode from barcode_input
                where tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' and id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and barcode not in (select barcode from scan where id_perusahaan=".Yii::$app->user->identity->id_perusahaan."' 
                and add_who=".$model->add_who.")
                ")->queryAll();
            }


            return $this->render('reportsemua2', [
            'grup' => $grup,'user'=>$user,'tgl_a'=>$model->tgl_a,'tgl_b'=>$model->tgl_b,'gagal'=>$gagal
            ]);
        }    
        return $this->render('reportsum', [
        'model' => $model,
        ]);
    }
	public function actionUpdatescan()
    {
        $request = Yii::$app->request;
        //$model = $this->findModel($id);       
		$id=Yii::$app->user->identity->id;
		$model = new Usergrup;
		if($model->load($request->post())){
				$i=0;
				$has=Grup::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->all();
				foreach ($has as $key => $value){
					if($model["id_grup"][$value->id]==1){
						$cek=Usergrup::findOne(['id_grup'=>$value->id,'id_user'=>$id]);
						if(!$cek){
							$baru=new Usergrup();
							$baru->id_grup=$value->id;
							$baru->id_user=$id;
							$baru->save();
						}
					} else {
						$cek=Usergrup::findOne(['id_grup'=>$value->id,'id_user'=>$id]);
						if($cek){
							$cek->delete();
						}			
					}
				}
				 Yii::$app->session->setFlash('success', 'Data berhasil tersimpan');

          }
		  return $this->render('updatescan', [
            'model' => $model,'id'=>$id
        ]);
    }
	public function actionInvoice($id)
    {
         $this->layout="mainprint";
      
    $model=User::find()->where("md5(username)='".$id."'")->One();
    return $this->render('viewpdf',['model'=>$model]);

    }
	public function actionInvoiceqr($id)
    {
         $this->layout="mainprint";
      
    $model=User::find()->where("md5(username)='".$id."'")->One();
    return $this->render('viewpdfqr2',['model'=>$model]);

    }

     public function actionUserprofile(){
        $model= new Books();
        $huhu=User::findOne(Yii::$app->user->identity->id);
        $model->alamat=$huhu->alamat;
        $model->phone=$huhu->telp;
        if ($model->load(Yii::$app->request->post())) {
            $model->gambar = UploadedFile::getInstance($model, 'gambar');
                if(isset($model->gambar)){
                $namafile=rand(1000, 99999999);
                $file1= $namafile . '.' . $model->gambar->extension;
                $model->gambar->saveAs('images/' . $namafile . '.' . $model->gambar->extension,TRUE);
                $huhu->foto=$file1;
                } 
            $huhu->alamat=$model->alamat;    
            $huhu->telp=$model->phone;    
            $huhu->save();
            return $this->goHome();
        }

        return $this->render('createprofile', [
        'model' => $model,
        ]);


    }
	    public function actionGuest($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $data = Yii::$app->db->createCommand("select id, nama AS text from user where nama like '%".$q."%' and id_perusahaan=".Yii::$app->user->identity->id_perusahaan." limit 20")
            ->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => User::find($id)->nama];
        }
        return $out;
    }
     public function actionUserx(){
        $model= new User();
        if ($model->load(Yii::$app->request->post())) {
            $cek=User::findOne($model->username);
			if(isset($cek)){
				$this->redirect(['site/invoiceqr','id'=>md5($cek->username)]);
			}
			//return $this->goHome();
			 Yii::$app->session->setFlash('error', 'QR Code anda tidak ditemukan');
        }

        return $this->render('createkartu', [
        'model' => $model,
        ]);


    }
    public function actionXxx(){
        $model= new Scan();
        $model->barcode="qoweroiwqurowqr";
        $model->status=0;
        $model->id_grup=1;
        $model->save();        
    }
     public function actionScan(){
        $model= new Scan();
        if ($model->load(Yii::$app->request->post())) {
			$sac=substr($model->barcode,0,2);
			if($sac <>"88" and $sac <>"89" and $sac <>"90"){  
            $h=Usergrup::find()->where(['id_user'=>Yii::$app->user->identity->id])->all();
            foreach($h as $key2){
                $k=Kurir::find()->where(['id_grup'=>$key2->id_grup,'status'=>0])->orderBy(['id'=>SORT_DESC])->all();
                foreach($k as $key){
				if($key->cari3==0) {
                $cek1=strpos(" ".$model->barcode,$key->cari1);
				} else {
				$jml=strlen($key->cari1);
				$awal=substr($model->barcode,0,$jml);
				$ch=$key->cari1;
				//echo $model->barcode."/". $awal."/".$ch."/".$jml.$key->nama;
				//die();
				if($ch==$awal){
					$cek1=5;
				} else {
					$cek1=0;
				}
				}
                $h=strlen($model->barcode);
                $hasil=true;
                if($key->cari1=="0"){
                    $hh=is_numeric($model->barcode);
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
                        break;
                }   
                }
            }
            if(isset($nama)){
            $cekcok=Scan::findOne(['barcode'=>$model->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
            if(isset($cekcok)){
            Yii::$app->session->setFlash('danger', 'Data barcode sudah pernah diinput ');

            }   else {

            Yii::$app->session->setFlash('success', 'Data sudah tersimpan dengan kurir '.$nama .'<br/>
			<img src="'.Yii::$app->homeUrl.'/images/'.$nama4.'" style="height:80px;">');
            $model->id_grup=$nama3;
            $model->save();
            }             
            } else {
            
            Yii::$app->session->setFlash('danger', 'Data barcode tidak ditemukan, silahkan set expedisi terlebih dahulu');

            }
			}
            return $this->redirect(['site/scan']);
        }

        return $this->render('createscan', [
        'model' => $model,
        ]);
    }
    public function actionScaninputan(){
        $model= new Scan();
        return $this->render('createscanmama', [
        'model' => $model,
        ]);
    }
    public function actionScanm(){
        $model= new Inputan();
        if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->post()) {
            $resp="";
			$hasil = explode(PHP_EOL,$_POST['Inputan']['barcode']);
			foreach($hasil as $value){
            if($value<>" " or $value<>""){
				$value = preg_replace("/\r|\n/", "", $value);
				$value =trim($value);
				$jj=new Inputan();
				$jj->barcode=$value;
				if($jj->save()) {
					$resp.=$value." berhasil diinput <br/>";
				} else {
					$resp.=$value." gagal diinput <br/>";
				}
				
			}
			}
			return $resp;
			
        } else {
            return "data tidak berhasil diinput";
        }
        }
        return $this->render('createscanm', [
        'model' => $model,
        ]);
    } 
	public function actionScanm2x(){
        $model= new Inputan();
        if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $jj=new Inputan();
            $jj->barcode=$_POST['Inputan']['barcode'];
        if (Yii::$app->request->post() && $jj->save()) {
            return $_POST['Inputan']['barcode'] ." data berhasil diinput";
           
        } else {
            return "data tidak berhasil diinput";
        }
        }
        return $this->render('createscanm', [
        'model' => $model,
        ]);
    }
	public function actionScanx(){
        $model= new Scan();
        if ($model->load(Yii::$app->request->post())) {
			$hasil = explode(PHP_EOL,$model->barcode);
			foreach($hasil as $value){
				//echo $value;
				
//			$sac=substr($model->barcode,0,2);
			$sac=substr($value,0,2);
			if($sac <>"88" and $sac <>"89" and $sac <>"90"){  
            $h=Usergrup::find()->where(['id_user'=>Yii::$app->user->identity->id])->all();
            foreach($h as $key2){
                $k=Kurir::find()->where(['id_grup'=>$key2->id_grup])->all();
                foreach($k as $key){
                $cek1=strpos(" ".$value,$key->cari1);
                $h=strlen($value);
                $hasil=true;
                if($key->cari1=="0"){
                    $hh=is_numeric($value);
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
                        break;
                }
                    
                }
            }
            if(isset($nama)){
            if(isset($cekcok)){
            //Yii::$app->session->setFlash('danger', 'Data barcode sudah pernah diinput ');
			$data[]=['tipe'=>'danger','data'=>"Data Barcode Sudah pernah diinput"];
            }   else {
			$data[]=['tipe'=>'success','data'=>'Data sudah tersimpan dengan kurir '.$nama .'<br/>
			<img src="'.Yii::$app->homeUrl.'/images/'.$nama4.'" style="height:80px;">'];
            $cekcok=Scan::findOne(['barcode'=>$value,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
			/*
            Yii::$app->session->setFlash('success', 'Data sudah tersimpan dengan kurir '.$nama .'<br/>
			<img src="'.Yii::$app->homeUrl.'/images/'.$nama4.'" style="height:80px;">');*/
            $md= new Scan();
			$md->barcode=$value;
			$md->id_grup=$nama3;
			$md->save();
			//$model->id_grup=$nama3;
            //$model->save();
            }             
            } else {
            
            //Yii::$app->session->setFlash('danger', 'Data barcode tidak ditemukan ');
			$data[]=['tipe'=>'danger','data'=>$value ." Data barcode tidak ditemukan"];
            }
			}
			}
            //return $this->redirect(['site/scanx']);
            //return $this->redirect(['site/scanx']);
			$model->barcode="";
			return $this->render('createscanx', [
			'model' => $model,'data'=>$data
        ]);

        }

        return $this->render('createscanx', [
        'model' => $model,
        ]);
    }
    public function actionSiswa(){
        $this->layout="main";
        return $this->render('login');
    }
    public function actionAbut($id){
        return $this->render('error1',['message'=>$id]);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest) {
            return $this->render('indexmimin');
        } else {
        if(Yii::$app->user->identity->tipe_user2==1){

        return $this->render('indexmimin');
        } else {
            $model= new ScanSearch();
            $request = Yii::$app->request;
                if($model->load($request->post())){

                    return $this->render('index',['model'=>$model]);
                }
//                return $this->render('indexmember',['model'=>$model]);
              return $this->render('index',['model'=>$model]);
        }
        }
    }

    /**
     * Logs in a user.if
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    } 
    public function actionLoginbarcode()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            //return $this->goBack();
            $cek=User::find()->where("md5(concat(username,'daud313313'))='".$model->username."'")->One();
            if(isset($cek)){
                $user = \common\models\User::find()
            ->where([
                'id'=>$cek->id,
            ])
            ->one();
            Yii::$app->user->login($user,  3600 * 24 * 30 );
            return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'QR Code anda tidak ditemukan');
            
                return $this->render('loginbarcode', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('loginbarcode', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }



    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    public function actionContactadmin()
    {
        $model = new ContactForm();
        $user=User::findOne(Yii::$app->user->identity->id);
        $model->name=$user->username;
        $model->email=$user->email;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contactbarcode', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
    public function actionRegister()
    {
        $model = new Register();
        if ($model->load(Yii::$app->request->post())) {
            if($model->signup()){
                Yii::$app->session->setFlash('success', 'User registration process has been success, Admin will send email notification if account already active');
            }

        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        //$this->layout="main-login";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionReset()
    {
        //$this->layout="main-login";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    public function actionPassword()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
        $user=User::FindOne(['id'=>Yii::$app->user->identity->id]);
        $user->setPassword($model->password);
        if($user->save()){
        Yii::$app->session->setFlash('success', 'Password has been changed');
        return $this->goHome();
        }
        }    
        return $this->render('password', [
        'model' => $model,
        ]);
    } 
    public function actionReportsum()
    {

        $model = new ScanSearch();
        if ($model->load(Yii::$app->request->post())) {
            if(is_null($model->add_who) or $model->add_who=="") {

            $grup=Yii::$app->db->createCommand("select id_grup as id,count(id) as jml from scan 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' 
                group by id_grup")->queryAll();
            $user=Yii::$app->db->createCommand("select add_who as id,count(id) as jml from scan 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' 
                group by add_who")->queryAll();
            } else {
            $grup=Yii::$app->db->createCommand("select id_grup as id,count(id) as jml from scan 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' 
                and add_who=".$model->add_who."
                group by id_grup")->queryAll();
            $user=Yii::$app->db->createCommand("select add_who as id,count(id) as jml from scan 
                where id_perusahaan=".Yii::$app->user->identity->id_perusahaan." and tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' 
                and add_who=".$model->add_who."
                group by add_who")->queryAll();
            }
            return $this->render('reportsemua', [
            'grup' => $grup,'user'=>$user,'tgl_a'=>$model->tgl_a,'tgl_b'=>$model->tgl_b
            ]);
        }    
        return $this->render('reportsum', [
        'model' => $model,
        ]);
    }
	public function actionReportsumcsv()
    {

        $model = new ScanSearch();
        if ($model->load(Yii::$app->request->post())) {
            if(is_null($model->add_who) or $model->add_who=="") {
			$scann=Scan::find()->where("tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."'")->all();
            if($scann) {			
			$baris=Scan::find()->where("tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."'")->count();
			//header('Content-Type: text/csv; charset=utf-8');  
			//header('Content-Disposition: attachment; filename=data.csv');  
			ob_start();
			$output = fopen("php://output", "w");  
			fputcsv($output, array('BARCODE', 'GROUP', 'KODE', 'TANGGAL', 'OPERATOR','ADD DATE'));  
			//if($baris>3000) {
			$offset=0;
			$hitung=0;
			while($hitung<$baris) {
			$scann=Scan::find()->where("tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."'")
			->limit(3000)
			->offset($offset)
			->all();
			//fputcsv($output, array('BARCODE', 'GROUP', 'KODE', 'TANGGAL', $scann,$offset)); 
			foreach($scann as $value) {
			$row=[$value->barcode,$value->grup->nama,$value->kode,$value->add->nama,$value->tanggal,$value->add_date];
			fputcsv($output, $row); 
			}
			$hitung+=3000;
			$offset+=3000;
			//sleep(5);
			}
			$streamSize = ob_get_length();
			fclose($output);
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename=data.csv');  
			header('Expires: 0');  
			header('Cache-Control: no-cache');
			header('Content-Length: '. ob_get_length());
			// Flush (send) the output buffer and turn off output buffering
			ob_end_flush();			
			/*
			} 
			else {
			foreach($scann as $value) {
			$row=[$value->barcode,$value->grup->nama,$value->kode,$value->add->nama,$value->tanggal,$value->add_date];
			fputcsv($output, $row);  	
			}
			fclose($output);  
			}*/
			}
            } 
			else {
			$scann=Scan::find()->where("tanggal between '".$model->tgl_a ."' and '".$model->tgl_b."' and add_who=".$model->add_who)->all();
            if($scann) {			
			//header('Content-Type: text/csv; charset=utf-8');  
			//header('Content-Disposition: attachment; filename=data.csv');  
			ob_start();
			$output = fopen("php://output", "w");  
			fputcsv($output, array('BARCODE', 'GROUP', 'KODE', 'TANGGAL', 'OPERATOR','ADD DATE'));  
			foreach($scann as $value) {
			$row=[$value->barcode,$value->grup->nama,$value->kode,$value->add->nama,$value->tanggal,$value->add_date];
			fputcsv($output, $row);  
			}
			$streamSize = ob_get_length();			
			fclose($output);
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename=data.csv');  
			header('Expires: 0');  
			header('Cache-Control: no-cache');
			header('Content-Length: '. ob_get_length());
			// Flush (send) the output buffer and turn off output buffering
			ob_end_flush();						
			}
            } 
			die();
        }    
        return $this->render('reportsum1', [
        'model' => $model,
        ]);
    }

     public function actionKirimbarcode($barcode,$key) {
        $h=Perusahaan::find()->where(['serialkey'=>$key])->one();
        if(isset($h)) {
        $ipy=$_SERVER['REMOTE_ADDR'];
        $simm=new Inputan();
        $simm->barcode=$barcode;
        $simm->ip=$ipy;
        $simm->id_perusahaan=$h->id;
        $simm->save();
        } 
    }
      public function actionGetcamera(){
        $filename=Yii::$app->security->generateRandomString() . '0-' . time().".zip";
        $zip = new \ZipArchive(); 
        $zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile('camera.bat'); 
        $zip->addFile('scan.py'); 
        $zip->addFile('setting2.txt'); 
        $zip->close();
        //$zip->createZip($zip,$filename);
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Content-Length: ' . filesize($filename));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile("$filename");
    } 
     public function actionSettingcamera()
    {
        $model = new Setting();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success', 'Save File Setting');
            $myfile = fopen("setting2.txt", "w") or die("Unable to open file!");
            //$txt = "Mickey Mouse\n";
            fwrite($myfile, $model->url2."\n");
            fwrite($myfile, $model->port_alat."\n");
            fwrite($myfile, $model->key."\n");
            fwrite($myfile, $model->ip_alat."\n");
            fclose($myfile);
            //return $this->goHome();
            return $this->redirect(['site/settingcamera']);
        }

        return $this->render('settingcamera', [
            'model' => $model,
        ]);
    }

}
