<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ContactForm is the model behind the contact form.
 */
class ProxyLoadForm extends Model
{
    public $proxiesText;
    /**
     * @var UploadedFile|null
     */
    public $proxiesFile;

    public $proxies;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['proxiesText', 'proxiesFile'], 'safe'],
            [['proxiesFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'txt'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'proxiesText' => 'Checking proxy servers',
            'proxiesFile' => 'Checking proxies list file',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            if($this->proxiesFile) {
                $this->proxiesFile->saveAs($_SERVER['DOCUMENT_ROOT'] . '/../uploads/' . $this->proxiesFile->baseName . '.' . $this->proxiesFile->extension);
                $this->proxies = file($_SERVER['DOCUMENT_ROOT'] . '/../uploads/' . $this->proxiesFile->baseName . '.' . $this->proxiesFile->extension);
                return true;
            }

        } else {
            return false;
        }
    }

    public function getProxiesFromFile()
    {
        return $this->proxies;
    }

    public function getProxiesFromText()
    {
        return (!empty($this->proxiesText)) ? explode("\n", $this->proxiesText) : false;
    }

}
