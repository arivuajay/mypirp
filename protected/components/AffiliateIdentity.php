<?php

/**
 * AdminIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AffiliateIdentity extends CUserIdentity {

    private $_id;
    public $email;

    const ERROR_USERNAME_NOT_ACTIVE = 3;
    const ERROR_ROLE_NOT_ACTIVE = 4;

    /**
     * Authenticates a user.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {

        $affiliate = DmvAffiliateInfo::model()->find('user_id = :U', array(':U' => $this->username));

        if ($affiliate === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;     // Error Code : 1
        } else if ($affiliate->password !== $this->password) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;   // Error Code : 1
        } else if ($affiliate->enabled == 'N') {
            //Add new condition to finding the status of user.
            $this->errorCode = self::ERROR_USERNAME_NOT_ACTIVE;
        } else {
            $this->errorCode = self::ERROR_NONE;
        }

        if ($this->errorCode == self::ERROR_NONE) {

            $this->setUserData($affiliate);
        }

        return !$this->errorCode;
    }

    protected function setUserData($affiliate) {

        $this->_id = $affiliate->affiliate_id;
        $this->setState('affiliate_id', $affiliate->affiliate_id);
        $this->setState('username', $affiliate->agency_name);
        $this->setState('v1', $affiliate->email_addr);
        $this->setState('role', 'Affiliate');
        //$this->setState('role', $affiliate->role);
        //$this->setState('rolename', $affiliate->roleMdl->Description);
        return;
    }

    public function checkadminemail() {

        $affiliate = DmvAffiliateInfo::model()->find('email_addr = :U', array(':U' => $this->email));

        if ($affiliate === null):
            $this->errorCode = self::ERROR_EMAIL_INVALID;     // Error Code : 1        
        endif;

        return !$this->errorCode;
    }

    public static function checkAffiliate() {
        $return = false;
        if (isset(Yii::app()->user->role)) {
            //$user = User::model()->find('id = :U', array(':U' => Yii::app()->user->id));
            //$return = $user->role == 1;
            $return = (Yii::app()->user->role == "Affiliate") ? true : false;
        }
        return $return;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId() {
        return $this->_id;
    }

}
