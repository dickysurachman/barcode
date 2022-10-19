<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barcode_input".
 *
 * @property int $id
 * @property string|null $nama_file
 * @property int|null $id_perusahaan
 * @property string|null $barcode
 * @property string|null $tanggal
 * @property int|null $add_who
 * @property int|null $edit_who
 * @property string|null $add_date
 * @property string|null $edit_date
 */
class Barcodeinput extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $csv;
    public $delimitt;
    public static function tableName()
    {
        return 'barcode_input';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_perusahaan', 'add_who', 'edit_who'], 'integer'],
           // [['tanggal'],'required'],
            [[ 'add_date', 'edit_date','tanggal'], 'safe'],
            [['nama_file'], 'string', 'max' => 150],
            [['barcode'], 'string', 'max' => 50],
            [['delimitt'], 'string', 'max' => 2],
            //[['csv'],'file'], 
            [['csv'], 'file', 'extensions' => 'csv']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'nama_file' => Yii::t('yii', 'File Name'),
            'id_perusahaan' => Yii::t('yii', 'Company'),
            'barcode' => Yii::t('yii', 'Barcode'),
            'tanggal' => Yii::t('yii', 'Date'),
            'add_who' => Yii::t('yii', 'Add Who'),
            'edit_who' => Yii::t('yii', 'Edit Who'),
            'add_date' => Yii::t('yii', 'Add Date'),
            'edit_date' => Yii::t('yii', 'Edit Date'),
             'csv' => 'File CSV',
             'delimitt' => 'Delimiter',
        ];
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
        return $this->hasOne(Scan::className(), ['barcode' => 'barcode','id_perusahaan'=>'id_perusahaan']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord)
                $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
                $this->add_who = Yii::$app->user->identity->id;
                $this->add_date = date('Y-m-d H:i:s',time());
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
