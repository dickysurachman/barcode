<?php

namespace app\models;

use Yii;
use app\models\Profile;
use app\models\Perusahaan;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $tipe_user
 * @property integer $id_profile
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['username',  'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at', 'tipe_user', 'delete','id_perusahaan'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['nik'], 'string', 'max' => 50],
            [['nama'], 'string', 'max' => 150],
            [['jabatan'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            //[['password_reset_token'], 'unique'],
            //[['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id']],
            //[['id_profile'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['id_profile' => 'id']],

        ];
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getTipeuser(){
        $nama=$this->tipe_user;
        if($nama==0){
            return "Administrator";
        }else if ($nama==1){
            return "Operator Scan";
        }else if ($nama==2){
            return "Cetak Kartu";
        }else if ($nama==3){
            return "FO Leader";
        }else if ($nama==4){
            return "Akunting";
        }
    }
    public function getTipo(){
        $nama=$this->tipe_user2;
        if($nama==0){
            return "Admin Company";
        } else {
            return "Superadmin";
        }
    }

    public function getProfile(){
         //$hh=User::findOne($this->id_user);
        $nama=Profile::findOne($this->id_profile);
        if(isset($nama)){
            return $nama->nama;
        }else{
            return "";
        }   


    }
    public function getProfilo()
    {
        return $this->hasOne(Profile::className(), ['id' => 'id_profile']);
    }
    public function getKompeni()
    {
        return $this->hasOne(Perusahaan::className(), ['id' => 'id_perusahaan']);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'delete' => 'Hapus Data',
            'status' => 'Status',
            'tipo' => 'Tipe User',
            'nama' => 'Nama Karyawan',
            'nik' => 'Nomor Induk Karyawan',
            'jabatan' => 'Jabatan Karyawan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'tipe_user' => 'Tipe User',
            'tipe_user2' => 'Tipe User',
            'id_profile' => 'Outlet',
            'id_perusahaan' => 'Perusahaan',
            'tipeuser' => 'Tipe User',
            'profile' => 'Nama Outlet',
        ];
    }

        public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            $hh=Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=0');
            if($this->isNewRecord)
                    {
                        if(!Yii::$app->user->isGuest){                        
                            if(Yii::$app->user->identity->tipe_user2<>1){
                                $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
                            }
                        }
                    }
                    else
                    {
                    }
            return true;
        } else {
            return false;
        }
    }
}
