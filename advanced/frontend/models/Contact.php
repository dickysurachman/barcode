<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $tanggal
 * @property string|null $email
 * @property string|null $subjek
 * @property string|null $isi
 * @property int|null $id_perusahaan
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal'], 'safe'],
            [['isi'], 'string'],
            [['id_perusahaan'], 'integer'],
            [['name', 'email'], 'string', 'max' => 100],
            [['subjek'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yii', 'ID'),
            'name' => Yii::t('yii', 'Name'),
            'tanggal' => Yii::t('yii', 'Date'),
            'email' => Yii::t('yii', 'Email'),
            'subjek' => Yii::t('yii', 'Subjek'),
            'isi' => Yii::t('yii', 'Isi'),
            'statusnye' => Yii::t('yii', 'Status'),
            'id_perusahaan' => Yii::t('yii', 'Perusahaan'),
        ];
    }
    public function getStatusnye(){
        if($this->status==0) {
            return 'On Progress';
        } else {
            return 'Done';

        }
    }

        public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord)
              
                $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;

            return true;
        } else {
            return false;
        }
    }
}
