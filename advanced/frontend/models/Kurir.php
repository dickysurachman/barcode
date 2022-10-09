<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kurir".
 *
 * @property int $id
 * @property string $nama
 * @property string $cari1
 * @property int $cari2
 * @property int $id_perusahaan
 * @property int $status
 * @property int $add_who
 * @property string $add_date
 * @property int $edit_who
 * @property string $edit_date
 */
class Kurir extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kurir';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cari2', 'id_perusahaan','id_grup','status', 'add_who', 'edit_who','cari3'], 'integer'],
            [['id_grup'],'required'],
            [['add_date', 'edit_date'], 'safe'],
            [['nama', 'cari1'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'cari1' => 'Mengandung Huruf',
            'cari2' => 'Panjang karakter invoice',
            'cari3' => 'Letak Pencarian',
            'id_perusahaan' => 'Perusahaan',
            'id_grup' => 'Grup',
            'status' => 'Status',
            'add_who' => 'Add Who',
            'add_date' => 'Add Date',
            'edit_who' => 'Edit Who',
            'edit_date' => 'Edit Date',
        ];
    }
    public function getSat(){
        if($this->status==0)
        {
            return 'Active';
        } else {
            return 'Non Active';

        }
    
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
     public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            $hh=Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=0');
            if($this->isNewRecord)
                $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
                $this->add_who = Yii::$app->user->identity->id;
                $this->add_date = date('Y-m-d H:i:s',time());
            return true;
        } else {
            $this->edit_who =Yii::$app->user->identity->id;
            $this->edit_date =  date('Y-m-d H:i:s',time());
            return false;
        }
    }
}
