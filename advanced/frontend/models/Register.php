<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use app\models\Perusahaan;
use app\models\User;
use app\models\Grup;
use app\models\Usergrup;
/**
 * Books is the model behind the contact form.
 */
class Register extends Model
{
    public $username;
    public $email;
    public $password;
    public $nama;
    public $kota;
    public $alamat;
    public $telp;
    public $fax;
    public $verifyCode;
    public $jumlahuser;
    /**
     * @inheritdoc
     */
        
    public function rules()
    {
        return [
        // name, email, subject and body are required
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['jumlahuser'],'integer'],
            [['nama','kota'], 'string', 'max' => 100],
             [['alamat'], 'string', 'max' => 250],
            [['telp', 'fax'], 'string', 'max' => 30],
            ['verifyCode', 'captcha'],

            // verifyCode needs to be entered correctly
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'nama' => 'Nama Perusahaan',
                    'alamat' => 'Alamat',
                    'jumlahuser' => 'User Needs',
                    'kota' => 'Kota',
                    'telp' => 'Telp',
                    'fax' => 'Fax',
                    'email' => 'Email',
                    'verifyCode' => 'Verification Code',
                    ];
     
    }
   
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        function RandomString($length) {
            $keys = array_merge(range(0,9), range('a', 'z'));

            $key = "";
            for($i=0; $i < $length; $i++) {
                $key .= $keys[mt_rand(0, count($keys) - 1)];
            }
            return $key;
            }
        $company= new Perusahaan();
        $company->nama=$this->nama;
        $company->alamat=$this->alamat;
        $company->kota=$this->kota;
        $company->telp=$this->telp;
        $company->fax=$this->fax;
        $company->email=$this->email;
        $kode=RandomString(3);
        $hasil=false;
        while($hasil==false){
            $cek =Perusahaan::findOne(['kodebon'=>$kode]);
            if(isset($cek)) {
                $kode=RandomString(3);
            } else {
                $hasil=true;
            }
        }
        $company->batas=10;
        $company->timer1=2000;
        $company->timer2=2000;
        $company->kodebon=$kode;
        $company->urutbon = 0;
        $company->urutdepo = 0;
        $company->urutoutlet = 0;
        $company->limitan = $this->jumlahuser;
        $company->save();
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->tipe_user2 =0;
        $user->tipe_user = 0;
        $user->id_perusahaan =$company->id;
        $user->status =9;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();
        $has=Grup::find()->all();
        foreach ($has as $key => $value){
            $baru=new Usergrup();
            $baru->id_grup=$value->id;
            $baru->id_user=$user->id;
            $baru->id_perusahaan=$company->id;
            $baru->save();
        }   
        return isset($user) ? $user : null;
    }
    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
}
