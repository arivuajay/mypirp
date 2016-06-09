<?php

/**
 * AdminIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class SuAdminIdentity extends CUserIdentity {

    private $_id;
    
    public $email;

   const ERROR_USERNAME_NOT_ACTIVE = 3;    
   const ERROR_ROLE_NOT_ACTIVE = 4;    

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {

        $user = SuAdmin::model()->find('username = :U', array(':U' => $this->username));

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;     // Error Code : 1
        } else if ($user->password !== Myclass::refencryption($this->password)) {           
            $this->errorCode = self::ERROR_PASSWORD_INVALID;   // Error Code : 1
        } else if ($user->status == 0) {             
            //Add new condition to finding the status of user.
            $this->errorCode = self::ERROR_USERNAME_NOT_ACTIVE;
        }else{
           
            $this->errorCode = self::ERROR_NONE;
        } 
        
        if ($this->errorCode == self::ERROR_NONE)
        { 
            
            $this->setUserData($user);
        }

        return !$this->errorCode;
    }
    
    protected function setUserData($user) {
     
        $this->_id = $user->id;
        $this->setState('username', $user->username);
        $this->setState('v1', $user->email);
        $this->setState('role', 'suadmin');
        //$this->setState('role', $user->role);
        //$this->setState('rolename', $user->roleMdl->Description);
        return;
    }
    
     public function checkadminemail() {
         
         $user = SuAdmin::model()->find('email = :U', array(':U' => $this->email));

        if ($user === null):
            $this->errorCode = self::ERROR_EMAIL_INVALID;     // Error Code : 1        
        endif;
        
        return !$this->errorCode;
     }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }
    
    public static function checkAdmin() {
        $return = false;
        if(isset(Yii::app()->user->role)){
            //$user = User::model()->find('id = :U', array(':U' => Yii::app()->user->id));
            //$return = $user->role == 1;
            $return = (Yii::app()->user->role=="suadmin")?true:false;
        }
        return $return;
    }
    
     public static function checkPrivilages($rank) {
        $return = false;
        if(isset(Yii::app()->user->id)){
            $user = User::model()->find('id = :U', array(':U' => Yii::app()->user->id));
            $return = $user->roleMdl->Rank <= $rank;
        }
        return $return;
    }
}