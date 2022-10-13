<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grup".
 *
 * @property int $id
 * @property string|null $nama
 * @property int|null $status
 * @property int|null $id_perusahaan
 */
class Grup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'id_perusahaan'], 'integer'],
            [['nama'], 'string', 'max' => 100],
            [['foto'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'foto' => 'Foto',
            'status' => 'Status',
            'id_perusahaan' => 'Perusahaan',
        ];
    }
   
   /*   
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            //$hh=Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS=0');
            if($this->isNewRecord)
                //$this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
            return true;
        } else {
            return false;
        }
    }
    */
}
