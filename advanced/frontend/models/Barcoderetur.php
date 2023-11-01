<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barcode_retur".
 *
 * @property int $id
 * @property int|null $status
 * @property string|null $alasan
 * @property int|null $id_perusahaan
 * @property string|null $barcode
 * @property string|null $tanggal
 * @property int|null $add_who
 * @property int|null $edit_who
 * @property string|null $add_date
 * @property string|null $edit_date
 */
class Barcoderetur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'barcode_retur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'id_perusahaan', 'add_who', 'edit_who','id_grup'], 'integer'],
            [['tanggal', 'add_date', 'edit_date'], 'safe'],
            [['alasan'], 'string', 'max' => 200],
            [['barcode'], 'string', 'max' => 50],
            [['pesanan'], 'string', 'max' => 100],
            ['pesanan', 'notExistsValidator'],
            //['barcode', 'unique'],
        ];
    }
    public function notExistsValidator()
    {
        if(!Barcodeinput::findOne(['pesanan' => $this->pesanan]))
         {
            $this->addError('pesanan', 'No Invoice does not exists on Scan');
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'status' => Yii::t('yii', 'Status'),
            'alasan' => Yii::t('yii', 'Mark'),
            'id_perusahaan' => Yii::t('yii', 'Perusahaan'),
            'barcode' => Yii::t('yii', 'Barcode'),
            'id_grup' => Yii::t('yii', 'Expedition'),
            'pesanan' => Yii::t('yii', 'No Pesanan'),
            'tanggal' => Yii::t('yii', 'Date'),
            'add_who' => Yii::t('yii', 'Add Who'),
            'edit_who' => Yii::t('yii', 'Edit Who'),
            'add_date' => Yii::t('yii', 'Add Date'),
            'edit_date' => Yii::t('yii', 'Edit Date'),
        ];
    }
    public function getGrup()
    {
        return $this->hasOne(Grup::className(), ['id' => 'id_grup']);
    }
     public function getAdd()
    {
        return $this->hasOne(User::className(), ['id' => 'add_who']);
    }
    public function getEdit()
    {
        return $this->hasOne(User::className(), ['id' => 'edit_who']);
    }
    public function getScann()
    {
        return $this->hasOne(Scan::className(), ['barcode' => 'barcode']);
    }

        public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord)
                $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
                $this->add_who = Yii::$app->user->identity->id;
                $this->add_date = date('Y-m-d H:i:s',time());


                $sac=substr($this->barcode,0,2);
            if($sac <>"88" and $sac <>"89" and $sac <>"90"){  
            $h=Usergrup::find()->where(['id_user'=>Yii::$app->user->identity->id])->all();
            foreach($h as $key2){
                $k=Kurir::find()->where(['id_grup'=>$key2->id_grup,'status'=>0])->orderBy(['id'=>SORT_DESC])->all();
                foreach($k as $key){
                if($key->cari3==0) {
                $cek1=strpos(" ".$this->barcode,$key->cari1);
                } else {
                $jml=strlen($key->cari1);
                $awal=substr($this->barcode,0,$jml);
                $ch=$key->cari1;
                if($ch==$awal){
                    $cek1=5;
                } else {
                    $cek1=0;
                }
                }
                $h=strlen($this->barcode);
                $hasil=true;
                if($key->cari1=="0"){
                    $hh=is_numeric($this->barcode);
                    if($h==$key->cari2 and $hh==1){
                        $hasil=true;
                    } else {
                        $hasil=false;
                    }

                }
                if($cek1>0 and $h==$key->cari2 and $hasil==true){
                        $this->id_grup=$key->grup->id;
                        break;
                }   
                }
                }
                }
            return true;
        } else {
            $this->edit_who =Yii::$app->user->identity->id;
            $this->edit_date =  date('Y-m-d H:i:s',time());
            $sac=substr($this->barcode,0,2);
            if($sac <>"88" and $sac <>"89" and $sac <>"90"){  
            $h=Usergrup::find()->where(['id_user'=>Yii::$app->user->identity->id])->all();
            foreach($h as $key2){
                $k=Kurir::find()->where(['id_grup'=>$key2->id_grup,'status'=>0])->orderBy(['id'=>SORT_DESC])->all();
                foreach($k as $key){
                if($key->cari3==0) {
                $cek1=strpos(" ".$this->barcode,$key->cari1);
                } else {
                $jml=strlen($key->cari1);
                $awal=substr($this->barcode,0,$jml);
                $ch=$key->cari1;
                if($ch==$awal){
                    $cek1=5;
                } else {
                    $cek1=0;
                }
                }
                $h=strlen($this->barcode);
                $hasil=true;
                if($key->cari1=="0"){
                    $hh=is_numeric($this->barcode);
                    if($h==$key->cari2 and $hh==1){
                        $hasil=true;
                    } else {
                        $hasil=false;
                    }

                }
                if($cek1>0 and $h==$key->cari2 and $hasil==true){
                        $this->id_grup=$key->grup->id;
                        break;
                }   
                }
                }
                }
            return false;
        }
    }

}
