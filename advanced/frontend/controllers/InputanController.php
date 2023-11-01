<?php

namespace frontend\controllers;

use Yii;
use app\models\Barcodeinput;
use app\models\BarcodeinputSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\Scan;
use app\models\Barcode;
use app\models\Barcoderetur;
/**
 * InputanController implements the CRUD actions for Barcodeinput model.
 */
class InputanController extends Controller
{
    /**
     * @inheritdoc
     */
   public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['create', 'view','index','delete','update','updatep','updateperusahaan','bulkdelete','viewp'],
                    'rules' => [
                        [
                            'actions' => ['create', 'view','index','delete','update','updatep','updateperusahaan','bulkdelete','viewp'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback'=>function(){
                                return (
                                    (Yii::$app->user->identity->tipe_user==0 or Yii::$app->user->identity->tipe_user==1)// and 
                                    //(Yii::$app->user->identity->faa==true or Yii::$app->user->identity->tipe_user2==0)
                                );}
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['post'],
                        'bulk-delete' => ['post'],
                    ],
                ],
            ];
        }

    /**
     * Lists all Barcodeinput models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new BarcodeinputSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Barcodeinput model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Barcodeinput #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Barcodeinput model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Barcodeinput();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Barcodeinput",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) ){
                //$model->save()
                $i=0;
                $model->csv = UploadedFile::getInstance($model, 'csv');
                if(isset($model->csv)){
                $namafile=rand(1000, 99999999);
                $file1= $namafile . '.' . $model->csv->extension;
                $model->csv->saveAs('kartu/' . $namafile . '.' . $model->csv->extension,TRUE);
                $csvFilePath = "kartu/".$file1;
                $file = fopen($csvFilePath, "r");
                $i=0;
                $j=0;
                $transaction = Yii::$app->db->beginTransaction();
                try
                {                
                if((isset($model->delimitt)==true) and (is_null($model->delimitt)==false) and (trim($model->delimitt<>""))) {
                while (($row = fgetcsv($file,0,$model->delimitt)) !== FALSE) {
                        $i++;
                        $barang = New Barcodeinput();                        
                        $barang->tanggal = $model->tanggal;
                        $barang->nama_file = $file1;
                        $barang->barcode = $row[1];
                        $barang->pesanan = $row[2];
                        $barang->save();                    
                }

                }
                else {
                while (($row = fgetcsv($file,0,"\t")) !== FALSE) {
                      
                        if(count($row)>1) {                            
                        $i++;
                        $barang = New Barcodeinput();
                        $barang->nama_file = $file1;
                        $barang->tanggal = $model->tanggal;
                        $barang->barcode = $row[1];
                        $barang->pesanan = $row[2];
                        $barang->save();    
                        }                        
                }
                }

                    $transaction->commit();
                    //Yii::$app->session->setFlash('success', $i.' rows Success ');
                }
                catch(Exception $e)
                {
                    $transaction->rollBack();
                    //Yii::$app->session->setFlash('danger', 'Failed import '.$e.getMessage());

                }
                }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Barcodeinput",
                    'content'=>'<span class="text-success">'.$i.' rows Success imported</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new Barcodeinput",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }
    }

    /**
     * Updates an existing Barcodeinput model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Barcodeinput #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Barcodeinput #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Barcodeinput #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Barcodeinput model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $cek=Yii::$app->user->identity->delete;
        if($cek==0){
        $request = Yii::$app->request;
        $mako=$this->findModel($id);
        $scan=Scan::findOne(['barcode'=>$mako->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
        if(!isset($scan)){
            $barr=Barcode::findOne(['barcode'=>$mako->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
            $barr->delete();
        }            
        $mako->delete();
        } else {
            return $this->redirect(['site/abut','id'=>'Not Authorize']);
            die();
            //$this->redirect(['site/abut'])
        }
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Barcodeinput model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $cek=Yii::$app->user->identity->delete;
        if($cek==0){
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            //$model = $this->findModel($pk);
            $mako = $this->findModel($pk);
            //$mako=$this->findModel($id);
            $scan=Scan::findOne(['barcode'=>$mako->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
            if(!isset($scan)){
                $barr=Barcode::findOne(['barcode'=>$mako->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
                $barr->delete();
            }            
            $mako->delete();
            //$model->delete();
        }
        } else {
            return $this->redirect(['site/abut','id'=>'Not Authorize']);
            die();
            //$this->redirect(['site/abut'])
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Barcodeinput model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Barcodeinput the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Barcodeinput::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
