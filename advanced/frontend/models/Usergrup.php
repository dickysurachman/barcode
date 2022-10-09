<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_grup".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_grup
 * @property int $id_perusahaan
 */
class Usergrup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_grup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['id_user', 'id_grup', 'id_perusahaan'], 'required'],
            [['id_user', 'id_grup', 'id_perusahaan'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'User',
            'id_grup' => 'Grup Scan',
            'id_perusahaan' => 'Perusahaan',
        ];
    }
        public function getGrup()
    {
        return $this->hasOne(Grup::className(), ['id' => 'id_grup']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord)
                $this->id_perusahaan=Yii::$app->user->identity->id_perusahaan;
                //$this->id_user=Yii::$app->user->identity->id;
            return true;
        } else {
            return false;
        }
    }

}
