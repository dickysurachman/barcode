<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Books is the model behind the contact form.
 */
class Csv extends Model
{
    public $alamat;
    public $phone;
    public $gambar;
    public $tanggal;
    public $csv;


    /**
     * @inheritdoc
     */
        
    public function rules()
    {
        return [
            // name, email, subject and body are required
            
            [['csv'],'file'], 
			[['csv'], 'file', 'extensions' => 'csv',],
            //[['gambar'],'file', 'extensions' => 'csv', 'mimeTypes' => 'image/jpeg, image/png'], 
            //[['gambar'], 'file', 'extensions' => 'jpg,jpeg,png'],
            [['alamat','phone','tanggal'],'safe'],
            // verifyCode needs to be entered correctly
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'tanggal'=>'Tanggal Scanning',
                    'gambar'=>'File Foto',
                    'csv'=>'File CSV',
                    'alamat'=> 'Alamat',
                    'phone'=>'Phone',
                    ];
     
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
}
