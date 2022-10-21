<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perusahaan".
 *
 * @property int $id
 * @property string $nama
 * @property string $alamat
 * @property string $telp
 * @property string $fax
 * @property string $email
 * @property double $tax
 * @property double $service
 * @property string $logo_1
 * @property int $status
 */
class Perusahaan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perusahaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kodebon'], 'required'],
            [['kodebon'], 'unique'],
            [['tax', 'service'], 'number'],
            [['status','timer1','timer2','batas','limitan'], 'integer'],
            [['nama','kota'], 'string', 'max' => 100],
            [['alamat'], 'string', 'max' => 250],
            [['telp', 'fax'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 150],
            [['kodebon'], 'string', 'max' => 3],
            [['logo_1','logo_2','logo_3'], 'string', 'max' => 200],
            [['serialkey'], 'string', 'max' => 100],
            [['expiredate'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Perusahaan',
            'alamat' => 'Alamat',
            'expiredate' => 'Expired Date',
            'kota' => 'Kota',
            'batas' => 'Character Batas',
            'timer1' => 'Timer Scan (ms)',
            'timer2' => 'Timer Validasi (ms)',
            'kodebon' => 'Kode Transaksi',
            'serialkey' => 'Secure Key',
            //'kodedepo' => 'Kode Deposit',
            //'kodeoutlet' => 'Kode Outlet',
            'telp' => 'Telp',
            'fax' => 'Fax',
            'email' => 'Email',
            //'tax' => 'Tax %',
            //'service' => 'Service %',
            'logo_1' => 'Logo',
            'limitan'=>'Batas User',
            'logo_2' => 'Kartu Depan',
            'logo_3' => 'Kartu Belakang',
            'status' => 'Status',
        ];
    }

      public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            //$hh=Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=0');
            if($this->isNewRecord)
                    {
                        $Date = date('Y-m-d');
                        $this->expiredate=date('Y-m-d', strtotime($Date. ' + 7 days'));
                    }
            return true;
        } else {
            return false;
        }
    }
}
