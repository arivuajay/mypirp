<?php

/**
 * AdminLoginForm class.
 * AdminLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UploadForm extends CFormModel {

   public $scheduledoc;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('scheduledoc','file','allowEmpty' => false,'types'=>"xls" ),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            "scheduledoc" => "Upload Schedule File"
        );
    }    
}
