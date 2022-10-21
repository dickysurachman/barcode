<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Books is the model behind the contact form.
 */
class Setting extends Model
{
    public $url1;
    public $url2;
    public $url3;
    public $timer;
    public $ip_alat;
    public $port_alat;
    public $buffer;
    public $key;

    /**
     * @inheritdoc
     */
        
    public function rules()
    {
        return [
            // name, email, subject and body are required
            
            //[['csv'],'file'], 
			//[['csv'], 'file', 'extensions' => 'csv',],
            //[['gambar'],'file', 'extensions' => 'csv', 'mimeTypes' => 'image/jpeg, image/png'], 
            //[['gambar'], 'file', 'extensions' => 'jpg,jpeg,png'],
            [['timer','port_alat','buffer'],'integer'],
            [['url1','url2','url3','ip_alat','key'],'safe'],
            // verifyCode needs to be entered correctly
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'url1'=> Yii::t('yii', 'URL Get Data'),
                    'url2'=> Yii::t('yii', 'URL Sent Data'),
                    'url3'=> Yii::t('yii', 'URL Counter'),
                    'timer'=> Yii::t('yii', 'Loop Duration in second'),
                    'ip_alat'=> Yii::t('yii', 'Printer IP'),
                    'port_alat'=> Yii::t('yii', 'Printer Port'),
                    'buffer'=> Yii::t('yii', 'Buffer'),
                    'key'=> Yii::t('yii', 'Key'),
                    ];
     
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
}
