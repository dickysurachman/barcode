<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_daerah".
 *
 * @property integer $id
 * @property string $nama
 * @property string $alamat
 * @property string $telp
 * @property string $fax
 * @property integer $shelter
 * @property string $map
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_daerah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alamat', 'map','map_bib','map_bet'], 'string'],
            [['shelter','sdm','sdl','jml_shelter','id_perusahaan'], 'integer'],
            [['luas_shelter','dt_shelter'], 'number'],
            [['nama'], 'string', 'max' => 100],
            [['telp', 'fax'], 'string', 'max' => 20],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
        public function getKompeni()
    {
        return $this->hasOne(Perusahaan::className(), ['id' => 'id_perusahaan']);
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Outlet',
            'alamat' => 'Keterangan',
            'telp' => 'Akun Food / Default',
            'fax' => 'Akun Beverage',
            'shelter' => 'Shelter',
            'jml_shelter' => 'Jumlah Shelter',
            'luas_shelter' => 'Luas Shelter (Ha)',
            'dt_shelter' => 'Daya Tampung Shelter',
            'sdm' => 'Sumber Daya Manusia',
            'sdl' => 'Sumber Daya Lahan',
            'map' => 'Lokasi',
            'map_bib'=>'Lokasi',
            'map_bet'=>'Lokasi',
        ];
    }
      public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            //$hh=Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=0');
            if($this->isNewRecord)
                    {
                        if(Yii::$app->user->identity->tipe_user2<>1){
                            $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
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
