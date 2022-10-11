<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Books is the model behind the contact form.
 */
class Books extends Model
{
    public $alamat;
    public $phone;
    public $gambar;


    /**
     * @inheritdoc
     */
        
    public function rules()
    {
        return [
            // name, email, subject and body are required
            
            //[['gambar'],'file'], 
            [['gambar'],'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png'], 
            //[['gambar'], 'file', 'extensions' => 'jpg,jpeg,png'],
            [['alamat','phone'],'safe'],
            // verifyCode needs to be entered correctly
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                    'gambar'=>'File Foto',
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
