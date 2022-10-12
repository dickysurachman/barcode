<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scan".
 *
 * @property int $id
 * @property string|null $barcode
 * @property int|null $id_grup
 * @property string $kode
 * @property string|null $tanggal
 * @property int|null $id_perusahaan
 * @property int $status
 * @property int|null $add_who
 * @property string|null $add_date
 * @property int|null $edit_who
 * @property string|null $edit_date
 */
class Scan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'scan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_grup', 'id_perusahaan', 'status', 'add_who', 'edit_who'], 'integer'],
            [['barcode'], 'required'],
            //[['barcode'], 'unique'],
            [['tanggal', 'add_date', 'edit_date'], 'safe'],
            [['barcode'], 'string', 'max' => 1000],
            [['kode'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barcode' => 'Barcode',
            'id_grup' => 'Expedition',
            'kode' => 'Kode',
            'tanggal' => 'Tanggal',
            'id_perusahaan' => 'Perusahaan',
            'status' => 'Status',
            'foto' => 'Foto',
            'add_who' => 'Operator',
            'add_date' => 'Add Date',
            'edit_who' => 'Edit Who',
            'edit_date' => 'Edit Date',
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
    public function getRetur()
    {
        return $this->hasOne(Barcoderetur::className(), ['barcode' => 'barcode']);
    }
    public function getInput()
    {
        return $this->hasOne(Barcodeinput::className(), ['barcode' => 'barcode']);
    }





         public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord)
                $produksis = Scan::find()->where(['id_perusahaan'=>Yii::$app->user->identity->id_perusahaan])->count();
                $produksi =$produksis;
                $kode=Perusahaan::findOne(Yii::$app->user->identity->id_perusahaan);
                $awal=$kode->kodebon;
                if($produksi==0 or $produksi==""){
                            $produksi=1;
                }else{
                            $produksi++;
                }
                if($produksi>9999 and $produksi<100000000){
                    $novo=$awal."-".substr("0000".substr($produksi,0,strlen($produksi)-4), -4) ."-". substr("0000".$produksi, -4);
                } elseif($produksi>99999999) {
                            $novo=$awal."-" .number_format($produksi,0,",","-");
                } else {
                            $novo=$awal."-0000-" . substr("0000".$produksi, -4);
                }
                $this->kode=$novo;
                $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
                $this->add_who = Yii::$app->user->identity->id;
                $this->add_date = date('Y-m-d H:i:s',time());
                $this->tanggal = date('Y-m-d',time());
                $cek=Barcode::findOne(['barcode'=>$this->barcode,'id_perusahaan'=>Yii::$app->user->identity->id_perusahaan]);
                if(!$cek){
                    $simpan=new Barcode();
                    $simpan->barcode = $this->barcode;
                    $simpan->save();
                }


            return true;
        } else {
            $this->edit_who =Yii::$app->user->identity->id;
            $this->edit_date =  date('Y-m-d H:i:s',time());
            return false;
        }
    }
}
