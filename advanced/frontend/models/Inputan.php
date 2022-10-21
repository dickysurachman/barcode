<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inputan".
 *
 * @property int $id
 * @property string $barcode
 * @property int $id_perusahaan
 * @property int $status
 */
class Inputan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    //public $csv;
    public static function tableName()
    {
        return 'inputan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             
        //[['barcode'], 'unique'],
            [['barcode'], 'required'],
            [['id_perusahaan', 'status','id_group'], 'integer'],
            [['barcode'], 'string', 'max' => 30],
            [['nama'], 'string', 'max' => 100],
            [['foto'], 'string', 'max' => 250]
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
            'id_perusahaan' => 'Perusahaan',
            'id_group' => 'Group',
            'nama' => 'Nama Group',
            'foto' => 'Foto',
            'status' => 'Status',
        ];
    }

         public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord)
                if(!isset($this->id_perusahaan)) {
                    $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
                }
                
            return true;
        } else {
            
            return false;
        }
    }
}
