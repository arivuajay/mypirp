<?php

/**
 * AdminLoginForm class.
 * AdminLoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class PasswordResetForm extends CFormModel {

     public $current_password,$re_password,$remember_token;
     private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(                     
            array('current_password,re_password,remember_token', 'required'),
            array('current_password', 'compare', 'compareAttribute' => 're_password'),        
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'current_password' => "New Password", 
            're_password' => "Confirm New Password", 
        );
    }

        
    public function suadmin_authenticate()
    {
        $userinfo = SuAdmin::model()->find('remember_token = :U', array(':U' => $this->remember_token));

        if ($userinfo === null):
            $this->addError('re_password', "Reset password token is invalid.");  // Error Code : 1               
        else:
            // $randpass   = Myclass::getRandomString(5);   
            $userinfo->remember_token = "";
            $userinfo->password = Myclass::refencryption($this->current_password);                    
            $userinfo->save(false); 
            return true;
        endif; 
    }         
   

}