<?php

namespace frontend\controllers;

use Yii;
use app\models\User;
use app\models\Grup;
use app\models\Perusahaan;
use app\models\Usersearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\models\Usergrup;
use app\models\UsergrupSearch;
use yii\web\UploadedFile;
/**
 * UserController implements the CRUD actions for user model.
 */
class UserController extends Controller
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
     * Lists all user models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new Usersearch();
        $dataProvider = $searchModel->searchpr(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
     public function actionViewp($id)
    {
        $searchModel = new UsergrupSearch();
        $searchModel->id_user=$id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('view2', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
        public function actionCreategrup($id)
    {
        $request = Yii::$app->request;
        $model = new Usergrup();  
        $model->id_user=$id;

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Grup",
                    'content'=>$this->renderAjax('creategrup', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Grup",
                    'content'=>'<span class="text-success">Create Grup success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['creategrup','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new Grup",
                    'content'=>$this->renderAjax('creategrup',[
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
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

        public function actionBulkDeleteu()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModelgrup($pk);
            $model->delete();
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
      protected function findModelgrup($id)
    {
        if (($model = Usergrup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
public function actionUpdatescan($id)
    {
        $request = Yii::$app->request;
        //$model = $this->findModel($id);       
		$model = new Usergrup;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Grup Scan #".$id,
                    'content'=>$this->renderAjax('updatescan', [
                        'model' => $model,'id'=>$id
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post())){
				$i=0;
				//$has=Grup::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->all();
                $has=Grup::find()->all();
				foreach ($has as $key => $value){
					//echo $value->id."=";
					//echo $model["id_grup"][$value->id].",";
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
				return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
                    
            }else{
                 return [
                    'title'=> "Update Grup Scan #".$id,
                    'content'=>$this->renderAjax('updatescan', [
                        'model' => $model,'id'=>$id
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
        }
    }

 public function actionUpdatep($id)
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
                    'title'=> "Update Password #".$id,
                    'content'=>$this->renderAjax('updatep', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post())){
                $model->updated_at=time();
                $model->setPassword($model->password_hash);
                $model->generateAuthKey();
                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "User #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['updatep','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Password #".$id,
                    'content'=>$this->renderAjax('updatep', [
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
                return $this->render('updatep', [
                    'model' => $model,
                ]);
            }
            */
        }
    }
    /**
     * Displays a single user model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "user #".$id,
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
     * Creates a new user model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new User();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new user",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post())) {

                $limit=Perusahaan::findOne(Yii::$app->user->identity->id_perusahaan);
                if(isset($limit)) {
                    $cccount=$limit->limitan;
                    $usertotal=User::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->count();
                    if($cccount>=$usertotal) {                
                        $model->status=10;
                        $model->created_at=time();
                        $model->updated_at=time();
                        $model->foto = UploadedFile::getInstance($model, 'foto');
                        if(isset($model->foto)){
                        $namafile=rand(1000, 99999999);
                        $file1= $namafile . '.' . $model->foto->extension;
                        $model->foto->saveAs('images/' . $namafile . '.' . $model->foto->extension,TRUE);
                        $model->foto=$file1;
                        } 
                        $model->setPassword($model->password_hash);
                        $model->generateAuthKey();
                        $model->save();
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Create new user",
                        'content'=>'<span class="text-success">Create user success</span>',
                        'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                        ];         
                    } else {

                        return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Data Failed",
                        'content'=>'<span class="text-success">Create User Failed because limit user</span>',
                        'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
            
                        ];         
                    }
        

                } else {
                    return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Data Failed",
                    'content'=>'<span class="text-success">Create User Failed because limit user</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                    ];         
                }

            }else{           
                return [
                    'title'=> "Create new user",
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
     * Updates an existing user model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        $bd=$this->findModel($id);
        $foto1=$bd->foto;
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update user #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) ){
                //$model->setPassword($model->password_hash);
                //$model->generateAuthKey();
                $model->foto = UploadedFile::getInstance($model, 'foto');
                if(isset($model->foto)){
                $namafile=rand(1000, 99999999);
                $file1= $namafile . '.' . $model->foto->extension;
                $model->foto->saveAs('images/' . $namafile . '.' . $model->foto->extension,TRUE);
                $model->foto=$file1;
                } else {
                    $model->foto=$foto1;
                } 

                $model->save();
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "user #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update user #".$id,
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
            if ($model->load($request->post())) {
                $model->setPassword($model->password_hash);
                $model->generateAuthKey();
                $model->save();
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
     * Delete an existing user model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
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
    public function actionDeletedet($id)
    {
        $request = Yii::$app->request;
        $this->findModelgrup($id)->delete();
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
     * Delete multiple existing user model.
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
            $model = $this->findModel($pk);
            $model->delete();
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
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = user::findOne($id)) !== null) {
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
