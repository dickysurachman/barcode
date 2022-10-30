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
            [['status', 'id_perusahaan', 'add_who', 'edit_who'], 'integer'],
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
            'pesanan' => Yii::t('yii', 'No Invoice'),
            'tanggal' => Yii::t('yii', 'Date'),
            'add_who' => Yii::t('yii', 'Add Who'),
            'edit_who' => Yii::t('yii', 'Edit Who'),
            'add_date' => Yii::t('yii', 'Add Date'),
            'edit_date' => Yii::t('yii', 'Edit Date'),
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
        return $this->hasOne(Scan::className(), ['barcode' => 'barcode']);
    }

        public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
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
