<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barcode".
 *
 * @property int $id
 * @property string|null $barcode
 * @property string|null $tanggal
 * @property int|null $add_who
 * @property int|null $edit_who
 * @property string|null $add_date
 * @property string|null $edit_date
 */
class Barcode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'barcode';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'add_date', 'edit_date'], 'safe'],
            [['add_who', 'edit_who','id_perusahaan'], 'integer'],
            [['barcode'], 'string', 'max' => 50],
            [['pesanan'], 'string', 'max' => 100],
            //[['barcode'], 'unique'],
            [['barcode'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'barcode' => Yii::t('yii', 'Barcode'),
            'tanggal' => Yii::t('yii', 'Date'),
            'pesanan' => Yii::t('yii', 'No Pesanan'),
            'add_who' => Yii::t('yii', 'Add Who'),
            'edit_who' => Yii::t('yii', 'Edit Who'),
            'add_date' => Yii::t('yii', 'Add Date'),
            'edit_date' => Yii::t('yii', 'Edit Date'),
            'id_perusahaan' => Yii::t('yii', 'Company'),
        ];
    }

    public function getScann()
    {
        return $this->hasOne(Scan::className(), ['barcode' => 'barcode','id_perusahaan'=>'id_perusahaan']);
    }

    public function getRetur()
    {
        return $this->hasOne(Barcoderetur::className(), ['pesanan' => 'pesanan','id_perusahaan'=>'id_perusahaan']);
    }
    public function getInput()
    {
        return $this->hasOne(Barcodeinput::className(), ['barcode' => 'barcode','id_perusahaan'=>'id_perusahaan']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord)
               
                $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
                $this->add_who = Yii::$app->user->identity->id;
                $this->add_date = date('Y-m-d H:i:s',time());
                $this->tanggal = date('Y-m-d',time());


            return true;
        } else {
            $this->edit_who =Yii::$app->user->identity->id;
            $this->edit_date =  date('Y-m-d H:i:s',time());
            return false;
        }
    }


}
