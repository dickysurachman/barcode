<?php

namespace frontend\controllers;

use Yii;
use app\models\User;
use app\models\Profile;
use app\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\models\Perusahaan;
use yii\web\UploadedFile;
/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
     public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['create', 'view','index','delete','update','updateperusahaan','bulkdelete'],
                    'rules' => [
                        [
                            'actions' => ['create', 'view','index','delete','update','updateperusahaan','bulkdelete'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback'=>function(){
                                return (
                                    (Yii::$app->user->identity->tipe_user==0)// and 
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

    public function beforeAction($action)
    {
        if(Yii::$app->user->isGuest){
            $this->redirect(array('site/login'));
        } else {   
            if(Yii::$app->user->identity->tipe_user<>0){
                //$this->redirect(array('site/index'));
                return $this->redirect(['site/abut','id'=>'Not Authorize']);
                die();
            }            
        return parent::beforeAction($action);
        }

    }

    /**
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateperusahaan()
    {
        $request = Yii::$app->request;
        $bandung= $this->findModelPerusahaan(Yii::$app->user->identity->id_perusahaan);
        $model = $this->findModelPerusahaan(Yii::$app->user->identity->id_perusahaan);
        if ($model->load($request->post())) {
            $model->logo_1 = UploadedFile::getInstance($model, 'logo_1');
                if(isset($model->logo_1)){
                $namafile="A".rand(1000, 99999999);
                $file1= $namafile . '.' . $model->logo_1->extension;
                $model->logo_1->saveAs('images/' . $namafile . '.' . $model->logo_1->extension,TRUE);
                $model->logo_1=$file1;
                } else {
                    $model->logo_1=$bandung->logo_1;
                }
            $model->logo_2 = UploadedFile::getInstance($model, 'logo_2');
                if(isset($model->logo_2)){
                $namafile="B".rand(1000, 99999999);
                $file1= $namafile . '.' . $model->logo_2->extension;
                $model->logo_2->saveAs('images/' . $namafile . '.' . $model->logo_2->extension,TRUE);
                $model->logo_2=$file1;
                } else {
                    $model->logo_2=$bandung->logo_2;
                }
            $model->logo_3 = UploadedFile::getInstance($model, 'logo_3');
                if(isset($model->logo_3)){
                $namafile="C".rand(1000, 99999999);
                $file1= $namafile . '.' . $model->logo_3->extension;
                $model->logo_3->saveAs('images/' . $namafile . '.' . $model->logo_3->extension,TRUE);
                $model->logo_3=$file1;
                } else {
                    $model->logo_3=$bandung->logo_3;
                }
                $model->save();
                Yii::$app->session->setFlash('success', 'Data sudah tersimpan');
        }
        return $this->render('perusahaan', [
                    'model' => $model,
                ]);       
    }
    protected function findModelPerusahaan($id)
    {
        if (($model = Perusahaan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Profile #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            /*
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);*/
        }
    }

    /**
     * Creates a new Profile model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Profile();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Profile",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Profile",
                    'content'=>'<span class="text-success">Create Profile success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new Profile",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            */
        }
       
    }

    /**
     * Updates an existing Profile model.
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
                    'title'=> "Update Profile #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Profile #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Profile #".$id,
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
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            */
        }
    }

    /**
     * Delete an existing Profile model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $cek=User::findOne(['id_profile'=>$this->id]);
        if (isset($cek)) {

        }else{
            $this->findModel($id)->delete();

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



    }

     /**
     * Delete multiple existing Profile model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $cek=User::findOne(['id_profile'=>$this->id]);
            if (!isset($cek)) {
                $model = $this->findModel($pk);
                $model->delete();
            }
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
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
             if($model->id_perusahaan<>Yii::$app->user->identity->id_perusahaan){

            throw new NotFoundHttpException('The requested page does not exist.');
            } else {
            return $model;
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
